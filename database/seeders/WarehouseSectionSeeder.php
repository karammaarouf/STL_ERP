<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseZone;
use App\Models\WarehouseSection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class WarehouseSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------ إنشاء الصلاحيات ------------------
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-warehouse-section',
            'create-warehouse-section',
            'edit-warehouse-section',
            'delete-warehouse-section',
            'show-warehouse-section',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // ------------------ إضافة أقسام المستودعات ------------------

        $dryZone = WarehouseZone::where('code', 'RUH-DRY')->first();
        $coldZone = WarehouseZone::where('code', 'RUH-COLD')->first();
        $hazZone = WarehouseZone::where('code', 'RUH-HAZ')->first();

        $sectionsData = [];

        if ($dryZone) {
            $sectionsData[] = ['name' => 'قسم الأغذية المعلبة', 'code' => 'DRY-CANNED', 'zone_id' => $dryZone->id];
            $sectionsData[] = ['name' => 'قسم الحبوب والبقوليات', 'code' => 'DRY-GRAINS', 'zone_id' => $dryZone->id];
            $sectionsData[] = ['name' => 'قسم المنظفات', 'code' => 'DRY-CLEAN', 'zone_id' => $dryZone->id];
        }

        if ($coldZone) {
            $sectionsData[] = ['name' => 'قسم اللحوم المجمدة', 'code' => 'COLD-MEAT', 'zone_id' => $coldZone->id];
            $sectionsData[] = ['name' => 'قسم الخضروات المجمدة', 'code' => 'COLD-VEG', 'zone_id' => $coldZone->id];
            $sectionsData[] = ['name' => 'قسم الألبان', 'code' => 'COLD-DAIRY', 'zone_id' => $coldZone->id];
        }

        if ($hazZone) {
            $sectionsData[] = ['name' => 'قسم المواد الكيميائية', 'code' => 'HAZ-CHEM', 'zone_id' => $hazZone->id];
            $sectionsData[] = ['name' => 'قسم المواد القابلة للاشتعال', 'code' => 'HAZ-FLAM', 'zone_id' => $hazZone->id];
        }

        foreach ($sectionsData as $sectionData) {
            WarehouseSection::firstOrCreate(
                ['code' => $sectionData['code']],
                $sectionData
            );
        }
    }
}