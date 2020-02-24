<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Seolite', ['path' => '/'], function (RouteBuilder $routeBuilder) {
    $routeBuilder->prefix('admin', function (RouteBuilder $routeBuilder) {
        $routeBuilder->setExtensions(['json']);

        $routeBuilder->connect('/seo-lite/analyze', ['controller' => 'Analyze', 'action' => 'index']);
        $routeBuilder->connect('/seo-lite/urls', ['controller' => 'Urls', 'action' => 'index']);
        $routeBuilder->connect('/seo-lite/urls/:action/*', ['controller' => 'Urls']);
    });
});
