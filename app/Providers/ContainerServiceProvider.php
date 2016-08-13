<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class ContainerServiceProvider extends ServiceProvider
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
        // $this->app->instance('Helpers', new \App\Jobs\Helpers());
        // $this->app->instance('PGV', new \App\Jobs\PiratesGridView());
        // $this->app->instance('DOM', new \App\Jobs\Dom());
        $this->app->instance('GeneratorMigrate', new \App\Jobs\GeneratorMigrate());
        $this->app->instance('GeneratorModel', new \App\Jobs\GeneratorModel());
        // $this->app->instance('FormMultipleRow', new \App\Jobs\FormMultipleRow());
        $data = DB::table('service_container')->where('type', '=', 'helpers')->get();
        foreach ($data as $kData => $vData) {
            $name = $vData->name;
            $path = $vData->path;
            $this->app->instance($name, new $path());
            // $this->app->instance('modelTables', new \App\Http\Models\Tables());

        }
    }
}
