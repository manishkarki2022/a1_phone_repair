<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register SEO Tools Facades as middleware aliases
        $middleware->alias([
            'SEOMeta' => Artesaos\SEOTools\Facades\SEOMeta::class,
            'OpenGraph' => Artesaos\SEOTools\Facades\OpenGraph::class,
            'Twitter' => Artesaos\SEOTools\Facades\TwitterCard::class,
            'SEO' => Artesaos\SEOTools\Facades\SEOTools::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        // Register SEO Tools Service Provider
        Artesaos\SEOTools\Providers\SEOToolsServiceProvider::class,
    ])
    ->create();
