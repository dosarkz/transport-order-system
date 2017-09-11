<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            'title' => 'Администратор',
            'alias' => 'admin',
        ]);

        DB::table('roles')->insert([
            'title' => 'Клиент',
            'alias' => 'client',
        ]);


        DB::table('roles')->insert([
            'title' => 'Поставщик',
            'alias' => 'provider',
        ]);

        DB::table('roles')->insert([
            'title' => 'Водитель',
            'alias' => 'driver',
        ]);

        DB::table('roles')->insert([
            'title' => 'Модератор',
            'alias' => 'moderator',
        ]);

        DB::table('roles')->insert([
            'title' => 'Оператор',
            'alias' => 'operator',
        ]);
    }
}
