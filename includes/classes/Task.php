<?php

namespace Task;
use JasonGrimes\Paginator;

/**
 * Class Task
 * @package Task
 */
class Task extends DB
{
    const PAGER_COUNT = 3;

    /**
     * Разрешенные поля для сортировки
     * @var array
     */
    public static $arSortableFields = [
        "name",
        "email",
        "status"
    ];

    /**
     * Получения список задач из Request
     * @param $select
     * @param string|null $sort
     * @param string|null $order
     * @param int $page
     * @return array|\stdClass|null
     * @throws \Pixie\Exception
     */
    public static function getList ($select, string $sort = null, string $order = null, int $page = 1)
    {
        $tasks = [];
        $query = self::getConnection()->table('tasks')->select('*')->limit(self::PAGER_COUNT)->offset(($page - 1) * self::PAGER_COUNT);
        if ($sort) {
            $query->orderBy($sort, $order);
        }
        $tasks = $query->get();
        return $tasks;
    }

    /**
     * Сохранение задач
     * @param $request
     * @return array|string
     * @throws \Pixie\Exception
     */
    public static function save ($request)
    {
        $connection = self::getConnection();

        $name = htmlspecialchars($request['name']);
        $email = htmlspecialchars($request['email']);
        $text = htmlspecialchars($request['text']);
        $data = [
            'name' => $name,
            'email' => $email,
            'text' => $text,
            'status' => 0
        ];
        $query = $connection->table('tasks')->insert($data);

        return $query;
    }

    /**
     * Редактирование задач
     * @param $request
     * @param $id
     * @return bool|\Pixie\QueryBuilder\QueryBuilderHandler|null
     * @throws \Pixie\Exception
     */
    public static function update ($request, $id)
    {
        $connection = self::getConnection();
        $task = $connection->table('tasks')->where('id', $id)->get();
        $text = htmlspecialchars($request['text']);
        if ($request['status'] == true) {
            $status = true;
        } else {
            $status = false;
        }

        if ($task[0]->text != $text) {
            $edit_by_admin = true;
        } else {
            $edit_by_admin = false;
        }
        $data = [
            'text' => $text,
            'status' => $status,
            'edit_by_admin' => $edit_by_admin
        ];

        $query = $connection->table('tasks')->where('id', $id)->update($data);

        return $query;
    }

    /**
     * Функционал постраничной навигации
     * @param int $currentPage
     * @return Paginator
     * @throws \Pixie\Exception
     */
    public static function paginator (int $currentPage = 1)
    {
        $connection = self::getConnection();
        $totalItems = $connection->table('tasks')->count();
        $itemsPerPage = self::PAGER_COUNT;
        $urlPattern = '/page/(:num)/';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $paginator;
    }

    /**
     * Функционал постраничной навигации для админа
     * @param int $currentPage
     * @return Paginator
     * @throws \Pixie\Exception
     */
    public static function adminPaginator (int $currentPage = 1)
    {
        $connection = self::getConnection();
        $totalItems = $connection->table('tasks')->count();
        $itemsPerPage = self::PAGER_COUNT;
        $urlPattern = '/admin/page/(:num)/';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $paginator;
    }

    /**
     * Сортировка по тегу
     * @return bool|string
     */
    public static function getSortField ()
    {
        $field = htmlspecialchars($_REQUEST['sort']);
        if (in_array($field, self::$arSortableFields)) {
            return $field;
        } else {
            return false;
        }
    }

    /**
     * Сортировка по возрастанию или по убыванию
     * @return string
     */
    public static function getSortOrder ()
    {
        $order = strtolower(htmlspecialchars($_REQUEST['order']));
        if ($order == "desc") {
            return "desc";
        } else {
            return "asc";
        }
    }
}