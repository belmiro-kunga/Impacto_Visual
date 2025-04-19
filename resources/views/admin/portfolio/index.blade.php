@extends('admin.layouts.app')

@section('title', 'Gerenciar Portfólio')
@section('page_title', 'Gerenciar Portfólio')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Portfólio de Vídeos</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Novo Vídeo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(isset($portfolios) && $portfolios->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Ordem</th>
                                        <th>Thumbnail</th>
                                        <th>Título</th>
                                        <th>ID do YouTube</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($portfolios as $item)
                                        <tr>
                                            <td>{{ $item->order }}</td>
                                            <td>
                                                <img src="{{ $item->youtube_thumbnail_url }}" 
                                                    alt="{{ $item->title }}" 
                                                    class="img-thumbnail" 
                                                    style="max-width: 120px;">
                                            </td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->youtube_id }}</td>
                                            <td>
                                                @if($item->active)
                                                    <span class="badge bg-success">Ativo</span>
                                                @else
                                                    <span class="badge bg-danger">Inativo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.portfolio.edit', $item->id) }}" class="btn btn-info btn-sm">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm('Tem certeza que deseja excluir este item?')) document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.portfolio.destroy', $item->id) }}" method="POST" style="display: none;">
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
                            Nenhum item de portfólio encontrado. <a href="{{ route('admin.portfolio.create') }}">Adicione seu primeiro vídeo</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 