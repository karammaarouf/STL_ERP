@extends('../layouts.app')

@section('title', __('Locations Management'))

@push('styles')
    <style>
        /* --- تم إبقاء نفس التنسيقات --- */
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
            border-color: rgb(36, 105, 92)
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
                    <!-- عمود البلدان -->
                    <div id="countries-column" class="location-column">
                        <div class="column-header">
                            <span>{{ __('Countries') }}</span>
                            @can('create-country')
                                <a href="{{ route('countries.create') }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-plus"></i></a>
                            @endcan
                        </div>
                        <div class="column-search">
                            <input type="text" class="form-control form-control-sm" id="country-search"
                                placeholder="{{ __('Search...') }}">
                        </div>
                        <div class="column-body list-group list-group-flush">
                            @foreach ($countries as $country)
                                <a href="#" class="list-group-item country-item" data-id="{{ $country->id }}">
                                    <span> <i
                                            class="flag-icon flag-icon-{{ strtolower($country->iso_code) }}"></i>{{ $country->name }}</span>
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

                    <!-- عمود المحافظات -->
                    <div id="states-column" class="location-column">
                        <div class="column-header">
                            <span>{{ __('States') }}</span>
                            @can('create-city')
                                <a href="#" id="add-state-btn" class="btn btn-sm btn-primary d-none"><i
                                        class="fa fa-plus"></i></a>
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

                    <!-- عمود المدن -->
                    <div id="cities-column" class="location-column">
                        <div class="column-header">
                            <span>{{ __('Cities') }}</span>
                            @can('create-city')
                                <a href="#" id="add-city-btn" class="btn btn-sm btn-primary d-none"><i
                                        class="fa fa-plus"></i></a>
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

@push('scripts')
    <script>
        // تمرير الصلاحيات من PHP إلى JavaScript للتحقق من جهة العميل
        window.userPermissions = {
            canCreateStates: @json(optional(auth()->user())->can('create-state')),
            canEditStates: @json(optional(auth()->user())->can('edit-state')),
            canCreateCities: @json(optional(auth()->user())->can('create-city')),
            canEditCities: @json(optional(auth()->user())->can('edit-city'))
        };

        document.addEventListener('DOMContentLoaded', function() {
            const countriesColumn = document.getElementById('countries-column');
            const statesColumn = document.getElementById('states-column');
            const citiesColumn = document.getElementById('cities-column');

            const statesList = document.getElementById('states-list');
            const citiesList = document.getElementById('cities-list');

            // الأزرار قد لا تكون موجودة إذا لم يكن لدى المستخدم صلاحية
            const addStateBtn = document.getElementById('add-state-btn');
            const addCityBtn = document.getElementById('add-city-btn');

            const countrySearch = document.getElementById('country-search');
            const stateSearch = document.getElementById('state-search');
            const citySearch = document.getElementById('city-search');

            // --- دوال البحث ---
            const filterList = (input, listContainer) => {
                const filter = input.value.toUpperCase();
                const items = listContainer.getElementsByTagName('a');
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

            // --- تفويض الأحداث للنقرات ---

            countriesColumn.addEventListener('click', function(event) {
                const item = event.target.closest('.country-item');
                if (!item) return;

                // منع الانتقال إذا تم النقر على زر التعديل مباشرةً
                if (event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    window.location.href = event.target.closest('.edit-icon-btn').dataset.editUrl;
                    return;
                }

                event.preventDefault();

                countriesColumn.querySelectorAll('.country-item').forEach(el => el.classList.remove(
                    'active'));
                item.classList.add('active');

                fetchStates(item.dataset.id);
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

                fetchCities(item.dataset.id);
            });

            citiesColumn.addEventListener('click', function(event) {
                const item = event.target.closest('.city-item');
                if (!item) return;

                if (event.target.closest('.edit-icon-btn')) {
                    event.preventDefault();
                    window.location.href = event.target.closest('.edit-icon-btn').dataset.editUrl;
                }
            });


            // --- دوال جلب البيانات ---

            function fetchStates(countryId) {
                // تحديث زر إضافة محافظة (إذا كان موجوداً)
                if (addStateBtn && window.userPermissions.canCreateStates) {
                    addStateBtn.href = `{{ url('states/create') }}?country_id=${countryId}`;
                    addStateBtn.classList.remove('d-none');
                }

                // مسح الأعمدة اللاحقة
                citiesList.innerHTML =
                    `<p class="text-muted p-3">{{ __('Select a state to see its cities.') }}</p>`;
                if (addCityBtn) addCityBtn.classList.add('d-none');
                statesList.innerHTML =
                    `<div class="d-flex justify-content-center p-3"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __('Loading...') }}</span></div></div>`;

                const url = `{{ url('/api/countries') }}/${countryId}/states`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        statesList.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(state => {
                                let editButtonHtml = '';
                                if (window.userPermissions.canEditStates) {
                                    editButtonHtml = `<button class="btn btn-sm btn-outline-secondary edit-icon-btn" data-edit-url="{{ url('states') }}/${state.id}/edit">
                                                    <i class="fa fa-pencil"></i>
                                                  </button>`;
                                }
                                statesList.innerHTML += `
                                <a href="#" class="list-group-item state-item" data-id="${state.id}">
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
                            `<p class="text-danger p-3">{{ __('Failed to load states. Check browser console for details.') }}</p>`;
                    });
            }

            function fetchCities(stateId) {
                // تحديث زر إضافة مدينة (إذا كان موجوداً)
                if (addCityBtn && window.userPermissions.canCreateCities) {
                    addCityBtn.href = `{{ url('cities/create') }}?state_id=${stateId}`;
                    addCityBtn.classList.remove('d-none');
                }

                citiesList.innerHTML =
                    `<div class="d-flex justify-content-center p-3"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __('Loading...') }}</span></div></div>`;
                const url = `{{ url('/api/states') }}/${stateId}/cities`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        citiesList.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(city => {
                                let editButtonHtml = '';
                                if (window.userPermissions.canEditCities) {
                                    editButtonHtml = `<button class="btn btn-sm btn-outline-secondary edit-icon-btn" data-edit-url="{{ url('cities') }}/${city.id}/edit">
                                                    <i class="fa fa-pencil"></i>
                                                  </button>`;
                                }
                                citiesList.innerHTML += `
                                <a href="#" class="list-group-item city-item" data-id="${city.id}">
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
                            `<p class="text-danger p-3">{{ __('Failed to load cities. Check browser console for details.') }}</p>`;
                    });
            }
        });
    </script>
@endpush
