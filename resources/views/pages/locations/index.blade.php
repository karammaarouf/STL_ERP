@extends('../layouts.app')

@section('title', __('Locations Management'))

@push('styles')
    <style>
        /* CSS الخاص بك لم يتغير */
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
            color: white;
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
                    {{-- Countries Column --}}
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
                                    <span class="item-name">
                                        <i class="flag-icon flag-icon-{{ strtolower($country->iso_code) }}"></i>
                                        {{ $country->name }}
                                    </span>
                                    @can('edit-country')
                                        <button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn"
                                            data-bs-toggle="modal" data-bs-target="#locationModal" data-action="edit-country"
                                            data-title="{{ __('Edit Country') }}"
                                            data-url="{{ route('countries.update', $country->id) }}"
                                            data-fetch-url="{{ route('countries.edit', $country->id) }}"
                                            data-id="{{ $country->id }}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    @endcan
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- States Column --}}
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

                    {{-- Cities Column --}}
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
    {{-- Reusable Modal for Add/Edit --}}
    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Content will be loaded via JavaScript --}}
                    <div class="d-flex justify-content-center p-5">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- تم التعليق على هذا السطر لأنه لن يستخدم في هذا السياق بعد الآن --}}
    {{-- <script src="{{ asset('assets/js/sweet-alert/app.js') }}"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- العناصر وحالة المودال ---
            const locationModalElement = document.getElementById('locationModal');
            const locationModal = new bootstrap.Modal(locationModalElement);
            const lists = {
                country: document.querySelector('#countries-column .column-body'),
                state: document.getElementById('states-list'),
                city: document.getElementById('cities-list'),
            };
            const addButtons = {
                state: document.getElementById('add-state-btn'),
                city: document.getElementById('add-city-btn'),
            };
            const searchInputs = {
                country: document.getElementById('country-search'),
                state: document.getElementById('state-search'),
                city: document.getElementById('city-search'),
            };
            const userPermissions = {
                canCreateState: @json(auth()->user()->can('create-state')),
                canEditState: @json(auth()->user()->can('edit-state')),
                canCreateCity: @json(auth()->user()->can('create-city')),
                canEditCity: @json(auth()->user()->can('edit-city')),
                canDeleteCountry: @json(auth()->user()->can('delete-country')),
                canDeleteState: @json(auth()->user()->can('delete-state')),
                canDeleteCity: @json(auth()->user()->can('delete-city')),
            };

            // قم بتمرير الرموز المميزة لـ CSRF إلى JavaScript
            const csrfToken = '{{ csrf_token() }}';

            // تحديد مسارات API الأساسية لتجنب URLS المشفرة
            const apiBaseUrls = {
                countries: '{{ url('/api/countries') }}',
                states: '{{ url('/api/states') }}',
                cities: '{{ url('/api/cities') }}',
            };

            // --- وظيفة مساعدة: البحث/تصفية القائمة ---
            const filterList = (input, listContainer) => {
                const filter = input.value.toUpperCase();
                const items = listContainer.querySelectorAll('.list-group-item');
                items.forEach(item => {
                    const txtValue = item.querySelector('.item-name')?.textContent || item.textContent;
                    item.style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                });
            };

            // ربط حقول البحث
            Object.keys(searchInputs).forEach(key => {
                if (searchInputs[key]) {
                    searchInputs[key].addEventListener('keyup', () => filterList(searchInputs[key], lists[
                        key]));
                }
            });

            // --- النقر على الأعمدة الرئيسية (لاختيار العنصر) ---
            lists.country.addEventListener('click', function(event) {
                const item = event.target.closest('.country-item');
                if (item && !event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    // إزالة التحديد من جميع عناصر الدولة والمدينة
                    document.querySelectorAll('.country-item.active').forEach(el => el.classList.remove(
                        'active'));
                    document.querySelectorAll('.state-item.active').forEach(el => el.classList.remove(
                        'active'));
                    document.querySelectorAll('.city-item.active').forEach(el => el.classList.remove(
                        'active'));

                    item.classList.add('active');

                    // إظهار زر "إضافة ولاية" إذا كان المستخدم لديه الإذن
                    if (addButtons.state && userPermissions.canCreateState) {
                        addButtons.state.classList.remove('d-none');
                        addButtons.state.dataset.countryId = item.dataset.id;
                    } else {
                        addButtons.state.classList.add('d-none'); // إخفاء الزر إذا لم يكن لديه إذن
                    }
                    addButtons.city.classList.add('d-none'); // إخفاء زر "إضافة مدينة" عند تغيير الدولة

                    // مسح حقول البحث في الأعمدة التالية
                    searchInputs.state.value = '';
                    searchInputs.city.value = '';

                    fetchStates(item.dataset.id);
                }
            });

            lists.state.addEventListener('click', function(event) {
                const item = event.target.closest('.state-item');
                if (item && !event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    // إزالة التحديد من جميع عناصر الولاية والمدينة
                    document.querySelectorAll('.state-item.active').forEach(el => el.classList.remove(
                        'active'));
                    document.querySelectorAll('.city-item.active').forEach(el => el.classList.remove(
                        'active'));

                    item.classList.add('active');

                    // إظهار زر "إضافة مدينة" إذا كان المستخدم لديه الإذن
                    if (addButtons.city && userPermissions.canCreateCity) {
                        addButtons.city.classList.remove('d-none');
                        addButtons.city.dataset.stateId = item.dataset.id;
                    } else {
                        addButtons.city.classList.add('d-none'); // إخفاء الزر إذا لم يكن لديه إذن
                    }

                    // مسح حقل البحث في عمود المدن
                    searchInputs.city.value = '';

                    fetchCities(item.dataset.id);
                }
            });

            lists.city.addEventListener('click', function(event) {
                const item = event.target.closest('.city-item');
                if (item && !event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    // إزالة التحديد من جميع عناصر المدينة
                    document.querySelectorAll('.city-item.active').forEach(el => el.classList.remove(
                        'active'));
                    item.classList.add('active');
                }
            });

            // --- معالج حدث المودال ---
            locationModalElement.addEventListener('show.bs.modal', async function(event) {
                const button = event.relatedTarget;
                const action = button.dataset.action;
                const modalTitle = locationModalElement.querySelector('.modal-title');
                const modalBody = locationModalElement.querySelector('.modal-body');

                modalTitle.textContent = button.dataset.title;
                modalBody.innerHTML =
                    `<div class="d-flex justify-content-center p-5"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __('Loading...') }}</span></div></div>`;

                let model = {};

                if (action.startsWith('edit')) {
                    try {
                        const response = await fetch(button.dataset.fetchUrl, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });
                        if (!response.ok) throw new Error('Failed to fetch data for editing.');
                        const responseData = await response.json();
                        model = responseData.model || responseData;
                    } catch (error) {
                        modalBody.innerHTML = `<p class="text-danger p-3">${error.message}</p>`;
                        return;
                    }
                }

                modalBody.innerHTML = generateFormContent(action, button, model);

                if (action.endsWith('country')) {
                    setupFlagUpdater(modalBody);
                }

                const form = modalBody.querySelector('#locationForm');
                if (form) {
                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        handleFormSubmission(form, action);
                    });
                }

                const deleteBtn = modalBody.querySelector('#deleteBtn');
                if (deleteBtn) {
                    // ربط حدث النقر بزر الحذف
                    deleteBtn.addEventListener('click', function() {
                        const deleteUrl = button.dataset.url;
                        const itemType = action.split('-')[1];
                        const itemId = button.dataset.id;
                        let permissionCheck = false;

                        if (itemType === 'country' && userPermissions.canDeleteCountry)
                            permissionCheck = true;
                        else if (itemType === 'state' && userPermissions.canDeleteState)
                            permissionCheck = true;
                        else if (itemType === 'city' && userPermissions.canDeleteCity)
                            permissionCheck = true;

                        if (permissionCheck) {
                            showDeleteConfirmation(deleteUrl, itemType, itemId);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('Permission Denied!') }}',
                                text: '{{ __('You do not have permission to delete this item.') }}',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });

            // --- وظيفة مساعدة: إنشاء نموذج للمودال ---
            function generateFormContent(action, button, model) {
                const isEdit = action.startsWith('edit');
                let content = `<form id="locationForm" action="${button.dataset.url}" method="POST" novalidate>`;

                // إضافة رمز CSRF توكن لكل طلب POST/PATCH
                content += `<input type="hidden" name="_token" value="${csrfToken}">`;

                if (isEdit) {
                    content += `<input type="hidden" name="_method" value="PATCH">`;
                }

                // --- نموذج الدولة ---
                if (action.endsWith('country')) {
                    content += `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name">{{ __('Country Name') }}</label>
                            <input class="form-control" type="text" id="name" name="name" value="${model.name || ''}" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="iso_code">{{ __('Country Code (2 characters)') }}</label>
                            <div class="input-group">
                                <input class="form-control" type="text" id="iso_code" name="iso_code" value="${model.iso_code || ''}" maxlength="2" required>
                                <span class="input-group-text" id="flag-display"><i id="country-flag-icon"></i></span>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>`;
                }
                // --- نموذج الولاية أو المدينة ---
                else {
                    const label = action.endsWith('state') ? '{{ __('State Name') }}' : '{{ __('City Name') }}';
                    content += `
                    <div class="mb-3">
                        <label for="name" class="form-label">${label}</label>
                        <input type="text" class="form-control" name="name" id="name" value="${model.name || ''}" required>
                        <div class="invalid-feedback"></div>
                    </div>`;

                    // إرسال معرفات الأصل كحقول مخفية تلقائيًا
                    if (action === 'create-state') {
                        content += `<input type="hidden" name="country_id" value="${button.dataset.countryId}">`;
                    } else if (action === 'edit-state') {
                        // يجب أن يكون country_id متاحًا في الـ model عند التحرير
                        content += `<input type="hidden" name="country_id" value="${model.country_id || ''}">`;
                    }

                    if (action === 'create-city') {
                        content += `<input type="hidden" name="state_id" value="${button.dataset.stateId}">`;
                    } else if (action === 'edit-city') {
                        // يجب أن يكون state_id متاحًا في الـ model عند التحرير
                        content += `<input type="hidden" name="state_id" value="${model.state_id || ''}">`;
                    }
                }

                content += `
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        ${isEdit ? `
                                <button type="button" id="deleteBtn" class="btn btn-danger">
                                    {{ __('Delete') }}
                                </button>
                            ` : ''}
                    </div>
                    <div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>`;

                return content;
            }

            // --- تحديث أيقونة العلم ---
            function setupFlagUpdater(container) {
                const isoCodeInput = container.querySelector('#iso_code');
                const flagIcon = container.querySelector('#country-flag-icon');
                const updateFlag = (code) => {
                    flagIcon.className = code ? `flag-icon flag-icon-${code.toLowerCase()}` : '';
                };
                isoCodeInput.addEventListener('input', () => updateFlag(isoCodeInput.value));
                updateFlag(isoCodeInput.value); // تحديث مبدئي عند فتح المودال
            }

            // --- معالجة إرسال النموذج (إضافة/تعديل) ---
            async function handleFormSubmission(form, action) {
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML =
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Saving...') }}`;

                // إزالة رسائل التحقق السابقة
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                    const feedback = el.closest('.mb-3, .col-md-6')?.querySelector('.invalid-feedback');
                    if (feedback) feedback.textContent = '';
                });

                try {
                    const response = await fetch(form.action, {
                        method: 'POST', // سيتم تغييرها إلى PUT/PATCH بواسطة _method
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: new FormData(form)
                    });

                    const responseData = await response.json();
                    if (!response.ok) throw responseData; // رمي الاستجابة كلها للتعامل مع أخطاء التحقق

                    const itemData = responseData.model || responseData;

                    if (action.startsWith('edit')) {
                        updateItemInList(action, itemData);
                    } else {
                        addNewItemToList(action, itemData);
                    }
                    locationModal.hide(); // إغلاق المودال عند النجاح
                    // تم إزالة رسالة النجاح الخاصة بعمليات الإضافة/التعديل هنا
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: '{{ __('Success!') }}',
                    //     text: '{{ __('Operation completed successfully.') }}',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // });

                } catch (error) {
                    if (error.errors) { // أخطاء التحقق من Laravel
                        Object.keys(error.errors).forEach(key => {
                            const input = form.querySelector(`[name="${key}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                const feedback = input.closest('.mb-3, .col-md-6')?.querySelector(
                                    '.invalid-feedback');
                                if (feedback) feedback.textContent = error.errors[key][0];
                            }
                        });
                    } else {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('Oops...') }}',
                            text: error.message || '{{ __('An unexpected error occurred.') }}',
                        });
                    }
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            }

         function showDeleteConfirmation(deleteUrl, itemType, itemId) {
    Swal.fire({
        title: '{{ __('Are you sure?') }}',
        text: '{{ __('You will not be able to revert this!') }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '{{ __('Yes, delete it!') }}',
        cancelButtonText: '{{ __('Cancel') }}'
    }).then(async (result) => {
        if (result.isConfirmed) {
            console.log('Delete confirmed, sending request to:', deleteUrl); // تصحيح
            try {
                const response = await fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Delete failed:', errorData); // تصحيح
                    throw new Error(errorData.message || 'Failed to delete item.');
                }

                console.log('Delete successful, removing item and reloading...'); // تصحيح
                removeItemFromList(itemType, itemId);
                locationModal.hide(); // إخفاء المودال
                Swal.fire({
                    icon: 'success',
                    title: '{{ __('Success!') }}',
                    text: '{{ __('Item deleted successfully.') }}',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    console.log('Reloading page...'); // تصحيح
                    window.location.reload(); // إعادة تحميل الصفحة
                });

            } catch (error) {
                console.error('Error during deletion:', error);
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('Oops...') }}',
                    text: error.message || '{{ __('An unexpected error occurred.') }}',
                });
            }
        }
    });
}

            // --- تحديث القائمة بعد الإضافة ---
            function addNewItemToList(action, newItem) {
                const type = action.split('-')[1];
                if (type === 'country') {
                    // للحصول على تحديث كامل مع الـ flags، إعادة تحميل الصفحة أفضل
                    window.location.reload();
                } else if (type === 'state') {
                    const activeCountry = document.querySelector('.country-item.active');
                    if (activeCountry) {
                        fetchStates(activeCountry.dataset.id);
                        // يمكن تحديد الولاية المضافة حديثًا تلقائيًا
                        setTimeout(() => {
                            const newlyAddedState = lists.state.querySelector(
                                `.state-item[data-id="${newItem.id}"]`);
                            if (newlyAddedState) {
                                newlyAddedState.click(); // لمحاكاة النقر وتحديدها وعرض المدن
                            }
                        }, 100); // تأخير بسيط للسماح بتحميل القائمة
                    }
                } else if (type === 'city') {
                    const activeState = document.querySelector('.state-item.active');
                    if (activeState) {
                        fetchCities(activeState.dataset.id);
                    }
                }
            }

            // --- تحديث القائمة بعد التعديل ---
            function updateItemInList(action, updatedItem) {
                const type = action.split('-')[1];
                const list = lists[type];
                const itemElement = list.querySelector(`.list-group-item[data-id="${updatedItem.id}"]`);

                if (itemElement) {
                    const nameSpan = itemElement.querySelector('.item-name');
                    if (nameSpan) {
                        if (type === 'country') {
                            nameSpan.innerHTML =
                                `<i class="flag-icon flag-icon-${updatedItem.iso_code.toLowerCase()}"></i> ${updatedItem.name}`;
                        } else {
                            nameSpan.textContent = updatedItem.name;
                        }
                    }
                }
            }

            // --- إزالة العنصر من القائمة بعد الحذف ---
            function removeItemFromList(itemType, itemId) {
                const list = lists[itemType];
                const itemElement = list.querySelector(`.${itemType}-item[data-id="${itemId}"]`);
                if (itemElement) {
                    itemElement.remove();
                }
                // إعادة تحميل القوائم التابعة إذا تم حذف عنصر أب
                if (itemType === 'country') {
                    lists.state.innerHTML =
                        `<p class="text-muted p-3">{{ __('Select a country to see its states.') }}</p>`;
                    lists.city.innerHTML =
                        `<p class="text-muted p-3">{{ __('Select a state to see its cities.') }}</p>`;
                    if (addButtons.state) addButtons.state.classList.add('d-none');
                    if (addButtons.city) addButtons.city.classList.add('d-none');
                } else if (itemType === 'state') {
                    lists.city.innerHTML =
                        `<p class="text-muted p-3">{{ __('Select a state to see its cities.') }}</p>`;
                    if (addButtons.city) addButtons.city.classList.add('d-none');
                }
            }


            // --- وظائف جلب البيانات عبر AJAX ---
            const fetchDataForList = async (url, listElement, itemType, noDataMessage) => {
                // مسح الأعمدة التالية قبل التحميل
                if (itemType === 'state') {
                    lists.city.innerHTML =
                        `<p class="text-muted p-3">{{ __('Select a state to see its cities.') }}</p>`;
                    if (addButtons.city) addButtons.city.classList.add('d-none');
                }
                listElement.innerHTML =
                    `<div class="d-flex justify-content-center p-3"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __('Loading...') }}</span></div></div>`;
                try {
                    const response = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    listElement.innerHTML = ''; // مسح الرسالة التحميل
                    searchInputs[itemType].value = ''; // مسح مربع البحث بعد تحميل البيانات الجديدة

                    if (data.length > 0) {
                        data.forEach(item => {
                            const canEdit = (itemType === 'state' && userPermissions
                                .canEditState) ||
                                (itemType === 'city' && userPermissions.canEditCity) ||
                                (itemType === 'country' && userPermissions.canEditCountry);
                            listElement.innerHTML += createDynamicItemHtml(itemType, item, canEdit);
                        });
                    } else {
                        listElement.innerHTML = `<p class="text-muted p-3">${noDataMessage}</p>`;
                    }
                } catch (error) {
                    console.error(`Error fetching ${itemType}s:`, error);
                    listElement.innerHTML =
                        `<p class="text-danger p-3">${error.message || '{{ __('Failed to load items.') }}'}</p>`;
                }
            };

            function fetchStates(countryId) {
                fetchDataForList(`${apiBaseUrls.countries}/${countryId}/states`, lists.state, 'state',
                    '{{ __('No states found for this country.') }}');
            }

            function fetchCities(stateId) {
                fetchDataForList(`${apiBaseUrls.states}/${stateId}/cities`, lists.city, 'city',
                    '{{ __('No cities found for this state.') }}');
            }

            // --- إنشاء HTML للعناصر الديناميكية في القوائم ---
            function createDynamicItemHtml(type, item, canEdit) {
                let editButtonHtml = '';
                const resourceName = type === 'city' ? 'cities' : `${type}s`;
                // استخدام مسارات الـ API المعرفة في apiBaseUrls
                const editUrl = `${apiBaseUrls[resourceName]}/${item.id}`;
                const fetchUrl = `${apiBaseUrls[resourceName]}/${item.id}/edit`;
                const editTitle = `{{ __('Edit') }} ${type.charAt(0).toUpperCase() + type.slice(1)}`;

                if (canEdit) {
                    editButtonHtml = `<button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn"
                                            data-bs-toggle="modal" data-bs-target="#locationModal"
                                            data-action="edit-${type}" data-title="${editTitle}"
                                            data-url="${editUrl}" data-fetch-url="${fetchUrl}" data-id="${item.id}">
                                            <i class="fa fa-pencil"></i>
                                        </button>`;
                }

                let itemContent = item.name;
                if (type === 'country' && item.iso_code) {
                    itemContent = `<i class="flag-icon flag-icon-${item.iso_code.toLowerCase()}"></i> ${item.name}`;
                }

                return `<a href="#" class="list-group-item ${type}-item" data-id="${item.id}">
                            <span class="item-name">${itemContent}</span>
                            ${editButtonHtml}
                        </a>`;
            }
        });
    </script>
@endpush
