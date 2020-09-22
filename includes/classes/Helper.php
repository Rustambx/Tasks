<?php

namespace Task;

use Wa72\Url\Url;

class Helper
{
    /**
     * Получения url страницы без параметров
     * @return string
     */
    public static function getCurrentUrl ()
    {
        $obUrl = Url::parse($_SERVER['REQUEST_URI']);
        return $obUrl->getPath();
    }

    public static function getUrlParams ()
    {
        $obUrl = Url::parse($_SERVER['REQUEST_URI']);
        return "?" . $obUrl->getQuery();
    }
}