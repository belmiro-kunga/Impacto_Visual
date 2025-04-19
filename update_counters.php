<?php

// Carregar o framework Laravel
require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Content;

// Verificar se os contadores já existem
$contadoresProjetos = Content::where('key', 'contador-projetos')->first();
$contadoresClientes = Content::where('key', 'contador-clientes')->first();
$contadoresAnos = Content::where('key', 'contador-anos')->first();

// Array com os dados dos contadores
$contadores = [
    [
        'key' => 'contador-projetos',
        'section' => 'Contadores',
        'label' => 'Número de Projetos',
        'value' => '100',
        'type' => 'text',
        'order' => 1,
    ],
    [
        'key' => 'contador-clientes',
        'section' => 'Contadores',
        'label' => 'Número de Clientes',
        'value' => '50',
        'type' => 'text',
        'order' => 2,
    ],
    [
        'key' => 'contador-anos',
        'section' => 'Contadores',
        'label' => 'Número de Anos',
        'value' => '5',
        'type' => 'text',
        'order' => 3,
    ],
];

// Inserir contadores que não existem
foreach ($contadores as $contador) {
    $existente = Content::where('key', $contador['key'])->first();
    
    if (!$existente) {
        Content::create($contador);
        echo "Contador {$contador['key']} criado com sucesso!\n";
    } else {
        echo "Contador {$contador['key']} já existe. Nenhuma ação necessária.\n";
    }
}

echo "Processo concluído!\n"; 