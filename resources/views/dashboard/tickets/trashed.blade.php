@extends('dashboard.layout')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <!-- Your content header goes here -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Include filters if needed -->
                @include('dashboard.inc.filters')
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trashed Tickets</h3>
                        </div>
                        <div class="card-body">
                            <table id="trashedTickets"
                                class="table table-bordered table-responsive-md table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">رقم التذكرة</th>
                                        <th class="text-center">اسم العميل</th>
                                        <th class="text-center">رقم الجوال</th>
                                        <th class="text-center">العطل</th>
                                        <th class="text-center">نوع الآلة</th>
                                        {{-- <th class="text-center">المدينة</th> --}}
                                        <th class="text-center">القسم</th>
                                        <th class="text-center">تاريخ انشاء الطلب</th>
                                        <th class="text-center">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trashedTickets as $ticket)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $ticket->ticket_code }}</td>
                                        <td class="text-center">{{ $ticket->requester_name }}</td>
                                        <td class="text-center" dir="ltr">{{ $ticket->phone }}</td>
                                        <td class="text-center">{{ $ticket->problemType->name }}</td>
                                        <td class="text-center">{{$ticket->printer->name}}</td>
                                        {{-- <td class="text-center">{{$ticket->city->name}}</td> --}}
                                        <td class="text-center">{{ $ticket->department?->localized_name ?? 'غير متوفر' }}</td>
                                        <td class="text-center">{{ formatDate($ticket->created_at) }}</td>
                                        <td class="text-center">
                                            <!-- You can include actions like restoring or permanently deleting tickets here -->
                                            <a href="{{ route('dashboard.tickets.restore', $ticket->id) }}"
                                                class="btn btn-sm btn-success">
                                                استعادة الطلب
                                            </a>
                                            <div class="btn-group">
                                                <button class="btn btn-danger " type="submit"
                                                    onclick="removeItem('{{route('dashboard.tickets.forceDelete',$ticket->id)}}')">
                                                    حذف نهائي
                                                </button>
                                                <form id="deleteItem" action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>

                                            {{-- Show Review Button --}}
                                            <div class="btn-group">
                                                @if($ticket->review)
                                                <a href="#" data-toggle="modal" onclick="showReview('{{$ticket->id}}')"
                                                    data-target="#reviewModal" class="ml-1 btn btn-sm btn-info">
                                                    <i class="fas fa-star"></i> عرض التقييم
                                                </a>
                                                @else
                                                <button class="ml-1 btn btn-sm btn-secondary" disabled>
                                                    <i class="fas fa-star"></i> عرض التقييم
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                {{ $trashedTickets->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Review Modal --}}
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="reviewModalLabel"><i class="fas fa-star"></i> تقييم الفني</h5>
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
                                <th style="width: 50%"><i class="fas fa-clipboard-list mr-2"></i>المعيار</th>
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
    function showReview(ticket_id) {
        // Fetch review data via AJAX
        $.ajax({
            url: '/dashboard/tickets/' + ticket_id + '/review',
            method: 'GET',
            success: function(response) {
                if (response.review) {
                    let review = response.review;

                    // Calculate average rating
                    let avgRating = (
                        (review.professionalism || 0) +
                        (review.response_time || 0) +
                        (review.quality_of_work || 0) +
                        (review.communication || 0) +
                        (review.overall_satisfaction || 0)
                    ) / 5;

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
                        { name: 'الاحترافية', value: review.professionalism, color: 'primary', icon: 'fa-user-check' },
                        { name: 'وقت الاستجابة', value: review.response_time, color: 'info', icon: 'fa-clock' },
                        { name: 'جودة العمل', value: review.quality_of_work, color: 'success', icon: 'fa-tools' },
                        { name: 'التواصل', value: review.communication, color: 'warning', icon: 'fa-comments' },
                        { name: 'الرضا العام', value: review.overall_satisfaction, color: 'success', icon: 'fa-smile' }
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

                        let rowClass = (index === criteria.length - 1) ? 'style="background-color: #fff3cd;"' : '';
                        tableHtml += '<tr ' + rowClass + '>';
                        tableHtml += '<td><i class="fas ' + item.icon + ' text-' + item.color + ' mr-2"></i><strong>' + item.name + '</strong></td>';
                        tableHtml += '<td class="text-center"><span class="badge bg-' + item.color + '" style="font-size: 1.1rem; padding: 0.5rem 1rem;">' + '5/' + (item.value ?? 'N/A') + '</span></td>';
                        tableHtml += '<td class="text-center">' + stars + '</td>';
                        tableHtml += '</tr>';
                    });

                    $('#reviewTableBody').html(tableHtml);

                    // Display notes
                    if (review.notes) {
                        $('#reviewNotes').text(review.notes);
                    } else {
                        $('#reviewNotes').html('<em class="text-muted">لا توجد ملاحظات إضافية</em>');
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
