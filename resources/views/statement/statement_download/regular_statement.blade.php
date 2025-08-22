<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Bill Regular</title>
    <style>
        @page { margin: 5mm 12mm 5mm 12mm; }
        body { font-family: "Times New Roman", serif; font-size: 12px; }
        .header_table, .body_table_1, .footer_table_1 { width: 100%; border-collapse: collapse; }
        .header_table td { text-align: center; font-size: 13px; }
        .body_table_1 th, .body_table_1 td { border: 1px solid #000; padding: 4px; text-align: center; }
        .body_table_1 td { font-size: 15px; }
        .footer_table_1 { margin-top: 50px; font-size: 12px; }
        .page-break { page-break-after: always; }
        td.textstart { text-align: left; } td.textend { text-align: right; } td.textcenter { text-align: center; }
    </style>
</head>
<body>

@php
    // Ordinal helper (1=>1st, 2=>2nd, 3=>3rd, else => th)
    $ordinals = [1 => '1st', 2 => '2nd', 3 => '3rd', 4 => '4th', 5 => '5th', 6 => '6th', 7 => '7th', 8 => '8th'];
    $yearText = $ordinals[$session_info->year ?? null] ?? (($session_info->year ?? '') . 'th');
    $semesterText = $ordinals[$session_info->semester ?? null] ?? (($session_info->semester ?? '') . 'th');
@endphp

@hasanyrole('Teacher|Admin|SuperAdmin')

{{-- Repeatable Header --}}
<table class="header_table" style="table-layout: fixed;">
    <colgroup>
        <col style="width: 15%;">
        <col style="width: 35%;">
        <col style="width: 20%;">
        <col style="width: 30%;">
    </colgroup>

    <tr>
        <td colspan="1" style="text-align: right; padding: 20px 0 0 0;">
            <img src="{{ public_path('images/logo_duet.png') }}" style="width: 50px;">
        </td>
        <td colspan="3" style="text-align: left; padding: 20px 0 0 35px;">
            <strong>Dhaka University of Engineering &amp; Technology, Gazipur</strong><br>
            <span style="display:inline-block; margin-left:100px; margin-top:5px;">Gazipur-1707</span>
        </td>
    </tr>

    <tr>
        <td colspan="4" style="padding: 10px 0;">
            <div style="margin-left:5px; font-weight:bold;">(Department of Architecture)</div>
        </td>
    </tr>

    <tr>
        <td style="text-align:right; padding-right:10px;">Bachelor in Architecture</td>
        <td>
            <span>{{ $yearText }} year {{ $semesterText }} semester</span>
        </td>
        <td style="text-align:left; padding-left:40px;">
                <span style="font-weight:bold">
                    {{ isset($exam_type) && (int)$exam_type === 2 ? 'Review' : 'Regular' }}
                </span>
        </td>
        <td style="text-align:right;">Examination: {{ $session_info->session ?? '' }}</td>
    </tr>
</table>

<h3 style="margin-top:15px;margin-bottom: 4px">
    A) List of Examination Committee/Moderation Committee Members (@ min 1500/- per member)
</h3>

{{-- Body Table --}}
<table class="body_table_1" style="margin-top: 0px;" border="1" cellpadding="6">
    <thead>
    <tr>
        <th style="width:10%;">Sl. No.</th>
        <th style="width:65%;">Name and Address</th>
        <th style="width:25%;">Position</th>
    </tr>
    </thead>
    <tbody>
        @foreach($assigns_order_1 as $i => $assign)
            @php
                $person = $assign->teacher ?? $assign->employee;
                $email  = data_get($person, 'user.email');
                $isChair = $email === ($headEmail ?? null);
            @endphp
            <tr>
                <td style="text-align:center;">{{ $i + 1 }}</td>
                <td style="text-align: left;">
                    {{ $person?->user?->name }},
                    {{ $person?->designation?->designation }},
                    {{ $person?->department?->fullname }},
                    DUET, Gazipur
                </td>
                <td style="text-align:center;">{{ $isChair ? 'Chairman' : 'Member' }}</td>
            </tr>
        @endforeach
    </tbody>

</table>

@endhasanyrole

</body>
</html>
