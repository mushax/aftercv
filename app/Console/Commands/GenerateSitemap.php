<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // إضافة الصفحة الرئيسية باللغتين
        $sitemap->add(Url::create('/en')->setPriority(1.0));
        $sitemap->add(Url::create('/ar')->setPriority(1.0));
        
        // هنا في المستقبل، سنضيف الروابط الأخرى ديناميكيًا
        // مثل صفحات الفرص الوظيفية العامة وملفات الشركات

        // كتابة الملف في المجلد العام
        $sitemap->writeToFile(public_path('sitemap.xml'));
        
        $this->info('The sitemap has been generated successfully.');
        
        return 0;
    }
}