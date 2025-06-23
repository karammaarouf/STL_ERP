@extends('../layouts.app')

@section('title', 'الدول')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>قائمة الدول</h5>
                        @can('create-country')
                            <a href="{{ route('countries.create') }}" class="btn btn-primary">إضافة دولة جديدة</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">اسم الدولة</th>
                                    <th scope="col">رمز الدولة</th>
                                    @canany(['edit-country', 'delete-country'])
                                    <th scope="col">خيارات</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($countries as $country)
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td> <i class="flag-icon flag-icon-{{ strtolower($country->iso_code) }}"></i>  {{ $country->name }} </td>
                                        <td>{{ $country->iso_code }}</td>
                                        @canany(['edit-country', 'delete-country'])
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton{{ $country->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $country->id }}">
                                                    @can('edit-country')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('countries.edit', $country->id) }}">تعديل</a>
                                                    </li>
                                                    @endcan
                                                    @can('show-country')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('countries.show', $country->id) }}">تفاصيل الدولة</a>
                                                    </li>
                                                    @endcan
                                                    @can('delete-country')
                                                    <li>
                                                        <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذه الدولة؟')">حذف</button>
                                                        </form>
                                                    </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        </td>
                                        @endcanany
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد بيانات لعرضها</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                      @include('pagination.page', ['page' => $countries])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
