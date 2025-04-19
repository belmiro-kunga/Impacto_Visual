<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Verificar se o usuu00e1rio atual tem permissu00e3o para gerenciar usuu00e1rios
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser->hasPermission('manage_users') && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.content.sections')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para gerenciar usuu00e1rios.');
        }
        
        $users = AdminUser::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Verificar se o usuu00e1rio atual tem permissu00e3o para gerenciar usuu00e1rios
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser->hasPermission('manage_users') && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.content.sections')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para gerenciar usuu00e1rios.');
        }
        
        $roles = AdminUser::getAvailableRoles();
        $permissions = AdminUser::getAvailablePermissions();
        
        return view('admin.users.form', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Verificar se o usuu00e1rio atual tem permissu00e3o para gerenciar usuu00e1rios
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser->hasPermission('manage_users') && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.content.sections')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para gerenciar usuu00e1rios.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(array_keys(AdminUser::getAvailableRoles()))],
            'permissions' => 'nullable|array',
            'is_active' => 'boolean',
        ]);
        
        // Filtrar permissu00f5es vu00e1lidas
        $availablePermissions = array_keys(AdminUser::getAvailablePermissions());
        $validated['permissions'] = array_intersect($validated['permissions'] ?? [], $availablePermissions);
        
        AdminUser::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuu00e1rio criado com sucesso!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(AdminUser $user)
    {
        // Verificar se o usuu00e1rio atual tem permissu00e3o para gerenciar usuu00e1rios
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser->hasPermission('manage_users') && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.content.sections')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para gerenciar usuu00e1rios.');
        }
        
        // Impedir que um usuu00e1rio nu00e3o super_admin edite um super_admin
        if ($user->role === 'super_admin' && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para editar um Super Administrador.');
        }
        
        $roles = AdminUser::getAvailableRoles();
        $permissions = AdminUser::getAvailablePermissions();
        
        return view('admin.users.form', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, AdminUser $user)
    {
        // Verificar se o usuu00e1rio atual tem permissu00e3o para gerenciar usuu00e1rios
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser->hasPermission('manage_users') && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.content.sections')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para gerenciar usuu00e1rios.');
        }
        
        // Impedir que um usuu00e1rio nu00e3o super_admin edite um super_admin
        if ($user->role === 'super_admin' && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para editar um Super Administrador.');
        }
        
        // Validar os dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admin_users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(array_keys(AdminUser::getAvailableRoles()))],
            'permissions' => 'nullable|array',
            'is_active' => 'boolean',
        ]);
        
        // Filtrar permissu00f5es vu00e1lidas
        $availablePermissions = array_keys(AdminUser::getAvailablePermissions());
        $validated['permissions'] = array_intersect($validated['permissions'] ?? [], $availablePermissions);
        
        // Remover a senha se estiver vazia
        if (empty($validated['password'])) {
            unset($validated['password']);
        }
        
        // Impedir que o u00faltimo super_admin seja rebaixado
        if ($user->role === 'super_admin' && $validated['role'] !== 'super_admin') {
            $superAdminCount = AdminUser::where('role', 'super_admin')->count();
            if ($superAdminCount <= 1) {
                return redirect()->route('admin.users.edit', $user)
                    ->with('error', 'Nu00e3o u00e9 possu00edvel rebaixar o u00faltimo Super Administrador.')
                    ->withInput();
            }
        }
        
        // Impedir que o usuu00e1rio desative sua pru00f3pria conta
        if ($user->id === $currentUser->id && !($validated['is_active'] ?? true)) {
            return redirect()->route('admin.users.edit', $user)
                ->with('error', 'Vocu00ea nu00e3o pode desativar sua pru00f3pria conta.')
                ->withInput();
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuu00e1rio atualizado com sucesso!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(AdminUser $user)
    {
        // Verificar se o usuu00e1rio atual tem permissu00e3o para gerenciar usuu00e1rios
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser->hasPermission('manage_users') && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.content.sections')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para gerenciar usuu00e1rios.');
        }
        
        // Impedir que um usuu00e1rio nu00e3o super_admin exclua um super_admin
        if ($user->role === 'super_admin' && $currentUser->role !== 'super_admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vocu00ea nu00e3o tem permissu00e3o para excluir um Super Administrador.');
        }
        
        // Impedir que o u00faltimo super_admin seja excluu00eddo
        if ($user->role === 'super_admin') {
            $superAdminCount = AdminUser::where('role', 'super_admin')->count();
            if ($superAdminCount <= 1) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Nu00e3o u00e9 possu00edvel excluir o u00faltimo Super Administrador.');
            }
        }
        
        // Impedir que o usuu00e1rio exclua sua pru00f3pria conta
        if ($user->id === $currentUser->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vocu00ea nu00e3o pode excluir sua pru00f3pria conta.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuu00e1rio excluu00eddo com sucesso!');
    }
}
