<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'              => 'سید عارف حسینی کیا',
            'mobile'            => '09024855528',
            'verification_code' => '123456',
            'verified'          => true,
            'password'          => '$2y$12$5n9km5jW8olZyvgVXVOJM.3V1UdUgDN3JMhCPkkv6BeAfLVMMQxCG'
        ]);

        $role = Role::create([
            'name' => 'Super Admin'
        ]);

        $user->assignRole('Super Admin');

    }
}
