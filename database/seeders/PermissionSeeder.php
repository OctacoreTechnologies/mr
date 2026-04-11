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

            // Admin
            'admin_access',

            // Dashboard & Reminder
            'dashboard_view',
            'reminder_view',

            // Lead
            'lead_view',
            'lead_create',
            'lead_edit',
            'lead_delete',
            'lead_show',

            // Opportunity
            'opportunity_view',
            'opportunity_create',
            'opportunity_edit',
            'opportunity_delete',
            'opportunity_show',

            // Quotation
            'quotation_view',
            'quotation_create',
            'quotation_edit',
            'quotation_delete',
            'quotation_pdf',
            'quotation_verify',
            'quotation_status_update',
            'quotation_reorder',
            'quotation_history',

            // Sale Order
            'sale_order_view',
            'sale_order_show',
            'sale_order_create',
            'sale_order_edit',
            'sale_order_delete',

            // Advance Payment
            'advance_payment_view',
            'advance_payment_show',
            'advance_payment_pdf',
            'advance_payment_create',
            'advance_payment_edit',
            'advance_payment_delete',

            // OAL
            'oal_view',
            'oal_show',
            'oal_pdf',
            'oal_create',
            'oal_edit',
            'oal_delete',

            // customer account details
            'customer_account_view',
            'customer_account_pdf',

            // Application
            'application_view',
            'application_create',
            'application_edit',
            'application_delete',

            // Customer
            'customer_view',
            'customer_create',
            'customer_edit',
            'customer_delete',
            'customer_show',

            // Followups
            'followup_customer',
            'followup_track',

            // Category
            'category_view',
            'category_create',
            'category_edit',
            'category_delete',
            'category_manage',

            // Reports
            'report_view',
            'report_lead_view',
            'report_customer_view',
            'report_quotation_view',
            'report_sale_view',

            // Terms
            'terms_view',
            'terms_edit',

            // Bank
            'bank_view',
            'bank_create',
            'bank_edit',
            'bank_delete',

            // Mail
            'mail_view',
            'mail_create',
            'mail_edit',
            'mail_delete',
            'mail_send',

            // Email Template
            'email_template_view',
            'email_template_show',
            'email_template_create',
            'email_template_edit',
            'email_template_delete',

            // Roles
            'role_view',
            'role_create',
            'role_edit',
            'role_delete',

            // Permissions
            'permission_view',
            'permission_create',
            'permission_edit',
            'permission_delete',

            // Users
            'user_view',
            'user_create',
            'user_edit',
            'user_delete',
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
            return !str_contains($permission->name, '_delete') &&
                   !str_contains($permission->name, 'role_') &&
                   !str_contains($permission->name, 'permission_') &&
                   !str_contains($permission->name, 'user_');
        });
        $user->syncPermissions($userPermissions);

        // Viewer → only view
        $viewerPermissions = $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, '_view');
        });
        $viewer->syncPermissions($viewerPermissions);
    }
}