@extends('dashboard.layout')

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>المستخدمين</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">الصفحة الرئيسية</a></li>
            <li class="breadcrumb-item active">المستخدمين</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">قائمة المستخدمين</h3>
              @role('super-admin')
              <div class="card-tools">
                <a href="{{route('dashboard.users.create')}}" class="btn btn-small btn-primary">اضافة مستخدم</a>
              </div>
              @endrole
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="users" class="table table-bordered table-responsive-md table-striped table-hover ">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">الاسم</th>
                    <th class="text-center">البريد الالكتروني</th>
                    <th class="text-center">المسؤلية</th>
                    <th class="text-center">تاريخ الإنشاء</th>
                    <th class="text-center">تاريخ التعديل</th>
                    <th class="text-center">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($Users as $user)
                  <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">{{$user->name}}</td>
                    <td class="text-center">{{$user->email}}</td>
                    <td class="text-center"> @foreach($user->getRoleNames() as $role)
                      @if ($role == 'user')
                      فني الصيانة
                      @elseif ($role == 'super-admin')
                      إدارة الشركة
                      @elseif ($role == 'contract-supervisor')
                      مشرف العقد
                      @elseif ($role == 'admin')
                      مشرف الصيانة
                      @endif
                      @endforeach
                    </td>
                    <td class="text-center">{{ formatDate($user->created_at) }}</td>
                    <td class="text-center">{{ formatDate($user->updated_at) }}</td>
                    <td class="text-center">
                      <div class="btn-group">
                        @role('super-admin')
                        <a href="{{route('dashboard.users.edit', $user->id)}}" class="mr-1 btn btn-sm
                          btn-primary"><i class="fas fa-edit"></i></a>
                        @endrole
                        <button class="btn btn-danger " type="submit"
                          onclick="removeItem('{{route('dashboard.users.destroy',$user->id)}}')">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
                @endforeach
                <form id="deleteItem" action="" method="POST">
                  @csrf
                  @method('DELETE')
                </form>
                </tbody>
              </table>
              <div class="mt-2">
                {{ $Users->links() }}
            </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('scripts')

<script>
  // $(function () {
  //   $(".table").DataTable({
  //     "responsive": true, "lengthChange": false, "autoWidth": false,
  //     "buttons": [
  //       {
  //         extend: 'csv'
  //       },
  //       {
  //         extend: 'excel'
  //       },
  //     ],
  //     searching: false,
  //   }).buttons().container().appendTo('#users_wrapper .col-md-6:eq(0)');
  // });
</script>
@endsection
