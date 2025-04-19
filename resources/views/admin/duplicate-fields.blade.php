@extends('admin.layouts.app')

@section('title', 'Gerenciar Campos Duplicados')
@section('page_title', 'Gerenciar Campos Duplicados')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-info">
                <p><strong>Sobre esta página:</strong> Aqui você pode gerenciar campos duplicados encontrados no sistema. 
                Campos duplicados ocorrem quando há múltiplos registros com a mesma chave na mesma seção, o que pode causar problemas ao editar conteúdo.</p>
                <p>Para cada grupo de campos duplicados, você pode escolher qual campo manter (geralmente o mais antigo) e eliminar os outros.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Campos Duplicados Encontrados</h5>
                    <div>
                        <a href="{{ route('admin.duplicate-fields.remove-all') }}" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover TODOS os campos duplicados automaticamente? Esta ação é irreversível.');">
                            <i class="bi bi-trash"></i> Remover Todos Duplicados Automaticamente
                        </a>
                        <a href="{{ route('admin.sections.edit', 'hero') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar para Edição de Seções
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($duplicateGroups) > 0)
                        <form action="{{ route('admin.duplicate-fields.remove') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Seção</th>
                                            <th>Chave</th>
                                            <th>Quantidade</th>
                                            <th>Campo a Manter</th>
                                            <th>Campos Duplicados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($duplicateGroups as $index => $group)
                                        <tr>
                                            <td>{{ ucfirst($group['section']) }}</td>
                                            <td><code>{{ $group['key'] }}</code></td>
                                            <td>{{ $group['count'] }}</td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="keep_ids[{{ $group['key'] }}]" class="form-control">
                                                        @foreach($group['fields'] as $field)
                                                        <option value="{{ $field->id }}">
                                                            ID: {{ $field->id }} - 
                                                            Label: {{ $field->label }} - 
                                                            Valor: {{ Str::limit($field->value, 30) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="list-group">
                                                    @foreach($group['fields'] as $field)
                                                    <li class="list-group-item">
                                                        <strong>ID:</strong> {{ $field->id }}<br>
                                                        <strong>Label:</strong> {{ $field->label }}<br>
                                                        <strong>Valor:</strong> {{ Str::limit($field->value, 50) }}
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Remover Campos Duplicados Selecionados
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-success">
                            Não foram encontrados campos duplicados no sistema.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 