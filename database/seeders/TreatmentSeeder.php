<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Treatment::factory(10)->create();
        
        DB::table('treatments')->insert([
            ['treatmentName' => 'Ortodoncia', 'description' => 'Invisalign o Brackets linguales incógnito'],
            ['treatmentName' => 'Endodoncia', 'description' => 'Se realiza con radiografía muy precisa cual nos permitirá ver tu grado de afectación, tiempo de trabajo y pasos a realizarte, comenzará el tratamiento'],
            ['treatmentName' => 'Prótesis dentales', 'description' => 'Nuestro equipo de protésicos dentales en Valencia te recomendará la que mejor se adapte a tus necesidades para que vuelvas a tener la sonrisa perfecta'],
            ['treatmentName' => 'Prevención Bucal', 'description' => 'La prevención en odontología como en cualquier área de medicina, es algo muy importante que debemos concienciarnos a realizarla por costumbre ya que es menos costosa económicamente y menos indolora'],
            ['treatmentName' => 'Odontopediatría', 'description' => 'En nuestro Centro Odontológico tenemos los mejores expertos en odontopediatría en Valencia, poniendo al cuidado, mantenimiento y prevención la salud dental del niño desde su infancia hasta su adolescencia'],
            ['treatmentName' => 'Empastes', 'description' => 'Los empastes dentales son un procedimiento odontológico para la eliminación de una caries devolviendo al diente su forma y color natural'],
            ['treatmentName' => 'Primera consulta', 'description' => 'En la primera consulta tendrías una valoración del especialista y conocerías mejor nuestra clínica'],
            
        ]);
    }
}
