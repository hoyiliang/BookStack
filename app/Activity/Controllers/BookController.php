<?php

namespace BookStack\Activity\Controllers;

use BookStack\App\Model;
use BookStack\Entities\Models\Entity;
use BookStack\Entities\Tools\MixedEntityRequestHelper;
use BookStack\Http\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected MixedEntityRequestHelper $entityHelper,
    ) {
    }

    /**
     * Add a new item as a favourite.
     */
    public function copyUrl(Request $request)
    {
        $this->showSuccessNotification(trans('activities.copied_url_notification'));

        return redirect()->back();
    }
}
