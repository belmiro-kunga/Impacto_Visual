<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Automatically hash the password when setting it.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        // Super admin has all permissions
        if ($this->role === 'super_admin') {
            return true;
        }

        // Check if the user has the specific permission
        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Check if the user has any of the given permissions.
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAnyPermission(array $permissions): bool
    {
        // Super admin has all permissions
        if ($this->role === 'super_admin') {
            return true;
        }

        // Check if the user has any of the permissions
        foreach ($permissions as $permission) {
            if (in_array($permission, $this->permissions ?? [])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get available roles for admin users.
     *
     * @return array
     */
    public static function getAvailableRoles(): array
    {
        return [
            'super_admin' => 'Super Administrador',
            'admin' => 'Administrador',
            'editor' => 'Editor',
            'viewer' => 'Visualizador',
        ];
    }

    /**
     * Get available permissions for admin users.
     *
     * @return array
     */
    public static function getAvailablePermissions(): array
    {
        return [
            'manage_users' => 'Gerenciar Usuários',
            'manage_content' => 'Gerenciar Conteúdo',
            'manage_services' => 'Gerenciar Serviços',
            'manage_portfolio' => 'Gerenciar Portfólio',
            'manage_testimonials' => 'Gerenciar Depoimentos',
            'manage_clients' => 'Gerenciar Clientes',
            'manage_settings' => 'Gerenciar Configurações',
        ];
    }
}
