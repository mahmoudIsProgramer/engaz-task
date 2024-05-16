<?php
 
namespace app\controllers;

use app\models\User;
use app\core\Request;
use app\core\Response;
use app\core\Controller;
use app\core\Application;
use app\models\LoginForm;
use app\core\middlewares\AuthMiddleware;

 
class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function home()
    {
        return $this->render('home', [
            'name' => 'Mahmoud'
        ]);
    }

    public function login(Request $request)
    {
        // echo '<pre>';
        // var_dump($request->getBody(), $request->getRouteParam('id'));
        // echo '</pre>';
        $loginForm = new LoginForm();
        if ($request->getMethod() === 'post') {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request)
    {
        $registerModel = new User();
        if ($request->getMethod() === 'post') {
            $registerModel->loadData($request->getBody());
            // echo var_dump($registerModel);
            // echo var_dump($registerModel->validate());
            // echo var_dump($registerModel->errors);
            
            // return ;
            if ($registerModel->validate() && $registerModel->save()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                return 'Show success page';
            }

        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $registerModel
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        return $this->render('profile');
    }

    public function profileWithId(Request $request)
    {
        echo '<pre>';
        var_dump($request->getBody());
        echo '</pre>';
    }
}
