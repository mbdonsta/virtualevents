<?php

namespace App\Observers;

use App\Models\ExhibitionStand;
use App\Services\FileUploadHandler;

class ExhibitionStandObserver
{
    private FileUploadHandler $fileUploadHandler;

    public function __construct(FileUploadHandler $fileUploadHandler)
    {
        $this->fileUploadHandler = $fileUploadHandler;
    }

    public function updated(ExhibitionStand $exhibitionStand)
    {
        if (count($exhibitionStand->items) > ExhibitionStand::STAND_LAYOUTS[$exhibitionStand->layout_style]) {
            foreach ($exhibitionStand->items as $index => $exhibitionStandItem) {
                if ($index < ExhibitionStand::STAND_LAYOUTS[$exhibitionStand->layout_style]) {
                    continue;
                }

                $exhibitionStandItem->delete();
            }
        }
    }

    public function deleting(ExhibitionStand $exhibitionStand)
    {
        if ($exhibitionStand->mediaFile) {
            $this->fileUploadHandler->delete($exhibitionStand->mediaFile);
        }
    }
}
