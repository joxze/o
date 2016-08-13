<?php

use Illuminate\Database\Seeder;

class ServiceContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'DOM',
                'path' => '\App\Jobs\Dom',
                'type' => 'helpers'
            ],
            [
                'name' => 'FormMultipleRow',
                'path' => '\App\Jobs\FormMultipleRow',
                'type' => 'helpers'
            ],
            [
                'name' => 'Helpers',
                'path' => '\App\Jobs\Helpers',
                'type' => 'helpers'
            ],
            [
                'name' => 'PGV',
                'path' => '\App\Jobs\PiratesGridView',
                'type' => 'helpers'
            ],
            [
                'name' => 'User',
                'path' => '\App\User',
                'type' => 'models'
            ],
        ];
        $countModel = $countHelper = 0;
        foreach ($data as $key => $value) {
            DB::insert('insert into service_container (name, path, type) values (:name, :path, :type)', [
                ':name' => $value['name'],
                ':path' => $value['path'],
                ':type' => $value['type'],
            ]);
            if ($value['type'] == 'models')
                $countModel++;
            elseif ($value['type'] == 'helpers')
                $countHelper++;
        }
        $this->command->info("Berhasil menambah {$countModel} Models, dan {$countHelper} Helpers !");
    }
}
