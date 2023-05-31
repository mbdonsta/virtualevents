<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exist = Event::where('user_id', 2)->where('title', 'Sample event')->first();

        if (!$exist) {
            (new EventService)->create([
                'user_id' => 1,
                'title' => 'Sample event',
                'slug' => 'sample-event-11111',
                'subject' => 'Sample subject',
                'description' => 'Sample description',
                'begin_datetime' => date('Y-m-d 10:00', strtotime("+2 days")),
                'end_datetime' => date('Y-m-d 15:00', strtotime("+4 days")),
                'location' => 'Online',
                'language_id' => 1,
                'is_public' => 0,
                'enabled' => 0
            ]);
        }
    }
}
