<?php

namespace App\Observers;

use App\Models\ExhibitionStandItem;
use App\Services\FileUploadHandler;

class ExhibitionStandItemObserver
{
    private FileUploadHandler $fileUploadHandler;

    public function __construct(FileUploadHandler $fileUploadHandler)
    {
        $this->fileUploadHandler = $fileUploadHandler;
    }

    public function deleting(ExhibitionStandItem $exhibitionStandItem)
    {
        if ($exhibitionStandItem->bannerImage) {
            $this->fileUploadHandler->delete($exhibitionStandItem->bannerImage);
        }

        if ($exhibitionStandItem->downloadFile) {
            $this->fileUploadHandler->delete($exhibitionStandItem->downloadFile);
        }
    }
}
