<?php

require_once __DIR__ . '/bootstrap.php';

use Silex\Provider\FormServiceProvider;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
            'driver'    => 'pdo_pgsql',
            'host'      => 'ec2-54-228-219-2.eu-west-1.compute.amazonaws.com',
            'dbname'    => 'd3vnke52eblbbl',
            'user'      => 'lzmuqflpmwtzrt',
            'password'  => 'LPL23uI2xKUlFlZpUlSkmdnPP5',
            'port' => '5432', 
    ),
));

$app['swiftmailer.options'] = array(
	'host' => 'smtp.gmail.com',
	'port' => '465',
	'username' => 'demoform31@gmail.com',
	'password' => '****',
	'encryption' => 'ssl',
	'auth_mode' => 'login'
);
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);


$app->get('/', 'demoproductform\Controller\PageController::getHomePage');
$app->get('/products', 'demoproductform\Controller\PageController::getAllProducts');
$app->get('/product/{uuid}', 'demoproductform\Controller\ProductController::getProductDetailByUuid');
$app->post('/product/opinion/{uuidproduct}', 'demoproductform\Controller\ProductController::addOpinion');

return $app;
