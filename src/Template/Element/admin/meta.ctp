<?php

$this->Html->script('Seolite.admin', ['block' => 'scriptBottom']);

$field = isset($field) ? $field : 'body';
$id = !empty($this->data[$this->Form->defaultModel]['id']) ? $this->data[$this->Form->defaultModel]['id'] : null;

$this->append('actions');
echo $this->Croogo->adminAction(__d('seolite', 'Analyze'), [
    'plugin' => 'seolite',
    'controller' => 'seo_lite_analyze',
    'action' => 'index',
    $this->Form->plugin,
    $this->Form->defaultModel,
    $id,
    $field,
    'ext' => 'json',
], [
    'data-toggle' => 'seo-lite-analyze',
    'data-id' => $id,
    'icon' => 'cogs',
    'iconSize' => 'small',
    'tooltip' => [
        'data-title' => 'Simple auto keywords and description',
        'data-placement' => 'right',
    ],
]);
$this->end();

$keys = Configure::read('Seolite.keys');
$fields = [
    'id' => ['type' => 'hidden'],
    'model' => ['type' => 'hidden'],
    'foreign_key' => ['type' => 'hidden'],
    'key' => ['type' => 'hidden'],
    'value' => ['type' => 'textarea'],
];

foreach ($keys as $key => $keyOptions):
    foreach ($fields as $field => $options):
        $input = sprintf('SeoLite.%s.%s', $key, $field);
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
