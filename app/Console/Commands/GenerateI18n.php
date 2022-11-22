<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Lang;

class GenerateI18n extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'i18n:generate {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate i18n json';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $targetDirectory = ltrim(rtrim($this->argument('path')));

        if (! file_exists($targetDirectory)) {
            mkdir($targetDirectory);
        }

        $locales = array_diff(scandir(base_path('lang')), ['..', '.']);

        foreach ($locales as $locale) {
            $files = array_diff(scandir(base_path('lang/'.$locale)), ['..', '.']);
            app()->setLocale($locale);
            $messages = [];

            foreach ($files as $file) {
                $key = str_replace('.php', '', $file);
                $messages[$key] = Lang::get($key);
            }

            $fileName = "$targetDirectory/$locale.json";
            file_put_contents($fileName, json_encode($messages));
        }

        $this->info('I18n generated successfully!');

        return Command::SUCCESS;
    }
}
