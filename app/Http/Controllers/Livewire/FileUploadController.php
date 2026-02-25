<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Support\Facades\URL;
use Livewire\Features\SupportFileUploads\FileUploadController as BaseFileUploadController;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;

class FileUploadController extends BaseFileUploadController
{
    /**
     * Validate the Livewire upload signature using APP_URL's scheme and host,
     * not the scheme PHP sees from the server-side request.
     *
     * Behind a reverse proxy (e.g. Apache → PHP-FPM without X-Forwarded-Proto)
     * $request->url() can return "http://" even though the signed URL was
     * generated with "https://", causing hasValidSignature() to always fail → 401.
     *
     * We duplicate the request and force the scheme/host from APP_URL so the
     * HMAC comparison is made against the same URL used at signing time.
     */
    public function handle()
    {
        $appParsed = parse_url(config('app.url', ''));
        $scheme    = $appParsed['scheme'] ?? 'http';
        $host      = $appParsed['host']   ?? request()->getHost();
        $port      = $appParsed['port']   ?? null;
        $httpHost  = $port ? "{$host}:{$port}" : $host;

        // Build a copy of the request whose scheme/host matches APP_URL.
        $canonicalRequest = request()->duplicate();
        $canonicalRequest->server->set('HTTPS', $scheme === 'https' ? 'on' : 'off');
        $canonicalRequest->server->set('HTTP_HOST', $httpHost);
        $canonicalRequest->headers->set('HOST', $httpHost);

        abort_unless(URL::hasValidSignature($canonicalRequest), 401);

        $disk      = FileUploadConfiguration::disk();
        $filePaths = $this->validateAndStore(request('files'), $disk);

        return ['paths' => $filePaths];
    }
}
