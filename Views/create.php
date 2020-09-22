<?php require_once 'layouts/header.php'?>
    <form method="post" class="add-form">
        <div class="form-group">
            <label for="exampleInputName">Имя пользователя</label>
            <input type="text" name="name" class="form-control" id="exampleInputName">
            <span class="error"><?=$errors['name']?></span>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">E-mail</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <span class="error"><?=$errors['email']?></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Текст задачи</label>
            <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"></textarea>
            <span class="error"><?=$errors['text']?></span>
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
<?php require_once 'layouts/footer.php'?>