<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Project;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $sitemap = Sitemap::create();

        $sitemap->add(Url::create('/'));
        $sitemap->add(Url::create('/about'));
        $sitemap->add(Url::create('/facility'));
        $sitemap->add(Url::create('/projects'));
        $sitemap->add(Url::create('/products/new'));
        $sitemap->add(Url::create('/products/second'));
        $sitemap->add(Url::create('/products/safety-equipment'));

        foreach (Product::all() as $product) {
            $sitemap->add(Url::create(route('product.show', $product->slug)));
        }

        foreach (Project::all() as $project) {
            $sitemap->add(Url::create(route('project.show', $project->slug)));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}
