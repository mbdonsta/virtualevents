<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic'
            ],
            [
                'name' => 'Standard',
                'slug' => 'standard'
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium'
            ]
        ];

        foreach ($plans as $plan) {
            $exist = Plan::where('slug', $plan['slug'])->first();

            if ($exist) {
                continue;
            }

            Plan::create($plan);
        }
    }
}
