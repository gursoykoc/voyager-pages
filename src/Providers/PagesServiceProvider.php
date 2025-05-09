<?php

namespace Pvtl\VoyagerPages\Providers;

use Pvtl\VoyagerPages\Commands;
use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Our root directory for this package to make traversal easier
     */
    const PACKAGE_DIR = __DIR__ . '/../../';

    /**
     * Bootstrap the application services
     *
     * @return void
     */
    public function boot()
    {
        $this->strapRoutes();
        $this->strapPublishers();
        $this->strapViews();
        $this->strapCommands();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap our Routes
     */
    protected function strapRoutes()
    {
        $this->loadRoutesFrom(self::PACKAGE_DIR . 'routes/web.php');
    }

    /**
     * Bootstrap our Publishers
     */
    protected function strapPublishers()
    {
        // Defines which files to copy the root project
    }

    /**
     * Bootstrap our Views
     */
    protected function strapViews()
    {
        // Load views
        $this->loadViewsFrom(self::PACKAGE_DIR . 'resources/views', 'voyager-pages');
    }

    /**
     * Bootstrap our Commands/Schedules
     */
    protected function strapCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class
            ]);
        }
    }
}
