@extends('../layouts.app')

@push('styles')
<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold">{{ __('Warehouse Management') }}</h5>
                <div class="d-flex gap-2">
                    @can('create-warehouse')
                    <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>{{ __('Add Warehouse') }}
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="locations-container">
                <!-- Warehouses Column -->
                <div class="location-column">
                    <div class="column-header">
                        <h6 class="mb-0 text-dark fw-semibold">
                            <i class="fas fa-warehouse me-2 text-primary"></i>{{ __('Warehouses') }}
                        </h6>
                        @can('create-warehouse')
                        <button class="btn btn-outline-primary btn-sm" id="add-warehouse-btn" title="{{ __('Add Warehouse') }}">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                    <div class="column-search">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="{{ __('Search warehouses...') }}" id="warehouse-search">
                        </div>
                    </div>
                    <div class="column-body">
                        <div class="list-group list-group-flush" id="warehouses-list">
                            @forelse($warehouses as $warehouse)
                            <div class="list-group-item warehouse-item border-0 mb-2 rounded" data-id="{{ $warehouse->id }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="item-content flex-grow-1 cursor-pointer">
                                        <h6 class="mb-1 fw-semibold">{{ $warehouse->name }}</h6>
                                        <small class="text-muted">{{ $warehouse->location ?? __('No location specified') }}</small>
                                    </div>
                                    <div class="action-buttons">
                                        <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-sm btn-outline-info" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('edit-warehouse')
                                        <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete-warehouse')
                                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger delete-btn" type="button" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                                <p class="text-muted">{{ __('No warehouses found') }}</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

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

                <!-- Sections Column -->
                <div class="location-column">
                    <div class="column-header">
                        <h6 class="mb-0 text-dark fw-semibold">
                            <i class="fas fa-th-large me-2 text-warning"></i>{{ __('Sections') }}
                        </h6>
                        @can('create-warehouse-section')
                        <button class="btn btn-outline-warning btn-sm d-none" id="add-section-btn" title="{{ __('Add Section') }}">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                    <div class="column-search">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="{{ __('Search sections...') }}" id="section-search">
                        </div>
                    </div>
                    <div class="column-body">
                        <div class="list-group list-group-flush" id="sections-list">
                            <div class="text-center py-4">
                                <i class="fas fa-th-large fa-2x text-muted mb-2"></i>
                                <p class="text-muted small">{{ __('Select a zone to see its sections') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

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
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Main Container */
.locations-container {
    display: flex;
    gap: 1.25rem;
    padding: 1.5rem;
    height: calc(100vh - 200px);
    overflow-x: auto;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 0.5rem;
}

/* Column Styling */
.location-column {
    flex: 1;
    min-width: 320px;
    max-width: 380px;
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.location-column:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

/* Column Header */
.column-header {
    padding: 1.25rem;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-bottom: 2px solid #e9ecef;
    border-radius: 0.75rem 0.75rem 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.column-header h6 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
}

/* Search Section */
.column-search {
    padding: 1rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.column-search .input-group-text {
    background: #ffffff;
    border: 1px solid #dee2e6;
    color: #6c757d;
}

.column-search .form-control {
    background: #ffffff;
    border: 1px solid #dee2e6;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.column-search .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    background: #ffffff;
}

/* Column Body */
.column-body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
    background: #ffffff;
    border-radius: 0 0 0.75rem 0.75rem;
}

/* List Items */
.list-group-item {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    margin-bottom: 0.75rem;
    background: #ffffff;
    transition: all 0.3s ease;
    padding: 1rem;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.list-group-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.list-group-item:hover {
    background: #f8f9fa;
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.list-group-item:hover::before {
    transform: scaleY(1);
}

.list-group-item.active {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-color: #2196f3;
    color: #1565c0;
    font-weight: 500;
}

.list-group-item.active::before {
    transform: scaleY(1);
    background: linear-gradient(135deg, #2196f3, #1976d2);
}

/* Item Content */
.item-content {
    cursor: pointer;
}

.item-content h6 {
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.item-content small {
    color: #6c757d;
    font-size: 0.75rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.375rem;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.list-group-item:hover .action-buttons {
    opacity: 1;
}

.action-buttons .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
}

.action-buttons .btn:hover {
    transform: scale(1.1);
}

/* Loading and Empty States */
.text-center {
    color: #6c757d;
}

.text-center i {
    opacity: 0.5;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .locations-container {
        gap: 1rem;
        padding: 1rem;
    }
    
    .location-column {
        min-width: 280px;
        max-width: 320px;
    }
}

@media (max-width: 768px) {
    .locations-container {
        flex-direction: column;
        height: auto;
        gap: 1rem;
    }
    
    .location-column {
        min-width: 100%;
        max-width: 100%;
        max-height: 400px;
    }
}

/* Custom Scrollbar */
.column-body::-webkit-scrollbar,
.locations-container::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.column-body::-webkit-scrollbar-track,
.locations-container::-webkit-scrollbar-track {
    background: #f1f3f4;
    border-radius: 3px;
}

.column-body::-webkit-scrollbar-thumb,
.locations-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #cbd5e1, #94a3b8);
    border-radius: 3px;
}

.column-body::-webkit-scrollbar-thumb:hover,
.locations-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #94a3b8, #64748b);
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.loading {
    position: relative;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    const searchInputs = {
        warehouse: document.getElementById('warehouse-search'),
        zone: document.getElementById('zone-search'),
        section: document.getElementById('section-search'),
        rack: document.getElementById('rack-search'),
        slot: document.getElementById('slot-search')
    };
    
    const lists = {
        warehouses: document.getElementById('warehouses-list'),
        zones: document.getElementById('zones-list'),
        sections: document.getElementById('sections-list'),
        racks: document.getElementById('racks-list'),
        slots: document.getElementById('slots-list')
    };
    
    const addButtons = {
        zone: document.getElementById('add-zone-btn'),
        section: document.getElementById('add-section-btn'),
        rack: document.getElementById('add-rack-btn'),
        slot: document.getElementById('add-slot-btn')
    };

    // Search functionality
    function enableSearch(input, listElement) {
        if (!input || !listElement) return;
        
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = listElement.querySelectorAll('.list-group-item:not(.text-center)');
            let visibleCount = 0;
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                item.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });
            
            // Remove previous no results message
            const existingMsg = listElement.querySelector('.no-results-msg');
            if (existingMsg) existingMsg.remove();
            
            // Show no results message if needed
            if (visibleCount === 0 && items.length > 0 && searchTerm) {
                const noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-msg text-center py-3';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">{{ __('No results found for') }} "${searchTerm}"</p>
                `;
                listElement.appendChild(noResultsMsg);
            }
        });
    }

    // Initialize search for all inputs
    Object.keys(searchInputs).forEach(key => {
        enableSearch(searchInputs[key], lists[Object.keys(lists)[Object.keys(searchInputs).indexOf(key)]]);
    });

    // Utility functions
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

    function createListItem(item, type, permissions = {}) {
        const icons = {
            zone: 'fas fa-layer-group text-success',
            section: 'fas fa-th-large text-warning', 
            rack: 'fas fa-grip-vertical text-info',
            slot: 'fas fa-square text-danger'
        };
        
        return `
            <div class="list-group-item ${type}-item border-0 mb-2 rounded fade-in" data-id="${item.id}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="item-content flex-grow-1 cursor-pointer">
                        <h6 class="mb-1 fw-semibold">
                            <i class="${icons[type]} me-2"></i>${item.name}
                        </h6>
                        ${item.description ? `<small class="text-muted">${item.description}</small>` : ''}
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-info view-btn" title="{{ __('View') }}" data-id="${item.id}" data-type="${type}">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${permissions.edit ? `
                            <button class="btn btn-sm btn-outline-warning edit-btn" title="{{ __('Edit') }}" data-id="item.id}" data-type="${type}">
                                <i class="fas fa-edit"></i>
                            </button>
                        ` : ''}
                        ${permissions.delete ? `
                            <button class="btn btn-sm btn-outline-danger delete-btn" title="{{ __('Delete') }}" data-id="${item.id}" data-type="${type}">
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

    function resetSubsequentLists(fromIndex) {
        const listArray = Object.values(lists);
        const buttonArray = Object.values(addButtons);
        const messages = [
            '', // warehouses (not reset)
            '{{ __('Select a warehouse to see its zones') }}',
            '{{ __('Select a zone to see its sections') }}',
            '{{ __('Select a section to see its racks') }}',
            '{{ __('Select a rack to see its slots') }}'
        ];
        const icons = [
            '',
            'fas fa-layer-group',
            'fas fa-th-large', 
            'fas fa-grip-vertical',
            'fas fa-square'
        ];
        
        for (let i = fromIndex; i < listArray.length; i++) {
            if (messages[i]) {
                showEmpty(listArray[i], messages[i], icons[i]);
            }
        }
        
        // Hide subsequent add buttons
        for (let i = fromIndex - 1; i < buttonArray.length; i++) {
            if (buttonArray[i]) {
                buttonArray[i].classList.add('d-none');
            }
        }
    }

    // Warehouse selection
    lists.warehouses.addEventListener('click', async function(e) {
        const item = e.target.closest('.warehouse-item');
        if (!item || e.target.closest('.action-buttons')) return;

        updateActiveState(this, item);
        resetSubsequentLists(1);
        
        const warehouseId = item.dataset.id;
        
        // Show add zone button
        if (addButtons.zone) {
            addButtons.zone.classList.remove('d-none');
            addButtons.zone.dataset.warehouseId = warehouseId;
        }

        showLoading(lists.zones, '{{ __('Loading zones...') }}');

        try {
            const response = await fetch(`/api/warehouses/${warehouseId}/zones`);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const zones = await response.json();

            if (zones.length === 0) {
                showEmpty(lists.zones, '{{ __('No zones found') }}', 'fas fa-layer-group');
                return;
            }

            lists.zones.innerHTML = zones.map(zone => 
                createListItem(zone, 'zone', {
                    edit: @json(auth()->user()->can('edit-zone')),
                    delete: @json(auth()->user()->can('delete-zone'))
                })
            ).join('');
            
        } catch (error) {
            console.error('Error fetching zones:', error);
            showError(lists.zones, '{{ __('Error loading zones') }}');
        }
    });

    // Zone selection
    lists.zones.addEventListener('click', async function(e) {
        const item = e.target.closest('.zone-item');
        if (!item || e.target.closest('.action-buttons')) return;

        updateActiveState(this, item);
        resetSubsequentLists(2);
        
        const zoneId = item.dataset.id;
        
        // Show add section button
        if (addButtons.section) {
            addButtons.section.classList.remove('d-none');
            addButtons.section.dataset.zoneId = zoneId;
        }

        showLoading(lists.sections, '{{ __('Loading sections...') }}');

        try {
            const response = await fetch(`/api/zones/${zoneId}/sections`);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const sections = await response.json();

            if (sections.length === 0) {
                showEmpty(lists.sections, '{{ __('No sections found') }}', 'fas fa-th-large');
                return;
            }

            lists.sections.innerHTML = sections.map(section => 
                createListItem(section, 'section', {
                    edit: @json(auth()->user()->can('edit-section')),
                    delete: @json(auth()->user()->can('delete-section'))
                })
            ).join('');
            
        } catch (error) {
            console.error('Error fetching sections:', error);
            showError(lists.sections, '{{ __('Error loading sections') }}');
        }
    });

    // Section selection
    lists.sections.addEventListener('click', async function(e) {
        const item = e.target.closest('.section-item');
        if (!item || e.target.closest('.action-buttons')) return;

        updateActiveState(this, item);
        resetSubsequentLists(3);
        
        const sectionId = item.dataset.id;
        
        // Show add rack button
        if (addButtons.rack) {
            addButtons.rack.classList.remove('d-none');
            addButtons.rack.dataset.sectionId = sectionId;
        }

        showLoading(lists.racks, '{{ __('Loading racks...') }}');

        try {
            const response = await fetch(`/api/sections/${sectionId}/racks`);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const racks = await response.json();

            if (racks.length === 0) {
                showEmpty(lists.racks, '{{ __('No racks found') }}', 'fas fa-grip-vertical');
                return;
            }

            lists.racks.innerHTML = racks.map(rack => 
                createListItem(rack, 'rack', {
                    edit: @json(auth()->user()->can('edit-rack')),
                    delete: @json(auth()->user()->can('delete-rack'))
                })
            ).join('');
            
        } catch (error) {
            console.error('Error fetching racks:', error);
            showError(lists.racks, '{{ __('Error loading racks') }}');
        }
    });

    // Rack selection
    lists.racks.addEventListener('click', async function(e) {
        const item = e.target.closest('.rack-item');
        if (!item || e.target.closest('.action-buttons')) return;

        updateActiveState(this, item);
        
        const rackId = item.dataset.id;
        
        // Show add slot button
        if (addButtons.slot) {
            addButtons.slot.classList.remove('d-none');
            addButtons.slot.dataset.rackId = rackId;
        }

        showLoading(lists.slots, '{{ __('Loading slots...') }}');

        try {
            const response = await fetch(`/api/racks/${rackId}/slots`);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const slots = await response.json();

            if (slots.length === 0) {
                showEmpty(lists.slots, '{{ __('No slots found') }}', 'fas fa-square');
                return;
            }

            lists.slots.innerHTML = slots.map(slot => 
                createListItem(slot, 'slot', {
                    edit: @json(auth()->user()->can('edit-slot')),
                    delete: @json(auth()->user()->can('delete-slot'))
                })
            ).join('');
            
        } catch (error) {
            console.error('Error fetching slots:', error);
            showError(lists.slots, '{{ __('Error loading slots') }}');
        }
    });

    // Add button handlers
    Object.keys(addButtons).forEach(key => {
        const button = addButtons[key];
        if (!button) return;
        
        button.addEventListener('click', function() {
            const routes = {
                zone: `/warehouses/${this.dataset.warehouseId}/zones/create`,
                section: `/zones/${this.dataset.zoneId}/sections/create`,
                rack: `/sections/${this.dataset.sectionId}/racks/create`,
                slot: `/racks/${this.dataset.rackId}/slots/create`
            };
            
            if (routes[key]) {
                window.location.href = routes[key];
            }
        });
    });

    // Add warehouse button handler
    const addWarehouseBtn = document.getElementById('add-warehouse-btn');
    if (addWarehouseBtn) {
        addWarehouseBtn.addEventListener('click', function() {
            window.location.href = '{{ route('warehouses.create') }}';
        });
    }

    // Action handlers
    function handleView(id, type) {
        const routes = {
            'zone': `/zones/${id}`,
            'section': `/sections/${id}`,
            'rack': `/racks/${id}`,
            'slot': `/slots/${id}`
        };
        
        if (routes[type]) {
            window.location.href = routes[type];
        }
    }
    
    function handleEdit(id, type) {
        const routes = {
            'zone': `/zones/${id}/edit`,
            'section': `/sections/${id}/edit`,
            'rack': `/racks/${id}/edit`,
            'slot': `/slots/${id}/edit`
        };
        
        if (routes[type]) {
            window.location.href = routes[type];
        }
    }
    
    function handleDelete(id, type) {
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
                    const routes = {
                        'zone': `/zones/${id}`,
                        'section': `/sections/${id}`,
                        'rack': `/racks/${id}`,
                        'slot': `/slots/${id}`
                    };
                    
                    if (routes[type]) {
                        // Create and submit delete form
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = routes[type];
                        
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
                }
            });
        } else {
            if (confirm('{{ __('Are you sure you want to delete this item?') }}')) {
                // Handle delete without SweetAlert
            }
        }
    }

    // Event listeners for action buttons
    document.addEventListener('click', function(e) {
        // Handle action buttons
        if (e.target.closest('.view-btn')) {
            const btn = e.target.closest('.view-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            handleView(id, type);
        }
        
        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            handleEdit(id, type);
        }
        
        if (e.target.closest('.delete-btn') && !e.target.closest('form')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            handleDelete(id, type);
        }
    });

    // Delete confirmation handler for existing warehouse forms
    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-btn');
        if (!deleteBtn || !deleteBtn.closest('form')) return;
        
        e.preventDefault();
        const form = deleteBtn.closest('form');
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: '{{ __('You will not be able to recover this item!') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Yes, delete it!') }}',
                cancelButtonText: '{{ __('Cancel') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            if (confirm('{{ __('Are you sure you want to delete this item?') }}')) {
                form.submit();
            }
        }
    });

    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
@endpush
