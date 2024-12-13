<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ----------------- ADMIN -----------------------
        User::create([
            'name' => 'Anabel',
            'lastname' => 'Mollà',
            'dni' => '12345678Z',
            'email' => 'admin@example.com',
            'phone' => '123456999',
            'address' => 'null',
            'city' => 'null',
            'postal_code' => 'null',
            'birth_date' => 'null',
            'role' => 'admin',
            'user_type' => 'admin',
            'password' => bcrypt('example'),
        ]);

        // ----------------- USERS -----------------------

        // Crear músicos con nombres específicos
        $userMusicianData = [
            [
                'name' => 'Juan ',
                'lastname' => 'González Pérez',
                'dni' => '12345678A',
                'email' => 'musico1@example.com',
                'phone' => '123456789',
                'address' => 'Calle Falsa 123',
                'city' => 'Madrid',
                'postal_code' => '28000',
                'birth_date' => '1990-01-01',
                'role' => 'user',
                'user_type' => 'musician',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'Ana',
                'lastname' => 'Ruiz García',
                'dni' => '87654321B',
                'email' => 'musico2@example.com',
                'phone' => '987644321',
                'address' => 'Calle Alta 321',
                'city' => 'Barcelona',
                'postal_code' => '08000',
                'role' => 'user',
                'user_type' => 'musician',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'Carla',
                'lastname' => 'Escudero Mos',
                'dni' => '12348765C',
                'email' => 'musico3@example.com',
                'phone' => '123456689',
                'address' => 'Calle Baja 456',
                'city' => 'Valencia',
                'postal_code' => '46000',
                'role' => 'user',
                'user_type' => 'musician',
                'password' => bcrypt('example'),
            ]
        ];
        foreach ($userMusicianData as $userMusician) {
            User::create($userMusician);
        }

        // Crear profesores con nombres específicos
        $userTeacherData =[
            [
                'name' => 'Luis',
                'lastname' => 'Blanco Sánchez',
                'dni' => '12345678D',
                'email' => 'teacher1@example.com',
                'phone' => '123456769',
                'address' => 'Carrer Major 13',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'role' => 'user',
                'user_type' => 'teacher',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'María',
                'lastname' => 'López García',
                'dni' => '87654321E',
                'email' => 'teacher2@example.com',
                'phone' => '987654321',
                'address' => 'Calle La Selva 21',
                'city' => 'Alicante',
                'postal_code' => '03000',
                'role' => 'user',
                'user_type' => 'teacher',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'Elena',
                'lastname' => 'Maldonado Beltrán',
                'dni' => '12348765F',
                'email' => 'teacher3@example.com',
                'phone' => '123456786',
                'address' => 'Calle Esperanza 34',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'role' => 'user',
                'user_type' => 'teacher',
                'password' => bcrypt('example'),
            ]
        ];
        foreach ($userTeacherData as $userTeacher) {
            User::create($userTeacher);
        }

        // Crear miembros con nombres específicos
        $userMemberData = [
            [
                'name' => 'Pedro',
                'lastname' => 'Rivera García',
                'dni' => '12345678G',
                'email' => 'member1@example.com',
                'phone' => '123656789',
                'address' => 'Calle Langreo 1',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'role' => 'user',
                'user_type' => 'member',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'Lucía',
                'lastname' => 'Riesgo Fernández',
                'dni' => '87654321H',
                'email' => 'member2@example.com',
                'phone' => '987684321',
                'address' => 'Calle Oviedo 2',
                'city' => 'La  Nucia',
                'postal_code' => '03530',
                'role' => 'user',
                'user_type' => 'member',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'Rafael',
                'lastname' => 'Navas Rivas',
                'dni' => '12348765I',
                'email' => 'member3@example.com',
                'phone' => '223456789',
                'address' => 'Calle Gijón 3',
                'city' => 'Altea',
                'postal_code' => '03590',
                'role' => 'user',
                'user_type' => 'member',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'Sofía',
                'lastname' => 'Moreno Torres',
                'dni' => '12345678J',
                'email' => 'member4@example.com',
                'phone' => '123456780',
                'address' => 'Calle Infierno 4',
                'city' => 'Villajoyosa',
                'postal_code' => '03570',
                'role' => 'user',
                'user_type' => 'member',
                'password' => bcrypt('example'),
            ],
            [
                'name' => 'David',
                'lastname' => 'Jimenez Roca',
                'dni' => '87654321K',
                'email' => 'memeber5@example.com',
                'phone' => '997654321',
                'address' => 'Calle Olvido 5',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'role' => 'user',
                'user_type' => 'member',
                'password' => bcrypt('example'),
            ]
        ];
        foreach ($userMemberData as $userMember) {
            User::create($userMember);
        }
    }
}
