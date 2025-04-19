/**
 * Script específico para resolver o problema de salvamento da seção Início
 */
document.addEventListener('DOMContentLoaded', function() {
    // Apenas execute este script se estivermos na seção hero
    const isHeroSection = window.location.href.includes('/admin/sections/hero');
    if (!isHeroSection) return;
    
    console.log('[Hero Fix] Script de correção da seção Hero carregado');
    
    // Referência aos formulários
    const mainForm = document.getElementById('update-content-form');
    const alternativeForm = document.getElementById('hero-direct-form');
    
    // Função para mostrar mensagem
    function showMessage(message, type = 'info') {
        const feedbackDiv = document.getElementById('global-feedback');
        if (feedbackDiv) {
            feedbackDiv.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        }
    }
    
    // Manipular o envio do formulário principal para evitar problemas
    if (mainForm) {
        mainForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Impedir envio padrão
            
            // Copiar os valores para o formulário alternativo
            if (alternativeForm) {
                // Para cada input no formulário principal
                const inputs = mainForm.querySelectorAll('input[name^="contents"], textarea[name^="contents"]');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const value = input.value;
                    
                    // Encontrar o campo correspondente no formulário alternativo
                    const targetInput = alternativeForm.querySelector(`[name="${name}"]`);
                    if (targetInput) {
                        targetInput.value = value;
                    }
                });
                
                // Mostrar mensagem
                showMessage('Usando método alternativo de salvamento para garantir que as alterações sejam salvas...', 'warning');
                
                // Enviar o formulário alternativo em vez do principal
                alternativeForm.submit();
            } else {
                // Se não tiver formulário alternativo, mostrar mensagem e enviar o principal
                showMessage('Tentando salvar usando método padrão...', 'warning');
                mainForm.submit();
            }
        });
    }
    
    // Adicionar também um botão de salvamento fixo no canto da tela
    const fixedButton = document.createElement('button');
    fixedButton.innerHTML = '<i class="bi bi-save"></i> Salvar Alterações';
    fixedButton.className = 'btn btn-success position-fixed';
    fixedButton.style.cssText = 'bottom: 20px; right: 20px; z-index: 1000; padding: 10px 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);';
    document.body.appendChild(fixedButton);
    
    fixedButton.addEventListener('click', function() {
        if (alternativeForm) {
            // Copiar os valores do formulário principal
            const inputs = mainForm.querySelectorAll('input[name^="contents"], textarea[name^="contents"]');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                const value = input.value;
                
                const targetInput = alternativeForm.querySelector(`[name="${name}"]`);
                if (targetInput) {
                    targetInput.value = value;
                }
            });
            
            // Mostrar mensagem e submeter
            showMessage('Salvando alterações...', 'info');
            alternativeForm.submit();
        }
    });
}); 