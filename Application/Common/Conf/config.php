<?php
return array(
    'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  'www.shop.com', // 服务器地址
    'DB_NAME'               =>  'php39',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '111',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'p39_',    // 数据库表前缀
    'DEFAULT_FILTER'        =>  'trim,htmlspecialchars',
    
    /*********图片相关配置************/
    'IMAGE_CONFIG'          =>  array(
        'maxSize'           =>  1024 * 1024 * 10,
        'exts'              =>  array('jpg','gif','png','jpeg'),
        'rootPath'          =>  './Public/Uploads/',
        'viewPath'          =>  'http://www.shop.com/Public/Uploads/',
    ),
);