<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPermissions, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_no',
        'last_login_at',
        'is_active',
        'phone',
        'department',
        'designation',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Guard name for permission checking
     *
     * @var string
     */
    protected $guard_name = 'web';

    // ========== RELATIONSHIPS ==========

    /**
     * Get all quotations created by this user
     */
    public function quotations()
    {
        return $this->hasMany(\App\Models\Quotation::class, 'user_id');
    }

    /**
     * Get all customers created by this user
     */
    public function customers()
    {
        return $this->hasMany(\App\Models\Customer::class, 'user_id');
    }

    /**
     * Get all leads created by this user
     */
    public function leads()
    {
        return $this->hasMany(\App\Models\Lead::class, 'user_id');
    }

    public function opportuniy()
    {
        return $this->hasMany(\App\Models\Opportunity::class, 'user_id');
    }

    /**
     * Get all leads followed by this user
     */
    public function leadFollows()
    {
        return $this->hasMany(\App\Models\Customer::class, 'followed_by')
            ->where('source', 'lead');
    }

    /**
     * Get all opportunities followed by this user
     */
    public function opportunityFollows()
    {
        return $this->hasMany(\App\Models\Opportunity::class, 'followed_by');
    }


    /**
     * Get all sale orders followed by this user
     */
    public function saleOrderFollows()
    {
        return $this->hasMany(\App\Models\SaleOrder::class, 'followed_by');
    }

    /**
     * Get all customers followed by this user
     */
    public function customerFollows()
    {
        return $this->hasMany(\App\Models\Customer::class, 'followed_by')
            ->where('source', 'customer');
    }

    /**
     * Get all quotations followed by this user
     */
    public function quotationFollows()
    {
        return $this->hasMany(\App\Models\Quotation::class, 'followed_by');
    }

    /**
     * Get all lead follow-ups created by this user
     */
    public function leadFollowUps()
    {
        return $this->hasMany(\App\Models\LeadFollowUp::class, 'user_id');
    }

    /**
     * Get all customer follow-ups created by this user
     */
    public function customerFollowUps()
    {
        return $this->hasMany(\App\Models\CustomerFollowUp::class, 'user_id');
    }

    /**
     * Get all quotation follow-ups created by this user
     */
    public function quotationFollowUps()
    {
        return $this->hasMany(CustomerFollowUp::class, 'user_id');
    }

    /**
     * Get all sale orders created by this user
     */
    public function saleOrders()
    {
        return $this->hasMany(\App\Models\SaleOrder::class, 'user_id');
    }

    /**
     * Get all reminders created for this user
     */
    public function reminders()
    {
        return $this->hasMany(\App\Models\Reminder::class, 'user_id');
    }

    /**
     * Get all notifications for this user
     */
    // public function notifications()
    // {
    //     return $this->hasMany(\App\Models\Notification::class, 'user_id');
    // }

    // ========== ACTIVITY LOGGING ==========

    /**
     * Configure activity logging
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'contact_no', 'is_active'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}");
    }

    // ========== STATUS METHODS ==========

    /**
     * Check if user is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active ?? true;
    }

    /**
     * Check if user is inactive
     *
     * @return bool
     */
    public function isInactive(): bool
    {
        return !$this->isActive();
    }

    /**
     * Activate user
     *
     * @return bool
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Deactivate user
     *
     * @return bool
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Update last login timestamp
     *
     * @return bool
     */
    public function updateLastLogin(): bool
    {
        return $this->update(['last_login_at' => now()]);
    }

    /**
     * Get user's last login date in human readable format
     *
     * @return string|null
     */
    public function getLastLoginFormatted(): ?string
    {
        return $this->last_login_at?->diffForHumans();
    }

    // ========== PERMISSION HELPER METHODS ==========

    /**
     * Check if user has multiple permissions (all)
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->can($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if user has any of the given permissions
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->can($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has multiple roles (all)
     *
     * @param array $roles
     * @return bool
     */
    public function hasAllRoles(array $roles): bool
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if user has any of the given roles
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return true;
    }

    /**
     * Get all permissions (including from roles)
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllPermissionsAttribute()
    {
        return $this->getAllPermissions();
    }

    /**
     * Get user's role names
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRoles()
    {
        return $this->getRoleNames();
    }

    /**
     * Get primary role (first assigned role)
     *
     * @return string|null
     */
    public function getPrimaryRole(): ?string
    {
        return $this->getRoleNames()->first();
    }

    /**
     * Get all roles with their permissions
     *
     * @return array
     */
    public function getRolesWithPermissions(): array
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->map(function ($role) {
                return [
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('name'),
                ];
            })
            ->toArray();
    }

    // ========== STATISTICS METHODS ==========

    /**
     * Get count of quotations created by this user
     *
     * @return int
     */
    public function quotationsCount(): int
    {
        return $this->quotations()->count();
    }

    /**
     * Get count of leads created by this user
     *
     * @return int
     */
    public function leadsCount(): int
    {
        return $this->leads()->count();
    }

    /**
     * Get count of customers created by this user
     *
     * @return int
     */
    public function customersCount(): int
    {
        return $this->customers()->count();
    }

    /**
     * Get count of sale orders created by this user
     *
     * @return int
     */
    public function saleOrdersCount(): int
    {
        return $this->saleOrders()->count();
    }

    /**
     * Get total followed items count
     *
     * @return int
     */
    public function followedItemsCount(): int
    {
        return $this->leadFollows()->count() +
            $this->customerFollows()->count() +
            $this->quotationFollows()->count() +
            $this->saleOrderFollows()->count();
    }

    /**
     * Get user statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'quotations' => $this->quotationsCount(),
            'leads' => $this->leadsCount(),
            'customers' => $this->customersCount(),
            'sale_orders' => $this->saleOrdersCount(),
            'followed_items' => $this->followedItemsCount(),
            'active' => $this->isActive(),
            'last_login' => $this->last_login_at?->toDateTimeString(),
        ];
    }

    // ========== QUERY SCOPES ==========

    /**
     * Scope: Filter active users
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter inactive users
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope: Filter by role
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $roleName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRole($query, $roleName)
    {
        return $query->whereHas('roles', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    /**
     * Scope: Filter by permission
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $permissionName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPermission($query, $permissionName)
    {
        return $query->whereHas('permissions', function ($q) use ($permissionName) {
            $q->where('name', $permissionName);
        })->orWhereHas('roles', function ($q) use ($permissionName) {
            $q->whereHas('permissions', function ($p) use ($permissionName) {
                $p->where('name', $permissionName);
            });
        });
    }

    /**
     * Scope: Filter by search term
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('contact_no', 'like', "%{$search}%");
    }

    /**
     * Scope: Get recently created users
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentlyCreated($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope: Get recently active users
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentlyActive($query, $days = 7)
    {
        return $query->where('last_login_at', '>=', now()->subDays($days));
    }

    /**
     * Scope: Order by latest
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Order by oldest
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    // ========== UTILITY METHODS ==========

    /**
     * Get user's full information for API responses
     *
     * @return array
     */
    public function toFullArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contact_no' => $this->contact_no,
            'department' => $this->department ?? 'N/A',
            'designation' => $this->designation ?? 'N/A',
            'is_active' => $this->is_active,
            'profile_picture' => $this->profile_picture,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'last_login' => $this->last_login_at?->toDateTimeString(),
            'statistics' => $this->getStatistics(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }

    /**
     * Get user's avatar URL or default
     *
     * @return string
     */
    public function getAvatarUrl(): string
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        // Default avatar from service
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }

    /**
     * Get user's initials for avatar
     *
     * @return string
     */
    public function getInitials(): string
    {
        $names = explode(' ', trim($this->name));
        $initials = '';

        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }

        return substr($initials, 0, 2);
    }

    /**
     * Check if user needs password reset
     *
     * @return bool
     */
    public function needsPasswordReset(): bool
    {
        // Reset password if last login is more than 90 days ago or never logged in
        if (!$this->last_login_at) {
            return true;
        }

        return $this->last_login_at->diffInDays(now()) > 90;
    }

    /**
     * Get user's display name with role
     *
     * @return string
     */
    public function getDisplayNameWithRole(): string
    {
        $role = $this->getPrimaryRole();
        $roleDisplay = $role ? ucfirst(str_replace('_', ' ', $role)) : 'No Role';

        return "{$this->name} ({$roleDisplay})";
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is manager
     *
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    /**
     * Check if user is sales executive
     *
     * @return bool
     */
    public function isSalesExecutive(): bool
    {
        return $this->hasRole('sales_executive');
    }

    /**
     * Check if user is viewer
     *
     * @return bool
     */
    public function isViewer(): bool
    {
        return $this->hasRole('viewer');
    }
}
