<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\State;
use App\Models\Country;
use Spatie\Permission\PermissionRegistrar;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------ إنشاء الصلاحيات ------------------

        // إعادة تعيين الكاش الخاص بالصلاحيات
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // قائمة صلاحيات إدارة المحافظات
        $permissions = [
            'view-state',
            'create-state',
            'edit-state',
            'delete-state',
            'show-state',
        ];

        // إنشاء الصلاحيات
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // إعطاء الصلاحيات لدور super-admin
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // ------------------ المحافظات ------------------

        $statesByCountryCode = [
            'SY' => ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'درعا'],
            'EG' => ['القاهرة', 'الإسكندرية', 'الجيزة', 'المنصورة', 'أسيوط'],
            'SA' => ['الرياض', 'مكة المكرمة', 'المدينة المنورة', 'الدمام', 'عسير'],
            'IQ' => ['بغداد', 'البصرة', 'أربيل', 'الموصل', 'النجف'],
            'DZ' => ['الجزائر العاصمة', 'وهران', 'قسنطينة', 'سطيف', 'باتنة'],
            'PS' => ['رام الله', 'نابلس', 'الخليل', 'غزة', 'جنين'],
            'JO' => ['عمّان', 'إربد', 'الزرقاء', 'العقبة', 'الكرك'],
            'TN' => ['تونس العاصمة', 'صفاقس', 'سوسة', 'بنزرت', 'قفصة'],
            'LB' => ['بيروت', 'طرابلس', 'صيدا', 'زحلة', 'بعلبك'],
            'YE' => ['صنعاء', 'عدن', 'تعز', 'الحديدة', 'حضرموت'],
            'MA' => ['الرباط', 'الدار البيضاء', 'مراكش', 'فاس', 'أكادير'],
            'LY' => ['طرابلس', 'بنغازي', 'مصراتة', 'سبها', 'سرت'],
        ];

        foreach ($statesByCountryCode as $countryCode => $states) {
            $country = Country::where('iso_code', $countryCode)->first();
            if ($country) {
                foreach ($states as $stateName) {
                    State::firstOrCreate([
                        'name' => $stateName,
                        'country_id' => $country->id,
                    ]);
                }
            } else {
                $this->command->warn("⚠️ لم يتم العثور على الدولة برمز: {$countryCode}");
            }
        }
    }
}
