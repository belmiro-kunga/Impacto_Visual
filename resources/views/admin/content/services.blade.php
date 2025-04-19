@extends('admin.layouts.app')

@section('title', 'Gerenciar Serviços')
@section('page_title', 'Gerenciar Serviços')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Serviços</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Novo Serviço
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($services->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Ordem</th>
                                        <th>Título</th>
                                        <th>Ícone</th>
                                        <th>Destaque</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $service)
                                        <tr>
                                            <td>{{ $service->order }}</td>
                                            <td>{{ $service->title }}</td>
                                            <td><i class="bi {{ $service->icon }}"></i> {{ $service->icon }}</td>
                                            <td>
                                                @if($service->is_highlighted)
                                                    <span class="badge bg-success">Sim</span>
                                                @else
                                                    <span class="badge bg-secondary">Não</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($service->active)
                                                    <span class="badge bg-success">Ativo</span>
                                                @else
                                                    <span class="badge bg-danger">Inativo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-info btn-sm">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $service->id }}').submit();">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                                <form id="delete-form-{{ $service->id }}" action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Nenhum serviço foi encontrado. <a href="{{ route('admin.services.create') }}">Crie seu primeiro serviço.</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 