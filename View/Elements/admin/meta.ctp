<?php
$this->Html->script('Seolite.admin', array('inline' => false));
$field = isset($field) ? $field : 'body';
$id = !empty($this->data[$this->Form->defaultModel]['id']) ?
	$this->data[$this->Form->defaultModel]['id'] :
	null;
?>
<div class="row-fluid">
	<div class="span12">
		<div class="actions pull-right">
			<ul class="nav-buttons">
			<?php
			echo $this->Croogo->adminAction(__d('seolite', 'Analyze'), array(
				'plugin' => 'seo_lite',
				'controller' => 'seo_lite_analyze',
				'action' => 'index',
				$this->Form->plugin,
				$this->Form->defaultModel,
				$id,
				$field,
				'ext' => 'json',
			), array(
				'data-toggle' => 'seo-lite-analyze',
				'data-id' => $id,
				'icon' => 'cogs',
				'iconSize' => 'small',
				'tooltip' => array(
					'data-title' => 'Simple auto keywords and description',
					'data-placement' => 'left',
				),
			));
			?>
			</ul>
		</div>
	</div>
</div>
<?php

$keys = Configure::read('Seolite.keys');
$fields = array(
	'id' => array('type' => 'hidden'),
	'model' => array('type' => 'hidden'),
	'foreign_key' => array('type' => 'hidden'),
	'key' => array('type' => 'hidden'),
	'value' => array('type' => 'textarea'),
);

foreach ($keys as $key => $keyOptions):
	foreach ($fields as $field => $options):
		$input = sprintf('Seolite.%s.%s', $key, $field);
		if ($field === 'id' && empty($this->data['SeoLite'][$key]['id'])):
			$options['value'] = String::uuid();
		endif;
		if ($field === 'model'):
			$options['value'] = $this->Form->defaultModel;
		endif;
		if ($field === 'foreign_key'):
			$options['value'] = $id;
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
