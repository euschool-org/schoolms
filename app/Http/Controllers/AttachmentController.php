<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Models\Attachment;
use App\Models\Student;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public $attachmentService;
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function store(StoreAttachmentRequest $request, $id)
    {
        $filename = $this->attachmentService->uploadAttachment($request, $id);
        if ($this->attachmentService->store($id, $filename)) {
            return redirect()->route('student.edit', $id)->with('success', 'File successfully uploaded');
        } else {
            return redirect()->route('student.edit', $id)->with('error', 'File upload failed');
        }
    }

    public function destroy(Attachment $attachment)
    {
        $this->attachmentService->deleteAttachment($attachment->filename);
        if ($attachment->delete()) {
            return redirect()->back()->with('success', 'Attachment successfully deleted');
        } else {
            return redirect()->back()->with('error', 'Failed to delete attachment');
        }
    }

}
