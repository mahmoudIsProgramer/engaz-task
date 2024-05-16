<?php

use app\core\form\Form;
$form = new Form();

?>
<h1>Edit Blog </h1>

<?php $form = Form::begin('/blogs/update', 'post') ?>
    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'title') ?>
        </div>
        <div class="col">
            <?php echo $form->field($model, 'content') ?>
        </div>
        <!-- <input type="hidden" name="id" value="1000000"> -->
        <input type="hidden" name="id" value="<?php echo $model->id; ?>">
    </div>
    <button class="btn btn-success">Update</button>
<?php Form::end() ?>
