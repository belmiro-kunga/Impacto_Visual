<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AdminUser;

$users = AdminUser::all();

echo "Lista de administradores:\n\n";

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Nome: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Perfil: {$user->role}\n";
    echo "-------------------------\n";
} 