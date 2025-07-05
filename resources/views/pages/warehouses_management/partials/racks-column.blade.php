<!-- Racks Column -->
<div class="location-column">
    <div class="column-header">
        <h6 class="mb-0 text-dark fw-semibold">
            <i class="fas fa-grip-vertical me-2 text-info"></i>{{ __('Racks') }}
        </h6>
        @can('create-warehouse-rack')
        <button class="btn btn-outline-info btn-sm d-none" id="add-rack-btn" title="{{ __('Add Rack') }}">
            <i class="fas fa-plus"></i>
        </button>
        @endcan
    </div>
    <div class="column-search">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" placeholder="{{ __('Search racks...') }}" id="rack-search">
        </div>
    </div>
    <div class="column-body">
        <div class="list-group list-group-flush" id="racks-list">
            <div class="text-center py-4">
                <i class="fas fa-grip-vertical fa-2x text-muted mb-2"></i>
                <p class="text-muted small">{{ __('Select a section to see its racks') }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables for racks
    const rackSearchInput = document.getElementById('rack-search');
    const racksList = document.getElementById('racks-list');
    const addRackBtn = document.getElementById('add-rack-btn');

    // Search functionality for racks
    function enableRackSearch() {
        if (!rackSearchInput || !racksList) return;

        rackSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = racksList.querySelectorAll('.list-group-item:not(.text-center)');
            let visibleCount = 0;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                item.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            // Remove previous no results message
            const existingMsg = racksList.querySelector('.no-results-msg');
            if (existingMsg) existingMsg.remove();

            // Show no results message if needed
            if (visibleCount === 0 && items.length > 0 && searchTerm) {
                const noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-msg text-center py-3';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">{{ __('No results found for') }} "${searchTerm}"</p>
                `;
                racksList.appendChild(noResultsMsg);
            }
        });
    }

    // Initialize rack search
    enableRackSearch();

    // Utility functions for racks
    function showRackLoading(message = '{{ __('Loading racks...') }}') {
        racksList.innerHTML = `
            <div class="text-center py-4 loading">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status">
                    <span class="visually-hidden">${message}</span>
                </div>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showRackEmpty(message, icon = 'fas fa-grip-vertical') {
        racksList.innerHTML = `
            <div class="text-center py-4">
                <i class="${icon} fa-2x text-muted mb-2"></i>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showRackError(message = '{{ __('Error loading racks') }}') {
        racksList.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                <p class="text-warning small mb-0">${message}</p>
            </div>
        `;
    }

    function createRackListItem(rack, permissions = {}) {
        return `
            <div class="list-group-item rack-item border-0 mb-2 rounded fade-in" data-id="${rack.id}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="item-content flex-grow-1 cursor-pointer">
                        <h6 class="mb-1 fw-semibold">
                            <i class="fas fa-grip-vertical text-info me-2"></i>${rack.name}
                        </h6>
                        ${rack.description ? `<small class="text-muted">${rack.description}</small>` : ''}
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-info view-btn" title="{{ __('View') }}" data-id="${rack.id}" data-type="rack">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${permissions.edit ? `
                                <button class="btn btn-sm btn-outline-warning edit-btn" title="{{ __('Edit') }}" data-id="${rack.id}" data-type="rack">
                                    <i class="fas fa-edit"></i>
                                </button>
                            ` : ''}
                        ${permissions.delete ? `
                                <button class="btn btn-sm btn-outline-danger delete-btn" title="{{ __('Delete') }}" data-id="${rack.id}" data-type="rack">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    function updateRackActiveState(activeItem) {
        racksList.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        if (activeItem) {
            activeItem.classList.add('active');
        }
    }

    // Listen for section selection to load racks
    document.addEventListener('sectionSelected', async function(e) {
        const sectionId = e.detail.sectionId;
        
        // Show add rack button
        if (addRackBtn) {
            addRackBtn.classList.remove('d-none');
            addRackBtn.dataset.sectionId = sectionId;
        }

        showRackLoading();

        try {
            const response = await fetch(`/api/sections/${sectionId}/racks`);
            if (!response.ok) throw new Error('Network response was not ok');

            const racks = await response.json();

            if (racks.length === 0) {
                showRackEmpty('{{ __('No racks found') }}', 'fas fa-grip-vertical');
                return;
            }

            racksList.innerHTML = racks.map(rack =>
                createRackListItem(rack, {
                    edit: @json(auth()->user()->can('edit-warehouse-rack')),
                    delete: @json(auth()->user()->can('delete-warehouse-rack'))
                })
            ).join('');

        } catch (error) {
            console.error('Error fetching racks:', error);
            showRackError();
        }
    });

    // Rack selection
    racksList.addEventListener('click', async function(e) {
        const item = e.target.closest('.rack-item');
        if (!item || e.target.closest('.action-buttons')) return;

        updateRackActiveState(item);

        const rackId = item.dataset.id;

        // Dispatch custom event for rack selection
        const rackSelectedEvent = new CustomEvent('rackSelected', {
            detail: { rackId: rackId }
        });
        document.dispatchEvent(rackSelectedEvent);
    });

    // Add rack button handler
    if (addRackBtn) {
        addRackBtn.addEventListener('click', function() {
            const sectionId = this.dataset.sectionId;
            if (sectionId) {
                window.location.href = `/sections/${sectionId}/racks/create`;
            }
        });
    }

    // Action handlers for racks
    function handleRackView(id) {
        window.location.href = `/racks/${id}`;
    }

    function handleRackEdit(id) {
        window.location.href = `/racks/${id}/edit`;
    }

    function handleRackDelete(id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: '{{ __('You will not be able to recover this data!') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Yes, delete it!') }}',
                cancelButtonText: '{{ __('Cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/racks/${id}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        } else {
            if (confirm('{{ __('Are you sure you want to delete this item?') }}')) {
                // Handle delete without SweetAlert
            }
        }
    }

    // Event listeners for rack action buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-btn')) {
            const btn = e.target.closest('.view-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'rack') {
                handleRackView(id);
            }
        }

        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'rack') {
                handleRackEdit(id);
            }
        }

        if (e.target.closest('.delete-btn') && !e.target.closest('form')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'rack') {
                handleRackDelete(id);
            }
        }
    });

    // Reset racks when warehouse or zone changes
    document.addEventListener('warehouseSelected', function() {
        showRackEmpty('{{ __('Select a section to see its racks') }}', 'fas fa-grip-vertical');
        if (addRackBtn) {
            addRackBtn.classList.add('d-none');
        }
    });

    document.addEventListener('zoneSelected', function() {
        showRackEmpty('{{ __('Select a section to see its racks') }}', 'fas fa-grip-vertical');
        if (addRackBtn) {
            addRackBtn.classList.add('d-none');
        }
    });
});
</script>
@endpush