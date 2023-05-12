<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
showtableheader(showdev(aurl(lang('plugin/payment', 'api_new'), ['op' => 'design'])));
showsubtitle([
    lang('plugin/payment', 'plugin_name'),
    lang('plugin/payment', 'identifier'),
    lang('plugin/payment', 'api_id'),
    lang('plugin/payment', 'classfile'),
    lang('plugin/payment', 'description'),
    lang('plugin/payment', 'method_available'),
    showdev(lang('plugin/payment', 'dev')),
]);
$plugins = sql('payment_api')->select();
foreach ($plugins as $value) {
    showtablerow('', array(), array(
        sql('common_plugin')->where('identifier', $value['identifier'])->value('name'),
        $value['identifier'],
        $value['api_id'],
        $value['filename'],
        $value['description'],
        aurl(lang('plugin/payment', 'method_available'), [
            'op'     => 'payment',
            'api_id' => $value['api_id'],
        ]),
        showdev(aurl(lang('plugin/payment', 'design'), [
            'op'     => 'design',
            'api_id' => $value['api_id'],
        ]) . '&nbsp;' . aurl(lang('plugin/payment', 'install_sql'), [
            'op'     => 'sql',
            'api_id' => $value['api_id'],
        ])),
    ));
}
showtablefooter();
?>