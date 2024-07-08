<ul class="list-group">
    <li class="list-group-item">
        <h1>Sign In</h1>
        <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                ));?>

                <p class="note">Fields with <span class="required text-danger">*</span> are required.</p>
                <div class="row">
                    <?php echo HtmlHelper::requiredLabelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'username', array('id'=>"username-status", 'class' => 'text-danger')); ?>
                </div>

                <div class="row">
                    <?php echo HtmlHelper::requiredLabelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'password', array('id'=>"password-status", 'class' => 'text-danger')); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('SignIn', array('class' => 'btn btn-success mt-3')); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div>
    </li>
</ul>