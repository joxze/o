<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'user_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminnyao'),
            'rules_id' => 1,
        ]);
        $this->command->info("Berhasil menambah Admin user!");
    }
}
