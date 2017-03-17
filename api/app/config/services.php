<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as Dispatcher;

use Phalcon\Mvc\Router;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {
            $volt = new VoltEngine($view, $di);
            $volt->setOptions(array(
                'compiledPath' => $config->application->voltDir,
                'compiledSeparator' => '_'
			));
			$compiler = $volt->getCompiler();
			$compiler->addFilter('fix8hour', function($resolvedArgs, $exprArgs) {
				return 'date(' . '"Y-m-d H:i:s"' .', strtotime('. $resolvedArgs .')' .' + 28800)';
			});
			
            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        "charset" => $config->database->charset
    ));
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

//
//$di->set('dispatcher', function () {
//    $eventsManager = new EventsManager;
//    $eventsManager->attach('dispatch:beforeDispatch', new Security);
//    $dispatcher = new Dispatcher;
//    $dispatcher->setEventsManager($eventsManager);
//    return $dispatcher;
//});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

$di->set('crypt', function() {
    $crypt = new Phalcon\Crypt();
    $crypt->setPadding(\Phalcon\Crypt::PADDING_ZERO);
    $crypt->setKey('adieockf73k4o9rf');
    return $crypt;
});

$di->set('router',function(){
    $router = new Router();
    $router->add("/help", array( "controller" => 'about',"action" => 'help'));
    $router->add("/custom", array( "controller" => 'about',"action" => 'custom'));
    return $router;
});

