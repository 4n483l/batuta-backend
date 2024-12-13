<?php

namespace Database\Seeders;

use App\Models\Concert;
use Illuminate\Database\Seeder;

class ConcertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear conciertos con datos específicos
        Concert::create([
            'title' => 'Concierto de Año Nuevo',
            'place' => 'Auditorio Nacional',
            'date' => '2025-01-01',
            'hour' => '18:00',
        ]);

        Concert::create([
            'title' => 'Concierto Sinfónico',
            'place' => 'Teatro Real',
            'date' => '2025-01-15',
            'hour' => '20:00',
        ]);

        Concert::create([
            'title' => 'Recital de Piano',
            'place' => 'Centro Cultural',
            'date' => '2024-12-10',
            'hour' => '19:30',
        ]);

        Concert::create([
            'title' => 'Concierto de Música Clásica',
            'place' => 'Auditorio',
            'date' => '2024-12-25',
            'hour' => '21:00',
        ]);
        Concert::create([
            'title' => 'Concierto Aniversario',
            'place' => 'Centro Cultural',
            'date' => '2024-11-10',
            'hour' => '19:30',
        ]);

        Concert::create([
            'title' => 'Concierto de fiestas',
            'place' => 'Auditorio Julio Iglesias',
            'date' => '2024-11-25',
            'hour' => '21:00',
        ]);
    }
}
