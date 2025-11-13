@extends('dashboard.layout')

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">طلبات الصيانة</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">الصفحة الرئيسية</a></li>
                        <li class="breadcrumb-item active">طلبات الصيانة</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{route('dashboard.tickets.store')}}" enctype="multipart/form-data">
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
                                        <label for="selector" class="form-label">رقم الصيانة للطابعة (010601 - 010699) <span class="text-danger">*</span></label>
                                        <input type="text" name="printer_code" class="form-control @error('printer_code') is-invalid @enderror" id="num" maxlength="6" minlength="6" required pattern="^0106(0[1-9]|[1-9][0-9])$" inputmode="numeric" title="الرجاء إدخال رقم بين 010601 و 010699" />
                                        @error('printer_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <div class="form-group">

                                        <label for="selector" class="form-label">موديل الطابعة <span class="text-danger">*</span></label>
                                        <select name="printer_id" id="" class="form-control @error('printer_id') is-invalid @enderror">
                                            @foreach ($printers as $printer)
                                            <option value="{{ $printer->id }}">{{ $printer->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('printer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>


                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">نوع العطل <span class="text-danger">*</span></label>
                                    <select name="problem_type_id" id="problem_type_id" class="form-control @error('problem_type_id') is-invalid @enderror">
                                        @foreach ($problemTypes as $problemType)
                                        <option value="{{ $problemType->id }}">{{ $problemType->name }}</option>
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
                                        <option value="{{ $department->id }}">{{ $department->localized_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                            </div>

                            {{--<div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">نوع المبني <span class="text-danger">*</span></label>

                                    <div class="form-check">
                                        <input class="form-check-input" name="building_type" value="male" type="radio"
                                            id="flexRadioDefault1" />

                                        <label class="form-check-label"><b>رجال</b> (تتم الصيانة خلال وقت الدوام الرسمي) </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="building_type" value="female" type="radio"
                                            id="flexRadioDefault2" checked />
                                        <label class="form-check-label"> <b>نساء</b> (تتم الصيانة خارج وقت الدوام الرسمي) </label>
                                    </div>
                                </div> --}}

                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="description" class="form-label">وصف للعطل</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                        rows="4"></textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">اسم منشئ الطلب <span class="text-danger">*</span></label>
                                    <input type="text" name="requester_name" class="form-control @error('requester_name') is-invalid @enderror" id="num" />
                                    @error('requester_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">رقم الجوال <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="num" />
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="selector" class="form-label">البريد الالكتروني</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="num" />
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                        </div>
                        <div>
                            <button type="submit" class="btn btn-success">انشاء طلب</button>
                            <a href="{{route('dashboard.tickets.index')}}" class="btn btn-primary">رجوع</a>
                        </div>
                </div>
                <!-- /.card-body -->
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- /.content-wrapper -->

@endsection

@section('scripts')
<script>
    document.getElementById("exampleInputFile").addEventListener("change", function(e) {
        var fileName = e.target.files[0].name;
        var label = document.querySelector(".custom-file-label");
        label.textContent = fileName;
    });
</script>

<script>
    $('#city').on('change', function() {
        let city = $(this).val();
        if (city) {
            let link = '{{ url('/buildingsByCity') }}';
            $.ajax({
                url: link + '/' + city,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#building').empty();
        $('#building').append('<option value="">اختار المبني</option>');
                    $.each(data, function(key, value) {
                        $('#building').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }
            });
        }
    });
</script>
@endsection
