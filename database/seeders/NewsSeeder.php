<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for the news table
        $news = [
            [
                'news_title' => 'Job Fair 2024: A Great Opportunity for Job Seekers',
                'category' => 'Events',
                'publish_date' => Carbon::now()->toDateString(),
                'image_path' => 'path/to/image1.jpg',
                'tags' => 'job fair, event, career',
                'content' => 'Join us for a huge job fair in 2024, bringing employers and job seekers together.',
            ],
            [
                'news_title' => 'How to Build a Resume That Gets Noticed',
                'category' => 'Tips',
                'publish_date' => Carbon::now()->toDateString(),
                'image_path' => 'path/to/image2.jpg',
                'tags' => 'resume, career, job tips',
                'content' => 'Learn how to craft a compelling resume that stands out in the job market.',
            ],
            [
                'news_title' => 'Top 5 Skills Employers Look For in 2024',
                'category' => 'Trends',
                'publish_date' => Carbon::now()->toDateString(),
                'image_path' => 'path/to/image3.jpg',
                'tags' => 'skills, career, job trends',
                'content' => 'Discover the skills employers are seeking to fill jobs in 2024 and beyond.',
            ],
        ];

        // Insert the data into the news table
        DB::table('news')->insert($news);
    }
}
