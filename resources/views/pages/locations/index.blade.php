@extends('../layouts.app')

@section('title', __('Locations Management'))

@push('styles')
    <style>
        /* --- التنسيقات تبقى كما هي --- */
        .locations-container {
            display: flex;
            gap: 1rem;
            height: 75vh;
        }

        .location-column {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .column-header {
            padding: 0.75rem 1rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            flex-shrink: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .column-body {
            overflow-y: auto;
            flex-grow: 1;
        }

        .column-search {
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .location-column .list-group-item {
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .location-column .list-group-item.active {
            background-color: rgb(36, 105, 92);
            border-color: rgb(36, 105, 92);
        }

        .location-column .list-group-item.active .btn {
            border-color: white;
            color: white;
        }

        .location-column .list-group-item .btn {
            visibility: hidden;
        }

        .location-column .list-group-item:hover .btn,
        .location-column .list-group-item.active .btn {
            visibility: visible;
        }

        .edit-icon-btn {
            background: none;
            border: none;
            padding: 0.2rem 0.5rem;
        }

        /* لإظهار رسائل الخطأ بشكل صحيح */
        .form-control.is-invalid~.invalid-feedback {
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Locations Management') }}</h5>
            </div>
            <div class="card-body">
                <div class="locations-container">
                    <div id="countries-column" class="location-column">
                        <div class="column-header">
                            <span>{{ __('Countries') }}</span>
                            @can('create-country')
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#locationModal" data-action="create-country"
                                    data-title="{{ __('Add New Country') }}" data-url="{{ route('countries.store') }}">
                                    <i class="fa fa-plus"></i>
                                </button>
                            @endcan
                        </div>
                        <div class="column-search">
                            <input type="text" class="form-control form-control-sm" id="country-search"
                                placeholder="{{ __('Search...') }}">
                        </div>
                        <div class="column-body list-group list-group-flush">
                            @foreach ($countries as $country)
                                <a href="#" class="list-group-item country-item" data-id="{{ $country->id }}">
                                    <span> <i class="flag-icon flag-icon-{{ strtolower($country->iso_code) }}"></i>
                                        {{ $country->name }}</span>
                                    @can('edit-country')
                                        <button class="btn btn-sm btn-outline-secondary edit-icon-btn"
                                            data-edit-url="{{ route('countries.edit', $country->id) }}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    @endcan
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div id="states-column" class="location-column">
                        <div class="column-header">
                            <span>{{ __('States') }}</span>
                            @can('create-state')
                                <button type="button" id="add-state-btn" class="btn btn-sm btn-primary d-none"
                                    data-bs-toggle="modal" data-bs-target="#locationModal" data-action="create-state"
                                    data-title="{{ __('Add New State') }}" data-url="{{ route('states.store') }}">
                                    <i class="fa fa-plus"></i>
                                </button>
                            @endcan
                        </div>
                        <div class="column-search">
                            <input type="text" class="form-control form-control-sm" id="state-search"
                                placeholder="{{ __('Search...') }}">
                        </div>
                        <div id="states-list" class="column-body list-group list-group-flush">
                            <p class="text-muted p-3">{{ __('Select a country to see its states.') }}</p>
                        </div>
                    </div>

                    <div id="cities-column" class="location-column">
                        <div class="column-header">
                            <span>{{ __('Cities') }}</span>
                            @can('create-city')
                                <button type="button" id="add-city-btn" class="btn btn-sm btn-primary d-none"
                                    data-bs-toggle="modal" data-bs-target="#locationModal" data-action="create-city"
                                    data-title="{{ __('Add New City') }}" data-url="{{ route('cities.store') }}">
                                    <i class="fa fa-plus"></i>
                                </button>
                            @endcan
                        </div>
                        <div class="column-search">
                            <input type="text" class="form-control form-control-sm" id="city-search"
                                placeholder="{{ __('Search...') }}">
                        </div>
                        <div id="cities-list" class="column-body list-group list-group-flush">
                            <p class="text-muted p-3">{{ __('Select a state to see its cities.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('plus-code')
    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // تمرير الصلاحيات للتحقق من جهة العميل
        window.userPermissions = {
            canCreateStates: @json(optional(auth()->user())->can('create-state')),
            canEditStates: @json(optional(auth()->user())->can('edit-state')),
            canCreateCities: @json(optional(auth()->user())->can('create-city')),
            canEditCities: @json(optional(auth()->user())->can('edit-city'))
        };

        document.addEventListener('DOMContentLoaded', function() {
            const locationModalElement = document.getElementById('locationModal');
            const locationModal = new bootstrap.Modal(locationModalElement);

            const countriesColumn = document.getElementById('countries-column');
            const statesColumn = document.getElementById('states-column');
            const citiesColumn = document.getElementById('cities-column');

            const statesList = document.getElementById('states-list');
            const citiesList = document.getElementById('cities-list');

            const addStateBtn = document.getElementById('add-state-btn');
            const addCityBtn = document.getElementById('add-city-btn');

            const countrySearch = document.getElementById('country-search');
            const stateSearch = document.getElementById('state-search');
            const citySearch = document.getElementById('city-search');

            // --- دوال البحث ---
            const filterList = (input, listContainer) => {
                const filter = input.value.toUpperCase();
                const items = listContainer.querySelectorAll('.list-group-item');
                for (let i = 0; i < items.length; i++) {
                    const txtValue = items[i].textContent || items[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        items[i].style.display = "";
                    } else {
                        items[i].style.display = "none";
                    }
                }
            };

            countrySearch.addEventListener('keyup', () => filterList(countrySearch, countriesColumn.querySelector(
                '.column-body')));
            stateSearch.addEventListener('keyup', () => filterList(stateSearch, statesList));
            citySearch.addEventListener('keyup', () => filterList(citySearch, citiesList));

            // --- تفويض الأحداث للنقرات على القوائم ---
            countriesColumn.addEventListener('click', function(event) {
                const item = event.target.closest('.country-item');
                if (!item) return;

                if (event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    event.stopPropagation();
                    // فتح النافذة المنبثقة للتعديل
                    const editBtn = event.target.closest('.edit-icon-btn');
                    const countryId = item.dataset.id;
                    const countryName = item.querySelector('span').textContent.trim();
                    openEditModal('edit-country', 'تعديل الدولة', editBtn.dataset.editUrl, {
                        id: countryId,
                        name: countryName
                    });
                    return;
                }

                event.preventDefault();
                countriesColumn.querySelectorAll('.country-item').forEach(el => el.classList.remove(
                    'active'));
                item.classList.add('active');

                if (addStateBtn && window.userPermissions.canCreateStates) {
                    addStateBtn.classList.remove('d-none');
                    addStateBtn.dataset.countryId = item.dataset.id;
                }

                fetchStates(item.dataset.id);
            });

            citiesColumn.addEventListener('click', function(event) {
                const item = event.target.closest('.city-item');
                if (!item) return;

                if (event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    window.location.href = event.target.closest('.edit-icon-btn').dataset.editUrl;
                    return;
                }

                event.preventDefault();
                citiesColumn.querySelectorAll('.city-item').forEach(el => el.classList.remove('active'));
                item.classList.add('active');
            });

            statesColumn.addEventListener('click', function(event) {
                const item = event.target.closest('.state-item');
                if (!item) return;

                if (event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    window.location.href = event.target.closest('.edit-icon-btn').dataset.editUrl;
                    return;
                }

                event.preventDefault();
                statesColumn.querySelectorAll('.state-item').forEach(el => el.classList.remove('active'));
                item.classList.add('active');

                if (addCityBtn && window.userPermissions.canCreateCities) {
                    addCityBtn.classList.remove('d-none');
                    addCityBtn.dataset.stateId = item.dataset.id;
                }

                fetchCities(item.dataset.id);
            });

            // --- التعامل مع فتح الـ Modal ---
            locationModalElement.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const action = button.dataset.action;
                const title = button.dataset.title;
                const url = button.dataset.url;

                const modalTitle = locationModalElement.querySelector('.modal-title');
                const modalBody = locationModalElement.querySelector('.modal-body');
                modalTitle.textContent = title;

                // بناء الفورم ديناميًا
                let formContent = `<form id="locationForm" action="${url}" method="POST" novalidate>`;
                
                if (action === 'create-country') {
                    formContent += `<div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="name">{{ __('Country Name') }}</label>
                                                <input class="form-control" type="text" id="name" name="name" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="iso_code">{{ __('Country Code (2 characters)') }}</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="iso_code" name="iso_code" maxlength="2" required>
                                                    <span class="input-group-text" id="flag-display" style="min-width: 60px; justify-content: center;">
                                                        <img id="country-flag" src="" alt="" style="width: 32px; height: 24px; display: none; border-radius: 3px;">
                                                        <span id="flag-placeholder" class="text-muted">🏳️</span>
                                                    </span>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>`;
                } else {
                     formContent += `<div class="mb-3">
                                      <label for="name" class="form-label">${action === 'create-state' ? '{{ __('State Name') }}' : '{{ __('City Name') }}'}</label>
                                      <input type="text" class="form-control" name="name" id="name" required>
                                      <div class="invalid-feedback"></div>
                                    </div>`;
                }

                if (action === 'create-state') {
                    formContent +=
                        `<input type="hidden" name="country_id" value="${button.dataset.countryId}">`;
                }
                if (action === 'create-city') {
                    formContent +=
                        `<input type="hidden" name="state_id" value="${button.dataset.stateId}">`;
                }

                formContent += `<div class="modal-footer d-flex justify-content-end">
                                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                  <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div></form>`;

                modalBody.innerHTML = formContent;

                // إضافة وظيفة عرض أيقونة العلم للدول
                if (action === 'create-country') {
                    const isoCodeInput = document.getElementById('iso_code');
                    const countryFlag = document.getElementById('country-flag');
                    const flagPlaceholder = document.getElementById('flag-placeholder');
                    
                    // Function to update flag display
                    function updateFlag(isoCode) {
                        if (isoCode && isoCode.length >= 2) {
                            const flagUrl = `https://flagcdn.com/32x24/${isoCode.toLowerCase()}.png`;
                            
                            // Test if flag exists
                            const img = new Image();
                            img.onload = function() {
                                countryFlag.src = flagUrl;
                                countryFlag.alt = `${isoCode.toUpperCase()} Flag`;
                                countryFlag.style.display = 'block';
                                flagPlaceholder.style.display = 'none';
                            };
                            img.onerror = function() {
                                countryFlag.style.display = 'none';
                                flagPlaceholder.style.display = 'block';
                            };
                            img.src = flagUrl;
                        } else {
                            countryFlag.style.display = 'none';
                            flagPlaceholder.style.display = 'block';
                        }
                    }
                    
                    // Update flag on input
                    isoCodeInput.addEventListener('input', function() {
                        const value = this.value.trim();
                        updateFlag(value);
                    });
                    
                    // Initial load
                    updateFlag(isoCodeInput.value);
                }

                // التعامل مع إرسال الفورم
                const form = modalBody.querySelector('#locationForm');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    handleFormSubmission(form, action);
                });
            });

            // --- دالة معالجة إرسال الفورم ---
            function handleFormSubmission(form, action) {
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML =
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Saving...') }}`;

                // إزالة رسائل الخطأ القديمة
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        addNewItemToList(action, data);
                        locationModal.hide();
                    })
                    .catch(error => {
                        if (error.errors) {
                            Object.keys(error.errors).forEach(key => {
                                const input = form.querySelector(`[name="${key}"]`);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    const feedback = input.parentElement.querySelector(
                                        '.invalid-feedback');
                                    if (feedback) feedback.textContent = error.errors[key][0];
                                }
                            });
                        } else {
                            console.error('Error:', error);
                            alert('An unexpected error occurred. Please check the console.');
                        }
                    })
                    .finally(() => {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                    });
            }

            // --- دالة إضافة العنصر الجديد للقائمة ---
            function addNewItemToList(action, item) {
                let listContainer, itemClass, itemContent;

                if (action === 'create-country') {
                    listContainer = countriesColumn.querySelector('.column-body');
                    itemClass = 'country-item';
                    itemContent =
                        `<span> <i class="flag-icon flag-icon-${item.iso_code.toLowerCase()}"></i> ${item.name}</span>`;
                } else if (action === 'create-state') {
                    listContainer = statesList;
                    itemClass = 'state-item';
                    itemContent = `<span>${item.name}</span>`;
                } else { // create-city
                    listContainer = citiesList;
                    itemClass = 'city-item';
                    itemContent = `<span>${item.name}</span>`;
                }

                const placeholder = listContainer.querySelector('p.text-muted');
                if (placeholder) placeholder.remove();

                const newItemElement = document.createElement('a');
                newItemElement.href = '#';
                newItemElement.className = `list-group-item ${itemClass}`;
                newItemElement.dataset.id = item.id;
                newItemElement.innerHTML = itemContent; // لا يحتوي على زر التعديل الآن، يمكن إضافته

                listContainer.appendChild(newItemElement);
            }

            // --- دوال جلب البيانات ---
            function fetchStates(countryId) {
                citiesList.innerHTML =
                    `<p class="text-muted p-3">{{ __('Select a state to see its cities.') }}</p>`;
                if (addCityBtn) addCityBtn.classList.add('d-none');
                statesList.innerHTML =
                    `<div class="d-flex justify-content-center p-3"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __('Loading...') }}</span></div></div>`;

                const url = `{{ url('/api/countries') }}/${countryId}/states`;
                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        statesList.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(state => {
                                // الجزء الجديد لإضافة زر التعديل
                                let editButtonHtml = '';
                                if (window.userPermissions.canEditStates) {
                                    const editUrl = `{{ url('states') }}/${state.id}/edit`;
                                    editButtonHtml = `<button class="btn btn-sm btn-outline-secondary edit-icon-btn" data-edit-url="${editUrl}">
                              <i class="fa fa-pencil"></i>
                          </button>`;
                                }

                                statesList.innerHTML += `<a href="#" class="list-group-item state-item" data-id="${state.id}">
                                <span>${state.name}</span>
                                ${editButtonHtml}
                             </a>`;
                            });
                        } else {
                            statesList.innerHTML =
                                `<p class="text-muted p-3">{{ __('No states found for this country.') }}</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching states:', error);
                        statesList.innerHTML =
                            `<p class="text-danger p-3">{{ __('Failed to load states.') }}</p>`;
                    });
            }

            function fetchCities(stateId) {
                citiesList.innerHTML =
                    `<div class="d-flex justify-content-center p-3"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __('Loading...') }}</span></div></div>`;
                const url = `{{ url('/api/states') }}/${stateId}/cities`;
                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        citiesList.innerHTML = '';
                        if (data.length > 0) {
                            // ...
                            data.forEach(city => {
                                // الجزء الجديد لإضافة زر التعديل
                                let editButtonHtml = '';
                                if (window.userPermissions.canEditCities) {
                                    const editUrl = `{{ url('cities') }}/${city.id}/edit`;
                                    editButtonHtml = `<button class="btn btn-sm btn-outline-secondary edit-icon-btn" data-edit-url="${editUrl}">
                              <i class="fa fa-pencil"></i>
                          </button>`;
                                }

                                citiesList.innerHTML += `<a href="#" class="list-group-item city-item" data-id="${city.id}">
                                <span>${city.name}</span>
                                ${editButtonHtml}
                             </a>`;
                            });

                        } else {
                            citiesList.innerHTML =
                                `<p class="text-muted p-3">{{ __('No cities found for this state.') }}</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                        citiesList.innerHTML =
                            `<p class="text-danger p-3">{{ __('Failed to load cities.') }}</p>`;
                    });
            }
        });
    </script>
@endpush
