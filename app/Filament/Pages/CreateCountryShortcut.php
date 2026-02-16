<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Http\RedirectResponse;

class CreateCountryShortcut extends Page
{
    protected static ?string $navigationLabel = 'Create Country';
    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    // A simple view is required by Filament pages, but we'll immediately
    // redirect in mount() to the real resource create URL.
    protected string $view = 'filament.pages.create-country-redirect';

    public function mount()
    {
        $url = url(config('filament.path', 'admin') . '/countries/create');

        return response()->redirectTo($url);
    }
}
