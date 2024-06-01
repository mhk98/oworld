<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HighlightView;

class HighlightViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HighlightView::create([
            'highlight_id' => 33,
            'ip_address' => '127.0.0.1'
        ]);

        HighlightView::create([
            'highlight_id' => 34,
            'ip_address' => '127.0.0.1'
        ]);

        echo "Highlight View Add";
    }
}
