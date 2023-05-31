<?php

namespace App\Observers;

use App\Models\EventPoster;
use App\Services\FileUploadHandler;

class EventPosterObserver
{
    private FileUploadHandler $fileUploadHandler;

    public function __construct(FileUploadHandler $fileUploadHandler)
    {
        $this->fileUploadHandler = $fileUploadHandler;
    }

    public function deleting(EventPoster $eventPoster)
    {
        if ($eventPoster->posterImage) {
            $this->fileUploadHandler->delete($eventPoster->posterImage);
        }
    }
}
