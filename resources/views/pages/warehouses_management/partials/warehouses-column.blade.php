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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Warehouse-specific functionality
    const warehouseSearch = document.getElementById('warehouse-search');
    const warehousesList = document.getElementById('warehouses-list');
    const addWarehouseBtn = document.getElementById('add-warehouse-btn');
    
    // Search functionality for warehouses
    if (warehouseSearch && warehousesList) {
        warehouseSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = warehousesList.querySelectorAll('.list-group-item:not(.text-center)');
            let visibleCount = 0;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                item.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            // Remove previous no results message
            const existingMsg = warehousesList.querySelector('.no-results-msg');
            if (existingMsg) existingMsg.remove();

            // Show no results message if needed
            if (visibleCount === 0 && items.length > 0 && searchTerm) {
                const noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-msg text-center py-3';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">{{ __('No results found for') }} "${searchTerm}"</p>
                `;
                warehousesList.appendChild(noResultsMsg);
            }
        });
    }
    
    // Add warehouse button handler
    if (addWarehouseBtn) {
        addWarehouseBtn.addEventListener('click', function() {
            window.location.href = '{{ route('warehouses.create') }}';
        });
    }
    
    // Delete confirmation handler for warehouse forms
    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-btn');
        if (!deleteBtn || !deleteBtn.closest('form')) return;
        
        // Only handle warehouse delete buttons in this partial
        if (!deleteBtn.closest('#warehouses-list')) return;

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
});
</script>
@endpush