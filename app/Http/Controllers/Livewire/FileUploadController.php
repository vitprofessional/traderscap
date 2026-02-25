<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Features\SupportFileUploads\FileUploadController as BaseFileUploadController;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;

class FileUploadController extends BaseFileUploadController
{
    /**
     * Override Livewire's default upload handler to use relative (non-absolute)
     * signature validation.
     *
     * The default `hasValidSignature()` (absolute = true) compares the full URL
     * including scheme and host against the HMAC-signed URL. Behind a reverse
     * proxy where the server receives HTTP internally but the client uses HTTPS,
     * the scheme can differ between URL generation time and validation time,
     * causing a signature mismatch and a spurious 401.
     *
     * Using relative validation (`hasValidSignature(false)`) signs and verifies
     * only the path + query string, making it immune to scheme/host differences.
     */
    public function handle()
    {
        abort_unless(request()->hasValidSignature(false), 401);

        $disk = FileUploadConfiguration::disk();

        $filePaths = $this->validateAndStore(request('files'), $disk);

        return ['paths' => $filePaths];
    }
}
