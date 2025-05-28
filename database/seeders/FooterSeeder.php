<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['section' => 'Our Studio', 'link_text' => 'About Us', 'link_url' => '/about-us'],
            ['section' => 'Our Studio', 'link_text' => 'Our Team', 'link_url' => '/our-team'],
            ['section' => 'Our Studio', 'link_text' => 'Our Games', 'link_url' => '/our-games'],
            ['section' => 'Our Studio', 'link_text' => 'Careers', 'link_url' => '/careers'],
            ['section' => 'Services', 'link_text' => 'Game Design', 'link_url' => '/game-design'],
            ['section' => 'Services', 'link_text' => 'Game Development', 'link_url' => '/game-development'],
            ['section' => 'Services', 'link_text' => 'Art Director', 'link_url' => '/art-director'],
            ['section' => 'Services', 'link_text' => 'Multiplatform', 'link_url' => '/multiplatform'],
            ['section' => 'Support', 'link_text' => 'Community', 'link_url' => '/community'],
            ['section' => 'Support', 'link_text' => 'FAQs', 'link_url' => '/faqs'],
            ['section' => 'Support', 'link_text' => 'License', 'link_url' => '/license'],
            ['section' => 'Support', 'link_text' => 'Privacy', 'link_url' => '/privacy'],
            ['section' => 'Follow Us', 'link_text' => 'Facebook'],
            ['section' => 'Follow Us', 'link_text' => 'Twitter'],
            ['section' => 'Follow Us', 'link_text' => 'Instagram'],
            ['section' => 'Follow Us', 'link_text' => 'YouTube'],
        ];

        foreach ($data as $index => $item) {
            Footer::create(array_merge($item, ['order' => $index]));
        }
    }
}
