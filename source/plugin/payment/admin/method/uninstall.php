<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}
if (submitcheck('op', 1)) {
    //卸载
    $method_id = csubase::getMod($_GET['method_id']); //标识
    //校验是否已经添加过了
    $method = sql('payment_method')->where(['method_id' => $method_id])->value('title');
    if (!$method) {
        cpmsg_error(lang('plugin/payment', 'method_not_exist'));
    }
    if (!$_GET['step']) {
        cpmsg(lang('plugin/payment', 'uninstall_confirm', ['text' => $method]), CP_URL . 'op=uninstall&step=1&method_id=' . $_GET['method_id'], 'form', '', FALSE);
    } else {
        //读取配置文件
        $config = csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json');
        if ($config['uninstall']) {
            if (is_file(PAYMENT_METHOD_ROOT . $method_id . '/uninstall.php')) {
                include_once PAYMENT_METHOD_ROOT . $method_id . '/uninstall.php';
                if (!$finish) {
                    cpmsg_error(lang('plugin/payment', 'uninstall_fail'));
                }

            }
        }
        //入库
        C::t('#payment#payment_method')->delete($method_id);
        cpsuccess(lang('plugin/payment', 'uninstall_success'));
    }
}
?>