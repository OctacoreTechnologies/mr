<?php

namespace App\Helpers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Permission Helper Class
 * 
 * Provides utility methods for permission and role management
 */
class PermissionHelper
{
    /**
     * Get all permissions grouped by resource
     *
     * @return array
     */
    public static function getAllPermissionsGrouped(): array
    {
        return [
            'lead' => [
                'lead_view' => 'View Leads',
                'lead_create' => 'Create Lead',
                'lead_edit' => 'Edit Lead',
                'lead_delete' => 'Delete Lead',
            ],
            'opportunity' => [
                'opportunity_view' => 'View Opportunities',
                'opportunity_create' => 'Create Opportunity',
                'opportunity_edit' => 'Edit Opportunity',
                'opportunity_delete' => 'Delete Opportunity',
            ],
            'quotation' => [
                'quotation_view' => 'View Quotations',
                'quotation_create' => 'Create Quotation',
                'quotation_edit' => 'Edit Quotation',
                'quotation_delete' => 'Delete Quotation',
            ],
            'application' => [
                'application_view' => 'View Applications',
                'application_create' => 'Create Application',
                'application_edit' => 'Edit Application',
                'application_delete' => 'Delete Application',
            ],
            'customer' => [
                'customer_view' => 'View Customers',
                'customer_create' => 'Create Customer',
                'customer_edit' => 'Edit Customer',
                'customer_delete' => 'Delete Customer',
            ],
            'category' => [
                'category_view' => 'View Categories',
                'category_create' => 'Create Category',
                'category_edit' => 'Edit Category',
                'category_delete' => 'Delete Category',
            ],
            'sale_order' => [
                'sale_order_view' => 'View Sale Orders',
                'sale_order_create' => 'Create Sale Order',
                'sale_order_edit' => 'Edit Sale Order',
                'sale_order_delete' => 'Delete Sale Order',
            ],
            'email' => [
                'mail_view' => 'View Emails',
                'mail_send' => 'Send Emails',
            ],
            'email_template' => [
                'email_template_view' => 'View Email Templates',
                'email_template_create' => 'Create Email Template',
                'email_template_edit' => 'Edit Email Template',
                'email_template_delete' => 'Delete Email Template',
            ],
            'report' => [
                'report_view' => 'View Reports',
                'report_create' => 'Create Report',
                'report_export' => 'Export Report',
            ],
            'bank' => [
                'bank_view' => 'View Bank Details',
                'bank_edit' => 'Edit Bank Details',
            ],
            'term' => [
                'terms_view' => 'View Terms & Conditions',
                'terms_create' => 'Create Term',
                'terms_edit' => 'Edit Term',
                'terms_delete' => 'Delete Term',
            ],
            'reminder' => [
                'reminder_view' => 'View Reminders',
                'reminder_create' => 'Create Reminder',
                'reminder_delete' => 'Delete Reminder',
            ],
            'dashboard' => [
                'dashboard_view' => 'View Dashboard',
            ],
            'admin' => [
                'role_view' => 'View Roles',
                'role_create' => 'Create Role',
                'role_edit' => 'Edit Role',
                'role_delete' => 'Delete Role',
                'permission_view' => 'View Permissions',
                'permission_create' => 'Create Permission',
                'permission_edit' => 'Edit Permission',
                'permission_delete' => 'Delete Permission',
                'user_view' => 'View Users',
                'user_create' => 'Create User',
                'user_edit' => 'Edit User',
                'user_delete' => 'Delete User',
            ],
        ];
    }

    /**
     * Get all permissions as flat array
     *
     * @return array
     */
    public static function getAllPermissionsFlat(): array
    {
        $grouped = self::getAllPermissionsGrouped();
        $flat = [];

        foreach ($grouped as $group) {
            $flat = array_merge($flat, array_keys($group));
        }

        return $flat;
    }

    /**
     * Create all permissions if they don't exist
     *
     * @return void
     */
    public static function createAllPermissions(): void
    {
        $permissions = self::getAllPermissionsFlat();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }
    }

    /**
     * Create a role with specific permissions
     *
     * @param string $roleName
     * @param array $permissionNames
     * @return Role
     */
    public static function createRoleWithPermissions(
        string $roleName,
        array $permissionNames
    ): Role {
        $role = Role::firstOrCreate(
            ['name' => $roleName, 'guard_name' => 'web']
        );

        $permissions = Permission::whereIn('name', $permissionNames)->get();
        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * Check if current user has permission
     *
     * @param string $permission
     * @return bool
     */
    public static function hasPermission(string $permission): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->can($permission);
    }

    /**
     * Check if current user has any of the given permissions
     *
     * @param array $permissions
     * @return bool
     */
    public static function hasAnyPermission(array $permissions): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->canAny($permissions);
    }

    /**
     * Check if current user has all given permissions
     *
     * @param array $permissions
     * @return bool
     */
    public static function hasAllPermissions(array $permissions): bool
    {
        if (!Auth::check()) {
            return false;
        }

        foreach ($permissions as $permission) {
            if (!Auth::user()->can($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if current user has role
     *
     * @param string $role
     * @return bool
     */
    public static function hasRole(string $role): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->hasRole($role);
    }

    /**
     * Check if current user has any of the given roles
     *
     * @param array $roles
     * @return bool
     */
    public static function hasAnyRole(array $roles): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->hasAnyRole($roles);
    }

    /**
     * Check if current user has all given roles
     *
     * @param array $roles
     * @return bool
     */
    public static function hasAllRoles(array $roles): bool
    {
        if (!Auth::check()) {
            return false;
        }

        foreach ($roles as $role) {
            if (!Auth::user()->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get current user's roles
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUserRoles()
    {
        if (!Auth::check()) {
            return collect();
        }

        return Auth::user()->getRoleNames();
    }

    /**
     * Get current user's permissions
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUserPermissions()
    {
        if (!Auth::check()) {
            return collect();
        }

        return Auth::user()->getAllPermissions()->pluck('name');
    }

    /**
     * Get role by name with permissions
     *
     * @param string $roleName
     * @return Role|null
     */
    public static function getRoleWithPermissions(string $roleName): ?Role
    {
        return Role::with('permissions')
            ->where('name', $roleName)
            ->first();
    }

    /**
     * Sync permissions to a role
     *
     * @param string $roleName
     * @param array $permissionNames
     * @return Role|null
     */
    public static function syncRolePermissions(
        string $roleName,
        array $permissionNames
    ): ?Role {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return null;
        }

        $permissions = Permission::whereIn('name', $permissionNames)->get();
        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * Add permission to role
     *
     * @param string $roleName
     * @param string $permissionName
     * @return Role|null
     */
    public static function addPermissionToRole(
        string $roleName,
        string $permissionName
    ): ?Role {
        $role = Role::where('name', $roleName)->first();
        $permission = Permission::where('name', $permissionName)->first();

        if (!$role || !$permission) {
            return null;
        }

        $role->givePermissionTo($permission);

        return $role;
    }

    /**
     * Remove permission from role
     *
     * @param string $roleName
     * @param string $permissionName
     * @return Role|null
     */
    public static function removePermissionFromRole(
        string $roleName,
        string $permissionName
    ): ?Role {
        $role = Role::where('name', $roleName)->first();
        $permission = Permission::where('name', $permissionName)->first();

        if (!$role || !$permission) {
            return null;
        }

        $role->revokePermissionTo($permission);

        return $role;
    }

    /**
     * Log permission changes
     *
     * @param string $action
     * @param string $resource
     * @param string|null $details
     * @return void
     */
    public static function logPermissionChange(
        string $action,
        string $resource,
        ?string $details = null
    ): void {
        if (!Auth::check()) {
            return;
        }

        // Implement your logging logic here
        // Example: Create activity log entry
        $logMessage = sprintf(
            '[%s] %s performed %s on %s. Details: %s',
            now()->toDateTimeString(),
            Auth::user()->name,
            $action,
            $resource,
            $details ?? 'N/A'
        );

        // Log to file or database as needed
        Log::info('Permission Change: ' . $logMessage);
    }
}