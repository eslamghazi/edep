<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير طلبات الصيانة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            font-family: 'DejaVu Sans', 'Roboto', 'Montserrat', 'Open Sans', sans-serif !important;
        }

        body {
            font-size: 12px;
            margin: 0;
            background-color: #f5f5f5;
            text-align: right;
            padding: 10px;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            border: 2px solid #333;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0 0 10px 0;
            font-size: 20px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .stats-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .stats-table th,
        .stats-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: right;
        }

        .stats-table th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        .stats-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .stats-table tr:hover {
            background-color: #f0f0f0;
        }

        .stat-label {
            font-weight: bold;
            width: 50%;
            color: #333;
            text-align: left;
        }

        .stat-value {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            background-color: #e8f5e9;
            color: #1b5e20;
            width: 50%;
        }

        .content-table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .content-table th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: right;
            font-weight: bold;
            border: 1px solid #333;
        }

        .content-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }

        .content-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .content-table tbody tr:hover {
            background-color: #e8f5e9;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
            color: white;
            font-size: 10px;
        }

        .badge-closed {
            background-color: #d9534f;
        }

        .badge-new {
            background-color: #5cb85c;
        }

        .badge-in-progress {
            background-color: #f0ad4e;
        }

        .badge-waiting {
            background-color: #5bc0de;
        }

        .badge-close-request {
            background-color: #d9534f;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            margin-top: 30px;
            border-top: 2px solid #333;
            font-size: 11px;
            color: #666;
        }

        .footer a {
            color: #0066cc;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                background-color: white;
            }

            .container {
                box-shadow: none;
                border: none;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📄 تقرير طلبات الصيانة</h1>
            <p>تاريخ الإعداد: {{ date('Y-m-d H:i') }}</p>
        </div>

        <table class="stats-table">
            <thead>
                <tr>
                    <th>العدد</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="stat-value">{{ $closedTickets }}</td>
                    <td class="stat-label">طلبات مغلقة</td>
                </tr>
                <tr>
                    <td class="stat-value">{{ $newTickets }}</td>
                    <td class="stat-label">طلبات جديدة</td>
                </tr>
                <tr>
                    <td class="stat-value">{{ $inProgressTickets }}</td>
                    <td class="stat-label">طلبات قيد التنفيذ</td>
                </tr>
                <tr>
                    <td class="stat-value">{{ $closeRequestTickets }}</td>
                    <td class="stat-label">طلبات بانتظار الإغلاق</td>
                </tr>
                <tr>
                    <td class="stat-value">{{ $waitingTickets }}</td>
                    <td class="stat-label">طلبات بانتظار الاعتماد</td>
                </tr>
                <tr style="background-color: #ffe6e6;">
                    <td class="stat-value" style="background-color: #ffcccc; color: #991111;">{{ $closedTickets + $newTickets + $inProgressTickets + $closeRequestTickets + $waitingTickets }}</td>
                    <td class="stat-label" style="color: #991111;"><strong>إجمالي الطلبات</strong></td>
                </tr>
            </tbody>
        </table>

        <table class="content-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الطلب</th>
                    <th>اسم العميل</th>
                    <th>رقم الجوال</th>
                    <th>رقم الجهاز</th>
                    <th>نوع العطل</th>
                    <th>موديل الجهاز</th>
                    <th>القسم</th>
                    <th>الحالة</th>
                    <th>فني الصيانة</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                <tr>
                    <td><strong>{{ $loop->iteration }}</strong></td>
                    <td><strong>{{ $ticket->ticket_code }}</strong></td>
                    <td>{{ $ticket->requester_name }}</td>
                    <td dir="ltr">{{ $ticket->phone }}</td>
                    <td>{{ $ticket->printer_code }}</td>
                    <td>{{ $ticket->problemType->name }}</td>
                    <td>{{ $ticket->printer->name }}</td>
                    <td>{{ $ticket->department?->localized_name ?? 'غير متوفر' }}</td>
                    <td>
                        @if ($ticket->status == 'Closed')
                        <span class="badge badge-closed">مغلق</span>
                        @elseif ($ticket->status == 'InProgress')
                        <span class="badge badge-in-progress">قيد التنفيذ</span>
                        @elseif ($ticket->status == 'New')
                        <span class="badge badge-new">جديد</span>
                        @elseif ($ticket->status == 'Waiting')
                        <span class="badge badge-waiting">انتظار</span>
                        @else
                        <span class="badge badge-close-request">إغلاق</span>
                        @endif
                    </td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ formatDate($ticket->created_at) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><strong>&copy; {{ date('Y') }} <a target="_blank" href="https://medadalaamal.com/">نظام مداد</a></strong><br>
            الحقوق محفوظة للشركة مداد للأعمال</p>
    </div>
</body>

</html>
