<?php require_once 'layouts/header.php'?>
<?if (!empty($errors)):?>
    <?foreach ($errors as $error):?>
        <p class="error-auth"><?=$error?></p>
    <?endforeach;?>
<?endif;?>
<form method="post">
    <input type="hidden" name="login-submit" value="Y">
    <div class="form-group">
        <label for="exampleInputEmail1">Login</label>
        <input type="text" class="form-control" name="login">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Пароль</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>
<?php require_once 'layouts/footer.php'?>