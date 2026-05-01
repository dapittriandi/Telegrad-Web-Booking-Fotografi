<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RenameViews extends Command
{
    protected $signature = 'views:rename';
    protected $description = 'Auto rename legacy ARPotret views to Telegrad naming';

    public function handle()
    {
        $basePath = resource_path('views/root');

        $map = [
            'root-main-index.blade.php' => 'index.blade.php',
            'root-main-contact-us.blade.php' => 'contact.blade.php',

            'root-main-portofolio.blade.php' => 'portfolio.blade.php',
            'root-main-portofoliod.blade.php' => 'portfolio-detail.blade.php',

            'root-main-product.blade.php' => 'package-categories.blade.php',
            'root-main-productc.blade.php' => 'package-category.blade.php',
            'root-main-productd.blade.php' => 'package-detail.blade.php',
        ];

        foreach ($map as $old => $new) {
            $oldPath = $basePath . '/' . $old;
            $newPath = $basePath . '/' . $new;

            if (!File::exists($oldPath)) {
                $this->warn("SKIP (not found): $old");
                continue;
            }

            if (File::exists($newPath)) {
                $this->warn("SKIP (already exists): $new");
                continue;
            }

            File::move($oldPath, $newPath);
            $this->info("RENAMED: $old → $new");
        }

        $this->info('DONE: View rename completed.');
    }
}
