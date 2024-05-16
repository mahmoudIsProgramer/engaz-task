<?php

namespace app\controllers;

use app\models\Blog;
use app\core\Request;
use app\core\Response;
use app\core\Controller;
use app\core\Application;
use app\services\BlogService;
use app\traits\ResponseTrait;
use app\core\middlewares\AuthMiddleware;

class BlogController extends Controller
{
    use ResponseTrait;
    protected BlogService $blogService;
    public function __construct()
    {
        $this->setLayout('main');
        $this->blogService = new BlogService();
        $this->registerMiddleware(new AuthMiddleware(['create','store','edit','update','delete']));
    }

    public function index(Request $request)
    {
        return $this->render('blogs', $this->blogService->getBlogs($request)   );
    }

    public function create(Request $request)
    {
        $blogModel = new Blog();
        return $this->render('create_blog', [
            'model' => $blogModel
        ]);
    }


    public function store(Request $request)
    {
        $blogModel = new Blog();

        if ($request->getMethod() === 'post') {
            $data = $request->getBody();
            $blogModel = $this->blogService->createBlog($blogModel,$data);

            if (count($blogModel->errors)==0) {
                Application::$app->response->redirect('/');
                return;
            }
        }
        return $this->render('create_blog', [
            'model' => $blogModel
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->getQuery('id');
        $blog = Blog::findOne(['id' => $id]);
        return $this->render('edit_blog', [
            'model' => $blog,
        ]);
    }

    public function update(Request $request, Response $response)
    {
        $id = $request->getBody()['id'];
        $blog = Blog::findOne(['id' => $id]);

        $blog->loadData($request->getBody());

        if ($blog->validate() && $blog->update()) {
            Application::$app->session->setFlash('success', 'Blog Updated Successfully');
            Application::$app->response->redirect('/');
            return 'Show success page';
        } else {
            return $this->render('edit_blog', [
                'model' => $blog,
            ]);
        }
    }


    public function delete(Request $request, Response $response)
    {

        $id = $request->getBody()['id'];
        $this->blogService->deleteBlog($id);
        $blog = Blog::findOne(['id' => $id]);
        Application::$app->session->setFlash('success', 'Blog Deleted Successfully');
        Application::$app->response->redirect('/');
    }
}
