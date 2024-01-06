<?php

namespace BookStack\Activity\Models;

use BookStack\Entities\Models\Page;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    /**
     * Get the url of this notification.
     */
    public function getUrl(): string
    {
        $entity = null;

        if ($this->type == "BookStack\Activity\Notifications\Messages\PageUpdateNotification") {
            $entity = Page::findOrFail($this->data['activity_detail']['id']);
        } else {
            if ($this->data['activity_detail']['entity_type'] == "page") {
                $entity = Page::findOrFail($this->data['activity_detail']['entity_id']);
            }
        }

        if ($entity) {
            return $entity->getUrl();
        }

        return route('books.index');
    }
}
