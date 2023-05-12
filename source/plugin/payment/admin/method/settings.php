<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
//设置项
$method_id = csubase::getMod($_GET['method_id']); //标识

//判断接口是否存在
if (!is_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json')) {
    cpmsg_error(lang('plugin/payment', 'config_not_exist'));
}

if (submitcheck('submit')) {
    $settings = [];
    foreach ($_GET['title'] as $key => $value) {
        $settings[] = [
            'title'   => trim(daddslashes($value)),
            'key'     => strip_tags(trim(daddslashes($_GET['key'][$key]))),
            'type'    => trim(daddslashes($_GET['type'][$key])),
            'default' => trim(daddslashes($_GET['default'][$key])),
            'comment' => trim(daddslashes($_GET['comment'][$key])),
        ];
    }
    //保存文件
    csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/setting.json', $settings); //创建配置文件
    cpsuccess(lang('plugin/payment', 'save'), ['op' => $_GET['op'], 'method_id' => $method_id]);
}
$config   = csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json'); //获取配置文件
$settings = getsettings(PAYMENT_METHOD_ROOT . $method_id . '/setting.json'); //获取设置项
formheader([
    'op'        => $_GET['op'],
    'method_id' => $method_id,
]);
showtableheader(lang('plugin/payment', 'editsetting') . $config['name']);
showsubtitle(['', lang('plugin/payment', 'name'), lang('plugin/payment', 'eng_identifier'), lang('plugin/payment', 'type'), lang('plugin/payment', 'default'), lang('plugin/payment', 'note')]);
foreach ($settings as $setting) {
    showsettingrow($setting['title'], $setting['key'], $setting['type'], $setting['default'], $setting['comment']);
}
showsubmit('submit', 'submit', '<a href="javascript:void(0);" onclick="addnewrow(this)" class="addtr">' . cplang('add') . '</a>');
showtablefooter();
showformfooter();
//添加行数据来源
showtableheader('', '', 'style="display:none" id="copytable"');
showsettingrow();
showtablefooter();

function showsettingrow($title = '', $key = '', $type = 'text', $default = '', $comment = '') {
    $types = [
        'number'   => lang('plugin/payment', 'number'),
        'text'     => lang('plugin/payment', 'text'),
        'textarea' => lang('plugin/payment', 'textarea'),
        'radio'    => lang('plugin/payment', 'radio'),
    ];
    $typecode = '';
    foreach ($types as $k => $v) {
        $typecode .= '<option value="' . $k . '"' . ($k == $type ? ' selected="selected"' : '') . '>' . $v . '(' . $k . ')</option>';
    }

    showtablerow('', [], [
        '<div>
                <a href="javascript:void(0);" onclick="addnewrow(this)" class="lightnum">' . cplang('add') . '</a>
                <a href="javascript:void(0);" onclick="rowup(this)" class="lightnum">' . lang('plugin/payment', 'up') . '</a>
                <a href="javascript:void(0);" onclick="rowdown(this)" class="lightnum">' . lang('plugin/payment', 'down') . '</a>
                <a href="javascript:void(0);" onclick="deleterow(this)" class="lightnum">' . cplang('delete') . '</a>
            </div>',
        '<input type="text" class="txt" name="title[]" value="' . dhtmlspecialchars(dstripslashes($title)) . '" style="width:200px"/>',
        '<input type="text" class="txt" name="key[]" value="' . $key . '" style="width:200px"/>',
        '<select name="type[]">' . $typecode . '</select>',
        '<input type="text" class="txt" name="default[]" value="' . dhtmlspecialchars(dstripslashes($default)) . '" style="width:200px"/>',
        '<input type="text" class="txt" name="comment[]" value="' . dhtmlspecialchars(dstripslashes($comment)) . '" style="width:200px"/>']
    );
}
?>
<script src="./source/plugin/csu_base/js/jquery-3.4.1.min.js"></script>
<script src="./source/plugin/payment/src/admin.js"></script>
