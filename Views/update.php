<?php require_once 'layouts/header.php'?>
    <form method="post" class="add-form">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Текст задачи</label>
            <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="4"><?=$task->text?></textarea>
            <span class="error"><?=$errors['text']?></span>
        </div>
        <div class="form-group form-check">
            <?if ($task->status == true):?>
                <input type="checkbox" name="status"  checked class="form-check-input" id="exampleCheck1">
            <?else:?>
                <input type="checkbox" name="status" class="form-check-input" id="exampleCheck1">
            <?endif;?>
            <label class="form-check-label" for="exampleCheck1">Задача выполнена</label>
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
<?php require_once 'layouts/footer.php'?>