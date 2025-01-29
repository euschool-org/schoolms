<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            padding: 0;
        }
        h2, h3, h4 {
            text-align: center;
            margin: 10px 0;
        }
        .title, .date, .tuitionFees, .Assistant {
            text-align: left;
            margin-left: 10%;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: center;
            padding: 10px;
        }
        .money {
            text-align: right;
        }
        .instruction {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        img {
            display: block;
            width: 100px;
            margin: 10px auto;
        }
        /* Ensure proper page breaks for PDF rendering */
        @page {
            size: A4;
            margin: 20mm;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
<h2>INVOICE #***</h2>
<div class="title">
    <h3>EUROPEAN SCHOOL LTD</h3>
    <h4>Legal address: I, Skhirtlafze av. 2</h4>
    <h4>Company ID: 205172917</h4>
</div>
<h4 class="date">Date: 27.08.2024</h4>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Tuition Fee for {{$student->name}}<br> {{now()->year}}-{{now()->addYear()->year}}</th>
        <th>Semester I</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>სწავლის საფასური / Tuition Fee</td>
        <td class="money">€ {{$student->yearlyFee(true)}}</td>
    </tr>
    <tr>
        <td>2</td>
        <td>{{($student->year_payment() > $student->last_year_balance + $student->yearlyFee()) ? 'გადახდა' : 'დავალიანება'}}</td>
        <td class="money">€ {{abs($student->year_payment() - $student->last_year_balance - $student->yearlyFee())}}</td>
    </tr>
    </tbody>
</table>
<div class="tuitionFees">
    <h3>სწავლის საფასურის 100%-ის გადახდის ვადაა 31 მაისი.</h3>
    <h3>100% of the tuition fee must be paid until 31st of May</h3>
</div>
<h4 class="instruction">*მოკლე ინსტრუქცია გადახდაზე*</h4>
<div class="Assistant">
    <h4>Ana Revazishvili</h4>
    <h4>Accountant Assistant</h4>
    <img src="../beched.jpeg" alt="">
</div>
<div class="page-break"></div>
</body>
</html>
