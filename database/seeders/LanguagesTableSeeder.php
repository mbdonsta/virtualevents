<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = ['English', 'Lithuanian'];

        foreach ($languages as $lang) {
            $exist = Language::where('name', $lang)->first();

            if ($exist) {
                continue;
            }

            Language::create([
                'name' => $lang
            ]);
        }
    }
}
