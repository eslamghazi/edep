<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>Ticket Show</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            font-family: 'DejaVu Sans', 'Roboto', 'Montserrat', 'Open Sans', sans-serif !important;
        }

        body {
            font-size: 7px;
            margin: 0;
            background-color: #fff;
            text-align: right;
        }

        .container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .content {
            width: 100%;
            max-width: 1000px;
            /* Increased max-width */
            margin: auto;
        }

        table {
            width: 100%;
            font-size: 7px;
            border-collapse: collapse;
        }

        th {
            background-color: #333;
            /* Dark background for the header */
            color: white;
            /* Light text color for contrast */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
            /* Align text to the right for Arabic */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Define background colors for each status */
        .closed td {
            background-color: #d9534f;
            /* Red for closed tickets */
            color: white;
        }

        .new td {
            background-color: #5cb85c;
            /* Green for new tickets */
            color: white;
        }

        .in-progress td {
            background-color: #f0ad4e;
            /* Orange for in-progress tickets */
            color: white;
        }


        /* Add more styling as needed */
    </style>
</head>

<body>

    <div class="container">
        <table>
            <tr>
                <td>{{ $closedTickets }}</td>
                <td style="font-weight: bold">طلب مغلق</td>
            </tr>
            <tr>
                <td>{{ $newTickets }}</td>
                <td style="font-weight: bold">طلب جديد</td>
            </tr>
            <tr>
                <td>{{ $inProgressTickets }}</td>
                <td style="font-weight: bold">قيد التنفيذ</td>
            </tr>

            <tr>
                <td>{{ $closeRequestTickets }}</td>
                <td style="font-weight: bold">تم ارسال طلب الإغلاق</td>
            </tr>

            <tr>
                <td>{{ $waitingTickets }}</td>
                <td style="font-weight: bold">بانتظار اعتماد التسعيرة</td>
            </tr>
        </table>
    </div>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>تاريخ الطلب</th>
                    <th>فني الصيانة</th>
                    <th>رقم الجوال</th>
                    <th>حالة الطلب</th>
                    {{-- <th>اسم المبني</th> --}}
                    {{-- <th>اسم المدينة</th> --}}
                    <th>القسم</th>
                    <th>العطل</th>
                    <th>نوع الآلة</th>
                    <th>رقم الآلة</th>
                    <th>اسم العميل</th>
                    <th>رقم التذكرة</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                <tr>
                    <td style="font-weight: bold">{{ formatDate($ticket->created_at) }}</td>
                    <td style="font-weight: bold">{{$ticket->user->name}}</td>
                    <td style="font-weight: bold" dir="ltr">{{$ticket->phone}}</td>
                    @if ($ticket->status == 'Closed')
                    <td style="font-weight: bold" class="text-center"><span class="badge bg-dark">مغلق
                      </span></td>
                    @elseif ($ticket->status == 'InProgress')
                    <td style="font-weight: bold" class="text-center"><span class="badge bg-warning">قيد التنفيذ
                      </span></td>
                    @elseif ($ticket->status == 'New')
                    <td style="font-weight: bold" class="text-center"><span class="badge bg-success">طلب جديد
                      </span></td>
                    @elseif ($ticket->status == 'Waiting')
                    <td style="font-weight: bold" class="text-center"><span class="badge bg-blue">بانتظار اعتماد التسعيرة
                      </span></td>
                    @else
                    <td style="font-weight: bold" class="text-center"><span class="badge bg-danger">تم إرسال طلب الإغلاق
                      </span></td>
                    @endif
                    {{-- <td style="font-weight: bold">{{$ticket->building->name}}</td> --}}
                    {{-- <td style="font-weight: bold">{{$ticket->city->name}}</td> --}}
                    <td style="font-weight: bold">{{$ticket->department?->localized_name}}</td>
                    <td style="font-weight: bold">{{$ticket->problemType->name}}</td>
                    <td style="font-weight: bold">{{$ticket->printer->name}}</td>
                    <td style="font-weight: bold">{{$ticket->printer_code}}</td>
                    <td style="font-weight: bold">{{$ticket->requester_name}}</td>
                    <td style="font-weight: bold">{{$ticket->ticket_code}}</td>
                    <td style="font-weight: bold">{{$loop->iteration}}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
        <div class="footer">
            &copy; {{ date('Y') }} <a target="_blank" href="https://medadalaamal.com/">Medad</a>. الحقوق محفوظة
            لمداد
        </div>
    </div>
</body>

</html>
