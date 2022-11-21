<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'particular';
        $role->description = 'particular';
        $role->save();
        $role = new Role();
        $role->name = 'profesional';
        $role->description = 'profesional';
        $role->save();
    }
}
