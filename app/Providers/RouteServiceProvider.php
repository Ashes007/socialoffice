<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use Session;

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
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    // public function map()
    // {
    //     $this->mapApiRoutes();

    //     $this->mapWebRoutes();

    //     //
    // }

    public function map(Router $router, Request $request)
    {
   
        $segment1 = $request->segment(1);
        //exit($segment1);
        //exit('2');
        if($segment1=='admin'){
            $this->mapApiRoutes();
        
            $this->mapWebRoutes();            
        }elseif(in_array($segment1, array('en','ar'))){ 
            
            //print_r($this->app->config->get('app.locales'));exit;
            $this->app->setLocale($segment1);
            
            //exit($segment1);
            //$this->mapApiRoutes();
            //$this->mapWebRoutes();
            $router->group(['namespace' => $this->namespace, 'prefix' => $segment1, 'middleware' => ['web']], function($router) {
                require app_path('../routes/web.php');
            });

           
        }else{
            
            $router->group(['namespace' => $this->namespace, 'middleware' => ['web']], function($router) {
                require app_path('../routes/web.php');
            });
            
            $this->mapApiRoutes();
            $this->mapWebRoutes();
        }

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

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
