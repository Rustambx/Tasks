<?php
namespace Task;

class Routes
{
    const SITE_DIR = '/';

    public static function init ()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', self::SITE_DIR . '', 'index');
            $r->addRoute('GET', self::SITE_DIR . 'page/{page:\d+}/', 'index');
            $r->addRoute(['GET', 'POST'], self::SITE_DIR . 'create', 'create');
            $r->addRoute(['GET', 'POST'], self::SITE_DIR . 'update/{id:\d+}', 'update');
            $r->addRoute('GET', self::SITE_DIR . 'admin', 'admin');
            $r->addRoute('GET', self::SITE_DIR . 'admin/page/{page:\d+}/', 'admin');
            $r->addRoute(['GET', 'POST'], self::SITE_DIR . 'login', 'login');
            $r->addRoute('GET', self::SITE_DIR . 'logout', 'logout');
        });

        self::routeHandler($dispatcher);
    }

    public static function routeHandler (\FastRoute\Dispatcher $dispatcher)
    {
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                call_user_func_array(array(new Controller, "notFound"), []);
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                call_user_func_array(array(new Controller, $handler), $vars);
                break;
        }
    }
}