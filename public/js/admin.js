// Menu item clear button functionality
$(document).ready(function() {
    $('.menu-clear-btn').on('click', function() {
        const menuId = $(this).data('menu-id');
        const row = $(this).closest('tr');
        
        // Clear the input fields in this row
        row.find('input[type="text"]').val('');
        
        // Visual feedback
        row.addClass('bg-light');
        setTimeout(() => {
            row.removeClass('bg-light');
        }, 500);
        
        // Show notification
        toastr.info('Item será removido quando você salvar as alterações');
    });
    
    // Adicionar novo item de menu (apenas interface)
    $('#add-menu-item').on('click', function() {
        // Esta funcionalidade seria implementada no futuro
        // Por enquanto, apenas mostra uma mensagem informativa
        toastr.info('Para adicionar um novo item de menu, use o formulário "Adicionar novo campo" no painel lateral');
        
        // Mostrar instruções
        Swal.fire({
            title: 'Adicionar novo item ao menu',
            html: `
                <p>Para adicionar um novo item ao menu, siga estes passos:</p>
                <ol class="text-left">
                    <li>No painel lateral esquerdo, use o formulário "Adicionar novo campo"</li>
                    <li>Defina um nome como "Menu Item X" (onde X é o número)</li>
                    <li>Escolha o tipo "Texto"</li>
                    <li>Clique em Adicionar</li>
                    <li>Repita o processo para adicionar o link correspondente com nome "Menu Item X Link"</li>
                </ol>
                <p>Após adicionar os dois campos, a página será recarregada e o novo item aparecerá na tabela.</p>
            `,
            icon: 'info',
            confirmButtonText: 'Entendi'
        });
    });
    
    // Excluir serviço com confirmação
    $('.delete-service-btn').on('click', function() {
        const serviceId = $(this).data('id');
        const serviceTitle = $(this).data('title');
        
        Swal.fire({
            title: 'Tem certeza?',
            html: `Você está prestes a excluir o serviço <strong>${serviceTitle}</strong>.<br>Esta ação não pode ser desfeita.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Criar e submeter um formulário para exclusão
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/services/${serviceId}`;
                form.style.display = 'none';
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
    
    // Garantir que todos os campos de texto tenham pelo menos string vazia
    $('form').on('submit', function() {
        $(this).find('input[type="text"]').each(function() {
            if ($(this).val() === null) {
                $(this).val('');
            }
        });
    });
}); 