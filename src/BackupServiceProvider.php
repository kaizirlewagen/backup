<?php

declare(strict_types=1);

namespace Orchid\Backup;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Screen\Actions\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Translation\TranslationServiceProvider;
use Spatie\Backup\BackupServiceProvider as SpatieBackupServiceProvider;
use Orchid\Backup\BackupDownloadFileController;

/**
 * Class BackupServiceProvider.
 */
class BackupServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Builder';
    	
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        // $this->loadJsonTranslationsFrom(__DIR__ . '/../lang'));

        Route::domain((string)config('platform.domain'))
            ->prefix(Dashboard::prefix('/systems'))
            ->middleware(config('platform.middleware.private'))
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/RoutesBackup.php');

        Route::get('/get/{file_name}', [BackupDownloadFileController::class, 'downloadFile'])
            ->name('platform.backups.downloadFile');

        //$dashboard->registerPermissions($this->registerPermissions());

        $dashboard->registerPermissions(
            ItemPermission::group(__('Systems'))
                ->addPermission('platform.systems.backups', __('Backups'))
        );

        // View::composer('platform::container.systems.index', SystemMenuComposer::class);
        
        View::composer('platform::dashboard', function () use ($dashboard) {
            $dashboard->registerMenuElement(
                Dashboard::MENU_MAIN,
                Menu::make(__('Backups'))
                    ->icon('clock')
                    ->route('platform.systems.backups')
                    ->permission('platform.systems.backups')
                    ->title(__('System'))
            );
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerProviders();
        
        if ($this->loadJsonTranslationsFrom(__DIR__ . '/../lang')) {
        	// If I call the loadJsonTranslationsFrom 
        	// not from my boot method but from register method, it works.
        }        
    }

    /**
     * Register provider.
     */
    public function registerProviders()
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            SpatieBackupServiceProvider::class,
        ];
    }
}
