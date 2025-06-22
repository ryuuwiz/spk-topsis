<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the permissions that are directly assigned to the user.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole(array $rolesSlugs): bool
    {
        return $this->roles()->whereIn('slug', $rolesSlugs)->exists();
    }

    /**
     * Check if the user has all of the given roles.
     */
    public function hasAllRoles(array $rolesSlugs): bool
    {
        return $this->roles()->whereIn('slug', $rolesSlugs)->count() === count($rolesSlugs);
    }

    /**
     * Assign roles to the user.
     */
    public function assignRoles(array $roles): self
    {
        $roles = Role::whereIn('slug', $roles)->get();
        $this->roles()->syncWithoutDetaching($roles);

        return $this;
    }

    /**
     * Remove roles from the user.
     */
    public function removeRoles(array $roles): self
    {
        $roles = Role::whereIn('slug', $roles)->get();
        $this->roles()->detach($roles);

        return $this;
    }

    /**
     * Check if the user has a specific permission directly or through a role.
     */
    public function hasPermission(string $permissionSlug): bool
    {
        // Check direct permissions
        if ($this->permissions()->where('slug', $permissionSlug)->exists()) {
            return true;
        }

        // Check permissions through roles
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permissionSlug)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has any of the given permissions.
     */
    public function hasAnyPermission(array $permissionSlugs): bool
    {
        // Check direct permissions
        if ($this->permissions()->whereIn('slug', $permissionSlugs)->exists()) {
            return true;
        }

        // Check permissions through roles
        foreach ($this->roles as $role) {
            foreach ($permissionSlugs as $permissionSlug) {
                if ($role->hasPermission($permissionSlug)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Give direct permissions to the user.
     */
    public function givePermissionsTo(array $permissions): self
    {
        $permissions = Permission::whereIn('slug', $permissions)->get();
        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    /**
     * Revoke direct permissions from the user.
     */
    public function revokePermissionsTo(array $permissions): self
    {
        $permissions = Permission::whereIn('slug', $permissions)->get();
        $this->permissions()->detach($permissions);

        return $this;
    }
}
