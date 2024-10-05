<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriaSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('materias')->insert([
            ['nombre' => 'Ciencias Sociales'],
            ['nombre' => 'Biologia Geografia'],
            ['nombre' => 'Matematicas'],
            ['nombre' => 'Lengua Castellana y Originaria'],
            ['nombre' => 'Educacion Musical'],
            ['nombre' => 'Educacion fisica'],
            ['nombre' => 'Fisica'],
            ['nombre' => 'Quimica'],
            ['nombre' => 'Cosmos Visiones, Filosofia y Psicologia'],
            ['nombre' => 'Tecnica tecnologica general'],
            ['nombre' => 'Tecnica tecnologica especializada'],
            ['nombre' => 'Artes Plasticas y Visuales'],
            ['nombre' => 'Valores Espirituales y Religiones'],
            ['nombre' => 'Lengua Extranjera'],
        ]);
    }
}
