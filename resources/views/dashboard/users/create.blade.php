@extends('dashboard.layout')

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">المستخدمين</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">الصفحة الرئيسية</a></li>
                        <li class="breadcrumb-item active">المستخدمين</li>
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
                    <form method="POST" action="{{route('dashboard.users.store')}}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>الاسم</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>البريد الالكتروني</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>المسئولية</label>
                                        <select class="form-control" name="role">
                                            @foreach($roles as $id => $role)
                                            @if ($role == 'user')
                                            <option value="{{ $id }}">فني الصيانة</option>
                                            @elseif ($role == 'super-admin')
                                            <option value="{{ $id }}">إدارة الشركة</option>
                                            @elseif ($role == 'contract-supervisor')
                                            <option value="{{ $id }}">مشرف العقد</option>
                                            @elseif ($role == 'admin')
                                            <option value="{{ $id }}">مشرف الصيانة</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>الرقم السري</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>تأكيد الرقم السري</label>
                                        <input type="passowrd" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success">حفظ</button>
                                <a href="{{route('dashboard.users.index')}}" class="btn btn-primary">رجوع</a>
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
</div>
<!-- /.content-wrapper -->

@endsection