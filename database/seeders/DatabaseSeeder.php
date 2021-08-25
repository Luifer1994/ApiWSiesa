<?php

namespace Database\Seeders;

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
        //CREAMOS UN ADMINISTRADOR POR DEFECTO
        \App\Models\User::factory(1)->create();

    }
}
