<ul class="list-group">
    <li class="list-group-item">
        <h1>Sign Up</h1>
        <div class="form">

                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'signup-form',
                    'enableAjaxValidation' => false,
                )); ?>

                <p class="note">Fields with <span class="required text-danger">*</span> are required.</p>

                <?php echo $form->errorSummary($model); ?>

                <div class="row">
                    <?php echo $form->labelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'Confirm Password'); ?>
                    <?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'password_repeat'); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('SignUp', array('class' => 'btn btn-success mt-3')); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div>
    </li>
</ul>