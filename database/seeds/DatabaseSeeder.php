<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        // $this->call(UsersTableSeeder::class);
        $this->call('RulesSeeder');
        $this->call('AssignSeeder');
        $this->call('UserSeeder');
        $this->call('ServiceContainerSeeder');
    }
}
