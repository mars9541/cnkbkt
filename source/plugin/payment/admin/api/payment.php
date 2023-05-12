<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
//可用的支付方式
if (submitcheck('submit')) {
    C::t('#payment#payment_api')->update($api_id, [
        'method_rule' => dintval($_GET['method_rule']),
        'method_list' => trim(daddslashes($_GET['method_list'])),
    ]);
    cpsuccess(lang('plugin/payment', 'save'), ['op' => $_GET['op'], 'api_id' => $config['api_id']]);
}
formheader(['op' => $_GET['op'], 'api_id' => $api_id]);
showtableheader(lang('plugin/payment', 'method_available') . ':' . $config['api_id']);
showsetting(lang('plugin/payment', 'rule'), ['method_rule', [[0, lang('plugin/payment', 'blacklist')], [1, lang('plugin/payment', 'whitelist')]]], $config['method_rule'], 'select');
showsetting(lang('plugin/payment', 'method_identifier'), 'method_list', $config['method_list'], 'text', '', 0, lang('plugin/payment', 'method_identifier_tips'));
//获取所有已安装的支付接口
$methods = sql('payment_method')->field('method_id,title')->select();
foreach ($methods as $value) {
    showtablerow('', ['colspan=2'], ['<a href="javascript:void(0)" onclick="addpayment(\'' . $value['method_id'] . '\')">' . $value['title'] . '(' . $value['method_id'] . ')</a>']);
}
showsubmit('submit');
showtablefooter();
showformfooter();
echo '<script src="./source/plugin/csu_base/js/jquery-3.4.1.min.js"></script>
<script>
function addpayment(payment){
    var method_list = jQuery("input[name=method_list]").val().length > 0 ? jQuery("input[name=method_list]").val().split(",") : [];
    if(method_list.indexOf(payment)==-1){
        method_list.push(payment);
        jQuery("input[name=method_list]").val(method_list.join(","));
    }
}
</script>';
?>