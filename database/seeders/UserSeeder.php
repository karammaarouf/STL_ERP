<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إعادة تعيين الكاش الخاص بالأدوار والصلاحيات لتجنب المشاكل
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الأدوار
        // استخدام firstOrCreate لتجنب إنشاء أدوار مكررة عند إعادة تشغيل الـ Seeder
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $this->command->info('تم إنشاء دور "super-admin" و "admin" بنجاح.');

        // إنشاء المستخدم الأول - Super Admin
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        // ربط دور Super Admin مع المستخدم
        $superAdminUser->assignRole($superAdminRole);

        $this->command->info('تم إنشاء مستخدم Super Admin وربطه بالدور.');

        // إنشاء المستخدم الثاني - Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // ربط دور Admin مع المستخدم
        $adminUser->assignRole($adminRole);

        $this->command->info('تم إنشاء مستخدم Admin وربطه بالدور.');

        // إعطاء جميع الصلاحيات الموجودة لدور الـ Super Admin
        // هذا يضمن أن الـ Super Admin لديه كل الصلاحيات دائماً
        $allPermissions = Permission::pluck('id', 'id')->all();
        $superAdminRole->syncPermissions($allPermissions);

        $this->command->info('تم إعطاء جميع الصلاحيات لدور Super Admin.');
    }
}
