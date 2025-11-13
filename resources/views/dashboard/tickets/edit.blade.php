@extends('dashboard.layout')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">طلبات الصيانة</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الصفحة الرئيسية</a></li>
                        <li class="breadcrumb-item active">طلبات الصيانة</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('dashboard.tickets.update', $ticket->id) }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="num" class="form-label">رقم الصيانة للطابعة <span class="text-danger">*</span></label>
                                        <input type="text" name="printer_code" class="form-control @error('printer_code') is-invalid @enderror" id="num" maxlength="6" minlength="6" value="{{$ticket->printer_code}}" required pattern="^0106(0[1-9]|[1-9][0-9])$" inputmode="numeric" title="الرجاء إدخال رقم بين 010601 و 010699" />
                                        @error('printer_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="selector" class="form-label">موديل الطابعة <span class="text-danger">*</span></label>
                                        <select name="printer_id" id="" class="form-control @error('printer_id') is-invalid @enderror">
                                            @foreach ($printers as $printer)
                                            <option value="{{ $printer->id }}" @if ($printer->id ==
                                                $ticket->printer->id) selected
                                                @endif>{{ $printer->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('printer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">نوع العطل <span class="text-danger">*</span></label>
                                    <select name="problem_type_id" id="problem_type_id" class="form-control @error('problem_type_id') is-invalid @enderror">
                                        @foreach ($problemTypes as $problemType)
                                        <option value="{{ $problemType->id }}" @if ($problemType->id ==
                                            $ticket->problemType->id) selected
                                            @endif>{{ $problemType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('problem_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="exampleInputFile">ارسال صورة للعطل</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="exampleInputFile" accept="image/*">
                                                <label class="custom-file-label" for="exampleInputFile">اختر
                                                    صورة</label>
                                            </div>
                                        </div>
                                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="department_id" class="form-label">القسم <span class="text-danger">*</span></label>
                                    <select name="department_id" id="department" class="form-control @error('department_id') is-invalid @enderror">
                                        <option value="" selected>اختر القسم</option>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @if ($department->id == $ticket->department_id) selected @endif>{{ $department->localized_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                         {{--   <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="selector" class="form-label">نوع المبني <span class="text-danger">*</span></label>

                                    <div class="form-check">
                                        <input class="form-check-input" name="building_type" value="male" type="radio"
                                               {{  $ticket->building_type == 'male' ? 'checked' : '' }} />
                                        <label class="form-check-label"><b>رجال</b> (تتم الصيانة خلال وقت الدوام الرسمي)</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" name="building_type" value="female" type="radio"
                                               {{  $ticket->building_type == 'female' ? 'checked' : '' }} />
                                        <label class="form-check-label"><b>نساء</b> (تتم الصيانة خارج وقت الدوام الرسمي)</label>
                                    </div>
                                </div>

                            </div> --}}

                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="selector" class="form-label">اسم منشئ الطلب <span class="text-danger">*</span></label>
                                    <input type="text" name="requester_name" value="{{$ticket->requester_name}}"
                                        class="form-control @error('requester_name') is-invalid @enderror" id="num" />
                                    @error('requester_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">رقم الجوال <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" value="{{$ticket->phone}}" class="form-control @error('phone') is-invalid @enderror"
                                        id="num" />
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">البريد الالكتروني</label>
                                    <input type="email" name="email" value="{{$ticket->email}}" class="form-control @error('email') is-invalid @enderror" id="num" />
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">حالة الطلب <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="New" @if ($ticket->status == 'New') selected @endif>طلب جديد
                                        </option>
                                        <option value="InProgress" @if ($ticket->status == 'InProgress') selected
                                            @endif>قيد التنفيذ</option>
                                            @if (auth()->user()->role('admin'))
                                            <option disabled value="Closed" @if ($ticket->status == 'Closed') selected @endif>مغلق
                                            </option>
                                            @else
                                            <option value="Closed" @if ($ticket->status == 'Closed') selected @endif>مغلق
                                            </option>
                                            @endif
                                        <option value="Close_request" @if ($ticket->status == 'Close_request') selected
                                            @endif>تم إرسال طلب الإغلاق
                                        </option>
                                        <option value="Waiting" @if ($ticket->status == 'Waiting') selected
                                            @endif>بانتظار اعتماد التسعيرة
                                        </option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                @hasanyrole('super-admin|admin')
                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">تقرير الصيانة</label>
                                    <textarea type="text" name="report" class="form-control @error('report') is-invalid @enderror" rows="4">{{$ticket->report  ?? ''}}</textarea>
                                    @error('report')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                @endhasanyrole

                                <div class="col-md-6 mt-2">
                                    <label for="description" class="form-label">وصف للعطل</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                        rows="4">{{$ticket->description}}</textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                @hasanyrole('super-admin|admin')
                                <div class="col-md-6 mt-3">
                                    <label for="selector" class="form-label"> إحالة الطلب الي فني صيانة</label>
                                    <a href="#" class="btn btn-dark" data-toggle="modal"
                                        onclick="assignTo('{{$ticket->id}}')" data-target="#assignTo" class="ml-1 btn btn-sm
                                        btn-primary"><i class="fas fa-plus"></i> فني الصيانة </a>
                                </div>
                                @endhasanyrole

                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success">تعديل طلب</button>
                            <a href="{{ route('dashboard.tickets.index') }}" class="btn btn-primary">رجوع</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignTo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">توكيل فني الصيانة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('dashboard.tickets.assign')}}" enctype="multipart/form-data"
                    file="true">
                    @csrf
                    <input type="hidden" name="ticket_id">
                    <div class="row">
                        <div class="form-group mb-3 col-12">
                    <label for="user_id">اختار فني الصيانة*</label>
                            <select name="user_id" class="form-control" required>
                                @foreach($users as $id => $user)
                                <option value="{{$id}}" {{ $ticket->user_id == $id ? 'selected' : '' }}>{{$user}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-primary ">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById("exampleInputFile").addEventListener("change", function (e) {
        var fileName = e.target.files[0].name;
        var label = document.querySelector(".custom-file-label");
        label.textContent = fileName;
    });
</script>

<script>
    $('#city').on('change', function () {
        let city = $(this).val();
        if (city) {
            let link = '{{ url('/buildingsByCity') }}';
            $.ajax({
                url: link + '/' + city,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#building').empty();
        $('#building').append('<option value="">اختار المبني</option>');
                    $.each(data, function (key, value) {
                        $('#building').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    });

    function assignTo(ticket_id) {
        let modal = $('#assignTo');
        modal.find('.modal-body input[name="ticket_id"]').val(ticket_id);
    };

</script>


@endsection
