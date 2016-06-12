<?php

namespace Seolite\Model\Behavior;

use Cake\Core\Configure;
use Cake\ORM\Behavior;

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
            'Model.Meta.formatFields' => 'formatSeoFields'
        ];
    }

    public function formatSeoFields(Event $event, Entity $entity)
    {
        $keySettings = Configure::read('Seolite.keys');
        $keys = array_keys($keySettings);
        if (!isset($entity->meta)) {
            return;
        }
        foreach ($entity->meta as $index => $meta) {
            if (!in_array($meta->key, $keys)) {
                continue;
            }
            $entity->seo_lite[$meta->key] = $meta;
            unset($entity->meta[$index]);
        }
    }
}
