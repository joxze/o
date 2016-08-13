<?php

use Illuminate\Database\Seeder;

class RulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $data = [
            [
                'rules_name' => 'admin',
                'status' => 1
            ]
        ];
        $count = 0;
        foreach ($data as $key => $value) {
            DB::insert('insert into rules (name, status) values (:name, :status)', [
                ':name' => $value['rules_name'],
                ':status' => $value['status'],
            ]);
            $count++;
        }
        $this->command->info("Berhasil menambah {$count} rules!");
    }
}
