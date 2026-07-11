<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            ['name' => 'TechFlow', 'logo' => 'storage/partners/logo1.png', 'url' => '#'],
            ['name' => 'Visionary AI', 'logo' => 'storage/partners/logo2.png', 'url' => '#'],
            ['name' => 'Global Nexus', 'logo' => 'storage/partners/logo3.png', 'url' => '#'],
        ];

        foreach ($partners as $index => $partner) {
            \App\Models\Partner::updateOrCreate(
                ['name' => $partner['name']],
                [
                    'logo' => $partner['logo'],
                    'url' => $partner['url'],
                    'is_active' => true,
                    'order_index' => $index,
                ]
            );
        }

        // Set default section content
        $homePage = \App\Models\Page::where('slug', 'home')->first();
        if ($homePage) {
            $section = \App\Models\Section::firstOrCreate(
                ['type' => 'home-partners', 'page_id' => $homePage->id], 
                ['name' => 'Partners Marquee', 'is_active' => true]
            );


        $section->contentBlocks()->updateOrCreate(
            ['key' => 'partners_title'],
            ['content' => 'Our Trusted Partners']
        );
        $section->contentBlocks()->updateOrCreate(
            ['key' => 'partners_subtitle'],
            ['content' => 'Collaborating with industry leaders to deliver excellence.']
        );
        }
    }
}
