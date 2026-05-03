<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\RedirectToRegisterIfNoUsers;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\Auth\Login;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->authGuard(config('filament.auth.guard', 'admin'))
            ->path('admin')
            ->login(Login::class)
            ->registration(Register::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->renderHook(
                'panels::head.start',
                fn () => '<base href="' . url('/') . '/">'
            )
            ->renderHook(
                'panels::head.end',
                fn () => <<<'HTML'
<style>
    body.fi-panel-admin .fi-sidebar {
        background:
            radial-gradient(circle at top, rgba(251, 191, 36, 0.08), transparent 38%),
            linear-gradient(180deg, #0f172a 0%, #111827 100%);
        border-right: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 24px 0 60px rgba(15, 23, 42, 0.18);
        backdrop-filter: blur(18px);
    }

    body.fi-panel-admin .fi-sidebar-header {
        justify-content: flex-start;
        padding-inline: 1.5rem;
        background: transparent;
        border-bottom: 1px solid rgba(148, 163, 184, 0.12);
    }

    body.fi-panel-admin .fi-sidebar .fi-logo {
        color: #f8fafc;
    }

    body.fi-panel-admin .fi-sidebar-nav {
        gap: 1.25rem;
        padding: 1.25rem 1rem 1rem;
    }

    body.fi-panel-admin .fi-sidebar-group-label {
        padding-inline: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-size: 0.6875rem;
        font-weight: 700;
        color: rgba(226, 232, 240, 0.58);
    }

    body.fi-panel-admin .fi-sidebar-item-btn,
    body.fi-panel-admin .fi-sidebar-group-dropdown-trigger-btn,
    body.fi-panel-admin .fi-sidebar-database-notifications-btn {
        border-radius: 0.9rem;
        padding: 0.75rem 0.95rem;
        transition:
            background-color 150ms ease,
            color 150ms ease,
            box-shadow 150ms ease,
            transform 150ms ease;
    }

    body.fi-panel-admin .fi-sidebar-item-btn:hover,
    body.fi-panel-admin .fi-sidebar-group-dropdown-trigger-btn:hover,
    body.fi-panel-admin .fi-sidebar-database-notifications-btn:hover {
        background: rgba(255, 255, 255, 0.06);
        transform: translateX(1px);
    }

    body.fi-panel-admin .fi-sidebar-item.fi-active > .fi-sidebar-item-btn,
    body.fi-panel-admin .fi-sidebar-group.fi-active .fi-sidebar-group-dropdown-trigger-btn {
        background: linear-gradient(90deg, rgba(251, 191, 36, 0.18), rgba(255, 255, 255, 0.08));
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }

    body.fi-panel-admin .fi-sidebar-item.fi-active > .fi-sidebar-item-btn > .fi-icon,
    body.fi-panel-admin .fi-sidebar-group.fi-active .fi-sidebar-group-dropdown-trigger-btn .fi-icon {
        color: #fbbf24;
    }

    body.fi-panel-admin .fi-sidebar-item-label,
    body.fi-panel-admin .fi-sidebar-group-label,
    body.fi-panel-admin .fi-sidebar-database-notifications-btn-label {
        color: #e2e8f0;
    }

    body.fi-panel-admin .fi-sidebar-item-btn > .fi-icon,
    body.fi-panel-admin .fi-sidebar-group-dropdown-trigger-btn > .fi-icon,
    body.fi-panel-admin .fi-sidebar-database-notifications-btn > .fi-icon {
        color: rgba(226, 232, 240, 0.72);
    }

    body.fi-panel-admin .fi-sidebar-footer {
        margin: 0.5rem 1rem 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(148, 163, 184, 0.12);
    }

    body.fi-panel-admin .fi-topbar-ctn {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.08), rgba(15, 23, 42, 0));
        backdrop-filter: blur(14px);
    }

    body.fi-panel-admin .fi-topbar {
        min-height: 4.5rem;
        padding-inline: 1rem;
        background:
            linear-gradient(180deg, rgba(15, 23, 42, 0.92), rgba(15, 23, 42, 0.82)),
            rgba(15, 23, 42, 0.9);
        border-bottom: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.16);
    }

    body.fi-panel-admin .fi-topbar-start {
        gap: 0.875rem;
    }

    body.fi-panel-admin .fi-topbar-start .fi-logo {
        color: #f8fafc;
        font-weight: 700;
        letter-spacing: 0.01em;
        filter: drop-shadow(0 1px 0 rgba(255, 255, 255, 0.08));
    }

    body.fi-panel-admin .fi-topbar-nav-groups {
        gap: 0.5rem;
    }

    body.fi-panel-admin .fi-topbar-item-btn,
    body.fi-panel-admin .fi-topbar-database-notifications-btn,
    body.fi-panel-admin .fi-user-menu-trigger,
    body.fi-panel-admin .fi-topbar-open-sidebar-btn,
    body.fi-panel-admin .fi-topbar-close-sidebar-btn,
    body.fi-panel-admin .fi-topbar-open-collapse-sidebar-btn,
    body.fi-panel-admin .fi-topbar-close-collapse-sidebar-btn {
        border-radius: 0.875rem;
        border: 1px solid rgba(148, 163, 184, 0.14);
        background: rgba(255, 255, 255, 0.03);
        color: #e2e8f0;
        box-shadow: none;
        transition:
            background-color 150ms ease,
            border-color 150ms ease,
            color 150ms ease,
            transform 150ms ease,
            box-shadow 150ms ease;
    }

    body.fi-panel-admin .fi-topbar-item-btn:hover,
    body.fi-panel-admin .fi-topbar-database-notifications-btn:hover,
    body.fi-panel-admin .fi-user-menu-trigger:hover,
    body.fi-panel-admin .fi-topbar-open-sidebar-btn:hover,
    body.fi-panel-admin .fi-topbar-close-sidebar-btn:hover,
    body.fi-panel-admin .fi-topbar-open-collapse-sidebar-btn:hover,
    body.fi-panel-admin .fi-topbar-close-collapse-sidebar-btn:hover {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(251, 191, 36, 0.24);
        transform: translateY(-1px);
    }

    body.fi-panel-admin .fi-topbar-item.fi-active .fi-topbar-item-btn {
        background: rgba(251, 191, 36, 0.14);
        border-color: rgba(251, 191, 36, 0.28);
    }

    body.fi-panel-admin .fi-topbar-item-btn > .fi-icon,
    body.fi-panel-admin .fi-topbar-database-notifications-btn > .fi-icon,
    body.fi-panel-admin .fi-user-menu-trigger > .fi-icon,
    body.fi-panel-admin .fi-topbar-open-sidebar-btn > .fi-icon,
    body.fi-panel-admin .fi-topbar-close-sidebar-btn > .fi-icon,
    body.fi-panel-admin .fi-topbar-open-collapse-sidebar-btn > .fi-icon,
    body.fi-panel-admin .fi-topbar-close-collapse-sidebar-btn > .fi-icon {
        color: rgba(226, 232, 240, 0.78);
    }

    body.fi-panel-admin .fi-global-search {
        min-width: min(24rem, 36vw);
    }

    body.fi-panel-admin .fi-global-search .fi-input-wrapper {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(148, 163, 184, 0.22);
        border-radius: 0.875rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
        transition:
            background-color 150ms ease,
            border-color 150ms ease,
            box-shadow 150ms ease;
    }

    body.fi-panel-admin .fi-global-search .fi-input-wrapper:focus-within {
        background: rgba(255, 255, 255, 1);
        border-color: rgba(251, 191, 36, 0.3);
        box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.08);
    }

    body.fi-panel-admin .fi-global-search input.fi-input {
        color: #0f172a;
    }

    body.fi-panel-admin .fi-global-search input.fi-input::placeholder {
        color: rgba(100, 116, 139, 0.78);
    }

    body.fi-panel-admin .fi-user-menu-trigger {
        width: 2.5rem;
        height: 2.5rem;
        overflow: hidden;
        padding: 0;
        border-radius: 9999px;
        border: 1px solid rgba(148, 163, 184, 0.22);
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.16);
    }

    body.fi-panel-admin .fi-user-menu-trigger img,
    body.fi-panel-admin .fi-user-menu-trigger svg {
        display: block;
        width: 100%;
        height: 100%;
    }

    body.fi-panel-admin .fi-topbar-item-label {
        color: #f8fafc;
        font-weight: 600;
        letter-spacing: 0.01em;
    }

    body.fi-panel-admin .fi-topbar-end {
        gap: 0.75rem;
    }

    body.fi-panel-admin .fi-topbar-end > * {
        flex-shrink: 0;
    }

    body.fi-panel-admin .fi-topbar-item.fi-active .fi-topbar-item-label {
        color: #fbbf24;
    }

    body.fi-panel-admin .fi-topbar-item-btn {
        padding: 0.65rem 0.9rem;
    }
</style>
HTML
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->navigationGroups([
                'Administration',
                'Users',
                'Catalog',
                'Support',
                'Content',
                'Settings',
            ])
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                RedirectToRegisterIfNoUsers::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
