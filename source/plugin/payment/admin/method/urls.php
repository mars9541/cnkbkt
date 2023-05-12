<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

//设置项
$method_id = csubase::getMod($_GET['method_id']); //标识
showtips('<ul>
    <li>' . lang('plugin/payment', 'url_tips_1') . 'source/plugin/payment/method/' . $method_id . '/' . lang('plugin/payment', 'url') . '.php</li>
    <li>' . lang('plugin/payment', 'url_tips_2') . '</li>
</ul>');
//判断接口是否存在
if (!is_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json')) {
    cpmsg_error(lang('plugin/payment', 'config_not_exist'));
}
$config = csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json'); //获取配置文件

if (submitcheck('submit')) {
    $config['urls'] = [];
    foreach ($_GET['text'] as $key => $value) {
        $config['urls'][] = [
            'text' => trim(daddslashes($value)),
            'url'  => strip_tags(trim(daddslashes($_GET['url'][$key]))),
            'type' => trim(daddslashes($_GET['type'][$key])),
        ];
    }
    csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json', $config); //创建配置文件
    cpsuccess(lang('plugin/payment', 'save'), ['op' => $_GET['op'], 'method_id' => $method_id]);
}
formheader([
    'op'        => $_GET['op'],
    'method_id' => $method_id,
]);
showtableheader(lang('plugin/payment', 'editurl') . $config['name']);
showsubtitle(['', lang('plugin/payment', 'text'), lang('plugin/payment', 'url'), lang('plugin/payment', 'type')]);
foreach ($config['urls'] as $setting) {
    showsettingrow($setting['text'], $setting['url'], $setting['type']);
}
showsubmit('submit', 'submit', '<a href="javascript:void(0);" onclick="addnewrow(this)" class="addtr">' . cplang('add') . '</a>');
showtablefooter();
showformfooter();
//添加行数据来源
showtableheader('', '', 'style="display:none" id="copytable"');
showsettingrow();
showtablefooter();

function showsettingrow($text = '', $url = '', $type = 'page') {
    $types = [
        'page'  => lang('plugin/payment', 'urlpage'),
        'blank' => lang('plugin/payment', 'urlblank'),
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
        '<input type="text" class="txt" name="text[]" value="' . dhtmlspecialchars(dstripslashes($text)) . '" style="width:200px"/>',
        '<input type="text" class="txt" name="url[]" value="' . $url . '" style="width:200px"/>',
        '<select name="type[]">' . $typecode . '</select>',
    ]);
}
?>
<script src="./source/plugin/csu_base/js/jquery-3.4.1.min.js"></script>
<script src="./source/plugin/payment/src/admin.js"></script>
