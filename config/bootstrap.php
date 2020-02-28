<?php
use \Cake\Core\Configure;
use \Croogo\Core\Croogo;
use \Cake\Cache\Cache;
use \Croogo\Core\Nav;

Croogo::mergeConfig('Meta.keys', [
    'og:title' => [
        'label' => 'Open Graph Title',
        'type' => 'text',
        'help' => 'The title of your object as it should appear within the graph, e.g., "The Rock"',
    ],
    'og:type' => [
        'label' => 'Open Graph Type',
        'type' => 'text',
        'help' => 'The type of your object, e.g., "video.movie"',
    ],
    'og:image' => [
        'label' => 'Open Graph Image',
        'type' => 'text',
        'help' => 'An image URL which should represent your object within the graph',
    ],
    'og:video' => [
        'label' => 'Open Graph Video',
        'type' => 'text',
        'help' => 'A URL to a video file that complements this object.',
    ],
    'og:url' => [
        'label' => 'Open Graph URL',
        'type' => 'text',
        'help' => 'The canonical URL of your object that will be used as its permanent ID in the graph',
    ],
]);

$cacheConfig = array_merge(Configure::read('Croogo.Cache.defaultConfig'), ['groups' => ['seo_lite']]);
Cache::setConfig('seo_lite', $cacheConfig);

Croogo::hookHelper('*', 'Seolite.SeoLite');

$queryString = env('REQUEST_URI');
if (strpos($queryString, 'admin') === false) {
    return;
}

/*
 * stuff for /admin routes only
 */

$title = 'SEO';
$element = 'Croogo/Meta.admin/seo_tab';
Croogo::hookAdminTab('Admin/Urls/add', $title, $element);
Croogo::hookAdminTab('Admin/Urls/edit', $title, $element);

Nav::add('sidebar', 'content.children.urls', [
    'title' => 'Seo',
    'url' => 'javascript:void(0)',
    'children' => [
        'urls' => [
            'title' => __d('seo_lite', 'By URL'),
            'url' => [
                'admin' => true,
                'plugin' => 'Seolite',
                'controller' => 'Urls',
                'action' => 'index',
            ],
        ],
    ],
]);
