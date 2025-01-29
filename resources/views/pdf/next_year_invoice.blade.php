<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            font-size: 16px;
        }

        h3 {
            font-size: 14px;
        }

        h4 {
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
            display: block;
            margin: 0 auto;
        }

        .company-info {
            text-align: left;
            margin-top: 20px;
            line-height: 1.4;
        }

        .date {
            margin-top: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
            text-align: center;
            font-size: 13px;
        }

        table td.text-center {
            text-align: center;
        }

        table td.text-right {
            text-align: right;
        }

        .notes {
            margin-top: 20px;
            line-height: 1.4;
        }

        .signature {
            margin-top: 30px;
            text-align: left;
            line-height: 1.4;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <h1 class="title">INVOICE #***</h1>
    </div>

    <div class="company-info">
        <h1>EUROPEAN SCHOOL LTD</h1>
        <h1>Legal address: l, skhirtladze av. 2</h1>
        <h1>Company ID: 205172917</h1>
    </div>

    <div class="date">
        Date: 27.08.2024
    </div>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Tuition Fee for {{$student->name}}<br>({{now()->year}}-{{now()->addYear()->year}} Academic Year)</th>
            <th>Semester I</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="text-center">სწავლის საფასური / Tuition Fee</td>
            <td class="text-right font-bold">{{$student->yearlyFee(true)}}</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td class="text-center">
                {{($student->year_payment() > $student->last_year_balance + $student->yearlyFee()) ? 'გადახდა' : 'დავალიანება'}}
            </td>
            <td class="text-right font-bold">
                {{abs($student->year_payment() - $student->last_year_balance - $student->yearlyFee())}}
            </td>
        </tr>
        </tbody>
    </table>

    <div class="notes">
        <h3>სწავლის საფასურის 100%-ის გადახდის ვადაა 31 მაისი.</h3>
        <h3>100% of the tuition fee must be paid until 31st of May.</h3>
    </div>

    <div class="signature">
        <h3 class="text-gray-700 font-bold">Ana Revazishvili</h3>
        <h3 class="text-gray-700 font-bold">Accountant Assistant</h3>
    </div>
</div>
</body>
</html>
