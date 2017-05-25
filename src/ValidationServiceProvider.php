<?php

namespace ITBrains\Validation;

use Illuminate\Support\ServiceProvider;
use ITBrains\Validation\Validators\NotEqualValidator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        NotEqualValidator::boot($this->app['validator']);

        $translationPath = __DIR__ . '/../resources/lang';
        $this->loadTranslationsFrom($translationPath, 'it-brains');
        $this->publishes([
            $translationPath => resource_path('lang/vendor/it-brains'),
        ], 'lang');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
