<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ReplyTicket extends Page
{
    // ensure page is not shown in the sidebar navigation
    protected static ?string $navigationLabel = null;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $slug = 'tickets/reply';

    // point to our blade view (nested path Filament expects)
    protected string $view = 'filament.pages.tickets.reply';

    // ensure Filament uses the correct view name
    public function getView(): string
    {
        return $this->view;
    }

    public function mount()
    {
        // nothing special - the view will read the `ticket` query param
    }

    // Filament page layout expects a `hasLogo()` method when rendering
    // the page wrapper. Provide a simple implementation to avoid
    // "method does not exist" errors and let Filament decide layout.
    public function hasLogo(): bool
    {
        return false;
    }
}
