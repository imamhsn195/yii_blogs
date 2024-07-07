<ul class="list-group">
    <li class="list-group-item">
        <h1>Add Post</h1>
        <div class="form">

                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'post-form',
                    'enableAjaxValidation' => false,
                )); ?>

                <p class="note">Fields with <span class="required text-danger">*</span> are required.</p>

                <?php echo $form->errorSummary($model); ?>

                <div class="row">
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model, 'image_url'); ?>
                    <?php echo $form->textField($model, 'image_url', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'image_url'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model, 'content'); ?>
                    <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'content'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'is_public'); ?>
                    <?php echo $form->dropDownList($model, 'is_public', array(1 => 'Public', 0 => 'Private'), array('class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'is_public'); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Add Post', array('class' => 'btn btn-success mt-3')); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div>
    </li>
</ul>