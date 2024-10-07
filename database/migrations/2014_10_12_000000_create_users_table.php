<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->boolean('is_docente')->default(false);
            $table->timestamps();
        });

        // Crear 17 usuarios con rol 'docente'
        $docentes = [
            ['name' => 'Alice.Smith', 'email' => 'alicesmith@example.com'],
            ['name' => 'Bob.Johnson', 'email' => 'bobjohnson@example.com'],
            ['name' => 'Charlie.Brown', 'email' => 'charliebrown@example.com'],
            ['name' => 'David.Wilson', 'email' => 'davidwilson@example.com'],
            ['name' => 'Eva.Davis', 'email' => 'evadavis@example.com'],
            ['name' => 'Frank.Miller', 'email' => 'frankmiller@example.com'],
            ['name' => 'Grace.Lee', 'email' => 'gracelee@example.com'],
            ['name' => 'Hannah.Walker', 'email' => 'hannahwalker@example.com'],
            ['name' => 'Ian.Hall', 'email' => 'ianhall@example.com'],
            ['name' => 'Jane.Allen', 'email' => 'janeallen@example.com'],
            ['name' => 'Kyle.Young', 'email' => 'kyleyoung@example.com'],
            ['name' => 'Laura.King', 'email' => 'lauraking@example.com'],
            ['name' => 'Mike.Scott', 'email' => 'mikescott@example.com'],
            ['name' => 'Nina.Wright', 'email' => 'ninawright@example.com'],
            ['name' => 'Oscar.Harris', 'email' => 'oscarharris@example.com'],
            ['name' => 'Paul.Green', 'email' => 'paulgreen@example.com'],
            ['name' => 'Quinn.Turner', 'email' => 'quinnturner@example.com'],
        ];

        foreach ($docentes as $docente) {
            DB::table('users')->insert([
                'name' => $docente['name'],
                'email' => $docente['email'],
                'password' => Hash::make('password'), // Cambia 'password' por la contraseña que prefieras
                'role' => 'docente',
                'is_docente' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('cantidad_sillas');
            $table->string('cantidad_mesas');
            $table->timestamps();
        });

        $aulas = [];

        for ($i = 1; $i <= 12; $i++) {
            $aulas[] = [
                'nombre' => 'Aula ' . $i,
                'cantidad_sillas' => 30,
                'cantidad_mesas' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('aulas')->insert($aulas);
    
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('hrs_trabajo');
            $table->timestamps();
        });

        DB::table('categorias')->insert([
            ['nombre' => 'merito', 'hrs_trabajo' => '120'],
            ['nombre' => 'primera', 'hrs_trabajo' => '116'],
            ['nombre' => 'segunda', 'hrs_trabajo' => '112'],
            ['nombre' => 'tercera', 'hrs_trabajo' => '108'],
            ['nombre' => 'cuarta', 'hrs_trabajo' => '104'],
            ['nombre' => 'quinta', 'hrs_trabajo' => '100'],
        ]);

        

        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('horas_semana')->default(0);
            $table->foreignId('docente_id')->nullable()->constrained('docentes')->onDelete('cascade');
            $table->timestamps();
        });

        

        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('cursos')->insert([
            ['nombre' => '1ro'],
            ['nombre' => '2do'],
            ['nombre' => '3ro'],
            ['nombre' => '4to'],
            ['nombre' => '5to'],
            ['nombre' => '6to'],
        ]);

        Schema::create('materia_curso', function (Blueprint $table){
            $table->id();
            $table->foreignId('materia_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        });

        DB::table('horarios')->insert([
            ['hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['hora_inicio' => '12:20', 'hora_fin' => '13:00'],
        ]);
    
        Schema::create('paralelos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cantidad_est')->default(0);
            $table->foreignId('curso_id')->constrained('cursos');
            $table->timestamps();
        });
        DB::table('paralelos')->insert([
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 1],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 1],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 2],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 2],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 3],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 3],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 4],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 4],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 5],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 5],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 6],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 6],
        ]);

        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->string('dia');
            $table->foreignId('horario_id')->constrained('horarios')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('aula_id')->constrained('aulas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
        Schema::dropIfExists('paralelos');
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('materia_curso');
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('docentes');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('aulas');
        Schema::dropIfExists('users');
    }
}
