<?php

$this->Html->script('Seolite.admin', ['block' => 'scriptBottom']);

$field = isset($field) ? $field : 'body';
$id = !empty($entity->id) ? $entity->id : null;

echo $this->Html->div('clearfix', $this->Html->div('pull-right', $this->Croogo->adminAction(__d('seolite', 'Analyze'), [
    'plugin' => 'Seolite',
    'controller' => 'Analyze',
    'action' => 'index',
    '?' => [
        'table' => $entity->source(),
        'id' => $id,
        'field' => $field,
    ],
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
])));

$keys = \Cake\Core\Configure::read('Seolite.keys');
$fields = [
    'id' => ['type' => 'hidden'],
    'model' => ['type' => 'hidden'],
    'foreign_key' => ['type' => 'hidden'],
    'key' => ['type' => 'hidden'],
    'value' => ['type' => 'textarea'],
];

foreach ($keys as $key => $keyOptions):
    foreach ($fields as $field => $options):
        $input = sprintf('seo_lite.%s.%s', $key, $field);
        if ($field === 'id' && empty($entity->seo_lite[$key]['id'])):
            $options['value'] = \Cake\Utility\Text::uuid();
        endif;
        if ($field === 'model'):
            $options['value'] = $entity->source();
        endif;
        if ($field === 'foreign_key'):
            $options['value'] = $id;
        endif;
        if ($field === 'key' && empty($entity->seo_lite[$key]['key'])):
            $options['value'] = $key;
        endif;
        if (!empty($keyOptions['label']) && $options['type'] !== 'hidden'):
            $options['label'] = $keyOptions['label'];
        endif;
        echo $this->Form->input($input, $options);
    endforeach;
endforeach;
