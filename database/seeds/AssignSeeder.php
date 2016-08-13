<?php

use Illuminate\Database\Seeder;

class AssignSeeder extends Seeder
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
                'controller' => 'Auth\AuthController',
                'action' => 'getLogin',
                'method' => 'get'
            ],
            [
                'controller' => 'Auth\AuthController',
                'action' => 'postLogin',
                'method' => 'post'
            ],
            [
                'controller' => 'Auth\AuthController',
                'action' => 'getLogout',
                'method' => 'get'
            ],
            [
                'controller' => 'Auth\AuthController',
                'action' => 'getRegister',
                'method' => 'get'
            ],
            [
                'controller' => 'Auth\AuthController',
                'action' => 'postRegister',
                'method' => 'post'
            ],
        ];
        $count = 0;
        foreach ($data as $key => $value) {
            DB::insert('insert into assign (controller, action, method) values ("'.$value['controller'].'", "'.$value['action'].'", "'.$value['method'].'")'
                // [
                //     ':controller' => $value['controller'],
                //     ':action' => $value['action'],
                //     ':method ' => $value['method']
                // ]
            );
            $count++;
        }
        $this->command->info("Berhasil menambah {$count} rules!");
    }
}
