<ul class="list-group">
    <li class="list-group-item">
        <h1>Sign Up</h1>
        <div class="form">

                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'signup-form',
                    'enableAjaxValidation' => false,
                )); ?>

                <p class="note">Fields with <span class="required text-danger">*</span> are required.</p>

                <div class="row">
                    <?php echo HtmlHelper::requiredLabelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 255, 'id' => 'username', 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'username', array('id'=>"username-status", 'class' => 'text-danger')); ?>
                    <div id="username-status"></div>
                </div>

                <div class="row">
                    <?php echo HtmlHelper::requiredLabelEx($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255, 'id' => 'email', 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'email', array('id'=>"email-status", 'class' => 'text-danger')); ?>
                    <div id="email-status"></div>
                </div>

                <div class="row">
                    <?php echo HtmlHelper::requiredLabelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255, 'id' => 'password', 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'password', array('id'=>"password-status", 'class' => 'text-danger')); ?>
                </div>

                <div class="row">
                    <?php echo HtmlHelper::requiredLabelEx($model, 'Confirm Password'); ?>
                    <?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 255, 'id' => 'password_repeat', 'class' => 'form-control mb-3')); ?>
                    <?php echo $form->error($model, 'password_repeat', array('id'=>"password_repeat-status", 'class' => 'text-danger')); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('SignUp', array('class' => 'btn btn-success mt-3')); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div>
    </li>
</ul>

<script>
document.getElementById('email').addEventListener('blur', function() {
    var email = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "<?=Yii::app()->createUrl('site/checkEmail')?>", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            // Success!
            var response = JSON.parse(this.responseText);
            var emailStatus = document.getElementById('email-status');
            emailStatus.innerHTML = response.message;

            if (response.status == 201) {
                emailStatus.classList.add('text-success');
                emailStatus.classList.remove('text-danger');
            } else {
                emailStatus.classList.remove('text-success');
                emailStatus.classList.add('text-danger');
            }
        } else {
            console.error('Server error:', this.responseText);
        }
    };
    xhr.onerror = function () {
        console.error('Connection error');
    };
    xhr.send('email=' + encodeURIComponent(email));
});

document.getElementById('username').addEventListener('blur', function() {
    var username = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "<?=Yii::app()->createUrl('site/checkUsername')?>", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            // Success!
            var response = JSON.parse(this.responseText);
            var usernameStatus = document.getElementById('username-status');
            usernameStatus.innerHTML = response.message;

            if (response.status == 201) {
                usernameStatus.classList.add('text-success');
                usernameStatus.classList.remove('text-danger');
            } else {
                usernameStatus.classList.remove('text-success');
                usernameStatus.classList.add('text-danger');
            }
        } else {
            console.error('Server error:', this.responseText);
        }
    };
    xhr.onerror = function () {
        console.error('Connection error');
    };
    xhr.send('username=' + encodeURIComponent(username));
});
</script>
