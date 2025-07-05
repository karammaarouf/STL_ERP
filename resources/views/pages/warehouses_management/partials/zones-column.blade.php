<!-- Zones Column -->
<div class="location-column">
    <div class="column-header">
        <h6 class="mb-0 text-dark fw-semibold">
            <i class="fas fa-layer-group me-2 text-success"></i>{{ __('Zones') }}
        </h6>
        @can('create-warehouse-zone')
        <button class="btn btn-outline-success btn-sm d-none" id="add-zone-btn" title="{{ __('Add Zone') }}">
            <i class="fas fa-plus"></i>
        </button>
        @endcan
    </div>
    <div class="column-search">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" placeholder="{{ __('Search zones...') }}" id="zone-search">
        </div>
    </div>
    <div class="column-body">
        <div class="list-group list-group-flush" id="zones-list">
            <div class="text-center py-4">
                <i class="fas fa-layer-group fa-2x text-muted mb-2"></i>
                <p class="text-muted small">{{ __('Select a warehouse to see its zones') }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Zone-specific variables
    const zoneSearchInput = document.getElementById('zone-search');
    const zonesList = document.getElementById('zones-list');
    const addZoneBtn = document.getElementById('add-zone-btn');
    const warehousesList = document.getElementById('warehouses-list');
    
    // Get references to other lists for resetting
    const sectionsList = document.getElementById('sections-list');
    const racksList = document.getElementById('racks-list');
    const slotsList = document.getElementById('slots-list');
    
    // Get references to other add buttons
    const addSectionBtn = document.getElementById('add-section-btn');
    const addRackBtn = document.getElementById('add-rack-btn');
    const addSlotBtn = document.getElementById('add-slot-btn');

    // Zone search functionality
    if (zoneSearchInput && zonesList) {
        zoneSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = zonesList.querySelectorAll('.list-group-item:not(.text-center)');
            let visibleCount = 0;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                item.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            // Remove previous no results message
            const existingMsg = zonesList.querySelector('.no-results-msg');
            if (existingMsg) existingMsg.remove();

            // Show no results message if needed
            if (visibleCount === 0 && items.length > 0 && searchTerm) {
                const noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-msg text-center py-3';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">{{ __('No results found for') }} "${searchTerm}"</p>
                `;
                zonesList.appendChild(noResultsMsg);
            }
        });
    }

    // Utility functions for zones
    function showLoading(listElement, message = '{{ __('Loading...') }}') {
        listElement.innerHTML = `
            <div class="text-center py-4 loading">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status">
                    <span class="visually-hidden">${message}</span>
                </div>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showEmpty(listElement, message, icon = 'fas fa-inbox') {
        listElement.innerHTML = `
            <div class="text-center py-4">
                <i class="${icon} fa-2x text-muted mb-2"></i>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showError(listElement, message = '{{ __('Error loading data') }}') {
        listElement.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                <p class="text-warning small mb-0">${message}</p>
            </div>
        `;
    }

    function createZoneListItem(zone) {
        return `
            <div class="list-group-item zone-item border-0 mb-2 rounded fade-in" data-id="${zone.id}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="item-content flex-grow-1 cursor-pointer">
                        <h6 class="mb-1 fw-semibold">
                            <i class="fas fa-layer-group text-success me-2"></i>${zone.name}
                        </h6>
                        ${zone.description ? `<small class="text-muted">${zone.description}</small>` : ''}
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-info view-btn" title="{{ __('View') }}" data-id="${zone.id}" data-type="zone">
                            <i class="fas fa-eye"></i>
                        </button>
                        @can('edit-warehouse-zone')
                        <button class="btn btn-sm btn-outline-warning edit-btn" title="{{ __('Edit') }}" data-id="${zone.id}" data-type="zone">
                            <i class="fas fa-edit"></i>
                        </button>
                        @endcan
                        @can('delete-warehouse-zone')
                        <button class="btn btn-sm btn-outline-danger delete-btn" title="{{ __('Delete') }}" data-id="${zone.id}" data-type="zone">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endcan
                    </div>
                </div>
            </div>
        `;
    }

    // إضافة دالة createSectionListItem
    function createSectionListItem(section, permissions = {}) {
        return `
            <div class="list-group-item section-item border-0 mb-2 rounded fade-in" data-id="${section.id}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="item-content flex-grow-1 cursor-pointer">
                        <h6 class="mb-1 fw-semibold">
                            <i class="fas fa-th-large text-info me-2"></i>${section.name}
                        </h6>
                        ${section.description ? `<small class="text-muted">${section.description}</small>` : ''}
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-info view-btn" title="{{ __('View') }}" data-id="${section.id}" data-type="section">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${permissions.edit ? `
                        <button class="btn btn-sm btn-outline-warning edit-btn" title="{{ __('Edit') }}" data-id="${section.id}" data-type="section">
                            <i class="fas fa-edit"></i>
                        </button>
                        ` : ''}
                        ${permissions.delete ? `
                        <button class="btn btn-sm btn-outline-danger delete-btn" title="{{ __('Delete') }}" data-id="${section.id}" data-type="section">
                            <i class="fas fa-trash"></i>
                        </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    function updateActiveState(listElement, activeItem) {
        listElement.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        if (activeItem) {
            activeItem.classList.add('active');
        }
    }

    function resetSubsequentLists() {
        // Reset sections, racks, and slots
        if (sectionsList) {
            showEmpty(sectionsList, '{{ __('Select a zone to see its sections') }}', 'fas fa-th-large');
        }
        if (racksList) {
            showEmpty(racksList, '{{ __('Select a section to see its racks') }}', 'fas fa-grip-vertical');
        }
        if (slotsList) {
            showEmpty(slotsList, '{{ __('Select a rack to see its slots') }}', 'fas fa-square');
        }

        // Hide subsequent add buttons
        if (addSectionBtn) addSectionBtn.classList.add('d-none');
        if (addRackBtn) addRackBtn.classList.add('d-none');
        if (addSlotBtn) addSlotBtn.classList.add('d-none');
    }

    // Warehouse selection handler for loading zones
    if (warehousesList) {
        warehousesList.addEventListener('click', async function(e) {
            const item = e.target.closest('.warehouse-item');
            if (!item || e.target.closest('.action-buttons')) return;

            const warehouseId = item.dataset.id;

            // Show add zone button
            if (addZoneBtn) {
                addZoneBtn.classList.remove('d-none');
                addZoneBtn.dataset.warehouseId = warehouseId;
            }

            showLoading(zonesList, '{{ __('Loading zones...') }}');

            try {
                const response = await fetch(`/api/warehouses/${warehouseId}/zones`);
                if (!response.ok) throw new Error('Network response was not ok');

                const zones = await response.json();

                if (zones.length === 0) {
                    showEmpty(zonesList, '{{ __('No zones found') }}', 'fas fa-layer-group');
                    return;
                }

                zonesList.innerHTML = zones.map(zone => createZoneListItem(zone)).join('');

            } catch (error) {
                console.error('Error fetching zones:', error);
                showError(zonesList, '{{ __('Error loading zones') }}');
            }
        });
    }

    // Zone selection handler
    if (zonesList) {
        zonesList.addEventListener('click', async function(e) {
            const item = e.target.closest('.zone-item');
            if (!item || e.target.closest('.action-buttons')) return;

            updateActiveState(this, item);
            resetSubsequentLists();

            const zoneId = item.dataset.id;

            // Show add section button
            if (addSectionBtn) {
                addSectionBtn.classList.remove('d-none');
                addSectionBtn.dataset.zoneId = zoneId;
            }

            if (sectionsList) {
                showLoading(sectionsList, '{{ __('Loading sections...') }}');

                try {
                    const response = await fetch(`/api/zones/${zoneId}/sections`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const sections = await response.json();

                    if (sections.length === 0) {
                        showEmpty(sectionsList, '{{ __('No sections found') }}', 'fas fa-th-large');
                        return;
                    }

                    // في event listener الخاص بـ zone selection، استبدل السطر 242:
                    sectionsList.innerHTML = sections.map(section => 
                        createSectionListItem(section, {
                            edit: @json(auth()->user()->can('edit-warehouse-section')),
                            delete: @json(auth()->user()->can('delete-warehouse-section'))
                        })
                    ).join('');

                } catch (error) {
                    console.error('Error fetching sections:', error);
                    showError(sectionsList, '{{ __('Error loading sections') }}');
                }
            }
        });
    }

    // Add zone button handler
    if (addZoneBtn) {
        addZoneBtn.addEventListener('click', function() {
            const warehouseId = this.dataset.warehouseId;
            if (warehouseId) {
                window.location.href = `/warehouses/${warehouseId}/zones/create`;
            }
        });
    }

    // Zone action handlers
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-btn')) {
            const btn = e.target.closest('.view-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'zone') {
                window.location.href = `/zones/${id}`;
            }
        }

        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'zone') {
                window.location.href = `/zones/${id}/edit`;
            }
        }

        if (e.target.closest('.delete-btn') && !e.target.closest('form')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'zone') {
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
                            form.action = `/zones/${id}`;

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                    if (confirm('{{ __('Are you sure you want to delete this zone?') }}')) {
                        // Handle delete without SweetAlert
                    }
                }
            }
        }
    });
});
</script>
@endpush