<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        // Using Picsum Photos for reliable placeholder images
        for ($i = 1; $i <= 10; $i++) {
            $url = "https://picsum.photos/800/600?random=" . $i;
            try {
                $imageContent = file_get_contents($url);
                if ($imageContent !== false) {
                    $filename = 'blog' . $i . '.jpg';
                    Storage::disk('public')->put('images/' . $filename, $imageContent);
                    $this->command->info("Downloaded and saved: {$filename}");
                }
            } catch (\Exception $e) {
                $this->command->error("Failed to download image {$i}: " . $e->getMessage());
            }
        }
    }
} 