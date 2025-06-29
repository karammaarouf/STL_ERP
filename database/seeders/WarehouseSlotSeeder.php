<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\WarehouseSlot;
use App\Models\WarehouseRack;

class WarehouseSlotSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view-warehouse-slot',
            'create-warehouse-slot',
            'edit-warehouse-slot',
            'delete-warehouse-slot',
            'show-warehouse-slot',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // Create sample warehouse slots
        $racks = WarehouseRack::all();
        
        if ($racks->count() > 0) {
            $slotData = [
                ['code' => 'SL-001', 'max_weight' => 100.00, 'max_volume' => 5.00],
                ['code' => 'SL-002', 'max_weight' => 150.00, 'max_volume' => 7.50],
                ['code' => 'SL-003', 'max_weight' => 200.00, 'max_volume' => 10.00],
                ['code' => 'SL-004', 'max_weight' => 120.00, 'max_volume' => 6.00],
                ['code' => 'SL-005', 'max_weight' => 180.00, 'max_volume' => 9.00],
            ];

            foreach ($slotData as $index => $data) {
                $rack = $racks->get($index % $racks->count());
                WarehouseSlot::create([
                    'code' => $data['code'],
                    'rack_id' => $rack->id,
                    'max_weight' => $data['max_weight'],
                    'max_volume' => $data['max_volume'],
                    'current_weight' => 0.00,
                    'current_volume' => 0.00,
                ]);
            }
        }
    }
}