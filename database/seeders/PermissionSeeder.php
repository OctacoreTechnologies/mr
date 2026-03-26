<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions based on menu items
        $permissions = [
            // Dashboard
            ['name' => 'view dashboard', 'guard_name' => 'web'],

            // Today/Reminders
            ['name' => 'view reminders', 'guard_name' => 'web'],

            // Lead
            ['name' => 'view leads', 'guard_name' => 'web'],
            ['name' => 'create lead', 'guard_name' => 'web'],
            ['name' => 'edit lead', 'guard_name' => 'web'],
            ['name' => 'delete lead', 'guard_name' => 'web'],

            // Opportunities
            ['name' => 'view opportunities', 'guard_name' => 'web'],
            ['name' => 'create opportunity', 'guard_name' => 'web'],
            ['name' => 'edit opportunity', 'guard_name' => 'web'],
            ['name' => 'delete opportunity', 'guard_name' => 'web'],

            // Quotation
            ['name' => 'view quotations', 'guard_name' => 'web'],
            ['name' => 'create quotation', 'guard_name' => 'web'],
            ['name' => 'edit quotation', 'guard_name' => 'web'],
            ['name' => 'delete quotation', 'guard_name' => 'web'],

            // Total Orders (Sales Order)
            ['name' => 'view sale orders', 'guard_name' => 'web'],
            ['name' => 'create sale order', 'guard_name' => 'web'],
            ['name' => 'edit sale order', 'guard_name' => 'web'],
            ['name' => 'delete sale order', 'guard_name' => 'web'],

            // Advance Payment
            ['name' => 'view advance payments', 'guard_name' => 'web'],
            ['name' => 'create advance payment', 'guard_name' => 'web'],
            ['name' => 'edit advance payment', 'guard_name' => 'web'],
            ['name' => 'delete advance payment', 'guard_name' => 'web'],

            // Order Acceptance Letter (OAL)
            ['name' => 'view oal', 'guard_name' => 'web'],
            ['name' => 'create oal', 'guard_name' => 'web'],
            ['name' => 'edit oal', 'guard_name' => 'web'],
            ['name' => 'delete oal', 'guard_name' => 'web'],

            // Application
            ['name' => 'view applications', 'guard_name' => 'web'],
            ['name' => 'create application', 'guard_name' => 'web'],
            ['name' => 'edit application', 'guard_name' => 'web'],
            ['name' => 'delete application', 'guard_name' => 'web'],

            // Customer
            ['name' => 'view customers', 'guard_name' => 'web'],
            ['name' => 'create customer', 'guard_name' => 'web'],
            ['name' => 'edit customer', 'guard_name' => 'web'],
            ['name' => 'delete customer', 'guard_name' => 'web'],

            // Categories
            ['name' => 'view categories', 'guard_name' => 'web'],
            ['name' => 'create category', 'guard_name' => 'web'],
            ['name' => 'edit category', 'guard_name' => 'web'],
            ['name' => 'delete category', 'guard_name' => 'web'],

            // Reports
            ['name' => 'view reports', 'guard_name' => 'web'],
            ['name' => 'view lead reports', 'guard_name' => 'web'],
            ['name' => 'view customer reports', 'guard_name' => 'web'],
            ['name' => 'view quotation reports', 'guard_name' => 'web'],
            ['name' => 'view sale reports', 'guard_name' => 'web'],

            // Terms & Email
            ['name' => 'view terms conditions', 'guard_name' => 'web'],
            ['name' => 'edit terms conditions', 'guard_name' => 'web'],

            ['name' => 'view bank details', 'guard_name' => 'web'],
            ['name' => 'create bank detail', 'guard_name' => 'web'],
            ['name' => 'edit bank detail', 'guard_name' => 'web'],
            ['name' => 'delete bank detail', 'guard_name' => 'web'],

            ['name' => 'view mails', 'guard_name' => 'web'],
            ['name' => 'create mail', 'guard_name' => 'web'],
            ['name' => 'edit mail', 'guard_name' => 'web'],
            ['name' => 'delete mail', 'guard_name' => 'web'],

            ['name' => 'send emails', 'guard_name' => 'web'],

            ['name' => 'view email templates', 'guard_name' => 'web'],
            ['name' => 'create email template', 'guard_name' => 'web'],
            ['name' => 'edit email template', 'guard_name' => 'web'],
            ['name' => 'delete email template', 'guard_name' => 'web'],

            // Roles & Permission
            ['name' => 'view roles', 'guard_name' => 'web'],
            ['name' => 'create role', 'guard_name' => 'web'],
            ['name' => 'edit role', 'guard_name' => 'web'],
            ['name' => 'delete role', 'guard_name' => 'web'],

            ['name' => 'view permissions', 'guard_name' => 'web'],
            ['name' => 'create permission', 'guard_name' => 'web'],
            ['name' => 'edit permission', 'guard_name' => 'web'],
            ['name' => 'delete permission', 'guard_name' => 'web'],

            ['name' => 'view users', 'guard_name' => 'web'],
            ['name' => 'create user', 'guard_name' => 'web'],
            ['name' => 'edit user', 'guard_name' => 'web'],
            ['name' => 'delete user', 'guard_name' => 'web'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']],
                $permission
            );
        }

        // Create roles
        $adminRole = Role::updateOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $userRole = Role::updateOrCreate(['name' => 'User', 'guard_name' => 'web']);
        $viewerRole = Role::updateOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);

        // Get all permissions
        $allPermissions = Permission::all();

        // Assign all permissions to Admin role
        $adminRole->syncPermissions($allPermissions);

        // Assign limited permissions to User role (can view, create, edit but not delete)
        $userPermissions = $allPermissions->filter(function ($permission) {
            return !str_contains($permission->name, 'delete') &&
                !str_contains($permission->name, 'permission') &&
                !str_contains($permission->name, 'role') &&
                !str_contains($permission->name, 'user');
        });
        $userRole->syncPermissions($userPermissions);

        // Assign view-only permissions to Viewer role
        $viewerPermissions = $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'view') &&
                !str_contains($permission->name, 'permission') &&
                !str_contains($permission->name, 'role') &&
                !str_contains($permission->name, 'user');
        });
        $viewerRole->syncPermissions($viewerPermissions);
    }
}
