<?php
use \Cake\Core\Configure;
use \Croogo\Core\Croogo;
use \Cake\Cache\Cache;
use \Croogo\Core\Nav;

Croogo::mergeConfig('Meta.keys', [
    'og:title' => [
        'label' => 'Open Graph Title',
        'type' => 'text',
    ],
    'og:type' => [
        'label' => 'Open Graph Type',
        'type' => 'text',
    ],
    'og:image' => [
        'label' => 'Open Graph Image',
        'type' => 'text',
    ],
    'og:url' => [
        'label' => 'Open Graph URL',
        'type' => 'text',
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
