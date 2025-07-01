<?php

namespace Database\Seeders;

use App\Models\Pallet;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PalletSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view-pallet',
            'create-pallet',
            'edit-pallet',
            'delete-pallet',
            'show-pallet'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // إعطاء الصلاحيات لدور super-admin
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // Create sample pallets
        $warehouses = Warehouse::all();
        
        if ($warehouses->count() > 0) {
            foreach ($warehouses as $warehouse) {
                for ($i = 1; $i <= 5; $i++) {
                    Pallet::create([
                        'barcode' => 'PLT-' . $warehouse->id . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                        'warehouse_id' => $warehouse->id,
                        'status' => collect(['empty', 'loaded', 'reserved'])->random(),
                        'current_weight' => rand(0, 1000) / 100,
                        'current_volume' => rand(0, 1000) / 100,
                    ]);
                }
            }
        }
    }
}