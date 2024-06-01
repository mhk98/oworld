<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoreOpeningHours;

class StoreOpeningHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = '{"Monday":{"opening":"09:00","closing":"22:00","open_24h":false,"closed":false},"Tuesday":{"opening":"09:00","closing":"22:00","open_24h":false,"closed":false},"Wednesday":{"opening":"09:00","closing":"22:00","open_24h":false,"closed":true},"Thursday":{"opening":"09:00","closing":"22:00","open_24h":false,"closed":false},"Friday":{"opening":"09:00","closing":"22:00","open_24h":false,"closed":true},"Saturday":{"opening":"09:00","closing":"22:00","open_24h":false,"closed":false},"Sunday":{"opening":"09:00","closing":"22:00","open_24h":false,"closed":false}}';
        $data = json_decode($json, true);

        foreach ($data as $day => $values) {
            StoreOpeningHours::create([
                'store_id' => 14,
                'day' => $day,
                'opening' => $values['opening'],
                'closing' => $values['closing'],
                'open_24h' => $values['open_24h'],
                'closed' => $values['closed'],
            ]);
        }

        echo "Store Opening Hours Added!";
    }
}
