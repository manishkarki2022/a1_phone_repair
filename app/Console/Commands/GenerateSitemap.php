<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml';

    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0))
            ->add(Url::create('/book-repair')->setPriority(0.9))
            ->add(Url::create('/contact')->setPriority(0.8))
            ->add(Url::create('/about')->setPriority(0.7))
            ->add(Url::create('/check-status')->setPriority(0.6));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at ' . public_path('sitemap.xml'));
    }
}
