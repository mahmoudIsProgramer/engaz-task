<?php

namespace app\controllers;

use app\models\Blog;
use app\core\Request;
use app\core\Response;
use app\core\Controller;
use app\core\Application;
use app\services\BlogService;
use app\traits\ResponseTrait;

class BlogController extends Controller
{
    use ResponseTrait;
    protected BlogService $blogService;
    public function __construct()
    {
        $this->setLayout('main');
        $this->blogService = new BlogService();
        // $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function create(Request $request)
    {
        // return $this->sendResponse('ali', "");

        $blogModel = new Blog();
        return $this->render('create_blog', [
            'model' => $blogModel
        ]);
    }

    public function index(Request $request)
    {
        return $this->render('blogs', $this->blogService->getBlogs($request)   );
    }

    public function store(Request $request)
    {
        $blogModel = new Blog();

        if ($request->getMethod() === 'post') {
            $data = $request->getBody();
            $blogModel = $this->blogService->createBlog($blogModel,$data);

            if (count($blogModel->errors)==0) {
                // Application::$app->session->setFlash('success', 'Blog Created Successfully');
                Application::$app->response->redirect('/blogs');
                return;
            }
        }
        return $this->render('create_blog', [
            'model' => $blogModel
        ]);
    }


    // public function store(Request $request)
    // {
    //     $blogModel = new Blog();
    //     if ($request->getMethod() === 'post') {

    //         $blogModel->loadData($request->getBody());
    //         if ($blogModel->validate() && $blogModel->save()) {
    //             Application::$app->session->setFlash('success', 'Blog Created Successfully');
    //             Application::$app->response->redirect('/blogs');
    //         }
    //     }
    //     return $this->render('create_blog', [
    //         'model' => $blogModel
    //     ]);
    // }

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
            Application::$app->response->redirect('/blogs');
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
        $blog = Blog::findOne(['id' => $id]);

        // if ($blog === null) {
        //     // Handle case where blog is not found
        //     $response->setStatusCode(404);
        //     return $response->render('errors/404');
        // }

        if ($blog->delete()) {
            Application::$app->session->setFlash('success', 'Blog Deleted Successfully');
            Application::$app->response->redirect('/blogs');
        } else {
            Application::$app->session->setFlash('error', 'Failed to delete the blog');
            Application::$app->response->redirect('/blogs');
        }
    }
}
