@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Seção: {{ $section }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.content.sections') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <a href="{{ route('admin.content.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Novo Conteúdo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($contents->count() > 0)
                        <form action="{{ route('admin.content.sections.update', $section) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Rótulo</th>
                                            <th>Tipo</th>
                                            <th>Conteúdo</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contents as $content)
                                            <tr>
                                                <td>{{ $content->label }}</td>
                                                <td>{{ $content->type }}</td>
                                                <td>
                                                    @if($content->type == 'text')
                                                        <input type="text" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                                    @elseif($content->type == 'textarea')
                                                        <textarea name="contents[{{ $content->id }}]" class="form-control" rows="3">{{ $content->value }}</textarea>
                                                    @elseif($content->type == 'html')
                                                        <textarea name="contents[{{ $content->id }}]" class="form-control html-editor" rows="5">{{ $content->value }}</textarea>
                                                    @elseif($content->type == 'image')
                                                        <div class="mb-2">
                                                            @if($content->value)
                                                                <img src="{{ asset($content->value) }}" class="img-thumbnail" style="max-height: 100px">
                                                            @endif
                                                        </div>
                                                        <input type="text" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}" placeholder="Caminho da imagem">
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-info btn-sm">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save"></i> Salvar Alterações
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            Nenhum conteúdo encontrado para esta seção. <a href="{{ route('admin.content.create') }}">Adicione conteúdo agora</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any WYSIWYG editors for HTML content
        if (typeof ClassicEditor !== 'undefined') {
            document.querySelectorAll('.html-editor').forEach(editor => {
                ClassicEditor
                    .create(editor)
                    .catch(error => {
                        console.error(error);
                    });
            });
        }
    });
</script>
@endpush 