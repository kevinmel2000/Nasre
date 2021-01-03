<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';
    public const ADMIN_HOME = '/admin/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapContactRoutes();
        $this->mapLeadRoutes();
        $this->mapOfficeRoutes();
        $this->mapProductRoutes();
        $this->mapProposalRoutes();
        $this->mapProjectRoutes();
        $this->mapInvoiceRoutes();
        $this->mapEstimateRoutes();
        $this->mapTaskRoutes();
        $this->mapMediaRoutes();
        $this->mapReminderRoutes();
        $this->mapUserRoutes();

        // Client Route Files Mapping
        $this->mapClientAuthRoutes();
        $this->mapClientRoutes();
        $this->mapPublicRoutesRoutes();
        $this->mapInstallationRoutes();
    }

    protected function mapUserRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/userRoutes.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapPublicRoutesRoutes()
    {
        Route::namespace($this->namespace)
            ->group(base_path('routes/publicRoutes.php'));
    }

    protected function mapContactRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/contactRoutes.php'));
    }

    protected function mapLeadRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/leadRoutes.php'));
    }

    protected function mapOfficeRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/officeRoutes.php'));
    }

    protected function mapProductRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/productRoutes.php'));
    }

    protected function mapProposalRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/proposalRoutes.php'));
    }

    protected function mapProjectRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/projectRoutes.php'));
    }

    protected function mapInvoiceRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/invoiceRoutes.php'));
    }

    protected function mapEstimateRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/estimateRoutes.php'));
    }

    protected function mapTaskRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/taskRoutes.php'));
    }

    protected function mapMediaRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/mediaRoutes.php'));
    }

    protected function mapReminderRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/crm/reminderRoutes.php'));
    }

    protected function mapClientAuthRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/client/clientAuth.php'));
    }

    protected function mapClientRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/client/client.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapInstallationRoutes(){
        Route::
            // middleware('web')
            namespace($this->namespace)
            ->group(base_path('routes/installation.php'));
    }
}
