<?php
 


use app\core\Application;
use app\controllers\BlogController;
use app\controllers\SiteController;
use app\controllers\AboutController;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config = [
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->on(Application::EVENT_BEFORE_REQUEST, function(){
    // echo "Before request from second installation";
});

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/register', [SiteController::class, 'register']);
$app->router->post('/register', [SiteController::class, 'register']);
$app->router->get('/login', [SiteController::class, 'login']);
$app->router->get('/login/{id}', [SiteController::class, 'login']);
$app->router->post('/login', [SiteController::class, 'login']);
$app->router->get('/logout', [SiteController::class, 'logout']);
$app->router->get('/blogs', [BlogController::class, 'index']);
$app->router->get('/blogs/create', [BlogController::class, 'create']);
$app->router->post('/blogs/store', [BlogController::class, 'store']);
$app->router->get('/blogs/edit', [BlogController::class, 'edit']);
$app->router->post('/blogs/update', [BlogController::class, 'update']);
$app->router->post('/blogs/delete', [BlogController::class, 'delete']);
$app->router->get('/profile', [SiteController::class, 'profile']);
$app->router->get('/profile/{id:\d+}/{username}', [SiteController::class, 'login']);
 
$app->run();
