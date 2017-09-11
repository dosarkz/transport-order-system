<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->delete();

        $user = \App\Models\User::where('phone', '7029242612')->first();
        if($user)
        {
            $user->update([
                'phone' =>  7029242612,
                'password' => bcrypt('123456'),
                'name' => 'Admin',
                'email' => 'admin@unipark.kz',
            ]);

        }else{
            $user =  \App\Models\User::create([
                'phone' =>  7029242612,
                'password' => bcrypt('123456'),
                'name' => 'Admin',
                'email' => 'admin@unipark.kz',
            ]);
        }


        $role = \App\Models\Role::where('alias','admin')->first();

        $user_role = \App\Models\UserRole::firstOrCreate([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $user->update([
            'user_role_id' => $user_role->id,
        ]);

    }
}
