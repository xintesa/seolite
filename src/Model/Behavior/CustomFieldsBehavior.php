<?php

namespace Seolite\Model\Behavior;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\Utility\Text;

class CustomFieldsBehavior extends Behavior
{
    /**
     * Gets the Model callbacks this behavior is interested in.
     *
     * By defining one of the callback methods a behavior is assumed
     * to be interested in the related event.
     *
     * Override this method if you need to add non-conventional event listeners.
     * Or if you want your behavior to listen to non-standard events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Model.Meta.formatFields' => 'formatSeoFields',
            'Model.Meta.prepareFields' => 'prepareSeoFields',
        ];
    }

    /**
     * Format data so that it can be processed by MetaBehavior for saving
     */
    public function prepareSeoFields(Event $event)
    {
        $data = $event->data['data'];
        if (isset($data['seo_lite'])) {
            if (empty($data['meta'])) {
                $data['meta'] = [];
            }

            $values = array_values($data['seo_lite']);
            foreach ($values as $value) {
                if (strlen($value['id']) == 36) {
                    unset($value['id']);
                }
                $data['meta'][Text::uuid()] = $value;
            }
            unset($data['seo_lite']);
        }
    }

    public function formatSeoFields(Event $event, Entity $entity)
    {
        $keySettings = Configure::read('Seolite.keys');
        $keys = array_keys($keySettings);
        if (!isset($entity->meta)) {
            return;
        }
        $entity->seo_lite = [];
        foreach ($entity->meta as $index => $meta) {
            if (!in_array($meta->key, $keys)) {
                continue;
            }
            $entity->seo_lite[$meta->key] = $meta;
            unset($entity->meta[$index]);
        }
    }
}
