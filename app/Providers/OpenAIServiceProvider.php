<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenAI;

class OpenAIServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('openai', function ($app) {
            return OpenAI::client(config('openai.api_key'));
        });
    }

    public function boot()
    {
        //
    }
} 