<?php

namespace Database\Seeders;

use App\Models\VideoSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videoSources = [
            'Youtube',
            'Vimeo'
        ];

        foreach ($videoSources as $videoSource) {
            $exist = VideoSource::where('name', $videoSource)->first();

            if ($exist) {
                continue;
            }

            VideoSource::create([
                'name' => $videoSource
            ]);
        }
    }
}
