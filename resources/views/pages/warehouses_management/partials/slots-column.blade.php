<!-- Slots Column -->
<div class="location-column">
    <div class="column-header">
        <h6 class="mb-0 text-dark fw-semibold">
            <i class="fas fa-square me-2 text-danger"></i>{{ __('Slots') }}
        </h6>
        @can('create-warehouse-slot')
        <button class="btn btn-outline-danger btn-sm d-none" id="add-slot-btn" title="{{ __('Add Slot') }}">
            <i class="fas fa-plus"></i>
        </button>
        @endcan
    </div>
    <div class="column-search">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" placeholder="{{ __('Search slots...') }}" id="slot-search">
        </div>
    </div>
    <div class="column-body">
        <div class="list-group list-group-flush" id="slots-list">
            <div class="text-center py-4">
                <i class="fas fa-square fa-2x text-muted mb-2"></i>
                <p class="text-muted small">{{ __('Select a rack to see its slots') }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables for slots
    const slotSearchInput = document.getElementById('slot-search');
    const slotsList = document.getElementById('slots-list');
    const addSlotBtn = document.getElementById('add-slot-btn');

    // Search functionality for slots
    function enableSlotSearch() {
        if (!slotSearchInput || !slotsList) return;

        slotSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = slotsList.querySelectorAll('.list-group-item:not(.text-center)');
            let visibleCount = 0;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                item.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            // Remove previous no results message
            const existingMsg = slotsList.querySelector('.no-results-msg');
            if (existingMsg) existingMsg.remove();

            // Show no results message if needed
            if (visibleCount === 0 && items.length > 0 && searchTerm) {
                const noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-msg text-center py-3';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">{{ __('No results found for') }} "${searchTerm}"</p>
                `;
                slotsList.appendChild(noResultsMsg);
            }
        });
    }

    // Initialize slot search
    enableSlotSearch();

    // Utility functions for slots
    function showSlotLoading(message = '{{ __('Loading slots...') }}') {
        slotsList.innerHTML = `
            <div class="text-center py-4 loading">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status">
                    <span class="visually-hidden">${message}</span>
                </div>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showSlotEmpty(message, icon = 'fas fa-square') {
        slotsList.innerHTML = `
            <div class="text-center py-4">
                <i class="${icon} fa-2x text-muted mb-2"></i>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showSlotError(message = '{{ __('Error loading slots') }}') {
        slotsList.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                <p class="text-warning small mb-0">${message}</p>
            </div>
        `;
    }

    function createSlotListItem(slot, permissions = {}) {
        return `
            <div class="list-group-item slot-item border-0 mb-2 rounded fade-in" data-id="${slot.id}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="item-content flex-grow-1 cursor-pointer">
                        <h6 class="mb-1 fw-semibold">
                            <i class="fas fa-square text-danger me-2"></i>${slot.name}
                        </h6>
                        ${slot.description ? `<small class="text-muted">${slot.description}</small>` : ''}
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-info view-btn" title="{{ __('View') }}" data-id="${slot.id}" data-type="slot">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${permissions.edit ? `
                                <button class="btn btn-sm btn-outline-warning edit-btn" title="{{ __('Edit') }}" data-id="${slot.id}" data-type="slot">
                                    <i class="fas fa-edit"></i>
                                </button>
                            ` : ''}
                        ${permissions.delete ? `
                                <button class="btn btn-sm btn-outline-danger delete-btn" title="{{ __('Delete') }}" data-id="${slot.id}" data-type="slot">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    // Listen for rack selection to load slots
    document.addEventListener('rackSelected', async function(e) {
        const rackId = e.detail.rackId;

        // Show add slot button
        if (addSlotBtn) {
            addSlotBtn.classList.remove('d-none');
            addSlotBtn.dataset.rackId = rackId;
        }

        showSlotLoading();

        try {
            const response = await fetch(`/api/racks/${rackId}/slots`);
            if (!response.ok) throw new Error('Network response was not ok');

            const slots = await response.json();

            if (slots.length === 0) {
                showSlotEmpty('{{ __('No slots found') }}', 'fas fa-square');
                return;
            }

            slotsList.innerHTML = slots.map(slot =>
                createSlotListItem(slot, {
                    edit: @json(auth()->user()->can('edit-warehouse-slot')),
                    delete: @json(auth()->user()->can('delete-warehouse-slot'))
                })
            ).join('');

        } catch (error) {
            console.error('Error fetching slots:', error);
            showSlotError();
        }
    });

    // Add slot button handler
    if (addSlotBtn) {
        addSlotBtn.addEventListener('click', function() {
            const rackId = this.dataset.rackId;
            if (rackId) {
                window.location.href = `/racks/${rackId}/slots/create`;
            }
        });
    }

    // Action handlers for slots
    function handleSlotView(id) {
        window.location.href = `/slots/${id}`;
    }

    function handleSlotEdit(id) {
        window.location.href = `/slots/${id}/edit`;
    }

    function handleSlotDelete(id) {
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
                    form.action = `/slots/${id}`;

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

    // Event listeners for slot action buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-btn')) {
            const btn = e.target.closest('.view-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'slot') {
                handleSlotView(id);
            }
        }

        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'slot') {
                handleSlotEdit(id);
            }
        }

        if (e.target.closest('.delete-btn') && !e.target.closest('form')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'slot') {
                handleSlotDelete(id);
            }
        }
    });

    // Reset slots when warehouse, zone, or section changes
    document.addEventListener('warehouseSelected', function() {
        showSlotEmpty('{{ __('Select a rack to see its slots') }}', 'fas fa-square');
        if (addSlotBtn) {
            addSlotBtn.classList.add('d-none');
        }
    });

    document.addEventListener('zoneSelected', function() {
        showSlotEmpty('{{ __('Select a rack to see its slots') }}', 'fas fa-square');
        if (addSlotBtn) {
            addSlotBtn.classList.add('d-none');
        }
    });

    document.addEventListener('sectionSelected', function() {
        showSlotEmpty('{{ __('Select a rack to see its slots') }}', 'fas fa-square');
        if (addSlotBtn) {
            addSlotBtn.classList.add('d-none');
        }
    });
});
</script>
@endpush