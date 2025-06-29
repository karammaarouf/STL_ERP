<?php

namespace Database\Seeders;

use App\Models\WarehouseRack;
use App\Models\WarehouseSection;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WarehouseRackSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view-warehouse-rack',
            'create-warehouse-rack',
            'edit-warehouse-rack',
            'delete-warehouse-rack',
            'show-warehouse-rack'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // Create sample warehouse racks
        $sections = WarehouseSection::all();
        
        if ($sections->count() > 0) {
            foreach ($sections->take(3) as $index => $section) {
                WarehouseRack::create([
                    'code' => 'RACK-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'section_id' => $section->id,
                ]);
            }
        }
    }
}