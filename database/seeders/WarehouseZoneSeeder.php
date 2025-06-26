<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\WarehouseZone;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class WarehouseZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------ إنشاء الصلاحيات ------------------
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-warehouse-zone',
            'create-warehouse-zone',
            'edit-warehouse-zone',
            'delete-warehouse-zone',
            'show-warehouse-zone',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // ------------------ إضافة مناطق المستودعات ------------------

        $riyadhWarehouse = Warehouse::where('code', 'RUH-MAIN-01')->first();
        $cairoWarehouse = Warehouse::where('code', 'CAI-EAST-01')->first();

        $zonesData = [];

        if ($riyadhWarehouse) {
            // -- تمت إضافة حقل "code" هنا --
            $zonesData[] = ['name' => 'منطقة البضائع الجافة', 'code' => 'RUH-DRY', 'warehouse_id' => $riyadhWarehouse->id];
            $zonesData[] = ['name' => 'منطقة التبريد', 'code' => 'RUH-COLD', 'warehouse_id' => $riyadhWarehouse->id];
            $zonesData[] = ['name' => 'منطقة المواد الخطرة', 'code' => 'RUH-HAZ', 'warehouse_id' => $riyadhWarehouse->id];
        }

        if ($cairoWarehouse) {
            // -- تمت إضافة حقل "code" هنا --
            $zonesData[] = ['name' => 'منطقة الاستلام', 'code' => 'CAI-REC', 'warehouse_id' => $cairoWarehouse->id];
            $zonesData[] = ['name' => 'منطقة التخزين المؤقت', 'code' => 'CAI-BUF', 'warehouse_id' => $cairoWarehouse->id];
        }

        foreach ($zonesData as $zone) {
            WarehouseZone::firstOrCreate(['code' => $zone['code']], $zone);
        }
    }
}
