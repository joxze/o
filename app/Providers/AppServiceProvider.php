<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\FormFacade as Form;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('formText', 'components.form.text', ['name', 'errors', 'label', 'value', 'attributes']);
        Form::component('formPassword', 'components.form.password', ['name', 'errors', 'label', 'attributes']);
        Form::component('formSelect', 'components.form.select', ['name', 'data', 'errors', 'label', 'value', 'attributes']);
        Form::component('formFile', 'components.form.file', ['name', 'errors', 'label']);
        Form::component('formSpan', 'components.form.span', ['label', 'value']);
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
