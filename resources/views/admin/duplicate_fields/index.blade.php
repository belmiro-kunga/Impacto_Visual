@extends('admin.layouts.app')

@section('title', 'Gerenciar Campos Duplicados')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gerenciar Campos Duplicados</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Campos Duplicados</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-copy me-1"></i>
            Ferramenta de Detecção e Correção
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button id="scanButton" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i> Escanear Campos Duplicados
                </button>
            </div>

            <div id="loading" class="text-center my-4 d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-2">Escaneando o banco de dados...</p>
            </div>

            <div id="noResults" class="alert alert-success d-none">
                <i class="fas fa-check-circle me-1"></i> Nenhum campo duplicado encontrado!
            </div>

            <div id="resultsContainer" class="d-none">
                <h4>Campos Duplicados Encontrados</h4>
                <div id="duplicateResults"></div>
            </div>
        </div>
    </div>
</div>

<!-- Template para duplicatas encontradas -->
<template id="duplicateTemplate">
    <div class="card mb-4 duplicate-item">
        <div class="card-header bg-warning">
            <strong>Duplicatas em <span class="table-name"></span> (<span class="field-name"></span>)</strong>
        </div>
        <div class="card-body">
            <div class="duplicate-info mb-3">
                <p><strong>Valor Duplicado:</strong> <span class="duplicate-value"></span></p>
                <p><strong>Número de Ocorrências:</strong> <span class="occurrence-count"></span></p>
            </div>
            
            <div class="duplicate-items"></div>
            
            <div class="mt-3">
                <button class="btn btn-success btn-fix">
                    <i class="fas fa-wrench me-1"></i> Corrigir Duplicatas
                </button>
            </div>
        </div>
    </div>
</template>

<!-- Template para cada item duplicado -->
<template id="duplicateItemTemplate">
    <div class="mb-2 duplicate-field-item">
        <div class="input-group">
            <span class="input-group-text">ID: <span class="item-id"></span></span>
            <input type="text" class="form-control new-value" placeholder="Novo valor">
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scanButton = document.getElementById('scanButton');
        const loading = document.getElementById('loading');
        const noResults = document.getElementById('noResults');
        const resultsContainer = document.getElementById('resultsContainer');
        const duplicateResults = document.getElementById('duplicateResults');
        
        scanButton.addEventListener('click', function() {
            // Mostrar loading
            loading.classList.remove('d-none');
            noResults.classList.add('d-none');
            resultsContainer.classList.add('d-none');
            duplicateResults.innerHTML = '';
            
            // Fazer requisição para escanear
            fetch('{{ route("admin.duplicate-fields.scan") }}')
                .then(response => response.json())
                .then(data => {
                    loading.classList.add('d-none');
                    
                    if (data.duplicates.length === 0) {
                        noResults.classList.remove('d-none');
                    } else {
                        resultsContainer.classList.remove('d-none');
                        renderDuplicates(data.duplicates);
                    }
                })
                .catch(error => {
                    loading.classList.add('d-none');
                    alert('Erro ao escanear: ' + error);
                });
        });
        
        // Renderizar duplicatas encontradas
        function renderDuplicates(duplicates) {
            const duplicateTemplate = document.getElementById('duplicateTemplate');
            const duplicateItemTemplate = document.getElementById('duplicateItemTemplate');
            
            duplicates.forEach(duplicate => {
                // Clonar template principal
                const duplicateEl = duplicateTemplate.content.cloneNode(true);
                
                // Preencher informações
                duplicateEl.querySelector('.table-name').textContent = duplicate.table;
                duplicateEl.querySelector('.field-name').textContent = duplicate.field;
                duplicateEl.querySelector('.duplicate-value').textContent = duplicate.value;
                duplicateEl.querySelector('.occurrence-count').textContent = duplicate.count;
                
                // Armazenar dados para uso posterior
                const duplicateItemEl = duplicateEl.querySelector('.duplicate-item');
                duplicateItemEl.dataset.table = duplicate.table;
                duplicateItemEl.dataset.field = duplicate.field;
                duplicateItemEl.dataset.ids = JSON.stringify(duplicate.ids);
                
                // Adicionar items duplicados
                const duplicateItemsContainer = duplicateEl.querySelector('.duplicate-items');
                
                duplicate.ids.forEach(id => {
                    const itemEl = duplicateItemTemplate.content.cloneNode(true);
                    itemEl.querySelector('.item-id').textContent = id;
                    itemEl.querySelector('.new-value').value = duplicate.value;
                    duplicateItemsContainer.appendChild(itemEl);
                });
                
                // Adicionar listener para o botão de correção
                duplicateEl.querySelector('.btn-fix').addEventListener('click', function(e) {
                    const card = e.target.closest('.duplicate-item');
                    fixDuplicates(card);
                });
                
                // Adicionar ao container de resultados
                duplicateResults.appendChild(duplicateEl);
            });
        }
        
        // Função para corrigir duplicatas
        function fixDuplicates(card) {
            const table = card.dataset.table;
            const field = card.dataset.field;
            const ids = JSON.parse(card.dataset.ids);
            const newValues = [];
            
            // Obter os novos valores
            card.querySelectorAll('.duplicate-field-item').forEach((item, index) => {
                newValues.push(item.querySelector('.new-value').value);
            });
            
            // Verificar se há valores vazios
            if (newValues.some(value => !value.trim())) {
                alert('Todos os campos devem ser preenchidos');
                return;
            }
            
            // Enviar dados para correção
            fetch('{{ route("admin.duplicate-fields.fix") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    table: table,
                    field: field,
                    ids: ids,
                    new_values: newValues
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remover o card após correção bem-sucedida
                    card.remove();
                    
                    // Verificar se não há mais duplicatas
                    if (duplicateResults.children.length === 0) {
                        resultsContainer.classList.add('d-none');
                        noResults.classList.remove('d-none');
                    }
                    
                    alert('Duplicatas corrigidas com sucesso!');
                } else {
                    alert('Erro: ' + (data.error || 'Ocorreu um erro ao corrigir as duplicatas'));
                }
            })
            .catch(error => {
                alert('Erro ao processar a requisição: ' + error);
            });
        }
    });
</script>
@endsection