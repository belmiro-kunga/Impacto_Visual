<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\DB;

class AdminUserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Atualizar todos os usuários administrativos existentes para terem o papel de super_admin
        // e todas as permissões disponíveis
        $users = AdminUser::all();
        
        if ($users->isEmpty()) {
            // Se não houver usuários, crie um super admin
            AdminUser::create([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => 'password', // Será automaticamente hasheado pelo modelo
                'role' => 'super_admin',
                'permissions' => array_keys(AdminUser::getAvailablePermissions()),
                'is_active' => true
            ]);
        } else {
            // Atualizar todos os usuários existentes para terem o papel de super_admin
            foreach ($users as $user) {
                $user->update([
                    'role' => 'super_admin',
                    'permissions' => array_keys(AdminUser::getAvailablePermissions()),
                    'is_active' => true
                ]);
            }
        }
        
        $this->command->info('Todos os usuários administrativos foram atualizados para Super Admin com todas as permissões!');
    }
}
