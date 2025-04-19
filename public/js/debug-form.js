/**
 * Depuração de formulários - Ajuda a diagnosticar problemas com envio de formulários
 */
(function() {
    // Ativar apenas em ambientes de desenvolvimento
    const DEBUG_ENABLED = true;
    
    // Função para log com prefixo
    function debugLog(message, data) {
        if (!DEBUG_ENABLED) return;
        
        console.log(`%c[DEBUG FORM] %c${message}`, 'color: #f00; font-weight: bold', 'color: #007bff', data || '');
    }
    
    // Monitorar todos os formulários na página
    function monitorForms() {
        const forms = document.querySelectorAll('form');
        debugLog(`Encontrados ${forms.length} formulários na página`);
        
        forms.forEach((form, index) => {
            const formId = form.id || form.getAttribute('action') || `form-${index}`;
            debugLog(`Monitorando formulário: ${formId}`);
            
            // Monitorar envio de formulário
            form.addEventListener('submit', function(e) {
                debugLog(`Formulário enviado: ${formId}`, {
                    action: form.action,
                    method: form.method,
                    enctype: form.enctype,
                    elements: form.elements.length
                });
                
                // Verificar elementos do formulário
                Array.from(form.elements).forEach(element => {
                    if (element.name && element.name !== '') {
                        let value = element.value;
                        if (element.type === 'file') {
                            value = element.files && element.files.length ? 
                                `${element.files.length} arquivo(s)` : 'Nenhum arquivo';
                        }
                        
                        debugLog(`Campo: ${element.name} (${element.type}) = ${value.substring(0, 50)}${value.length > 50 ? '...' : ''}`);
                    }
                });
            });
        });
    }
    
    // Monitorar resposta AJAX
    function monitorXHR() {
        const originalXHROpen = XMLHttpRequest.prototype.open;
        const originalXHRSend = XMLHttpRequest.prototype.send;
        
        XMLHttpRequest.prototype.open = function(method, url) {
            this._debug_method = method;
            this._debug_url = url;
            return originalXHROpen.apply(this, arguments);
        };
        
        XMLHttpRequest.prototype.send = function(data) {
            debugLog(`Requisição AJAX: ${this._debug_method} ${this._debug_url}`, data);
            
            // Monitorar resposta
            this.addEventListener('load', function() {
                debugLog(`Resposta AJAX (${this.status}): ${this.responseText.substring(0, 100)}...`);
            });
            
            this.addEventListener('error', function() {
                debugLog(`Erro na requisição AJAX: ${this._debug_url}`);
            });
            
            return originalXHRSend.apply(this, arguments);
        };
    }
    
    // Iniciar monitoramento quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function() {
        debugLog('Depuração de formulários iniciada');
        monitorForms();
        monitorXHR();
        
        // Monitorar alterações no DOM que poderiam adicionar novos formulários
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    const hasNewForms = Array.from(mutation.addedNodes).some(node => {
                        return node.nodeName === 'FORM' || 
                               (node.nodeType === 1 && node.querySelector('form'));
                    });
                    
                    if (hasNewForms) {
                        debugLog('Novos formulários detectados, atualizando monitoramento');
                        monitorForms();
                    }
                }
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
    });
})(); 