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
        $file->storeAs('attachments', $filename, 'public');
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
        $path = 'public/attachments/' . $filename;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
