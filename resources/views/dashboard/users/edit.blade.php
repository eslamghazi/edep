{{-- Extend the dashboard layout --}}
@extends('dashboard.layout')

{{-- Start the "main" section of this Blade template --}}
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        {{-- ... other code remains the same --}}
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{-- Assuming the route for updating is 'dashboard.users.update' and $user is the variable holding
                    user data --}}
                    <form method="POST" action="{{ route('dashboard.users.update', $user->id) }}">
                        {{-- Include the method_field to spoof a PUT/PATCH request --}}
                        @method('PUT')
                        @csrf

                        <div class="card-body">
                            {{-- ... other fields remain the same --}}

                            {{-- For each input, use the old helper to retain old input if available --}}
                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>الاسم</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>البريد الالكتروني</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>

                                {{-- ... repeat for other fields ... --}}

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>المسئولية</label>
                                        
                                        <select class="form-control" name="role">
                                            @foreach($roles as $id => $role)
                                            <option value="{{ $id }}" {{ $user->roles->first()->id == $id ? 'selected'
                                                : '' }}>
                                                {{-- Convert the role to a readable format --}}
                                                @if ($role == 'user')
                                                فني الصيانة
                                                @elseif ($role == 'super-admin')
                                                إدارة الشركة
                                                @elseif ($role == 'contract-supervisor')
                                                مشرف العقد
                                                @elseif ($role == 'admin')
                                                مشرف الصيانة
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- The password fields do not need the old value for security reasons --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>الرقم السري</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>تأكيد الرقم السري</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div>
                                <button type="submit" class="btn btn-success">تحديث</button>
                                <a href="{{ route('dashboard.users.index') }}" class="btn btn-primary">رجوع</a>
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