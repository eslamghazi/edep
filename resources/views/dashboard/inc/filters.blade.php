<!-- Filter Form -->
<div class="card-body">
    @hasanyrole('admin|super-admin')
    @if(request()->is('dashboard/tickets/trash*'))
    <form action="{{ route('dashboard.tickets.trash') }}" method="GET">
        @else
        <form action="{{ route('dashboard.tickets.index') }}" method="GET">
            @endif
            @else
            @if(request()->is('dashboard/tickets/trash*'))
            <form action="{{ route('dashboard.tickets.trash') }}" method="GET">
                @else
                <form action="{{ route('dashboard.tickets.support') }}" method="GET">
                    @endif
                    @endhasanyrole

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>رقم التذكرة</label>
                                <input name="ticket_code" type="text" value="{{ request('ticket_code') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>اسم المنشئ</label>
                                <input name="requester_name" type="text" value="{{ request('requester_name') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>رقم الجوال</label>
                                <input name="phone_number" type="text" value="{{ request('phone_number') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>رقم الصيانة للآلة</label>
                                <input name="printer_code" type="text" value="{{ request('printer_code') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>التاريخ (من)</label>
                                <input name="start_date" type="date" value="{{ request('start_date')}}"
                                    class="form-control">
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>التاريخ (إلي)</label>
                                <input name="end_date" type="date" value="{{ request('end_date') ?? date('Y-m-d')}}"
                                    class="form-control">
                            </div>

                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>تصفية حسب الفترة الزمنية</label>
                                <select name="date_range" class="form-control" onchange="updateDateValue(this)">
                                    <option value="">اختر الفترة الزمنية</option>
                                    <option value="1" {{ request('date_range')=='1' ? 'selected' : '' }}>اليوم</option>
                                    <option value="7" {{ request('date_range')=='7' ? 'selected' : '' }}>آخر سبع أيام
                                    </option>
                                    <option value="30" {{ request('date_range')=='30' ? 'selected' : '' }}>آخر 30 يوما
                                    </option>
                                    <option value="90" {{ request('date_range')=='90' ? 'selected' : '' }}>آخر 90 يوما
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>العطل</label>
                                <select name="type_id" class="form-control">
                                    <option value="">الجميع</option>
                                    @foreach ($problemTypes as $id => $type)
                                    <option value="{{$id}}" {{request('type_id')==$id ? 'selected' : '' }}>{{$type}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                {{--  <div class="col-md-2">
                            <div class="form-group">
                                <label>المدينة</label>
                                <select name="city_id" class="form-control">
                                    <option value="">الجميع</option>
                                    @foreach ($cities as $id => $city)
                                    <option value="{{$id}}" {{request('city_id')==$id ? 'selected' : '' }}>{{$city}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>القسم</label>
                                <select name="department_id" class="form-control">
                                    <option value="">الجميع</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->localized_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>حالة الطلب</label>
                                <select name="status" class="form-control">
                                    <option value="">الجميع</option>
                                    <option value="New" {{request('status')=='New' ? 'selected' : '' }}>طلب جديد</option>
                                    <option value="InProgress" {{request('status')=='InProgress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                    <option value="Closed" {{request('status')=='Closed' ? 'selected' : '' }}>طلب مغلق</option>
                                    <option value="Waiting" {{request('status')=='Waiting' ? 'selected' : '' }}>بانتظار الاعتماد</option>
                                    <option value="CloseRequest" {{request('status')=='CloseRequest' ? 'selected' : '' }}>طلب إغلاق</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>فني الصيانة</label>
                                <select name="user" class="form-control">
                                    <option value="">الجميع</option>
                                    @foreach ( $users as $id => $user)
                                    <option value="{{$id}}" {{request('user')==$id ? 'selected' : '' }}>{{$user}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">بحث</button>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                @if (request()->is('dashboard/tickets/trash*'))
                                <a href="{{ route('dashboard.tickets.reset-filters', 'trash=1') }}"
                                    class="btn btn-secondary">حذف</a>
                                @else
                                <a href="{{ route('dashboard.tickets.reset-filters') }}"
                                    class="btn btn-secondary">حذف</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
</div>
