<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rehearsal;

class RehearsalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rehearsal::create([
            'place' => 'Sala de ensayo',
            'date' => '2024-01-02',
            'hour' => '10:00',
        ]);

        Rehearsal::create([
            'place' => 'Auditorio',
            'date' => '2024-02-20',
            'hour' => '15:00',
        ]);

        Rehearsal::create([
            'place' => 'Sala de ensayo',
            'date' => '2024-12-6',
            'hour' => '17:30',
        ]);

        Rehearsal::create([
            'place' => 'Sala de ensayo',
            'date' => '2024-11-08',
            'hour' => '14:00',
        ]);
        Rehearsal::create([
            'place' => 'Sala de ensayo',
            'date' => '2024-12-13',
            'hour' => '17:30',
        ]);

        Rehearsal::create([
            'place' => 'Sala de ensayo',
            'date' => '2024-11-15',
            'hour' => '14:00',
        ]);
        Rehearsal::create([
            'place' => 'Sala de ensayo',
            'date' => '2024-12-20',
            'hour' => '17:30',
        ]);

        Rehearsal::create([
            'place' => 'Sala de ensayo',
            'date' => '2024-11-22',
            'hour' => '14:00',
        ]);
    }
}
