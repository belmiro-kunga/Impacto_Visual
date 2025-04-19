<div class="modal fade" id="iconPickerModal" tabindex="-1" aria-labelledby="iconPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconPickerModalLabel">Escolher u00cdcone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="iconSearch" placeholder="Pesquisar u00edcones...">
                </div>
                <div class="row icon-grid" id="iconGrid">
                    <!-- Icons will be loaded here via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const icons = [
            'alarm', 'archive', 'arrow-up', 'arrow-down', 'arrow-left', 'arrow-right',
            'bag', 'bell', 'book', 'bookmark', 'box', 'briefcase', 'brush',
            'building', 'bullseye', 'calculator', 'calendar', 'camera', 'cart',
            'chat', 'check', 'check-circle', 'check-square', 'chevron-down',
            'chevron-left', 'chevron-right', 'chevron-up', 'circle', 'clipboard',
            'clock', 'cloud', 'code', 'collection', 'columns', 'command',
            'compass', 'cpu', 'credit-card', 'cursor', 'dash', 'diagram-3',
            'diamond', 'display', 'door-closed', 'door-open', 'dot', 'download',
            'droplet', 'earbuds', 'easel', 'egg', 'eject', 'emoji-smile',
            'envelope', 'exclamation', 'exclamation-circle', 'eye', 'eyeglasses',
            'file', 'file-earmark', 'film', 'filter', 'flag', 'folder',
            'gear', 'gem', 'gift', 'globe', 'globe2', 'graph-up', 'grid',
            'hand-thumbs-up', 'heart', 'house', 'image', 'inbox', 'info',
            'info-circle', 'journal', 'key', 'keyboard', 'laptop', 'layers',
            'lightning', 'lightning-charge', 'link', 'list', 'lock', 'magic',
            'magnet', 'map', 'megaphone', 'menu-button', 'mic', 'moon',
            'music-note', 'palette', 'paperclip', 'pencil', 'people', 'person',
            'person-check', 'phone', 'pie-chart', 'pin', 'play', 'plug',
            'plus', 'power', 'printer', 'puzzle', 'question', 'question-circle',
            'receipt', 'reply', 'shield', 'shift', 'shop', 'shuffle',
            'signal', 'sliders', 'smartphone', 'speaker', 'star', 'stars',
            'stickies', 'stopwatch', 'sun', 'tablet', 'tag', 'terminal',
            'text-left', 'text-center', 'text-right', 'trophy', 'truck',
            'tv', 'type', 'umbrella', 'unlock', 'upload', 'usb', 'wallet',
            'watch', 'wifi', 'window', 'wrench', 'x', 'zoom-in', 'zoom-out'
        ];
        
        const iconGrid = document.getElementById('iconGrid');
        const iconSearch = document.getElementById('iconSearch');
        let targetInputId = '';
        
        // Populate the icon grid
        function populateIcons(iconsToShow) {
            iconGrid.innerHTML = '';
            
            iconsToShow.forEach(icon => {
                const iconName = `bi-${icon}`;
                const div = document.createElement('div');
                div.className = 'col-3 col-md-2 mb-3 text-center icon-item';
                div.innerHTML = `
                    <div class="p-2 icon-box" data-icon="${iconName}">
                        <i class="bi ${iconName} fs-3"></i>
                        <div class="small text-muted text-truncate mt-1">${iconName}</div>
                    </div>
                `;
                iconGrid.appendChild(div);
                
                div.querySelector('.icon-box').addEventListener('click', function() {
                    const selectedIcon = this.getAttribute('data-icon');
                    document.getElementById(targetInputId).value = selectedIcon;
                    
                    // Update the preview
                    const previewId = targetInputId.replace('input_', 'preview_');
                    const preview = document.getElementById(previewId);
                    if (preview) {
                        preview.innerHTML = `<i class="bi ${selectedIcon} fs-3"></i>`;
                    }
                    
                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('iconPickerModal'));
                    modal.hide();
                });
            });
        }
        
        // Initialize with all icons
        populateIcons(icons);
        
        // Search functionality
        iconSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const filteredIcons = icons.filter(icon => 
                icon.toLowerCase().includes(searchTerm)
            );
            populateIcons(filteredIcons);
        });
        
        // Open icon picker when clicking on an icon field
        document.querySelectorAll('.icon-picker-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                targetInputId = this.getAttribute('data-target');
                const modal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
                modal.show();
            });
        });
    });
</script>

<style>
    .icon-box {
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .icon-box:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
    }
    
    .icon-picker-trigger {
        cursor: pointer;
    }
    
    .icon-preview {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-right: 10px;
    }
</style>
