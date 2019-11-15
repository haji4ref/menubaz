<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'index roles', 'label' => 'دیدن نقش ها']);
        Permission::create(['name' => 'create roles', 'label' => 'ساخت نقش جدید']);
        Permission::create(['name' => 'edit roles', 'label' => 'ویرایش نقش ها']);
        Permission::create(['name' => 'delete roles', 'label' => 'پاک کردن نقش']);

        Permission::create(['name' => 'index robots', 'label' => 'دیدن همه ربات ها']);
        Permission::create(['name' => 'create robots', 'label' => 'ساخت ربات جدید']);
        Permission::create(['name' => 'delete robots', 'label' => 'پاک کردن ربات ها']);
        Permission::create(['name' => 'edit robots', 'label' => 'ویرایش کردن ربات ها']);
    }
}
