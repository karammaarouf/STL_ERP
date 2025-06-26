<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\City;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------ إنشاء الصلاحيات ------------------

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-warehouse',
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
            'show-warehouse',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // ------------------ إضافة المستودعات بناءً على المدن الموجودة ------------------

        // نحدد أسماء المدن التي نريد إنشاء مستودعات فيها
        $targetCityNames = ['الزبداني', 'مدينة نصر', 'الدرعية', 'جدة', 'عفرين'];

        // نحصل على هذه المدن من قاعدة البيانات
        $cities = City::whereIn('name', $targetCityNames)->get()->keyBy('name');

        $warehousesData = [];

        // نقوم بتعريف بيانات المستودعات لكل مدينة تم العثور عليها
        if (isset($cities['الدرعية'])) {
            $warehousesData[] = [
                'name' => 'مستودع الرياض الرئيسي',
                'code' => 'RUH-MAIN-01',
                'city_id' => $cities['الدرعية']->id,
                'type' => 'main',
                'total_capacity_weight' => 75000.00,
                'total_capacity_volume' => 15000.00,
            ];
        }

        if (isset($cities['جدة'])) {
            $warehousesData[] = [
                'name' => 'مستودع جدة اللوجستي',
                'code' => 'JED-LOG-01',
                'city_id' => $cities['جدة']->id,
                'type' => 'branch',
                'total_capacity_weight' => 40000.00,
                'total_capacity_volume' => 8000.00,
            ];
        }

        if (isset($cities['مدينة نصر'])) {
            $warehousesData[] = [
                'name' => 'مستودع شرق القاهرة',
                'code' => 'CAI-EAST-01',
                'city_id' => $cities['مدينة نصر']->id,
                'type' => 'branch',
                'total_capacity_weight' => 30000.00,
                'total_capacity_volume' => 6500.00,
            ];
        }

        if (isset($cities['الزبداني'])) {
            $warehousesData[] = [
                'name' => 'مستودع دمشق المركزي',
                'code' => 'DAM-CEN-01',
                'city_id' => $cities['الزبداني']->id,
                'type' => 'main',
                'total_capacity_weight' => 100000.00,
                'total_capacity_volume' => 20000.00,
            ];
        }

        // إضافة المستودعات إلى قاعدة البيانات
        foreach ($warehousesData as $warehouse) {
            Warehouse::updateOrCreate(['code' => $warehouse['code']], $warehouse);
        }
    }
}
