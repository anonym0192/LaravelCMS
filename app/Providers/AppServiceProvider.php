<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Page;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //MENU
        $front_menu = [];
        $pages = Page::all();

        foreach($pages as $page){
            $front_menu[$page['slug']] = $page['title'];
        }

        View::share('front_menu', $front_menu);

        //SETTINGS
        $front_config = [];
        $settings = Setting::all();

        foreach($settings as $setting){
            $front_config[$setting['name']] = $setting['value'];
        }

        View::share('front_config', $front_config);
    }
}
