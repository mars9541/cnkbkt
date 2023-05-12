<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}
define('PLUGIN_ROOT', DISCUZ_ROOT . './source/plugin/');
define('FORM_URL', 'plugins&operation=config&do=' . $pluginid . '&identifier=' . $plugin['identifier'] . '&pmod=' . daddslashes($_GET['pmod']) . '&'); //用于FORM
define('A_URL', ADMINSCRIPT . '?action=' . FORM_URL); //用于A链接
define('CP_URL', 'action=' . FORM_URL); //用于cpmsg
//php5.5以下兼容
if (!function_exists('array_column')) {
	function array_column($array, $column_name)
	{
		return array_map(function ($element) use ($column_name) {
			return $element[$column_name];
		}, $array);
	}
}
/**
 * 用于生成带a标签的链接
 * @param    string        $text   文本
 * @param    string        $url    链接
 * @param    string        $target 跳转方式
 * @param    string        $extra  额外参数
 * @return   string
 */
function aurl($text, $params = [], $target = "_self", $extra = '') {
    return '<a href="' . A_URL . http_build_query($params) . '" ' . $extra . ' target="' . $target . '">' . $text . '</a>';
}
/**
 * 显示设置项
 * @param    array         $array      [description]
 * @param    integer       $showsubmit [description]
 */
function showall($array, $showsubmit = 1) {
    if (!is_array($array)) {
        $array = explode(',', $array);
    }

    foreach ($array as $data) {
        showset($data);
    }
    if ($showsubmit) {
        showsubmit('submit');
    }
}
/**
 * 校验表单提交
 * @param    [type]        $array [description]
 * @return   [type]               [description]
 */
function checksubmit($array) {
    if (!is_array($array)) {
        $array = explode(',', $array);
    }
    if (submitcheck('submit')) {
        global $var, $pluginid;
        foreach ($array as $arr) {
            $updata   = $var[$arr];
            $variable = $updata['variable'];
            $value    = daddslashes($_GET[$arr]);
            if (is_array($value)) {
                $value = serialize($value);
            }

            if ($updata['type'] == 'password' && $value == '********') {
                continue;
            }

            DB::query("UPDATE " . DB::table('common_pluginvar') . " SET value='$value' WHERE pluginid='$pluginid' AND variable='$variable'");
        }
        updatecache(array('plugin', 'setting', 'styles'));
        cleartemplatecache();
        return true;
    } else {
        return false;
    }
}
function updateplugin($variable, $value, $plugin_id = '') {
    global $var, $pluginid;
    if (!$plugin_id) {
        $plugin_id = $pluginid;
    }
    DB::query("UPDATE " . DB::table('common_pluginvar') . " SET value='$value' WHERE pluginid='$plugin_id' AND variable='$variable'");
    updatecache(array('plugin', 'setting', 'styles'));
    cleartemplatecache();
}
function showset($varname, $disabled = '', $hidden = 0, $setid = '') {
    global $var, $_G, $plugin, $lang;
    $vars = $var[$varname];
    if ($vars['type'] == 'password') {
        $vars['type']     = 'text';
        $vars['password'] = 1;
        $vars['value']    = $vars['value'] ? $vars['value']{0} . '********' . substr($vars['value'], -4) : '';
    } elseif ($vars['type'] == 'number') {
        $vars['type'] = 'text';
    } elseif ($vars['type'] == 'select') {
        $vars['type'] = "<select name=\"$vars[variable]\">\n";
        foreach (explode("\n", $vars['extra']) as $key => $option) {
            $option = trim($option);
            if (strpos($option, '=') === FALSE) {
                $key = $option;
            } else {
                $item   = explode('=', $option);
                $key    = trim($item[0]);
                $option = trim($item[1]);
            }
            $vars['type'] .= "<option value=\"" . dhtmlspecialchars($key) . "\" " . ($vars['value'] == $key ? 'selected' : '') . ">$option</option>\n";
        }
        $vars['type'] .= "</select>\n";
        $vars['variable'] = $vars['value'] = '';
    } elseif ($vars['type'] == 'selects') {
        $vars['value'] = dunserialize($vars['value']);
        $vars['value'] = is_array($vars['value']) ? $vars['value'] : array($vars['value']);
        $vars['type']  = "<select name=\"$var[variable][]\" multiple=\"multiple\" size=\"10\">\n";
        foreach (explode("\n", $vars['extra']) as $key => $option) {
            $option = trim($option);
            if (strpos($option, '=') === FALSE) {
                $key = $option;
            } else {
                $item   = explode('=', $option);
                $key    = trim($item[0]);
                $option = trim($item[1]);
            }
            $vars['type'] .= "<option value=\"" . dhtmlspecialchars($key) . "\" " . (in_array($key, $vars['value']) ? 'selected' : '') . ">$option</option>\n";
        }
        $vars['type'] .= "</select>\n";
        $vars['variable'] = $vars['value'] = '';
    } elseif ($vars['type'] == 'date') {
        $vars['type']  = 'calendar';
        $extra['date'] = '<script type="text/javascript" src="static/js/calendar.js"></script>';
    } elseif ($vars['type'] == 'datetime') {
        $vars['type']  = 'calendar';
        $vars['extra'] = 1;
        $extra['date'] = '<script type="text/javascript" src="static/js/calendar.js"></script>';
    } elseif ($vars['type'] == 'forum') {
        require_once libfile('function/forumlist');
        $vars['type']     = '<select name="' . $vars['variable'] . '"><option value="">' . cplang('plugins_empty') . '</option>' . forumselect(FALSE, 0, $vars['value'], TRUE) . '</select>';
        $vars['variable'] = $vars['value'] = '';
    } elseif ($vars['type'] == 'forums') {
        $vars['description'] = ($vars['description'] ? (isset($lang[$vars['description']]) ? $lang[$vars['description']] : $vars['description']) . "\n" : '') . $lang['plugins_edit_vars_multiselect_comment'] . "\n" . $vars['comment'];
        $vars['value']       = dunserialize($vars['value']);
        $vars['value']       = is_array($vars['value']) ? $vars['value'] : array();
        require_once libfile('function/forumlist');
        $vars['type'] = '<select name="' . $vars['variable'] . '[]" size="10" multiple="multiple"><option value="">' . cplang('plugins_empty') . '</option>' . forumselect(FALSE, 0, 0, TRUE) . '</select>';
        foreach ($vars['value'] as $v) {
            $vars['type'] = str_replace('<option value="' . $v . '">', '<option value="' . $v . '" selected>', $vars['type']);
        }
        $vars['variable'] = $vars['value'] = '';
    } elseif (substr($vars['type'], 0, 5) == 'group') {
        if ($vars['type'] == 'groups') {
            $vars['description'] = ($vars['description'] ? (isset($lang[$vars['description']]) ? $lang[$vars['description']] : $vars['description']) . "\n" : '') . $lang['plugins_edit_vars_multiselect_comment'] . "\n" . $vars['comment'];
            $vars['value']       = dunserialize($vars['value']);
            $vars['type']        = '<select name="' . $vars['variable'] . '[]" size="10" multiple="multiple"><option value=""' . (@in_array('', $vars['value']) ? ' selected' : '') . '>' . cplang('plugins_empty') . '</option>';
        } else {
            $vars['type'] = '<select name="' . $vars['variable'] . '"><option value="">' . cplang('plugins_empty') . '</option>';
        }
        $vars['value'] = is_array($vars['value']) ? $vars['value'] : array($vars['value']);
        $query         = C::t('common_usergroup')->range_orderby_credit();
        $groupselect   = array();
        foreach ($query as $group) {
            $group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
            $groupselect[$group['type']] .= '<option value="' . $group['groupid'] . '"' . (@in_array($group['groupid'], $vars['value']) ? ' selected' : '') . '>' . $group['grouptitle'] . '</option>';
        }
        $vars['type'] .= '<optgroup label="' . $lang['usergroups_member'] . '">' . $groupselect['member'] . '</optgroup>' .
            ($groupselect['special'] ? '<optgroup label="' . $lang['usergroups_special'] . '">' . $groupselect['special'] . '</optgroup>' : '') .
            ($groupselect['specialadmin'] ? '<optgroup label="' . $lang['usergroups_specialadmin'] . '">' . $groupselect['specialadmin'] . '</optgroup>' : '') .
            '<optgroup label="' . $lang['usergroups_system'] . '">' . $groupselect['system'] . '</optgroup></select>';
        $vars['variable'] = $vars['value'] = '';
    } elseif ($vars['type'] == 'extcredit') {
        $vars['type'] = '<select name="' . $vars['variable'] . '"><option value="">' . cplang('plugins_empty') . '</option>';
        foreach ($_G['setting']['extcredits'] as $id => $credit) {
            $vars['type'] .= '<option value="' . $id . '"' . ($vars['value'] == $id ? ' selected' : '') . '>' . $credit['title'] . '</option>';
        }
        $vars['type'] .= '</select>';
        $vars['variable'] = $vars['value'] = '';
    }
    extract($vars);
    if (is_array($value)) {
        $value = dunserialize($value);
    }

    showsetting($title, $variable, $value, $type, $disabled, $hidden, $description, '', $setid, true);
}

function formheader($params, $extra = '', $name = 'cpform', $method = 'post') {
    showformheader(FORM_URL . http_build_query($params), $extra, $name, $method);
}

function cpsuccess($text, $params = []) {
    $url = is_array($params) ? CP_URL . http_build_query($params) : $params;
    cpmsg($text, $url, 'succeed');
}
function showselect($varname, $options, $val = null, $empty = false) {
    $code = '<select name="' . $varname . '">';
    if ($empty) {
        $code .= '<option value="">' . (is_bool($empty) ? lang('plugin/csu_base', 'please_select') : $empty) . '</option>';
    }
    foreach ($options as $key => $value) {
        $code .= '<option value="' . $key . '" ' . ($key == $val && !is_null($val) ? 'selected=""' : '') . '>' . $value . '</option>';
    }
    $code .= '</select>';
    return $code;
}
function empty_value($content, $empty = '-') {
    if (!$content) {
        return $empty;
    }

    return $content;
}
function empty_time($time, $empty = '-') {
    if (!$time) {
        return $empty;
    }

    return dgmdate($time, 'Y-m-d H:i:s');
}
function formtableheader($action, $headertext = '', $extra = '', $name = 'cpform', $method = 'post') {
    formheader($action, $extra, $name, $method);
    showtableheader($headertext);
}
function formtablefooter() {
    showtablefooter();
    showformfooter();
}
?>