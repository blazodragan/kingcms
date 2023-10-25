<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class SyncSitemapToDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:sitemap-to-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync sitemap.xml links to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Load sitemap content
    $sitemapContent = file_get_contents(public_path('sitemap.xml'));
    $xml = new \SimpleXMLElement($sitemapContent);

    // Loop through the URLs and store in database
    foreach ($xml->url as $urlItem) {
        $url = (string)$urlItem->loc;
        \DB::table('site_links')->updateOrInsert(['url' => $url], ['url' => $url]);
    }

    $this->info('Sitemap synced to database successfully!');
    }
}
