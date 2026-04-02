<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Section;
use App\Models\ContentBlock;

class EliteAboutSeeder extends Seeder
{
    public function run()
    {
        $page = Page::firstOrCreate(['slug' => 'about'], [
            'title' => 'About Us',
            'is_home' => false,
        ]);

        // Main About Section
        $aboutMain = Section::firstOrCreate(['page_id' => $page->id, 'type' => 'about-main'], [
            'name' => 'About Main',
            'is_active' => true,
            'order_index' => 1
        ]);
        
        $this->updateBlocks($aboutMain, [
            'about_title' => 'Pioneering Digital Excellence',
            'about_subtitle' => 'Our Identity',
            'about_description' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.",
            'features' => json_encode([
                ['title' => 'Innovation First', 'description' => 'We stay ahead of the curve with latest technologies.'],
                ['title' => 'Client Centric', 'description' => 'Your success is our top priority.'],
                ['title' => 'Proven Excellence', 'description' => 'A track record of delivering successful projects worldwide.']
            ])
        ]);

        // Stats Section
        $stats = Section::firstOrCreate(['page_id' => $page->id, 'type' => 'about-stats'], [
            'name' => 'About Stats',
            'is_active' => true,
            'order_index' => 2
        ]);
        
        $this->updateBlocks($stats, [
            'stats_title' => 'Our Impact in Numbers',
            'stats_subtitle' => 'By The Numbers',
            'stats' => json_encode([
                ['icon' => 'fa-solid fa-users', 'number' => '250', 'suffix' => '+', 'label' => 'Happy Clients'],
                ['icon' => 'fa-solid fa-rocket', 'number' => '150', 'suffix' => '+', 'label' => 'Projects Done'],
                ['icon' => 'fa-solid fa-trophy', 'number' => '12', 'suffix' => '', 'label' => 'Industry Awards'],
                ['icon' => 'fa-solid fa-briefcase', 'number' => '10', 'suffix' => 'yr', 'label' => 'Years Experience']
            ])
        ]);

        // Values Section
        $values = Section::firstOrCreate(['page_id' => $page->id, 'type' => 'about-values'], [
            'name' => 'Our Values',
            'is_active' => true,
            'order_index' => 3
        ]);
        
        $this->updateBlocks($values, [
            'values_title' => 'The Core Principles That Guide Us',
            'values_subtitle' => 'Our Culture',
            'values' => json_encode([
                ['icon' => 'fa-solid fa-lightbulb', 'title' => 'Integrity', 'description' => 'We believe in transparency and honest communication in every partnership.'],
                ['icon' => 'fa-solid fa-bolt', 'title' => 'Agility', 'description' => 'Our team adapts quickly to the ever-changing digital landscape.'],
                ['icon' => 'fa-solid fa-handshake', 'title' => 'Collaboration', 'description' => 'We work as an extension of your team to achieve shared goals.']
            ])
        ]);

        // History Section
        $history = Section::firstOrCreate(['page_id' => $page->id, 'type' => 'about-history'], [
            'name' => 'Company History',
            'is_active' => true,
            'order_index' => 4
        ]);
        
        $this->updateBlocks($history, [
            'history_title' => 'Our Journey From a Startup to Now',
            'history_subtitle' => 'Milestones',
            'milestones' => json_encode([
                ['year' => '2015', 'title' => 'The Beginning', 'description' => 'Nova Agency was founded with a vision to simplify complex IT challenges.'],
                ['year' => '2018', 'title' => 'Global Expansion', 'description' => 'We opened our first international office and expanded our service portfolio.'],
                ['year' => '2021', 'title' => 'Innovation Award', 'description' => 'Recognized as the most innovative IT agency in the region.'],
                ['year' => '2024', 'title' => 'Next Phase', 'description' => 'Launching our proprietary AI-driven platform for enterprise solutions.']
            ])
        ]);

        // Team Section
        $team = Section::firstOrCreate(['page_id' => $page->id, 'type' => 'about-team'], [
            'name' => 'Management Team',
            'is_active' => true,
            'order_index' => 5
        ]);
        
        $this->updateBlocks($team, [
            'team_title' => 'Meet the Visionaries Behind Nova Agency',
            'team_subtitle' => 'Our Team',
            'members' => json_encode([
                ['name' => 'Alex Rivera', 'position' => 'CEO & Founder', 'image' => 'assets/img/team/01.jpg', 'linkedin' => '#', 'twitter' => '#'],
                ['name' => 'Sarah Chen', 'position' => 'CTO', 'image' => 'assets/img/team/02.jpg', 'linkedin' => '#', 'twitter' => '#'],
                ['name' => 'Marcus Thorne', 'position' => 'Head of Design', 'image' => 'assets/img/team/03.jpg', 'linkedin' => '#', 'twitter' => '#'],
                ['name' => 'Elena Rodriguez', 'position' => 'Project Lead', 'image' => 'assets/img/team/04.jpg', 'linkedin' => '#', 'twitter' => '#']
            ])
        ]);
    }

    private function updateBlocks(Section $section, array $data)
    {
        foreach ($data as $key => $content) {
            ContentBlock::updateOrCreate(
                ['section_id' => $section->id, 'key' => $key],
                ['content' => $content]
            );
        }
    }
}
