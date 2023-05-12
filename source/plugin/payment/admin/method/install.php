<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}

if (submitcheck('op', 1)) {
    $method_id = csubase::getMod($_GET['method_id']); //标识

    //校验是否已经添加过了
    if (sql('payment_method')->exist(['method_id' => $method_id])) {
        cpmsg_error(lang('plugin/payment', 'method_installed'));
    }

    //判断接口是否存在
    if (!is_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json')) {
        cpmsg_error(lang('plugin/payment', 'config_not_exist'));
    }

    //读取配置文件
    $config = csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json');
    if ($config['install']) {
        if (is_file(PAYMENT_METHOD_ROOT . $method_id . '/install.php')) {
            include_once PAYMENT_METHOD_ROOT . $method_id . '/install.php';
            if (!$finish) {
                cpmsg_error(lang('plugin/payment', 'install_fail'));
            }

        }
    }
    $settings = [];
    if (is_file(PAYMENT_METHOD_ROOT . $method_id . '/setting.json')) {
        $settingFile = getsettings(PAYMENT_METHOD_ROOT . $method_id . '/setting.json');
        foreach ($settingFile as $value) {
            $settings[$value['key']] = $value['default'];
        }
    }
    //入库
    C::t('#payment#payment_method')->insert([
        'method_id'    => $method_id,
        'title'        => $config['title'] ? $config['title'] : $config['name'],
        'setting'      => serialize($settings),
        'available'    => 0,
        'displayorder' => 100,
    ]);
    cpsuccess(lang('plugin/payment', 'install_success'), [], 'succeed');

}
?>