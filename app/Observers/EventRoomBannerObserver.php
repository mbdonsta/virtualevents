<?php

namespace App\Observers;

use App\Models\EventRoomBanner;
use App\Services\FileUploadHandler;

class EventRoomBannerObserver
{
    private FileUploadHandler $fileUploadHandler;

    public function __construct(FileUploadHandler $fileUploadHandler)
    {
        $this->fileUploadHandler = $fileUploadHandler;
    }

    public function deleting(EventRoomBanner $eventRoomBanner)
    {
        if ($eventRoomBanner->bannerImage) {
            $this->fileUploadHandler->delete($eventRoomBanner->bannerImage);
        }

        if ($eventRoomBanner->downloadFile) {
            $this->fileUploadHandler->delete($eventRoomBanner->downloadFile);
        }
    }
}
