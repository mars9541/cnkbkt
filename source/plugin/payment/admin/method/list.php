<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}

//接口列表
showtableheader('<a href="' . ADMINSCRIPT . '?action=cloudaddons&id=payment.plugin">' . lang('plugin/payment', 'method_download') . '</a>' . showdev('&nbsp;' . aurl(lang('plugin/payment', 'method_new'), ['op' => 'design'])));

showsubtitle(
    ['LOGO', lang('plugin/payment', 'name'), lang('plugin/payment', 'intro'), lang('plugin/payment', 'version'), lang('plugin/payment', 'displayorder'), lang('plugin/payment', 'status'), lang('plugin/payment', 'op'), showdev(lang('plugin/payment', 'design'))],
    'header',
    ['style="width:40px"', 'style="width:120px"', 'style="min-width:150px"', 'style="width:80px"', 'style="width:80px"', 'style="width:80px"', 'style="min-width:200px"', 'style="min-width:150px"']
);
$apiList = scandir(PAYMENT_METHOD_ROOT); //获取api目录
foreach ($apiList as $key) {
    if ($key == '.' || $key == '..' || !is_file(PAYMENT_METHOD_ROOT . $key . '/config.json')) {
        continue;
    }

    $item = csubase::json_file(PAYMENT_METHOD_ROOT . $key . '/config.json'); //配置文件
    $sql  = C::t('#payment#payment_method')->fetch($key); //判断是否安装
    $op   = [];
    if (!$sql) {
        //未安装
        $op[] = aurl(lang('plugin/payment', 'install'), [
            'op'        => 'install',
            'method_id' => $key,
            'formhash'  => FORMHASH,
        ]);
        $status = '<span style="color:red">' . lang('plugin/payment', 'notinstall') . '</span>';
    } else {
        //已安装
        $op[] = aurl(lang('plugin/payment', 'setting'), [
            'op'        => 'setting',
            'method_id' => $key,
        ]);
        if ($sql['available']) {
            //已启用
            $status = '<span style="color:green">' . lang('plugin/payment', 'availabled') . '</span>';
            $op[]   = aurl(lang('plugin/payment', 'unavailable'), [
                'op'        => 'unavailable',
                'method_id' => $key,
                'formhash'  => FORMHASH,
            ]);
        } else {
            //未启用
            $status = '<span style="color:blue">' . lang('plugin/payment', 'unavailabled') . '</span>';
            $op[]   = aurl(lang('plugin/payment', 'available'), [
                'op'        => 'available',
                'method_id' => $key,
                'formhash'  => FORMHASH,
            ]);
        }
        //卸载
        $op[] = aurl(lang('plugin/payment', 'uninstall'), [
            'op'        => 'uninstall',
            'method_id' => $key,
            'formhash'  => FORMHASH,
        ]);
    }
    if ($item['urls']) {
        foreach ($item['urls'] as $value) {
            $op[] = $value['type'] == 'page' ? aurl($value['text'], ['op' => 'url', 'method_id' => $key, 'page' => $value['url']]) : ('<a href="' . ($value['url']) . '" target="_blank">' . ($value['text']) . '</a>');
        }
    }
    showtablerow('', [],
        [
            '<img src="source/plugin/payment/method/' . $item['method_id'] . '/logo.png" height="31px">',
            $item['name'] . '(' . $item['method_id'] . ')<br>' . $sql['title'],
            dstripslashes($item['description']),
            $item['version'],
            $sql['displayorder'],
            $status,
            implode('&nbsp;', $op),
            showdev(aurl(lang('plugin/payment', 'design'), [
                'op'        => 'design',
                'method_id' => $key,
            ]) . '&nbsp;' . aurl(lang('plugin/payment', 'settings'), [
                'op'        => 'settings',
                'method_id' => $key,
            ]) . '&nbsp;' . aurl(lang('plugin/payment', 'payment_url'), [
                'op'        => 'urls',
                'method_id' => $key,
            ])),
        ]
    );
}

showtablefooter();
?>