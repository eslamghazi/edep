@extends('dashboard.layout')

@section('main')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">الصفحة الرئيسية</a></li>
            <li class="breadcrumb-item active">صفحة البداية</li>
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
        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$ticketsCount}}</h3>

              <p>جميع الطلبات</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('dashboard.tickets.index')}}" class="small-box-footer">المزيد من المعلومات <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$newTickets}}<sup style="font-size: 20px"></sup></h3>

              <p>طلب جديد</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$inProgressTickets}}<sup style="font-size: 20px"></sup></h3>

              <p>قيد التنفيذ</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{$waitingTickets}}<sup style="font-size: 20px"></sup></h3>

              <p>بانتظار اعتماد التسعيرة</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$closeRequestTickets}}<sup style="font-size: 20px"></sup></h3>

              <p>تم إرسال طلب الإغلاق</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-dark">
            <div class="inner">
              <h3>{{$closedTickets}}<sup style="font-size: 20px"></sup></h3>

              <p>طلب مغلق</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>
      <!-- /.row -->
      <div class="row">
        {{-- charts --}}
        <div class="w-50">
          {!! $ticketsChart->container() !!}
        </div>

        <div class="w-50">
          {!! $usersChart->container() !!}
        </div>
        {!! $ticketsChart->script() !!}
        {!! $usersChart->script() !!}

      </div>

      <div class="row mt-5">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">طلبات الصيانة الجديدة</h3>
            </div>
            <div class="card-body">
              <table id="tickets" class="table table-bordered table-responsive-md table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">اسم المستخدم</th>
                    <th class="text-center">نوع العطل</th>
                    <th class="text-center">نوع الآلة</th>
                    {{-- <th class="text-center">المدينة</th> --}}
                    <th class="text-center">القسم</th>
                    <th class="text-center">حالة الطلب</th>
                    <th class="text-center">تاريخ انشاء الطلب</th>
                  </tr>
                </thead>
                @foreach ($tickets as $index => $ticket)
                <tbody>
                  <tr>
                    <td class="text-center">{{$index + 1 }}</td>
                    <td class="text-center">{{$ticket->requester_name}}</td>
                    <td class="text-center">{{ $ticket->problemType?->name ?? 'غير متوفر' }}</td>
                    <td class="text-center">{{ $ticket->printer?->name ?? 'غير متوفر' }}</td>
              {{--  <td class="text-center">{{ $ticket->city?->name ?? 'غير متوفر' }}</td> --}}
                    <td class="text-center">{{ $ticket->department?->localized_name ?? 'غير متوفر' }}</td>
                    @if ($ticket->status == 'Closed')
                    <td class="text-center"><span class="badge bg-dark">مغلق
                      </span></td>
                    @elseif ($ticket->status == 'InProgress')
                    <td class="text-center"><span class="badge bg-warning">قيد التنفيذ
                      </span></td>
                    @elseif ($ticket->status == 'New')
                    <td class="text-center"><span class="badge bg-success">طلب جديد
                      </span></td>
                    @elseif ($ticket->status == 'Waiting')
                    <td class="text-center"><span class="badge bg-blue">بانتظار اعتماد التسعيرة
                      </span></td>
                    @else
                    <td class="text-center"><span class="badge bg-danger">تم إرسال طلب الإغلاق
                      </span></td>
                    @endif
                    <td class="text-center">{{ formatDate($ticket->created_at) }}</td>
                  </tr>
                </tbody>
                @endforeach
              </table>
              <div class="mt-2">
                {{ $tickets->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->

  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
