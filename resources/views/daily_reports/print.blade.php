<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Daily IT Working Report — {{ $dailyReport->report_date->format('d M, Y') }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.5; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; color: #1e3a8a; }
        .header h3 { margin: 2px 0; font-size: 14px; font-weight: normal; color: #475569; }
        .meta-table, .work-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .meta-table td { padding: 5px; }
        .work-table th, .work-table td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        .work-table th { background-color: #f1f5f9; font-weight: bold; }
        .summary-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .footer { margin-top: 50px; display: flex; justify-between: space-between; }
        .signature { text-align: center; width: 200px; border-top: 1px solid #000; padding-top: 5px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer;">🖨️ Print Report</button>
    </div>

    <!-- Official Header -->
    <div class="header">
        <h1>UNNAYAN PROCHESTA</h1>
        <h3>IT Department — Daily IT Working Report</h3>
    </div>

    <!-- Report Meta -->
    <table class="meta-table">
        <tr>
            <td><strong>Report Number:</strong> {{ $dailyReport->report_number }}</td>
            <td><strong>Date:</strong> {{ $dailyReport->report_date->format('d F, Y') }}</td>
        </tr>
        <tr>
            <td><strong>IT Officer:</strong> {{ $dailyReport->user->name }}</td>
            <td><strong>Status:</strong> {{ strtoupper($dailyReport->status) }}</td>
        </tr>
    </table>

    <!-- Summary Box -->
    <div class="summary-box">
        <strong>Report Summary:</strong><br>
        Total Work Entries: {{ $dailyReport->total_entries }} | Total Duration: {{ $dailyReport->formatted_total_duration }}
    </div>

    <!-- Work Details Table -->
    <table class="work-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Work Title & Category</th>
                <th style="width: 15%;">Branch / Asset</th>
                <th style="width: 35%;">Problem & Action Taken</th>
                <th style="width: 10%;">Duration</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dailyReport->workEntries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $entry->title }}</strong><br>
                        <small style="color: #64748b;">{{ $entry->category->name ?? 'N/A' }}</small>
                    </td>
                    <td>
                        {{ $entry->branch->name ?? 'Head Office' }}<br>
                        <small style="color: #64748b;">{{ $entry->asset->asset_tag ?? '' }}</small>
                    </td>
                    <td>
                        <strong>Prob:</strong> {{ $entry->problem ?? 'N/A' }}<br>
                        <strong>Action:</strong> {{ $entry->action_taken ?? 'N/A' }}
                    </td>
                    <td>{{ $entry->formatted_duration }}</td>
                    <td>{{ ucfirst($entry->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No work entries found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signatures -->
    <div style="margin-top: 60px; display: flex; justify-content: space-between;">
        <div class="signature">
            <strong>Prepared By</strong><br>
            {{ $dailyReport->user->name }}<br>
            IT Officer
        </div>
        <div class="signature">
            <strong>Reviewed By</strong><br>
            Authorized Authority
        </div>
    </div>

</body>
</html>