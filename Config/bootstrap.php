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
Croogo::hookBehavior('Node', 'SeoLite.SeoCustomFields', array(
	'priority' => 1,
));

Croogo::hookAdminTab('Nodes/admin_edit', 'Meta', 'SeoLite.admin/meta', array(
	'elementData' => array(
		'field' => 'body',
	),
));
