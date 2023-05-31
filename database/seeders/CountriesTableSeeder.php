<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['name' => 'Austria', 'code' => 'AT', 'phone_prefix' => '+43'],
            ['name' => 'Belgium', 'code' => 'BE', 'phone_prefix' => '+32'],
            ['name' => 'Bulgaria', 'code' => 'BG', 'phone_prefix' => '+359'],
            ['name' => 'Croatia', 'code' => 'HR', 'phone_prefix' => '+385'],
            ['name' => 'Cyprus', 'code' => 'CY', 'phone_prefix' => '+357'],
            ['name' => 'Czech Republic', 'code' => 'CZ', 'phone_prefix' => '+420'],
            ['name' => 'Denmark', 'code' => 'DK', 'phone_prefix' => '+45'],
            ['name' => 'Estonia', 'code' => 'EE', 'phone_prefix' => '+372'],
            ['name' => 'Finland', 'code' => 'FI', 'phone_prefix' => '+358'],
            ['name' => 'France', 'code' => 'FR', 'phone_prefix' => '+33'],
            ['name' => 'Germany', 'code' => 'DE', 'phone_prefix' => '+49'],
            ['name' => 'Greece', 'code' => 'GR', 'phone_prefix' => '+30'],
            ['name' => 'Hungary', 'code' => 'HU', 'phone_prefix' => '+36'],
            ['name' => 'Iceland', 'code' => 'IS', 'phone_prefix' => '+354'],
            ['name' => 'Ireland', 'code' => 'IE', 'phone_prefix' => '+353'],
            ['name' => 'Italy', 'code' => 'IT', 'phone_prefix' => '+39'],
            ['name' => 'Latvia', 'code' => 'LV', 'phone_prefix' => '+371'],
            ['name' => 'Lithuania', 'code' => 'LT', 'phone_prefix' => '+370', 'tax_rate' => 21],
            ['name' => 'Luxembourg', 'code' => 'LU', 'phone_prefix' => '+352'],
            ['name' => 'Malta', 'code' => 'MT', 'phone_prefix' => '+356'],
            ['name' => 'Netherlands', 'code' => 'NL', 'phone_prefix' => '+31'],
            ['name' => 'Norway', 'code' => 'NO', 'phone_prefix' => '+47'],
            ['name' => 'Poland', 'code' => 'PL', 'phone_prefix' => '+48'],
            ['name' => 'Portugal', 'code' => 'PT', 'phone_prefix' => '+351'],
            ['name' => 'Romania', 'code' => 'RO', 'phone_prefix' => '+40'],
            ['name' => 'Russia', 'code' => 'RU', 'phone_prefix' => '+7'],
            ['name' => 'Slovakia', 'code' => 'SK', 'phone_prefix' => '+421'],
            ['name' => 'Slovenia', 'code' => 'SI', 'phone_prefix' => '+386'],
            ['name' => 'Spain', 'code' => 'ES', 'phone_prefix' => '+34'],
            ['name' => 'Sweden', 'code' => 'SE', 'phone_prefix' => '+46'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'phone_prefix' => '+44']
        ];

        foreach ($countries as $country) {
            $existing = Country::where('code', $country['code'])->first();
            if (!$existing) {
                Country::create($country);
            }
        }
    }
}
