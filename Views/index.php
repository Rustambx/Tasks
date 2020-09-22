<?php require_once 'layouts/header.php'?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col" class="name"><a href="<?=$currentPage?>?sort=name&order=<?if ($sort == "name"):?><?=($order == "asc" ? "desc" : "asc")?><?else:?>desc<?endif;?>">Имя пользователя</a></th>
            <th scope="col" class="sortable"><a href="<?=$currentPage?>?sort=email&order=<?if ($sort == "email"):?><?=($order == "asc" ? "desc" : "asc")?><?else:?>desc<?endif;?>">E-mail</a></th>
            <th scope="col">Текст задачи</th>
            <th scope="col"><a href="<?=$currentPage?>?sort=status&order=<?if ($sort == "status"):?><?=($order == "asc" ? "desc" : "asc")?><?else:?>desc<?endif;?>">Статус</a></th>
            <?if ($isAdmin):?>
                <th scope="col">Действие</th>
            <?endif;?>
        </tr>
        </thead>
        <tbody>
            <?foreach ($tasks as $task):?>
                <tr>
                    <th scope="row"><?=$task->id?></th>
                    <td><?=$task->name?></td>
                    <td><?=$task->email?></td>
                    <td><?=$task->text?></td>
                    <?if ($task->status == 0):?>
                        <td class="col_status">
                            Не выполнено
                            <?if ($task->edit_by_admin == 0):?>
                                <p></p>
                            <?else:?>
                                <p>/ Отредактировано администратором</p>
                            <?endif;?>
                        </td>
                    <?else:?>
                        <td class="col_status">
                            Выполнено
                            <?if ($task->edit_by_admin == 0):?>
                                <p></p>
                            <?else:?>
                                <p>/ Отредактировано администратором</p>
                            <?endif;?>
                        </td>
                    <?endif;?>
                    <?if ($isAdmin):?>
                        <th scope="col"><a href="/update/<?=$task->id?>" class="btn btn-primary">Редактировать</a></th>
                    <?endif;?>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>

    <?php if ($paginator->getNumPages() > 1): ?>
        <nav>
            <ul class="pagination">
                <?php if ($paginator->getPrevUrl()): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $paginator->getPrevUrl() . $urlQuery; ?>">&laquo; Пред.</a></li>
                <?php endif; ?>

                <?php foreach ($paginator->getPages() as $page): ?>
                    <?php if ($page['url']): ?>
                        <li <?php echo $page['isCurrent'] ? 'class="active page-item"' : 'page-item'; ?>>
                            <a class="page-link" href="<?php echo $page['url'] . $urlQuery; ?>"><?php echo $page['num']; ?></a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled"><span><?php echo $page['num']; ?></span></li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($paginator->getNextUrl()): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $paginator->getNextUrl() . $urlQuery; ?>">След. &raquo;</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php require_once 'layouts/footer.php'?>