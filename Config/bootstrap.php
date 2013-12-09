<?php

Configure::write('SeoLite.keys', array(
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

Croogo::hookHelper('Nodes', 'SeoLite.SeoLite');

$queryString = env('QUERY_STRING');
if (strpos($queryString, 'admin') === false) {
	return;
}

/*
 * stuff for /admin routes only
 */

Croogo::hookBehavior('Node', 'SeoLite.SeoCustomFields', array(
	'priority' => 1,
));

$title = 'SeoLite';
$element = 'SeoLite.admin/meta';
$options = array(
	'elementData' => array(
		'field' => 'body',
	),
);
Croogo::hookAdminTab('Nodes/admin_add', $title, $element, $options);
Croogo::hookAdminTab('Nodes/admin_edit', $title, $element, $options);
