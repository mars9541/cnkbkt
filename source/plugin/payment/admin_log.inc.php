<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/payment/admin.common.php';

echo '<script src="static/js/calendar.js"></script>';

$urlparams = ['param', 'type', 'method', 'method_id', 'status', 'begin_time', 'end_time'];
$url       = [];
foreach ($urlparams as $key) {
    if ($_GET[$key]) {
        $url[$key] = urlencode($_GET[$key]);
    }
}
if (submitcheck('submit')) {
    //删除
    if ($_GET['delete']) {
        foreach ($_GET['delete'] as $key => $value) {
            C::t('#payment#payment_log')->delete(dintval($value));
        }
    }
    cpsuccess(lang('plugin/payment', 'delete_success'), $url);
}

//生成搜索表单
formheader(['search' => true]);
showtableheader(lang('plugin/payment', 'search'));
showtablerow('', [], [
    lang('plugin/payment', 'log_detail'), '<input type="text" class="txt" name="param" value="' . $_GET['param'] . '" placeholder="' . lang('plugin/payment', 'like') . '" style="width:150px;">',
    lang('plugin/payment', 'type'), showselect('type', [1 => lang('plugin/payment', 'log_type_1'), 2 => lang('plugin/payment', 'log_type_2'), 3 => lang('plugin/payment', 'log_type_3')], $_GET['type'], lang('plugin/payment', 'all')),
    lang('plugin/payment', 'method'), '<input type="text" class="txt" name="method" value="' . $_GET['method'] . '" style="width:120px">',
    lang('plugin/payment', 'status'), showselect('status', [2 => lang('plugin/payment', 'success'), 1 => lang('plugin/payment', 'fail')], $_GET['status'], lang('plugin/payment', 'all')),
    lang('plugin/payment', 'create_time'), '<input type="text" class="txt" name="begin_time" value="' . $_GET['begin_time'] . '" style="width:80px;margin-right: 5px;" onclick="showcalendar(event, this,true)" placeholder="' . lang('plugin/payment', 'begin_time') . '">--<input type="text" class="txt" name="end_time" value="' . $_GET['end_time'] . '" style="width:80px;margin-left: 5px;" onclick="showcalendar(event, this,true)" placeholder="' . lang('plugin/payment', 'end_time') . '">',
    '<button type="submit" class="btn">' . lang('plugin/payment', 'schbtn') . '</button>',
]);
showtablefooter();
showformfooter();
//搜索
$sql = sql('payment_log');

if ($_GET['param']) {
    $sql->whereRaw("(concat_ws(',',order_id,comment) LIKE '%" . daddslashes($_GET['param']) . "%')");
}
if ($_GET['type']) {
    $sql->where('type', dintval($_GET['type']));
}
if ($_GET['method']) {
    $sql->whereRaw("(concat_ws(',',type_id,type_method) LIKE '%" . daddslashes($_GET['method']) . "%')");
}
if ($_GET['method_id']) {
    $sql->where('method_id', daddslashes($_GET['method_id']));
}
if ($_GET['status']) {
    $sql->where('status', dintval($_GET['status'] - 1));
}
if ($_GET['begin_time']) {
    $sql->where('create_time', '>=', csubase::mktime($_GET['begin_time']));
}
if ($_GET['end_time']) {
    $sql->where('create_time', '<=', csubase::mktime($_GET['end_time']) + 59);
}
$page = max(1, dintval($_GET['page']));
$num  = 20;

$count = $sql->count();
$list  = $sql->order('log_id', 'DESC')->page($page, $num)->select();
formtableheader($url);
showsubtitle([
    '',
    'ID',
    lang('plugin/payment', 'order_id'),
    lang('plugin/payment', 'method'),
    lang('plugin/payment', 'status'),
    lang('plugin/payment', 'create_time'),
    'IP',
    lang('plugin/payment', 'addition'),
    cplang('detail'),
]);

foreach ($list as $item) {
    echo '<tbody>';
    showtablerow('', [], [
        '<input type="checkbox" name="delete[]" value="' . $item['log_id'] . '">',
        $item['log_id'],
        $item['type'] != 3 ? '<a href="' . ADMINSCRIPT . '?action=plugins&operation=config&do=' . $pluginid . '&identifier=' . $plugin['identifier'] . '&pmod=admin_order&order_id=' . $item['order_id'] . '">' . $item['order_id'] . '</a>' : $item['order_id'],
        lang('plugin/payment', 'log_type_' . $item['type']) . '&nbsp;' .
        $item['type_id'] . '&nbsp;' .
        $item['type_method'],
        $item['status'] ? lang('plugin/payment', 'success') : lang('plugin/payment', 'fail'),
        dgmdate($item['create_time'], 'Y-m-d H:i:s'),
        $item['create_ip'],
        dhtmlspecialchars(dstripslashes($item['comment'])),
        '<a href="javascript:;" onclick="togglecplog(' . $item['log_id'] . ')">' . cplang('detail') . '</a>',
    ]);
    echo '</tbody>';
    echo '<tbody id="cplog_' . $item['log_id'] . '" style="display:none;">';
    echo '<tr>
    <td>' . lang('plugin/payment', 'log_params') . '</td>' .
    '<td colspan="3" style="word-break: break-all;word-wrap: break-word;width:500px">' . csubase::json_encode(dunserialize($item['params'])) . '</td>' .
    '<td>' . lang('plugin/payment', 'result') . '</td>' .
    '<td colspan="3" style="word-break: break-all;word-wrap: break-word;width:500px">' . csubase::json_encode(dhtmlspecialchars(dunserialize($item['result']))) . '</td></tr>';
    echo '</tbody>';

}
showsubmit('submit', 'submit', 'del', '', multi($count, $num, $page, A_URL . http_build_query($url)), false);
formtablefooter();
?>
<script type="text/javascript">
function togglecplog(k) {
    var cplogobj = $('cplog_'+k);
    if(cplogobj.style.display == 'none') {
        cplogobj.style.display = '';
    } else {
        cplogobj.style.display = 'none';
    }
}
</script>