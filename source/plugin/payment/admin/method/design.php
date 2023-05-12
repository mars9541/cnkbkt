<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
//设计接口
$method_id = csubase::getMod($_GET['method_id']); //标识
$config    = csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json');
if (submitcheck('submit')) {
    if (!$method_id) {
        cpmsg_error(lang('plugin/payment', 'input_identifier'));
    }

    $dir = PAYMENT_METHOD_ROOT . $method_id . '/';
    if (!is_dir($dir)) {
        dmkdir($dir);
    }
    $newconfig = [
        'method_id'   => $method_id,
        'user_agent'  => trim(daddslashes($_GET['user_agent'])),
        'name'        => trim(daddslashes($_GET['name'])),
        'title'       => trim(daddslashes($_GET['title'])),
        'version'     => trim(daddslashes($_GET['version'])),
        'description' => trim(daddslashes($_GET['description'])),
        'install'     => dintval($_GET['install']),
        'uninstall'   => dintval($_GET['uninstall']),
    ];
    if ($config['urls']) {
        $newconfig['urls'] = $config['urls']; //自定义连接
    }

    csubase::json_file($dir . 'config.json', $newconfig); //创建配置文件

    if (sql('payment_method')->exist(['method_id' => $config['method_id']])) {
        //已安装同时更新数据库
        C::t('#payment#payment_method')->update($config['method_id'], ['method_id' => $config['method_id'], 'user_agent' => $config['user_agent']]);
    }
    cpsuccess(lang('plugin/payment', 'save'), ['op' => 'design', 'method_id' => $newconfig['method_id']]);
}
showtableheader(lang('plugin/payment', 'method_design'));
showformheader(FORM_URL . 'op=design' . ($_GET['method_id'] ? '&method_id=' . $_GET['method_id'] : ''));
showsetting(lang('plugin/payment', 'name'), 'name', $config['name'], 'text');
showsetting(lang('plugin/payment', 'title'), 'title', $config['title'], 'text');
showsetting(lang('plugin/payment', 'api_id'), !$_GET['method_id'] ? 'method_id' : '', $config['method_id'], 'text', $_GET['method_id']);
showsetting(lang('plugin/payment', 'intro'), 'description', $config['description'], 'textarea');
showsetting(lang('plugin/payment', 'version'), 'version', $config['version'], 'text');
showsetting('HTTP_USER_AGENT', 'user_agent', $config['user_agent'], 'text', '', 0, lang('plugin/payment', 'user_agent'));
showsetting(lang('plugin/payment', 'install_file'), 'install', $config['install'], 'radio');
showsetting(lang('plugin/payment', 'uninstall_file'), 'uninstall', $config['uninstall'], 'radio');
showsubmit('submit');
showformfooter();
showtablefooter();
?>