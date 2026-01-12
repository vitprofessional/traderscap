<?php

namespace App\Livewire;

use Livewire\Mechanisms\HandleRequests\HandleRequests as BaseHandleRequests;

class CustomHandleRequests extends BaseHandleRequests
{
    public function getUpdateUri()
    {
        // Return full absolute URL instead of relative path
        return url('/livewire/update');
    }
}
