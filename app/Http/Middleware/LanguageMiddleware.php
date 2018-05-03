<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
//use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\Config;
use Session;

class LanguageMiddleware {

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //public function handle($request, Closure $next)
    //{ 
    //    $fallbackLocale = $this->app->config->get('app.fallback_locale');
    //    
    //    // Make sure current locale exists.
    //    $locale = $request->segment(1);
    //
    //    if(empty($locale))
    //    {
    //        return redirect()->route('site_lang_home', ['lang' => $fallbackLocale]);
    //    }
    //
    //    if (!array_key_exists($locale, $this->app->config->get('app.locales'))) 
    //    {
    //        $segments = $request->segments();
    //        $segments[0] = $fallbackLocale;
    //
    //        return $this->redirector->to(implode('/', $segments));
    //    }
    //
    //    $this->app->setLocale($locale);
    //    //exit(\App::getLocale());
    //    \View::share(['currentLocale'=> $locale]);
    //
    //    return $next($request);
    //}
    
    public function handle($request, Closure $next)
    { 
        //// Make sure current locale exists.
        //$locale = $request->segment(1);
        //
        //if ( ! array_key_exists($locale, $this->app->config->get('app.locales'))) {
        //    $segments = $request->segments();
        //    $segments[0] = $this->app->config->get('app.fallback_locale');
        //    return $this->redirector->to(implode('/', $segments));
        //}
        //
        //$this->app->setLocale($locale);
        
        
           //                 if(Session::has('success')) {
           //     echo Session::get('success');
           //exit;
           // }        
            
        // Make sure current locale exists.
        $locale = $request->segment(1);
        $defaultLang = 'en';

        if($locale==$defaultLang){  
            $segments = $request->segments();
            array_splice($segments, 0, 1);
            return $this->redirector->to(implode('/', $segments));            
        }
        
        if ( ! in_array($locale, ['en','ar'])) { 
            $locale = $defaultLang;
        }
                    
        $this->app->setLocale($locale);
        \View::share(['currentLocale'=> $locale]);

        return $next($request);
    }    

}
