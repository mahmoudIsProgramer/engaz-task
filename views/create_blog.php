<?php

use app\core\form\Form;
$form = new Form();

?>

<h1>Create Blog</h1>

<?php $form = Form::begin('/blogs/store', 'post') ?>
    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'title') ?>
        </div>
        <div class="col">
            <?php echo $form->field($model, 'content') ?>
        </div>
    </div>
    <button class="btn btn-success">Submit</button>
<?php Form::end() ?>
