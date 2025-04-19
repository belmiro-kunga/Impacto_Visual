/**
 * Script para gerenciar o editor de seções do painel administrativo
 */
document.addEventListener('DOMContentLoaded', function() {
    // Armazena os editores CKEditor
    const editors = {};
    
    // Inicializa o CKEditor para cada campo HTML
    if (typeof ClassicEditor !== 'undefined') {
        document.querySelectorAll('.html-editor').forEach(function(textarea) {
            ClassicEditor
                .create(textarea, {
                    // Configurações simples - evita modificar muito o HTML
                    plugins: ['Essentials', 'Paragraph', 'Bold', 'Italic', 'Link', 'List', 'Image'],
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertImage']
                })
                .then(editor => {
                    const contentId = textarea.getAttribute('data-content-id');
                    editors[contentId] = editor;
                    
                    // Monitorar mudanças no editor e atualizar o textarea
                    editor.model.document.on('change:data', () => {
                        textarea.value = editor.getData();
                        console.log('CKEditor atualizado o textarea ID:', contentId);
                    });
                    
                    // Capture eventos de mudança ao perder foco
                    editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                        if (!isFocused) {
                            textarea.value = editor.getData();
                            console.log('CKEditor perdeu foco, textarea atualizado ID:', contentId);
                        }
                    });
                })
                .catch(error => {
                    console.error('Erro ao inicializar o CKEditor:', error);
                });
        });
    }
    
    // Função para mostrar feedback visual durante o envio
    function showSavingFeedback(show) {
        const saveButton = document.getElementById('btn-save-changes');
        const feedbackDiv = document.getElementById('save-feedback');
        
        if (!saveButton || !feedbackDiv) return;
        
        if (show) {
            saveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Salvando...';
            saveButton.disabled = true;
            feedbackDiv.innerHTML = '<div class="alert alert-info">Salvando alterações, por favor aguarde...</div>';
            feedbackDiv.style.display = 'block';
        } else {
            saveButton.innerHTML = '<i class="bi bi-save"></i> Salvar Alterações';
            saveButton.disabled = false;
            feedbackDiv.style.display = 'none';
        }
    }
    
    // Manipula o envio do formulário principal
    const contentForm = document.getElementById('update-content-form');
    if (contentForm) {
        contentForm.addEventListener('submit', function(e) {
            // Antes de enviar, garantir que os dados CKEditor estão nos textareas
            Object.keys(editors).forEach(contentId => {
                const editor = editors[contentId];
                const textarea = document.querySelector(`textarea[data-content-id="${contentId}"]`);
                if (textarea) {
                    const editorData = editor.getData();
                    textarea.value = editorData;
                    console.log('Form submit - Conteúdo do editor sincronizado:', contentId);
                }
            });
            
            // Mostrar feedback visual
            showSavingFeedback(true);
            
            // Log para teste
            console.log('Formulário enviando...');
        });
    }
    
    // Manipula o formulário para adicionar campo
    const addFieldForm = document.getElementById('add-new-field-form');
    if (addFieldForm) {
        addFieldForm.addEventListener('submit', function() {
            const addButton = document.getElementById('btn-add-field');
            if (addButton) {
                addButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Adicionando...';
                addButton.disabled = true;
            }
        });
    }
});
