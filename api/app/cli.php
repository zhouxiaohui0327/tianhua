<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\CLI\Console as ConsoleApp;


define('VERSION', '1.0.0');
$di = new CliDI();
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)));


//加载配置文件（如果存在）
if(is_readable(APPLICATION_PATH . '/config/config.php')) {
    $config = include APPLICATION_PATH . '/config/config.php';
    $di->set('config', $config);
}


$loader = new \Phalcon\Loader();
$loader->registerDirs(
//    array(
//        APPLICATION_PATH . '/tasks'
//    )
    array(
        APPLICATION_PATH . '/tasks',
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->pluginsDir
    )

);
$loader->register();


$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        "charset" => $config->database->charset
    ));
});

// 创建console应用
$console = new ConsoleApp();
$console->setDI($di);

/**
 * 处理console应用参数
 */
$arguments = array();
foreach($argv as $k => $arg) {
    if($k == 1) {
        $arguments['task'] = $arg;
    } elseif($k == 2) {
        $arguments['action'] = $arg;
    } elseif($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

// 定义全局的参数， 设定当前任务及action
define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
    // 处理参数
    $console->handle($arguments);
}
catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}

