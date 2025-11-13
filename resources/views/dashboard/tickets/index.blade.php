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
                <div class="col-lg-2 col-6">
                    {{-- small box --}}
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$ticketsCount}}</h3>
                            <p>جميع الطلبات</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('dashboard.tickets.index')}}" class="small-box-footer">المزيد من المعلومات <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                {{-- ./col --}}
                <div class="col-lg-2 col-6">
                    {{-- small box --}}
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$newTickets}}<sup style="font-size: 20px"></sup></h3>
                            <p>طلب جديد</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('dashboard.tickets.index')}}?status=New" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    {{-- small box --}}
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$inProgressTickets}}<sup style="font-size: 20px"></sup></h3>
                            <p>قيد التنفيذ</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('dashboard.tickets.index')}}?status=InProgress" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    {{-- small box --}}
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{$waitingTickets}}<sup style="font-size: 20px"></sup></h3>
                            <p>بانتظار اعتماد التسعيرة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('dashboard.tickets.index')}}?status=Waiting" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    {{-- small box --}}
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$closeRequestTickets}}<sup style="font-size: 20px"></sup></h3>
                            <p>طلب اغلاق</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('dashboard.tickets.index')}}?status=CloseRequest" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    {{-- small box --}}
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{$closedTickets}}<sup style="font-size: 20px"></sup></h3>
                            <p>طلب مغلق</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('dashboard.tickets.index')}}?status=Closed" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
            <div class="row">

                @include('dashboard.inc.filters')
            </div>


            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">جميع طلبات الصيانة</h3>

                            @hasanyrole('admin|super-admin')
                            <div class="card-tools">
                                <a href="{{url('dashboard/tickets/create')}}" class="btn btn-small btn-primary">
                                    إضافة طلب صيانة</a>
                            </div>
                            <div class="card-tools mr-2">
                                <a href="{{route('dashboard.tickets.trash')}}" class="btn btn-small btn-danger">
                                    طلبات الصيانة المحذوفة</a>
                            </div>
                            @endhasanyrole
                            @hasanyrole('admin|super-admin|contract-supervisor')
                            <div class="card-tools mr-2">
                                <form method="POST" action="{{ route('dashboard.tickets.generateAllPdf')}}">
                                    @csrf
                                    <button class="form-control btn-dark" type="submit">استخراج تقرير PDF</button>
                                </form>
                            </div>
                            @endhasanyrole
                        </div>
                        <div class="card-body">
                            <table id="tickets"
                                class="table table-bordered table-responsive-md table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">رقم التذكرة</th>
                                        <th class="text-center">اسم العميل</th>
                                        <th class="text-center">رقم الجوال</th>
                                        <th class="text-center">رقم الصيانة للآلة</th>
                                        <th class="text-center">العطل</th>
                                        <th class="text-center">نوع الآلة</th>
                                        {{-- <th class="text-center">اسم المدينة</th> --}}
                                        {{-- <th class="text-center">اسم المبني</th> --}}
                                        <th class="text-center">القسم</th>
                                        <th class="text-center">حالة الطلب</th>
                                        <th class="text-center">تاريخ انشاء الطلب</th>
                                        <th class="text-center">فني الصيانة</th>
                                        <th class="text-center">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center">{{$ticket->ticket_code}}</td>
                                        <td class="text-center">{{$ticket->requester_name}}</td>
                                        <td class="text-center" dir="ltr">{{$ticket->phone}}</td>
                                        <td class="text-center">{{$ticket->printer_code}}</td>
                                        <td class="text-center">{{$ticket->problemType?->name ?? 'غير متوفر'}}</td>
                                        <td class="text-center">{{$ticket->printer?->name ?? 'غير متوفر'}}</td>
                                        {{--<td class="text-center">{{$ticket->city?->name ?? 'غير متوفر'}}</td>--}}
                                        {{--<td class="text-center">{{$ticket->building?->name ?? 'غير متوفر'}}</td>--}}
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

                                        <td class="text-center">{{$ticket->user?->name ?? 'غير متوفر'}}</td>

                                        <td class="text-center">
                                            <div class="d-flex flex-wrap gap-1" style="gap: 0.25rem;">
                                                <a href="{{route('dashboard.tickets.show', $ticket->id)}}" class="btn btn-sm btn-primary d-flex align-items-center" style="white-space: normal; "><i class="fas fa-eye"></i></a>
                                                @role('super-admin|admin')
                                                <a href="{{route('dashboard.tickets.edit', $ticket->id)}}" class="btn btn-sm btn-primary d-flex align-items-center" style="white-space: normal; "><i class="fas fa-edit"></i></a>
                                                <button class="btn btn-sm btn-danger d-flex align-items-center" type="submit"
                                                    onclick="removeItem('{{route('dashboard.tickets.destroy',$ticket->id)}}')"
                                                    style="white-space: normal; ">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endrole

                                                @hasanyrole('super-admin|admin|user')
                                                @if(auth()->user()->hasRole('super-admin') || $ticket->report == null)
                                                <a href="#" data-toggle="modal" onclick="report('{{ $ticket->id }}', '{{ $ticket->report }}')"
                                                    data-target="#report" class="btn btn-sm btn-primary d-flex align-items-center" style="white-space: normal; ">
                                                    <i class="fas fa-plus ms-1"></i><span>تقرير الصيانة</span>
                                                </a>
                                                @endif
                                                @endhasanyrole
                                                @if ($ticket->status != 'Closed')
                                                @hasanyrole('super-admin')
                                                <form action="{{route('dashboard.tickets.closeTicket')}}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                                    <button type="submit" class="btn btn-sm btn-warning d-flex align-items-center"
                                                    style="white-space: normal; "><i class="fas fa-plus ms-1"></i><span>اغلاق طلب الصيانة</span></button>
                                                </form>
                                                @endhasanyrole
                                                @hasanyrole('admin|user')
                                                @if ($ticket->report)
                                                <a href="#"  id="closeTicketButton" data-ticket-id="{{$ticket->id}}"  data-toggle="modal" onclick="closeTicket('{{$ticket->id}}')"
                                                    data-target="#close" class="btn btn-sm btn-warning d-flex align-items-center"
                                                    style="white-space: normal; "><i class="fas fa-plus ms-1"></i><span>اغلاق طلب الصيانة</span></a>
                                                @endif
                                                @endhasanyrole
                                                @endif
                                                @hasanyrole('super-admin|admin')
                                                @if(!$ticket->user_id)
                                                <a href="#" data-toggle="modal" onclick="assignTo('{{$ticket->id}}')"
                                                    data-target="#assignTo" class="btn btn-sm btn-primary d-flex align-items-center"
                                                    style="white-space: normal; "><i class="fas fa-plus ms-1"></i><span>فني الصيانة</span></a>
                                                @endif
                                                @endhasanyrole

                                                {{-- Show Review Button --}}
                                                @if($ticket->review)
                                                <a href="#" data-toggle="modal" onclick="showReview('{{$ticket->id}}')"
                                                    data-target="#reviewModal" class="btn btn-sm btn-info d-flex align-items-center"
                                                    style="white-space: normal; ">
                                                    <i class="fas fa-star ms-1"></i><span>عرض التقييم</span>
                                                </a>
                                                @else
                                                <button class="btn btn-sm btn-secondary d-flex align-items-center" disabled
                                                    style="white-space: normal; ">
                                                    <i class="fas fa-star ms-1"></i><span>عرض التقييم</span>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <form id="deleteItem" action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </table>
                            <div class="mt-2">
                                {{ $tickets->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
                                <option value="{{$id}}">{{$user}}</option>
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

{{-- Close Ticket Modal --}}
<div class="modal fade" id="close" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اغلاق طلب الصيانة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('dashboard.tickets.closeTicket')}}" file="true">
                    @csrf
                    <input type="hidden" name="ticket_id">
                    <div class="row">
                        <div class="form-group mb-3 col-12">
                            <label for="close_code">الرجاء ادخال رمز التحقق المرسل على جوال العميل*</label>
                            <input class="form-control" name="close_code" type="number" min="0" required>
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

<div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إغلاق طلب الصيانة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('dashboard.tickets.report')}}" enctype="multipart/form-data"
                    file="true">
                    @csrf
                    <input type="hidden" name="ticket_id">
                    <div class="row">
                        <div class="form-group">
                <label for="report">إضافة تقرير صيانة*</label>
                            <textarea class="form-control" required rows="4" cols="50" id="report"
                                name="report"></textarea>
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

{{-- Review Modal --}}
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="reviewModalLabel"><i class="fas fa-star"></i> <span id="technicianName"></span></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Average Rating Display --}}
                <div class="text-center mb-4 p-4 bg-light rounded">
                    <h3 class="mb-2 text-primary" id="avgRating"></h3>
                    <div class="mb-2" id="avgStars"></div>
                            <small class="text-muted">متوسط التقييم</small>
                </div>

                {{-- Review Details Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 50%"><i class="fas fa-clipboard-list mr-2"></i>المعايير</th>
                                <th style="width: 30%" class="text-center"><i class="fas fa-star mr-2"></i>التقييم</th>
                                <th style="width: 20%" class="text-center">النجوم</th>
                            </tr>
                        </thead>
                        <tbody id="reviewTableBody">
                            {{-- Will be populated by JavaScript --}}
                        </tbody>
                    </table>
                </div>

                {{-- Notes Section --}}
                <div class="mt-4">
                    <div class="card bg-light border-0">
                        <div class="card-header bg-secondary text-white">
                            <i class="fas fa-sticky-note mr-2"></i><strong>ملاحظات</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-0" id="reviewNotes" style="white-space: pre-wrap;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    function assignTo(ticket_id) {
        let modal = $('#assignTo');
        modal.find('.modal-body input[name="ticket_id"]').val(ticket_id);
    };

    function report(ticket_id, report) {
        let modal = $('#report');
        modal.find('.modal-body input[name="ticket_id"]').val(ticket_id);
        modal.find('.modal-body textarea[name="report"]').val(report);
    };

    function closeTicket(ticket_id) {
        let modal = $('#close');
        modal.find('.modal-body input[name="ticket_id"]').val(ticket_id);
    };

    $(document).ready(function() {
        // Initialize DataTables with sorting only (no search)
        $('#tickets').DataTable({
            'paging': false,      // Disable DataTables pagination (using Laravel pagination)
            'searching': false,   // Disable search (using filters above)
            'ordering': true,     // Enable column sorting
            'info': false,        // Disable table info display
            'autoWidth': false,   // Disable auto width calculation
            'columnDefs': [
                { 'orderable': false, 'targets': [-1] } // Disable sorting on first (#) and last (actions) columns
            ]
        });

        $('#closeTicketButton').one('click', function() {
            var ticketId = $(this).data('ticket-id');

            $.ajax({
                url: "{{route('dashboard.tickets.sendTicketCloseCodeSms')}}",
                type: 'POST',
                data: {
                    ticket_id: ticketId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log('Ticket close Code sent successfully');
                },
                error: function(error) {
                    console.error('Error sending close code for this ticket:', error);
                }
            });
        });
    });

    function showReview(ticket_id) {
        // Fetch review data via AJAX
        $.ajax({
            url: '/dashboard/tickets/' + ticket_id + '/review',
            method: 'GET',
            success: function(response) {
                if (response.review) {
                    let review = response.review;
                    let ticket = response.ticket;

                    // Display technician name
                    if (ticket && ticket.user) {
                        $('#technicianName').text('تقييم ' + ticket.user.name);
                    } else {
                        $('#technicianName').text('تقييم الفني');
                    }

                    // Calculate average rating
                    let avgRating = (
                        (review.service_quality || 0) +
                        (review.response_time || 0) +
                        (review.technician_behavior || 0) +
                        (review.technician_competence || 0)
                    ) / 4;

                    // Display average rating
                    $('#avgRating').text(avgRating.toFixed(1) + '/5');

                    // Display average stars
                    let starsHtml = '';
                    for (let i = 1; i <= 5; i++) {
                        if (i <= Math.round(avgRating)) {
                            starsHtml += '<i class="fas fa-star text-warning"></i> ';
                        } else {
                            starsHtml += '<i class="fas fa-star text-muted"></i> ';
                        }
                    }
                    $('#avgStars').html(starsHtml);

                    // Build review table
                    let tableHtml = '';
                    let criteria = [
                        { name: 'جودة خدمة الصيانة بشكل عام', value: review.service_quality, color: 'primary', icon: 'fa-star' },
                        { name: 'سرعة استجابة الشركة لطلب الصيانة', value: review.response_time, color: 'info', icon: 'fa-clock' },
                        { name: 'تعامل الفني أثناء الخدمة (الاحترام، اللباقة، المظهر)', value: review.technician_behavior, color: 'success', icon: 'fa-handshake' },
                        { name: 'مدى كفاءة الفني في أداء عمله', value: review.technician_competence, color: 'warning', icon: 'fa-tools' }
                    ];

                    criteria.forEach(function(item, index) {
                        let stars = '';
                        for (let i = 1; i <= 5; i++) {
                            if (i <= (item.value || 0)) {
                                stars += '<i class="fas fa-star text-warning"></i> ';
                            } else {
                                stars += '<i class="fas fa-star text-muted"></i> ';
                            }
                        }

                        tableHtml += '<tr>';
                        tableHtml += '<td><i class="fas ' + item.icon + ' text-' + item.color + ' mr-2"></i><strong>' + item.name + '</strong></td>';
                        tableHtml += '<td class="text-center"><span class="badge bg-' + item.color + '" style="font-size: 1.1rem; padding: 0.5rem 1rem;">' + (item.value ?? 'N/A') + '/5</span></td>';
                        tableHtml += '<td class="text-center">' + stars + '</td>';
                        tableHtml += '</tr>';
                    });

                    // Add problem resolution status
                    let problemStatusText = '';
                    let problemStatusIcon = '';
                    if (review.problem_solved === 'full') {
                        problemStatusText = '✅ نعم';
                        problemStatusIcon = 'fa-check-circle';
                    } else if (review.problem_solved === 'yes_certainly') {
                        problemStatusText = '🌟 نعم بالتأكيد';
                        problemStatusIcon = 'fa-check-circle';
                    } else if (review.problem_solved === 'partial') {
                        problemStatusText = '⚙ جزئيًا';
                        problemStatusIcon = 'fa-wrench';
                    } else {
                        problemStatusText = '❌ لا';
                        problemStatusIcon = 'fa-times-circle';
                    }
                    tableHtml += '<tr style="background-color: #fff3cd;">';
                    tableHtml += '<td><i class="fas ' + problemStatusIcon + ' mr-2"></i><strong>هل تم حل المشكلة بالكامل؟</strong></td>';
                    tableHtml += '<td colspan="2" class="text-center">' + problemStatusText + '</td>';
                    tableHtml += '</tr>';

                    

                    $('#reviewTableBody').html(tableHtml);

                    // Display notes
                    if (review.notes) {
                        $('#reviewNotes').text(review.notes);
                    } else {
                        $('#reviewNotes').html('<em class="text-muted">لم يتم تقديم ملاحظات إضافية.</em>');
                    }
                }
            },
            error: function(xhr) {
                alert('حدث خطأ أثناء تحميل بيانات التقييم');
            }
        });
    }
</script>

@endsection
