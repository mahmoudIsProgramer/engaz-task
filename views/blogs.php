<?php

use app\core\form\Form;
use app\core\Application;

$form = new Form();

?>

<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Blogs</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="/blogs/create" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New Blog</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                     
                    <?php if (!empty($blogs)) : ?>
                        <?php foreach ($blogs as $blog) : ?>
                            <tr>
                                <td><?php echo  $blog->id; ?></td>
                                <td><?php echo  $blog->title; ?></td>
                                <td><?php echo  $blog->content; ?></td>
                                <td><?php echo  $blog->created_at; ?></td>
                                <?php  if (!Application::isGuest()): ?>
                                        <td>
                                            <a href="/blogs/edit?id=<?php echo $blog->id; ?>" class="btn btn-secondary">Edit</a>
                                            <form action="/blogs/delete" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                <input type="hidden" name="id" value="<?php echo $blog->id; ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>

                                        </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <p>No blogs found.</p>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
            <div class="clearfix">
                <!-- pagination -->
                <?php include __DIR__ . '/components/pagination.php'; ?>
            </div>
        </div>
    </div>
</div>