<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Get all notifications from header file 
        view()->composer('front.includes.header', function($view) {
            $dataArray['user_id'] = \Auth::guard('user')->user()->id;
            $dataArray['department_id'] = \Auth::guard('user')->user()->department_id;
            // $notifications = \App\Notification::where(function ($query) use ($dataArray) {                
            //     $query->where('notificationable_type', 'Ticket')->where('department_id',$dataArray['department_id']);
            //     })->orWhere(function ($query) {
            //         $query->where('notificationable_type', 'Event');
            //     })->orderBy('id','desc')->limit(6)->get();

            $notifications = \App\Notification::where('user_id',$dataArray['user_id'])->orderBy('id','Desc')->limit(4)->get();
            // dd($notifications);

            $view->with('notifications',$notifications);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
