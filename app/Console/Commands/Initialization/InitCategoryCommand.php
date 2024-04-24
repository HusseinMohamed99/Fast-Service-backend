<?php

namespace App\Console\Commands\Initialization;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Category Initialize';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        Category::create([
            'name' => 'Cleaning',
        ]);
        Category::create([
            'name' => 'Repairing',
        ]);
        Category::create([

            'name' => 'Electricion',

        ]);
        $this->info('Update DataBase successfully.');
        return;

    }

}
