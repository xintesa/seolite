<?php

$keys = array(
	'meta_keywords' => array(
		'label' => __d('seolite', 'Keywords'),
	),
	'meta_description' => array(
		'label' => __d('seolite', 'Description'),
	),
);
$fields = array(
	'id' => array('type' => 'hidden'),
	'key' => array('type' => 'hidden'),
	'value' => array('type' => 'textarea'),
);

foreach ($keys as $key => $keyOptions):
	foreach ($fields as $field => $options):
		$input = sprintf('SeoLite.%s.%s', $key, $field);
		if ($field === 'id' && empty($this->data['SeoLite'][$key]['id'])):
			$options['value'] = String::uuid();
		endif;
		if ($field === 'key' && empty($this->data['SeoLite'][$key]['key'])):
			$options['value'] = $key;
		endif;
		if (!empty($keyOptions['label']) && $options['type'] !== 'hidden'):
			$options['label'] = $keyOptions['label'];
		endif;
		echo $this->Form->input($input, $options);
	endforeach;
endforeach;
