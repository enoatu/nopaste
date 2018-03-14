<?php
#
# Atsushi ENOMOTO <enotiru@moove.co.jp>
# moove Co., Ltd.

error_reporting(E_ALL);

//オートローダ
$loader = new Phalcon\Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/'
    ]
)->register();

$di = new Phalcon\Di\FactoryDefault();

$di->set('view', function () {
        $view = new Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
});
$di->set('url', function () {
    $url = new Phalcon\Mvc\Url();
    $url->setBaseUri('/nopaste/');
     return $url;
});

$di->set('db', function() {
       return new DbAdapter(
            'host' => $_SERVER['HOST'],
            'username' => $_SERVER['USERNAME'],
            'password' => $_SERVER['PASSWORD'],
            'dbname' => $_SERVER['DBNAME'], 
        )
});

$application = new Phalcon\Mvc\Application($di);
try {
    $response = $application->handle();
    $response->send();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage() . PHP_EOL;
}



