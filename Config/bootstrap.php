<?php

$cacheConfig = array_merge(
	Configure::read('Cache.defaultConfig'),
	array('groups' => array('seo_lite'))
);
CroogoCache::config('seo_lite', $cacheConfig);

Configure::write('Seolite.keys', array(
	'meta_keywords' => array(
		'label' => __d('seolite', 'Keywords'),
	),
	'meta_description' => array(
		'label' => __d('seolite', 'Description'),
	),
	'rel_canonical' => array(
		'label' => __d('seolite', 'Canonical Page'),
	),
));

Croogo::hookHelper('*', 'Seolite.SeoLite');

$queryString = env('REQUEST_URI');
if (strpos($queryString, 'admin') === false) {
	return;
}

/*
 * stuff for /admin routes only
 */

Croogo::hookBehavior('Node', 'Seolite.SeoCustomFields', array(
	'priority' => 1,
));

$title = 'SeoLite';
$element = 'Seolite.admin/meta';
$options = array(
	'elementData' => array(
		'field' => 'body',
	),
);
Croogo::hookAdminTab('Nodes/admin_add', $title, $element, $options);
Croogo::hookAdminTab('Nodes/admin_edit', $title, $element, $options);
$options['elementData']['field'] = 'description';
Croogo::hookAdminTab('SeoLiteUrls/admin_add', $title, $element, $options);
Croogo::hookAdminTab('SeoLiteUrls/admin_edit', $title, $element, $options);

CroogoNav::add('extensions.children.seo_lite', array(
	'title' => 'SeoLite',
	'url' => 'javascript:void(0)',
	'children' => array(
		'urls' => array(
			'title' => __d('seo_lite', 'Meta by URL'),
			'url' => array(
				'admin' => true,
				'plugin' => 'seo_lite',
				'controller' => 'seo_lite_urls',
				'action' => 'index',
			),
		),
	),
));
