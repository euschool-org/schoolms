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
            font-size: 10px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            font-size: 12px;
        }

        h3 {
            font-size: 10px;
        }

        h4 {
            font-size: 10px;
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
            font-size: 10px;
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

        .signature-container {
            margin-top: 30px;
        }

        .signature-info {
            text-align: left;
            white-space: nowrap;
        }

        .signature-img img {
            width: 240px;
            height: auto;
            float: left; /* Float the image to the left */
            margin-left: 200px; /* Add spacing between text and image */
            margin-top: -70px;
        }


        .instruction-title {
            font-size: 16px;
            font-weight: bold;
            color: black;
        }

        .signature-name {
            font-size: 14px;
            font-weight: bold;
            color: #4a5568; /* Equivalent to Tailwind 'text-gray-700' */
        }

        .signature-role {
            font-size: 12px;
            font-weight: bold;
            color: #4a5568;
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
        @if($student->individual_discount)
        <tr>
            <td class="text-center">3</td>
            <td class="text-center">
                ფასდაკლება
            </td>
            <td class="text-right font-bold">
                {{$student->individual_discount}}
            </td>
        </tr>
        @endif
        </tbody>
    </table>

    <div class="notes">
        <h3>სწავლის საფასურის 100%-ის გადახდის ვადაა 31 მაისი.</h3>
        <h3>100% of the tuition fee must be paid until 31st of May.</h3>
    </div>

    <div class="instruction">
        <span class="instruction-title">*მოკლე ინსტრუქცია გადახდაზე*</span><br>
    </div>
    <div class="signature-container">
        <div class="signature-info">
            <span class="signature-name">Ana Revazishvili</span><br>
            <span class="signature-role">Accountant Assistant</span>
        </div>
        <div class="signature-img">
            <img src="{{ public_path('images/signature.jpeg') }}" alt="Signature">
        </div>
    </div>
</div>
</body>
</html>
