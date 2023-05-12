<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
showtableheader(lang('plugin/payment', 'install_sql') . ':' . $config['api_id']);
$checkcode = 'if (!DB::fetch_first(\'SELECT * FROM information_schema.tables WHERE table_name=%s\', [DB::table(\'payment_api\')])) {
    cpmsg_error(\'' . lang('plugin/payment', 'payment_install') . '\', \'action=cloudaddons&id=payment.plugin\');
}
if (!in_array(\'payment\', $_G[\'setting\'][\'plugins\'][\'available\'])) {
    cpmsg_error(\'' . lang('plugin/payment', 'payment_available') . '\');
}';
showtablerow('', [], [
    'check.php',
    '<textarea class="tarea" style="width:800px;height:90px;" readonly onfocus="this.select()">' . $checkcode . '</textarea>',
]);
$enablecode = 'if (!DB::fetch_first(\'SELECT * FROM information_schema.tables WHERE table_name=%s\', [DB::table(\'payment_api\')])) {
    cpmsg_error(\'' . lang('plugin/payment', 'payment_install') . '\', \'action=cloudaddons&id=payment.plugin\');
}
if (!in_array(\'payment\', $_G[\'setting\'][\'plugins\'][\'available\'])) {
    cpmsg_error(\'' . lang('plugin/payment', 'payment_available') . '\');
}';
showtablerow('', [], [
    'enable.php',
    '<textarea class="tarea" style="width:800px;height:90px;" readonly onfocus="this.select()">' . $checkcode . '</textarea>',
]);
$installcode = 'if (DB::fetch_first(\'SELECT * FROM information_schema.tables WHERE table_name=%s\', [DB::table(\'payment_api\')])) {
    C::t(\'#payment#payment_api\')->insert([';
foreach ($config as $key => $value) {
    $installcode .= "\n\t\t'{$key}' => '" . str_replace("'", "\'", $value) . "',";
}
$installcode .= "\n\t]);
}";
showtablerow('', [], [
    'install.php',
    '<textarea class="tarea" style="width:800px;height:150px;" readonly onfocus="this.select()">' . $installcode . '</textarea>',
]);
$uninstallcode = 'if (DB::fetch_first(\'SELECT * FROM information_schema.tables WHERE table_name=%s\', [DB::table(\'payment_api\')])) {
    C::t(\'#payment#payment_api\')->delete(\'' . $config['api_id'] . '\');
}';
showtablerow('', [], [
    'uninstall.php',
    '<textarea class="tarea" style="width:800px;height:50px;" readonly onfocus="this.select()">' . $uninstallcode . '</textarea>',
]);
showtablefooter();
?>