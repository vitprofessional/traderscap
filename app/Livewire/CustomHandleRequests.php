<?php

namespace App\Livewire;

use Livewire\Mechanisms\HandleRequests\HandleRequests as BaseHandleRequests;

class CustomHandleRequests extends BaseHandleRequests
{
    public function getUpdateUri()
    {
        $path = parse_url(url('/livewire/update'), PHP_URL_PATH);

        return $path ?: '/livewire/update';
    }
}
