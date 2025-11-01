<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>عرض طلب الصيانة</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            font-family: 'DejaVu Sans', 'Courier New', monospace !important;
        }

        body {
            font-size: 14px;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            text-align: right;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
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
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th {
            background-color: #333;
            color: white;
            padding: 12px;
            text-align: right;
            font-weight: bold;
            border: 1px solid #333;
            font-size: 13px;
        }

        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: right;
            font-size: 13px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        .label-cell {
            background-color: #e8e8e8;
            font-weight: bold;
            width: 30%;
            text-align: right;
        }

        .value-cell {
            width: 70%;
            text-align: left;
        }

        .section-header {
            background-color: #555;
            color: white;
            padding: 10px 12px;
            font-weight: bold;
            font-size: 14px;
        }

        .section-row td {
            background-color: #f5f5f5;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            color: white;
            font-size: 12px;
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

        .footer {
            text-align: center;
            padding-top: 20px;
            margin-top: 30px;
            border-top: 2px solid #333;
            font-size: 12px;
            color: #666;
        }

        .footer a {
            color: #0066cc;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .report-section {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .report-section h3 {
            margin-top: 0;
            color: #856404;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }

        .info-item {
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 5px;
        }

        .info-item-label {
            font-weight: bold;
            color: #333;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .info-item-value {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🔧 عرض طلب الصيانة</h1>
            <p>تقرير تفصيلي لطلب الصيانة</p>
        </div>

        <table>
            <tr class="section-header">
                <th colspan="2">معلومات الطلب الأساسية</th>
            </tr>
            <tr>
                <td class="value-cell"><strong>{{ $ticket->ticket_code }}</strong></td>
                <td class="label-cell">رقم التذكرة</td>
            </tr>
            <tr>
                <td class="value-cell">
                    @if ($ticket->status == 'Closed')
                    <span class="badge badge-closed">مغلق</span>
                    @elseif ($ticket->status == 'InProgress')
                    <span class="badge badge-in-progress">قيد التنفيذ</span>
                    @elseif ($ticket->status == 'New')
                    <span class="badge badge-new">طلب جديد</span>
                    @elseif ($ticket->status == 'Waiting')
                    <span class="badge badge-waiting">بانتظار الاعتماد</span>
                    @else
                    <span class="badge" style="background-color: #d9534f;">تم إرسال طلب الإغلاق</span>
                    @endif
                </td>
                <td class="label-cell">حالة الطلب</td>
            </tr>
            <tr>
                <td class="value-cell">{{ formatDate($ticket->created_at) }}</td>
                <td class="label-cell">تاريخ الإنشاء</td>
            </tr>
        </table>

        <table>
            <tr class="section-header">
                <th colspan="2">معلومات صاحب الطلب</th>
            </tr>
            <tr>
                <td class="value-cell">{{ $ticket->requester_name }}</td>
                <td class="label-cell">اسم صاحب الطلب</td>
            </tr>
            <tr>
                <td class="value-cell" dir="ltr"><strong>{{ $ticket->phone }}</strong></td>
                <td class="label-cell">رقم الجوال</td>
            </tr>
            <tr>
                <td class="value-cell" dir="ltr">{{ $ticket->email ?? 'غير متوفر' }}</td>
                <td class="label-cell">البريد الإلكتروني</td>
            </tr>
            <tr>
                <td class="value-cell">{{ $ticket->department?->name ?? 'غير متوفر' }}</td>
                <td class="label-cell">القسم</td>
            </tr>
        </table>

        <table>
            <tr class="section-header">
                <th colspan="2">معلومات الجهاز والعطل</th>
            </tr>
            <tr>
                <td class="value-cell"><strong>{{ $ticket->printer->name }}</strong></td>
                <td class="label-cell">موديل الجهاز</td>
            </tr>
            <tr>
                <td class="value-cell"><strong>{{ $ticket->printer_code }}</strong></td>
                <td class="label-cell">رقم الصيانة للجهاز</td>
            </tr>
            <tr>
                <td class="value-cell">{{ $ticket->problemType->name }}</td>
                <td class="label-cell">نوع العطل</td>
            </tr>
            @if ($ticket->description)
            <tr>
                <td class="value-cell">{{ $ticket->description }}</td>
                <td class="label-cell">تفاصيل العطل</td>
            </tr>
            @endif
        </table>

        @if ($ticket->report)
        <div class="report-section">
            <h3>📋 تقرير الصيانة</h3>
            <p><strong>التقرير:</strong></p>
            <p style="line-height: 1.6; white-space: pre-wrap;">{{ $ticket->report }}</p>
            <p style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ffc107;">
                <strong>تقرير بواسطة:</strong><br>
                @foreach($ticket->reporter->getRoleNames() as $role)
            <span style="display: block; margin-top: 5px;">
                @if ($role == 'user')
                فني الصيانة
                @elseif ($role == 'super-admin')
                مدير النظام
                @elseif ($role == 'contract-supervisor')
                مشرف العقد
                @elseif ($role == 'admin')
                مشرف الصيانة
                @endif
                - {{ $ticket->reporter->name }}
            </span>
        @endforeach
            </p>
        </div>
        @endif

        <div class="footer">
            <strong>&copy; {{ date('Y') }} <a target="_blank" href="https://medadalaamal.com/">نظام مداد</a></strong><br>
            الحقوق محفوظة لشركة مداد الأعمال
        </div>
    </div>
</body>

</html>
