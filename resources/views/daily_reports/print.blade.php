<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Daily Work Report - {{ $report->report_date }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; padding: 20px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #6366f1; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; color: #4338ca; }
        .header p { margin: 2px 0 0; font-size: 13px; color: #64748b; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 8px; font-size: 13px; border-bottom: 1px solid #e2e8f0; }
        .work-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .work-table th, .work-table td { border: 1px solid #cbd5e1; padding: 10px; font-size: 12px; text-align: left; }
        .work-table th { background-color: #f1f5f9; font-weight: bold; }
        .footer { margin-top: 40px; text-align: right; font-size: 12px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4338ca; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
            🖨️ PDF সেভ করুন / প্রিন্ট করুন
        </button>
    </div>

    <div class="header">
        <h1>Unnayan Prochesta - IT Management System</h1>
        <p>দৈনন্দিন কাজের বিবরণী (Daily Working Report)</p>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>রিপোর্ট তারিখ:</strong> {{ \Carbon\Carbon::parse($report->report_date)->format('d F, Y') }}</td>
            <td><strong>প্রদানকারী:</strong> {{ $report->user->name }}</td>
            <td><strong>মোট কাজের সময়:</strong> {{ $report->total_duration }}</td>
        </tr>
    </table>

    <table class="work-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 35%;">কাজের বিষয়</th>
                <th style="width: 15%;">ক্যাটাগরি</th>
                <th style="width: 25%;">সংক্রান্ত ব্রাঞ্চ/ডিভাইস</th>
                <th style="width: 20%;">সময়</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->workEntries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $entry->title }}</strong>
                        @if($entry->description)
                            <br><small style="color: #64748b;">{{ $entry->description }}</small>
                        @endif
                    </td>
                    <td>{{ $entry->category }}</td>
                    <td>
                        {{ $entry->branch->name ?? 'N/A' }}
                        @if($entry->asset)
                            <br><small>({{ $entry->asset->name }})</small>
                        @endif
                    </td>
                    <td>{{ $entry->duration_minutes }} মিনিট</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <br><br>
        <p>___________________________<br>দায়িত্বপ্রাপ্ত কর্মকর্তা স্বাক্ষর</p>
    </div>
</body>
</html>