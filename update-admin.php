<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

// Atualiza a senha do usuário com email 'admin@impactovisual.com'
$user = AdminUser::where('email', 'admin@impactovisual.com')->first();

if ($user) {
    $user->password = Hash::make('password');
    $user->save();
    echo "Senha atualizada com sucesso para o usuário {$user->name}.\n";
    echo "Novas credenciais:\n";
    echo "Email: {$user->email}\n";
    echo "Senha: password\n";
} else {
    echo "Usuário não encontrado.\n";
} 