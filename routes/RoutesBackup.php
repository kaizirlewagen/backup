<?php

use Orchid\Backup\BackupScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('/backups', BackupScreen::class)
    ->name('platform.systems.backups')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Backups'), route('platform.systems.backups'));
    });