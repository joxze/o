<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class ModelsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $data = DB::table('service_container')->where('type', '=', 'models')->get();
        foreach ($data as $kData => $vData) {
            $name = $vData->name;
            $path = $vData->path;
            $this->app->instance($name, new $path());
           // $this->app->instance('User', new \App\User());

        }
    }
}
