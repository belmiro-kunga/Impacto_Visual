@extends('admin.layouts.app')

@section('title', 'Depoimentos')

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

    /* Modal styles */
    .testimonial-modal .modal-content {
        background: linear-gradient(135deg, #2a2d3e, #1e1f2e);
        color: #fff;
        border: none;
        border-radius: 15px;
    }

    .testimonial-modal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
    }

    .testimonial-modal .modal-title {
        color: #fff;
        font-weight: 600;
    }

    .testimonial-modal .modal-body {
        padding: 1.5rem;
    }

    .testimonial-modal .close {
        color: #fff;
        opacity: 0.8;
        text-shadow: none;
        transition: all 0.3s ease;
    }

    .testimonial-modal .close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .testimonial-detail {
        margin-bottom: 1.5rem;
    }

    .testimonial-detail-label {
        font-size: 0.875rem;
        color: #a0aec0;
        margin-bottom: 0.5rem;
    }

    .testimonial-detail-content {
        font-size: 1rem;
        color: #fff;
    }

    .testimonial-preview-image {
        max-width: 150px;
        border-radius: 50%;
        margin-bottom: 1rem;
        border: 3px solid rgba(255, 255, 255, 0.1);
    }

    .testimonial-rating {
        margin: 1rem 0;
    }

    .testimonial-rating i {
        color: #f6c23e;
        margin-right: 0.25rem;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Depoimentos</h1>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Depoimento
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($testimonials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="80">Ordem</th>
                                <th width="100">Imagem</th>
                                <th>Nome</th>
                                <th>Cargo</th>
                                <th>Empresa</th>
                                <th width="100">Avaliação</th>
                                <th width="120">Status</th>
                                <th class="actions-column">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td class="text-center">{{ $testimonial->order }}</td>
                                    <td class="text-center">
                                        @if($testimonial->image)
                                            <img src="{{ Storage::url($testimonial->image) }}" 
                                                 alt="{{ $testimonial->name }}" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 50px">
                                        @else
                                            <span class="text-muted">Sem imagem</span>
                                        @endif
                                    </td>
                                    <td>{{ $testimonial->name }}</td>
                                    <td>{{ $testimonial->position }}</td>
                                    <td>{{ $testimonial->company }}</td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                    <td class="text-center">
                                        <label class="switch">
                                            <input type="checkbox" 
                                                   class="status-toggle"
                                                   data-id="{{ $testimonial->id }}"
                                                   {{ $testimonial->active ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <span class="status-text {{ $testimonial->active ? 'status-active' : 'status-inactive' }}">
                                            {{ $testimonial->active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" 
                                               class="btn btn-sm btn-edit mr-1"
                                               data-toggle="tooltip"
                                               title="Editar Depoimento">
                                                <i class="fas fa-pencil-alt"></i>
                                                <span>Editar</span>
                                            </a>
                                            <a href="#" 
                                               class="btn btn-sm btn-view mr-1"
                                               data-toggle="tooltip"
                                               title="Visualizar Depoimento"
                                               onclick="viewTestimonial({{ $testimonial->id }})">
                                                <i class="fas fa-search"></i>
                                                <span>Visualizar</span>
                                            </a>
                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" 
                                                  method="POST" 
                                                  class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-delete"
                                                        data-toggle="tooltip"
                                                        title="Excluir Depoimento"
                                                        onclick="return confirm('Tem certeza que deseja excluir este depoimento?')">
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
                <p class="text-center mb-0">Nenhum depoimento cadastrado.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade testimonial-modal" id="testimonialModal" tabindex="-1" role="dialog" aria-labelledby="testimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testimonialModalLabel">Detalhes do Depoimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img src="" alt="" class="testimonial-preview-image" id="testimonialImage">
                </div>
                <div class="testimonial-detail">
                    <div class="testimonial-detail-label">Nome</div>
                    <div class="testimonial-detail-content" id="testimonialName"></div>
                </div>
                <div class="testimonial-detail">
                    <div class="testimonial-detail-label">Cargo</div>
                    <div class="testimonial-detail-content" id="testimonialPosition"></div>
                </div>
                <div class="testimonial-detail">
                    <div class="testimonial-detail-label">Empresa</div>
                    <div class="testimonial-detail-content" id="testimonialCompany"></div>
                </div>
                <div class="testimonial-detail">
                    <div class="testimonial-detail-label">Avaliação</div>
                    <div class="testimonial-rating" id="testimonialRating"></div>
                </div>
                <div class="testimonial-detail">
                    <div class="testimonial-detail-label">Depoimento</div>
                    <div class="testimonial-detail-content" id="testimonialContent"></div>
                </div>
                <div class="testimonial-detail">
                    <div class="testimonial-detail-label">Status</div>
                    <div class="testimonial-detail-content" id="testimonialStatus"></div>
                </div>
                <div class="testimonial-detail">
                    <div class="testimonial-detail-label">Ordem</div>
                    <div class="testimonial-detail-content" id="testimonialOrder"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize modal
    $('#testimonialModal').modal({
        backdrop: true,
        keyboard: true,
        show: false
    });

    // Modal close handler
    $('.modal .close, .modal .btn-secondary').on('click', function() {
        $('#testimonialModal').modal('hide');
    });

    // Status Toggle Handler
    $('.status-toggle').change(function() {
        const $switch = $(this);
        const $switchLabel = $switch.closest('label');
        const $statusText = $switchLabel.siblings('.status-text');
        const testimonialId = $switch.data('id');
        
        // Add loading state
        $switchLabel.addClass('loading');
        $switch.prop('disabled', true);

        $.ajax({
            url: `{{ url('admin/testimonials') }}/${testimonialId}/toggle-status`,
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
                    text: 'Não foi possível alterar o status do depoimento.',
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

// View Testimonial Function
function viewTestimonial(id) {
    // Show loading state
    Swal.fire({
        title: 'Carregando...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Fetch testimonial details
    $.ajax({
        url: `{{ url('admin/testimonials') }}/${id}`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            // Close loading indicator
            Swal.close();

            // Update modal content
            $('#testimonialName').text(response.name);
            $('#testimonialPosition').text(response.position);
            $('#testimonialCompany').text(response.company);
            $('#testimonialContent').text(response.testimonial);
            $('#testimonialOrder').text(response.order);
            
            // Update status with color
            const statusClass = response.active ? 'text-success' : 'text-danger';
            $('#testimonialStatus').html(`
                <span class="${statusClass}">
                    ${response.active ? 'Ativo' : 'Inativo'}
                </span>
            `);
            
            // Update rating stars
            let ratingHtml = '';
            for (let i = 1; i <= 5; i++) {
                ratingHtml += `<i class="fas fa-star ${i <= response.rating ? 'text-warning' : 'text-muted'}"></i>`;
            }
            $('#testimonialRating').html(ratingHtml);
            
            // Update image
            const imageUrl = response.image 
                ? `{{ url('storage') }}/${response.image}`
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(response.name)}&size=150`;
            $('#testimonialImage').attr('src', imageUrl).attr('alt', response.name);
            
            // Show modal
            $('#testimonialModal').modal('show');
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Não foi possível carregar os detalhes do depoimento.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
}
</script>
@endpush 