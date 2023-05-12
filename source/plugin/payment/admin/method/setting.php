<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}
//配置
$method_id = csubase::getMod($_GET['method_id']); //标识

//校验是否已经添加过了
$item = C::t('#payment#payment_method')->fetch($method_id);
if (!$item) {
    cpmsg_error(lang('plugin/payment', 'method_not_exist'));
}
$setting = getsettings(PAYMENT_METHOD_ROOT . $method_id . '/setting.json');
//导出配置
if (submitcheck('export_submit', 1)) {
    $filename = $method_id . ".config.json"; //生成的文件名
    define('IN_ARCHIVER', true);
    define('FOOTERDISABLED', true);
    ob_end_clean();
    header('Content-Encoding: none');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Pragma: no-cache');
    header('Expires: 0');
    echo csubase::json_encode($item['setting']);
    exit();
}
//导入配置
if (submitcheck('input_submit')) {
    $input = csubase::json_decode(file_get_contents($_FILES['file']['tmp_name']));
    @unlink($_FILES['file']['tmp_name']);
    $settings = [];
    foreach ($setting as $value) {
        $settings[$value['key']] = $input[$value['key']];
    }
    C::t('#payment#payment_method')->update($method_id, [
        'setting' => serialize($settings),
    ]);
    cpsuccess(lang('plugin/payment', 'input_config_success'), ['op' => $_GET['op'], 'method_id' => $method_id]);
}
//保存配置
if (submitcheck('submit')) {
    $settings = [];
    foreach ($setting as $value) {
        $settings[$value['key']] = trim(daddslashes($_GET[$value['key']]));
    }
    C::t('#payment#payment_method')->update($method_id, [
        'title'        => daddslashes($_GET['title']),
        'displayorder' => dintval($_GET['displayorder']),
        'setting'      => serialize($settings),
    ]);
    cpsuccess(lang('plugin/payment', 'save'), ['op' => $_GET['op'], 'method_id' => $method_id]);
}

$settings = $item['setting'];
$config   = csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json');
showformheader(FORM_URL . http_build_query(['op' => $op, 'method_id' => $method_id]), 'enctype', 'json_form');
showhiddenfields(['input_submit' => true]);
echo '<input type="file" name="file" accpet="application/JSON" style="display:none" id="json_choose" onchange="document.getElementById(\'json_form\').submit();"/>';
showformfooter();
//读取配置文件
formtableheader(['op' => $op, 'method_id' => $method_id], lang('plugin/payment', 'setting') . $config['name'] . '&nbsp;' . aurl(lang('plugin/payment', 'export_config'), ['op' => $op, 'method_id' => $method_id, 'export_submit' => true, 'formhash' => FORMHASH]) . '&nbsp;<a href="javascript:document.getElementById(\'json_choose\').click();">' . lang('plugin/payment', 'input_config') . '</a>');
showsetting(lang('plugin/payment', 'panel_title'), 'title', $item['title'], 'text');
showsetting(lang('plugin/payment', 'panel_displayorde'), 'displayorder', $item['displayorder'], 'number', '', 0, lang('plugin/payment', 'desc'));
foreach ($setting as $value) {
    showsetting($value['title'], $value['key'], $settings[$value['key']], $value['type'], '', 0, $value['comment']);
}

showsubmit('submit');
formtablefooter();
?>