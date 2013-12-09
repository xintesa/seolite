<?php

$queryString = env('QUERY_STRING');
if (strpos($queryString, 'admin') === false) {
	return;
}
Croogo::hookBehavior('Node', 'SeoLite.SeoCustomFields', array(
	'priority' => 1,
));

Croogo::hookAdminTab('Nodes/admin_edit', 'Meta', 'SeoLite.admin/meta');
