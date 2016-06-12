<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Seolite', ['path' => '/'], function (RouteBuilder $routeBuilder) {
    $routeBuilder->prefix('admin', function (RouteBuilder $routeBuilder) {
        $routeBuilder->extensions(['json']);

        $routeBuilder->connect('/seo-lite/urls/:action', ['controller' => 'Urls']);
    });
});
