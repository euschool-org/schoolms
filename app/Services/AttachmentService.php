<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{
    public function uploadAttachment($request, $studentId)
    {
        $file = $request->file('attachment');
        $filename = $request->filename . '-' . $studentId . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();

        $filePath = 'attachments/' . $filename;
        Storage::disk('spaces')->put($filePath, file_get_contents($file), 'public');
        return $filename;
    }

    public function store($id, $filename = null)
    {
        if($filename){
            $attachment = new Attachment();
            $attachment->student_id = $id;
            $attachment->user_id = auth()->id();
            $attachment->filename = $filename;
            $attachment->upload_date = now();
            $attachment->save();

            return true;
        } else {
            return false;
        }
    }

    public function deleteAttachment($filename)
    {
        $filePath = 'attachments/' . $filename;

        // Check if the file exists and delete it
        if (Storage::disk('spaces')->exists($filePath)) {
            Storage::disk('spaces')->delete($filePath);
        }
    }
}
