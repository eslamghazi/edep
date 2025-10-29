@extends('dashboard.layout')

@section('styles')
<style>
    /* Set the initial state for the image with a smooth transition for the transform property */
    .image-zoom-in {
        transition: transform 0.3s ease;
        transform-origin: center;
        /* Zoom in from the center of the image */
    }

    /* When the user hovers over the image, increase its size */
    .image-zoom-in:hover {
        transform: scale(2);
        /* Adjust scale as needed, 1.1 will increase the size to 110% */
    }
</style>

@endsection

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">عرض طلب الصيانة</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">الصفحة الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.tickets.index') }}">قائمة الطلبات</a>
                        </li>
                        <li class="breadcrumb-item active">عرض طلب الصيانة</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @hasanyrole('admin|super-admin|contract-supervisor')
            <div class="row mb-2">
                <form method="POST" action="{{ route('dashboard.tickets.generate-pdf', $ticket->id) }}">
                    @csrf
                    <button class="form-control btn-dark" type="submit">استخراج تقرير PDF</button>
                </form>
            </div>
            @endhasanyrole
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">رقم التذكرة:</label>
                                    <p>{{ $ticket->ticket_code }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">رقم الجوال:</label>
                                    <p dir="ltr">{{ $ticket->phone }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">رقم الصيانة للطابعة:</label>
                                    <p>{{ $ticket->printer_code }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">موديل الطابعة:</label>
                                    <p>{{ $ticket->printer->name }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">وصف العطل:</label>
                                    <p>{{ $ticket->problemType->name }}</p>
                                </div>
                                @if ($ticket->report)
                                <div class="col-md-6 mt-2">
                                    <label class="form-label"> تقرير الصيانة:</label>
                                    <p>{{ $ticket->report }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">تقرير الصيانة بواسطة :</label>

                                    <p> @foreach($ticket->reporter->getRoleNames() as $role)
                                        @if ($role == 'user')
                                        فني الصيانة
                                        @elseif ($role == 'super-admin')
                                        إدارة الشركة
                                        @elseif ($role == 'contract-supervisor')
                                        مشرف العقد
                                        @elseif ($role == 'admin')
                                        مشرف الصيانة
                                        @endif
                                        @endforeach :
                                        {{ $ticket->reporter->name }}
                                    </p>
                                </div>

                                @endif

                                <!-- Continue displaying other fields in a similar manner -->
                                {{--
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">المدينة:</label>
                                    <p>{{ $ticket->city->name }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">المبنى:</label>
                                    <p>{{ $ticket->building->name }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                <label class="form-label">نوع المبنى:</label>
                                <p>{{ $ticket->building_type == 'male' ? 'رجال' : 'نساء' }}</p>
                                </div>
                                --}}
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">القسم:</label>
                                    <p>{{ $ticket->department?->localized_name ?? 'غير متوفر' }}</p>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label class="form-label">اسم منشئ الطلب:</label>
                                    <p>{{ $ticket->requester_name }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="form-label">البريد الإلكتروني:</label>
                                    <p>{{ $ticket->email }}</p>
                                </div>


                                @if ($ticket->description)
                                <div class="col-md-6 mt-2">
                                    <label class="form-label"> تفاصيل العطل:</label>
                                    <p>{{ $ticket->description }}</p>
                                </div>
                                @endif

                                <div class="col-md-6 mt-2">
                                    <label class="form-label">صورة للعطل:</label>
                                    @if ($ticket->image)
                                    <div>
                                        <img class="image-zoom-in" style="width: 250px;height: 250px"
                                            src="{{$ticket->image}}">
                                    </div>
                                    @else
                                    <p>لا توجد صورة</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('dashboard.tickets.index') }}" class="btn btn-primary">رجوع</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection