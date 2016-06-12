<?php

namespace Seolite\Event;

use Cake\Event\EventListenerInterface;

class SeoLiteEventHandler implements EventListenerInterface
{

    public function implementedEvents()
    {
        return [
            'Model.Node.beforeSaveNode' => [
                'callable' => 'onBeforeSaveNode',
            ],
            'Model.Node.afterSaveNode' => [
                'callable' => 'onAfterSaveNode',
            ],
        ];
    }

    /**
     * Format data so that it can be processed by MetaBehavior for saving
     */
    public function onBeforeSaveNode(Event $event)
    {
        $node = $event->data['node'];
        if (isset($node->seo_lite)) {
            if (empty($node->meta)) {
                $node->meta = [];
            }

            $values = array_values($node->seo_lite);
            foreach ($values as $value) {
                if (strlen($value['id']) == 36) {
                    unset($value['id']);
                }
                if (!empty($value['value'])) {
                    $node->meta[Text::uuid()] = $value;
                } else {
                    // mark empty records for deletion
                    if (isset($value['id'])) {
                        $node['delete'][] = $value['id'];
                    }
                }
            }
        }
        unset($node->seo_lite);

        return $event;
    }

    /**
     * Delete records that has been marked for deletion from $event->data['delete']
     */
    public function onAfterSaveNode(Event $event)
    {
        if (empty($event->data['delete'])) {
            return $event;
        }

        ClassRegistry::init('Meta.Meta')
            ->deleteAll([
                'Meta.id' => $event->data['delete'],
            ]);

        return $event;
    }

}
