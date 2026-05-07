<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions
        $permissions = [
            // Dashboard
            'view dashboard',

            // Products
            'view products', 'create products', 'edit products', 'delete products',

            // Categories
            'view categories', 'create categories', 'edit categories', 'delete categories',

            // Suppliers
            'view suppliers', 'create suppliers', 'edit suppliers', 'delete suppliers',

            // Units
            'view units', 'create units', 'edit units', 'delete units',

            // Purchase Orders
            'view purchases', 'create purchases', 'receive purchases',

            // POS
            'access pos', 'view sales history',

            // Reports
            'view reports',

            // Users
            'view users', 'create users', 'edit users', 'delete users',

            // Stock
            'view stock', 'adjust stock',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Roles
        $admin  = Role::firstOrCreate(['name' => 'admin']);
        $kasir  = Role::firstOrCreate(['name' => 'kasir']);
        $gudang = Role::firstOrCreate(['name' => 'gudang']);

        // Admin — semua permission
        $admin->givePermissionTo(Permission::all());

        // Kasir — hanya POS dan laporan
        $kasir->givePermissionTo([
            'view dashboard',
            'access pos',
            'view sales history',
            'view products',
            'view reports',
        ]);

        // Gudang — inventory saja
        $gudang->givePermissionTo([
            'view dashboard',
            'view products', 'create products', 'edit products',
            'view categories',
            'view suppliers',
            'view units',
            'view purchases', 'create purchases', 'receive purchases',
            'view stock', 'adjust stock',
            'view reports',
        ]);

        // Buat Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@pos.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole('admin');

        // Buat Kasir User
        $kasirUser = User::firstOrCreate(
            ['email' => 'kasir@pos.com'],
            [
                'name'     => 'Kasir',
                'password' => Hash::make('password'),
            ]
        );
        $kasirUser->assignRole('kasir');

        // Buat Gudang User
        $gudangUser = User::firstOrCreate(
            ['email' => 'gudang@pos.com'],
            [
                'name'     => 'Staff Gudang',
                'password' => Hash::make('password'),
            ]
        );
        $gudangUser->assignRole('gudang');
    }
}