<!DOCTYPE html>
<html dir="rtl">

<head>
    <title>Arabic Maintenance Request View</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
            text-align: right;
        }

        .container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: right;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table>
            <tr>
                <th colspan="2">عرض طلب الصيانة</th>
            </tr>
            <tr>
                <td>{{ $ticket->ticket_code }}</td>
                <td>رقم التذكرة</td>
            </tr>
            <!-- Repeat rows for each piece of information -->
            <tr>
                <td>{{ $ticket->printer->name }}</td>
                <td>موديل الطابعة</td>
            </tr>
            <tr>
                <td>{{ $ticket->printer_code }}</td>
                <td>رقم الصيانة للطابعة</td>
            </tr>

            <tr>
                <td>{{ $ticket->problemType->name }}</td>
                <td>وصف العطل</td>
            </tr>

            @if ( $ticket->report)
            <tr>
                <td>{{ $ticket->report }}</td>
                <td>تقرير الصيانة</td>
            </tr>
            @endif

            <tr>
                <td>{{ $ticket->requester_name }}</td>
                <td>اسم منشئ الطلب</td>
            </tr>

            <tr>
                <td>{{ $ticket->phone }}</td>
                <td>رقم الجوال</td>
            </tr>

            @if ($ticket->report)
            <tr>
                <td>{{ $ticket->report }}</td>
                <td>تقرير الصيانة</td>
            </tr>

            <tr>
                <td>
                    @foreach($ticket->reporter->getRoleNames() as $role)
                    {{ $ticket->reporter->name }} :
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

                <td>تقرير الصيانة بواسطة</td>
            </tr>
            @endif

            {{-- <tr>
                <td>{{$ticket->city->name}}</td>
                <td>المدينة</td>
            </tr>

            <tr>
                <td>{{$ticket->building->name}}</td>
                <td>المبني</td>
            </tr> --}}

            <tr>
                <td>{{ $ticket->department?->localized_name }}</td>
                <td>القسم</td>
            </tr>

           {{-- <tr>
                <td>
                    {{ $ticket->building_type == 'male' ? 'رجال' : 'نساء' }}
                </td>
                <td>نوع المبني</td>
            </tr> --}}

            <tr>
                <td>{{ $ticket->email }}</td>
                <td>البريد الإلكتروني</td>
            </tr>

            @if ($ticket->description)
            <tr>
                <td>{{ $ticket->description }}</td>
                <td>تفاصيل العطل</td>
            </tr>
            @endif
        </table>
        <div class="footer">
            <strong>&copy; {{ date('Y') }} <a target="_blank" href="https://medadalaamal.com/">Medad</a>.</strong>
            الحقوق محفوظة لمداد
        </div>
    </div>
</body>

</html>
