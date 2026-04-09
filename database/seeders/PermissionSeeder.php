<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Basic Permissions (SQL me extra hai)
            'admin',
            'view',
            'edit',
            'delete',
            'create',
            'send mail',
            'index',

            // Dashboard & Reminder
            'view dashboard',
            'view reminders',

            // Lead
            'view leads',
            'create lead',
            'edit lead',
            'delete lead',
            'show lead',

            // Opportunity
            'view opportunities',
            'create opportunity',
            'edit opportunity',
            'delete opportunity',
            'show opportunity',

            // Quotation
            'view quotations',
            'create quotation',
            'edit quotation',
            'delete quotation',
            'pdf quotation',
            'verify quotation',
            'update quotation status',
            'reorder quotation',
            'history quotation',

            // Sale Order
            'view sale orders',
            'create sale order',
            'edit sale order',
            'delete sale order',

            // Advance Payment
            'view advance payments',
            'create advance payment',
            'edit advance payment',
            'delete advance payment',
            'view advance payment', // SQL me duplicate type naming

            // OAL
            'view oal',
            'create oal',
            'edit oal',
            'delete oal',

            // Application
            'view applications',
            'create application',
            'edit application',
            'delete application',

            // Customer
            'view customers',
            'create customer',
            'edit customer',
            'delete customer',
            'show customer',

            // Followups
            'customer followups',
            'customer-followup',
            'customer followup track',

            // Category
            'view categories',
            'create category',
            'edit category',
            'delete category',
            'categories management',

            // Reports
            'view reports',
            'view lead reports',
            'view customer reports',
            'view quotation reports',
            'view sale reports',

            // SQL me alag naming bhi hai
            'view lead report',
            'view customer report',
            'view quotation report',
            'view sale report',

            // Terms
            'view terms conditions',
            'edit terms conditions',

            // Bank
            'view bank details',
            'create bank detail',
            'edit bank detail',
            'delete bank detail',

            // Mail
            'view mails',
            'create mail',
            'edit mail',
            'delete mail',
            'send emails',

            // Email Template
            'view email templates',
            'create email template',
            'edit email template',
            'delete email template',

            // Roles
            'view roles',
            'create role',
            'edit role',
            'delete role',

            // Permissions
            'view permissions',
            'create permission',
            'edit permission',
            'delete permission',

            // Users
            'view users',
            'create user',
            'edit user',
            'delete user',
        ];

        // Insert Permissions
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Roles
        $admin = Role::updateOrCreate(['name' => 'Admin']);
        $user = Role::updateOrCreate(['name' => 'User']);
        $viewer = Role::updateOrCreate(['name' => 'Viewer']);

        $allPermissions = Permission::all();

        // Admin → all permissions
        $admin->syncPermissions($allPermissions);

        // User → no delete + no admin settings
        $userPermissions = $allPermissions->filter(function ($permission) {
            return !str_contains($permission->name, 'delete') &&
                   !str_contains($permission->name, 'role') &&
                   !str_contains($permission->name, 'permission') &&
                   !str_contains($permission->name, 'user');
        });
        $user->syncPermissions($userPermissions);

        // Viewer → only view
        $viewerPermissions = $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'view');
        });
        $viewer->syncPermissions($viewerPermissions);
    }
}