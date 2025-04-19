@extends('admin.layouts.app')

@section('title', 'Clientes')

@section('content')
<style>
    .btn-group .btn {
        padding: 0.4rem 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.85rem;
    }
    .btn-group .btn:hover {
        transform: translateY(-2px);
    }
    .btn-group .btn i {
        font-size: 0.9rem;
    }
    .btn-edit {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    .btn-edit:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
        color: white;
        box-shadow: 0 3px 8px rgba(78, 115, 223, 0.3);
    }
    .btn-view {
        background-color: #36b9cc;
        border-color: #36b9cc;
        color: white;
    }
    .btn-view:hover {
        background-color: #2c9faf;
        border-color: #2a96a5;
        color: white;
        box-shadow: 0 3px 8px rgba(54, 185, 204, 0.3);
    }
    .btn-delete {
        background-color: #e74a3b;
        border-color: #e74a3b;
        color: white;
    }
    .btn-delete:hover {
        background-color: #be2617;
        border-color: #be2617;
        color: white;
        box-shadow: 0 3px 8px rgba(231, 74, 59, 0.3);
    }
    .actions-column {
        min-width: 300px;
    }

    /* Toggle Switch Styles */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e74a3b;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #1cc88a;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #1cc88a;
    }

    input:checked + .slider:before {
        transform: translateX(30px);
    }

    .status-text {
        display: block;
        margin-top: 5px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-active {
        color: #1cc88a;
    }

    .status-inactive {
        color: #e74a3b;
    }

    /* Loading state */
    .switch.loading .slider {
        opacity: 0.7;
        cursor: wait;
    }

    .switch.loading .slider:before {
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }

    .client-logo {
        max-height: 60px;
        max-width: 120px;
        object-fit: contain;
    }

    .website-link {
        color: #4e73df;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .website-link:hover {
        color: #2e59d9;
        text-decoration: underline;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Clientes</h1>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($clients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="80">Ordem</th>
                                <th width="200">Logo</th>
                                <th>Nome</th>
                                <th>Website</th>
                                <th width="120">Status</th>
                                <th class="actions-column">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td class="text-center">{{ $client->order }}</td>
                                    <td class="text-center">
                                        @if($client->logo)
                                            <img src="{{ Storage::url($client->logo) }}" 
                                                 alt="{{ $client->name }}" 
                                                 class="client-logo">
                                        @else
                                            <span class="text-muted">Sem logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $client->name }}</td>
                                    <td>
                                        @if($client->website)
                                            <a href="{{ $client->website }}" 
                                               target="_blank"
                                               class="website-link">
                                                {{ $client->website }}
                                                <i class="fas fa-external-link-alt ml-1"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">Não informado</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <label class="switch">
                                            <input type="checkbox" 
                                                   class="status-toggle"
                                                   data-id="{{ $client->id }}"
                                                   {{ $client->active ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <span class="status-text {{ $client->active ? 'status-active' : 'status-inactive' }}">
                                            {{ $client->active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.clients.edit', $client) }}" 
                                               class="btn btn-sm btn-edit mr-1"
                                               data-toggle="tooltip"
                                               title="Editar Cliente">
                                                <i class="fas fa-pencil-alt"></i>
                                                <span>Editar</span>
                                            </a>
                                            <form action="{{ route('admin.clients.destroy', $client) }}" 
                                                  method="POST" 
                                                  class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-delete"
                                                        data-toggle="tooltip"
                                                        title="Excluir Cliente"
                                                        onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                                    <i class="fas fa-trash"></i>
                                                    <span>Excluir</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center mb-0">Nenhum cliente cadastrado.</p>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Status Toggle Handler
    $('.status-toggle').change(function() {
        const $switch = $(this);
        const $switchLabel = $switch.closest('label');
        const $statusText = $switchLabel.siblings('.status-text');
        const clientId = $switch.data('id');
        
        // Add loading state
        $switchLabel.addClass('loading');
        $switch.prop('disabled', true);

        $.ajax({
            url: `{{ url('admin/clients') }}/${clientId}/toggle-status`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    const newStatus = response.active;
                    
                    // Update status text and class
                    $statusText
                        .text(newStatus ? 'Ativo' : 'Inativo')
                        .removeClass('status-active status-inactive')
                        .addClass(newStatus ? 'status-active' : 'status-inactive');

                    // Show success toast
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: response.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function() {
                // Revert switch state
                $switch.prop('checked', !$switch.prop('checked'));
                
                // Show error toast
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Não foi possível alterar o status do cliente.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            },
            complete: function() {
                // Remove loading state
                $switchLabel.removeClass('loading');
                $switch.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush 