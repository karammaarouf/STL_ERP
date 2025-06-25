<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\City;
use App\Models\State;
use Spatie\Permission\PermissionRegistrar;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------ إنشاء الصلاحيات ------------------

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-city',
            'create-city',
            'edit-city',
            'delete-city',
            'show-city',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // ------------------ المدن ------------------

        $citiesByState = [
            'دمشق' => ['الزبداني', 'دوما', 'قطنا'],
            'حلب' => ['عفرين', 'الباب', 'منبج'],
            'القاهرة' => ['مدينة نصر', 'مصر الجديدة', 'حلوان'],
            'الإسكندرية' => ['برج العرب', 'سيدي جابر', 'العجمي'],
            'الرياض' => ['الدرعية', 'الخرج', 'المجمعة'],
            'مكة المكرمة' => ['جدة', 'الطائف', 'القنفذة'],
            'بغداد' => ['الكرخ', 'الرصافة', 'مدينة الصدر'],
            'البصرة' => ['الزبير', 'الفاو', 'شط العرب'],
            'عمّان' => ['وادي السير', 'تلاع العلي', 'الجبيهة'],
        ];

        foreach ($citiesByState as $stateName => $cities) {
            $state = State::where('name', $stateName)->first();
            if ($state) {
                foreach ($cities as $cityName) {
                    City::firstOrCreate([
                        'name' => $cityName,
                        'state_id' => $state->id,
                    ]);
                }
            }
        }
    }
}
