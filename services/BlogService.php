<?php

namespace app\services;

use app\models\Blog;
use app\core\Application;
use app\traits\ResponseTrait;

class BlogService
{
    use ResponseTrait;

    // public function getBlogs(int $currentPage, int $perPage)
    public function getBlogs($request)
    {
        $currentPage = $request->getQuery('page', 1);
        $perPage = $request->getQuery('perPage', 2);
        
        $offset = ($currentPage - 1) * $perPage;
        $blogs = Blog::query()
            ->orderBy('id', 'DESC')
            ->limit($perPage)
            ->offset($currentPage, $perPage)
            ->get();

        $totalRecords = Blog::countAll();
        $totalPages = ceil($totalRecords / $perPage);

        return compact('blogs', 'totalRecords', 'totalPages', 'currentPage', 'perPage');
    }

    public function createBlog(Blog $blogModel,array $data)
    {
        // $blogModel = new Blog();
      
        $blogModel->loadData($data);

        if ($blogModel->validate() && $blogModel->save()) {
            // echo var_dump($blogModel->id);
            // return; 
            Application::$app->session->setFlash('success', 'Blog Created Successfully');
            return $blogModel;
        }
        
        return $blogModel;
    }

    // public function createBlog(array $data): bool
    // {
    //     $blog = new Blog();
    //     $blog->loadData($data);
    //     if ($blog->validate() && $blog->save()) {
    //         return true;
    //     }
    //     return false;
    // }



    public function getBlogById(int $id): ?Blog
    {
        return Blog::findOne(['id' => $id]);
    }

    public function updateBlog(array $data): ?Blog
    {
        $blog = Blog::findOne(['id' => $data['id']]);
        if (!$blog) {
            return null;
        }

        $blog->loadData($data);
        if ($blog->validate() && $blog->update()) {
            Application::$app->session->setFlash('success', 'Blog Updated Successfully');
            return $blog;
        }

        return $blog;
    }

    public function deleteBlog(int $id): bool
    {
        $blog = Blog::findOne(['id' => $id]);
        if (!$blog) {
            return false;
        }

        return $blog->delete();
    }
}
