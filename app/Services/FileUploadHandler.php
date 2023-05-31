<?php

namespace App\Services;

use App\Models\MediaFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadHandler
{
    public function upload(UploadedFile $file, string $model): array
    {
        $originalFilename = $file->getClientOriginalName();
        $extention = $file->getClientOriginalExtension();
        $filename = Storage::disk('uploads')->put('', $file);
        $mediaFile = MediaFile::create([
            'user_id' => auth()->user()->id,
            'object_model' => $model,
            'filename' => $filename,
            'original_name' => $originalFilename,
            'extension' => $extention
        ]);

        return [
            'file_id' => $mediaFile->id,
            'url' => $mediaFile->getUrl(),
            'name' => $mediaFile->original_name
        ];
    }

    public function delete(MediaFile $mediaFile): void
    {
        if (Storage::disk('uploads')->exists($mediaFile->filename)) {
            Storage::disk('uploads')->delete($mediaFile->filename);
        }

        $mediaFile->delete();
    }
}
