<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the permissions that belong to the role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if the role has a specific permission.
     */
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }

    /**
     * Give permissions to the role.
     */
    public function givePermissionsTo(array $permissions): self
    {
        $permissions = Permission::whereIn('slug', $permissions)->get();
        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    /**
     * Revoke permissions from the role.
     */
    public function revokePermissionsTo(array $permissions): self
    {
        $permissions = Permission::whereIn('slug', $permissions)->get();
        $this->permissions()->detach($permissions);

        return $this;
    }
}
