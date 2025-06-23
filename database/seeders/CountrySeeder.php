<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // قائمة الدول العربية
        $countries = [
            ['name' => 'المملكة العربية السعودية', 'code' => 'SA'],
            ['name' => 'جمهورية مصر العربية', 'code' => 'EG'],
            ['name' => 'الإمارات العربية المتحدة', 'code' => 'AE'],
            ['name' => 'دولة الكويت', 'code' => 'KW'],
            ['name' => 'دولة قطر', 'code' => 'QA'],
            ['name' => 'مملكة البحرين', 'code' => 'BH'],
            ['name' => 'سلطنة عُمان', 'code' => 'OM'],
            ['name' => 'الجمهورية العربية السورية', 'code' => 'SY'],
            ['name' => 'المملكة الأردنية الهاشمية', 'code' => 'JO'],
            ['name' => 'الجمهورية اللبنانية', 'code' => 'LB'],
            ['name' => 'فلسطين', 'code' => 'PS'],
            ['name' => 'جمهورية العراق', 'code' => 'IQ'],
            ['name' => 'الجمهورية اليمنية', 'code' => 'YE'],
            ['name' => 'جمهورية السودان', 'code' => 'SD'],
            ['name' => 'دولة ليبيا', 'code' => 'LY'],
            ['name' => 'الجمهورية التونسية', 'code' => 'TN'],
            ['name' => 'الجمهورية الجزائرية الديمقراطية الشعبية', 'code' => 'DZ'],
            ['name' => 'المملكة المغربية', 'code' => 'MA'],
            ['name' => 'الجمهورية الإسلامية الموريتانية', 'code' => 'MR'],
            ['name' => 'جمهورية الصومال الفيدرالية', 'code' => 'SO'],
            ['name' => 'جمهورية جيبوتي', 'code' => 'DJ'],
            ['name' => 'جمهورية القمر المتحدة', 'code' => 'KM'],
        ];

        // إضافة الدول إلى قاعدة البيانات
        foreach ($countries as $country) {
            Country::updateOrCreate(['iso_code' => $country['code']], ['name' => $country['name']]);
        }


        // ------------------ إنشاء الصلاحيات ------------------

        // إعادة تعيين الكاش الخاص بالصلاحيات
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // قائمة الصلاحيات الخاصة بالدول
        $permissions = [
            'view-country',
            'create-country',
            'edit-country',
            'delete-country',
            'show-country',
        ];

        // إنشاء الصلاحيات
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }


        // إعطاء الصلاحيات لدور الـ Super Admin
        // تأكد من أن لديك دور بهذا الاسم أو قم بتغييره للاسم الصحيح
        $superAdminRole = Role::where('name', 'super-admin')->first();

        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }
    }
}
