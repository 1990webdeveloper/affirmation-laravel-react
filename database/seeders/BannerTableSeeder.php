<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banner = [
            'name' => 'Get Started Today',
            'description' => 'Start manifesting your affirmations now with our easy-to-use tool.',
            'image' => 'banner.png',
            'status' => '1'
        ];

        Banner::create($banner);
    }
}
