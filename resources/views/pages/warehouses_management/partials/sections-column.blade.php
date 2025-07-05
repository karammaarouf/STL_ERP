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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables for sections
    const sectionSearchInput = document.getElementById('section-search');
    const sectionsList = document.getElementById('sections-list');
    const addSectionBtn = document.getElementById('add-section-btn');

    // Search functionality for sections
    function enableSectionSearch() {
        if (!sectionSearchInput || !sectionsList) return;

        sectionSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = sectionsList.querySelectorAll('.list-group-item:not(.text-center)');
            let visibleCount = 0;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                item.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            // Remove previous no results message
            const existingMsg = sectionsList.querySelector('.no-results-msg');
            if (existingMsg) existingMsg.remove();

            // Show no results message if needed
            if (visibleCount === 0 && items.length > 0 && searchTerm) {
                const noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-msg text-center py-3';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">{{ __('No results found for') }} "${searchTerm}"</p>
                `;
                sectionsList.appendChild(noResultsMsg);
            }
        });
    }

    // Initialize search
    enableSectionSearch();

    // Utility functions
    function showLoading(message = '{{ __('Loading...') }}') {
        sectionsList.innerHTML = `
            <div class="text-center py-4 loading">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status">
                    <span class="visually-hidden">${message}</span>
                </div>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showEmpty(message, icon = 'fas fa-th-large') {
        sectionsList.innerHTML = `
            <div class="text-center py-4">
                <i class="${icon} fa-2x text-muted mb-2"></i>
                <p class="text-muted small mb-0">${message}</p>
            </div>
        `;
    }

    function showError(message = '{{ __('Error loading data') }}') {
        sectionsList.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                <p class="text-warning small mb-0">${message}</p>
            </div>
        `;
    }

    function createSectionListItem(section) {
        return `
            <div class="list-group-item section-item border-0 mb-2 rounded fade-in" data-id="${section.id}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="item-content flex-grow-1 cursor-pointer">
                        <h6 class="mb-1 fw-semibold">
                            <i class="fas fa-th-large text-warning me-2"></i>${section.name}
                        </h6>
                        ${section.description ? `<small class="text-muted">${section.description}</small>` : ''}
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-info view-btn" title="{{ __('View') }}" data-id="${section.id}" data-type="section">
                            <i class="fas fa-eye"></i>
                        </button>
                        @can('edit-warehouse-section')
                        <button class="btn btn-sm btn-outline-warning edit-btn" title="{{ __('Edit') }}" data-id="${section.id}" data-type="section">
                            <i class="fas fa-edit"></i>
                        </button>
                        @endcan
                        @can('delete-warehouse-section')
                        <button class="btn btn-sm btn-outline-danger delete-btn" title="{{ __('Delete') }}" data-id="${section.id}" data-type="section">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endcan
                    </div>
                </div>
            </div>
        `;
    }

    function updateActiveState(activeItem) {
        sectionsList.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        if (activeItem) {
            activeItem.classList.add('active');
        }
    }

    // Section selection handler
    sectionsList.addEventListener('click', async function(e) {
        const item = e.target.closest('.section-item');
        if (!item || e.target.closest('.action-buttons')) return;

        updateActiveState(item);
        
        const sectionId = item.dataset.id;
        
        // Trigger custom event for other components to listen
        const sectionSelectedEvent = new CustomEvent('sectionSelected', {
            detail: { sectionId: sectionId }
        });
        document.dispatchEvent(sectionSelectedEvent);
    });

    // Add section button handler
    if (addSectionBtn) {
        addSectionBtn.addEventListener('click', function() {
            const zoneId = this.dataset.zoneId;
            if (zoneId) {
                window.location.href = `/zones/${zoneId}/sections/create`;
            }
        });
    }

    // Action handlers for sections
    function handleSectionView(id) {
        window.location.href = `/sections/${id}`;
    }

    function handleSectionEdit(id) {
        window.location.href = `/sections/${id}/edit`;
    }

    function handleSectionDelete(id) {
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
                    form.action = `/sections/${id}`;

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
            if (confirm('{{ __('Are you sure you want to delete this item?') }}')) {
                // Handle delete without SweetAlert
            }
        }
    }

    // Event listeners for section action buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-btn')) {
            const btn = e.target.closest('.view-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'section') {
                handleSectionView(id);
            }
        }

        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'section') {
                handleSectionEdit(id);
            }
        }

        if (e.target.closest('.delete-btn') && !e.target.closest('form')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            if (type === 'section') {
                handleSectionDelete(id);
            }
        }
    });

    // Listen for zone selection to load sections
    document.addEventListener('zoneSelected', async function(e) {
        const zoneId = e.detail.zoneId;
        
        // Show add section button
        if (addSectionBtn) {
            addSectionBtn.classList.remove('d-none');
            addSectionBtn.dataset.zoneId = zoneId;
        }

        showLoading('{{ __('Loading sections...') }}');

        try {
            const response = await fetch(`/api/zones/${zoneId}/sections`);
            if (!response.ok) throw new Error('Network response was not ok');

            const sections = await response.json();

            if (sections.length === 0) {
                showEmpty('{{ __('No sections found') }}', 'fas fa-th-large');
                return;
            }

            sectionsList.innerHTML = sections.map(section => createSectionListItem(section)).join('');

        } catch (error) {
            console.error('Error fetching sections:', error);
            showError('{{ __('Error loading sections') }}');
        }
    });

    // Reset sections when warehouse changes
    document.addEventListener('warehouseSelected', function() {
        showEmpty('{{ __('Select a zone to see its sections') }}', 'fas fa-th-large');
        if (addSectionBtn) {
            addSectionBtn.classList.add('d-none');
        }
    });

    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
@endpush