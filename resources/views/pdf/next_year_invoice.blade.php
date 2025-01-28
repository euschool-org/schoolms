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
            }

            .container {
                width: 80%;
                margin: 0 auto;
            }

            h1, h3, h4 {
                margin: 0;
                padding: 0;
            }

            .header {
                text-align: center;
                margin-top: 50px;
                margin-bottom: 30px;
            }

            .company-info {
                text-align: left;
                margin-top: 30px;
                line-height: 1.6;
            }

            .date {
                margin-top: 20px;
                font-weight: bold;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 30px;
            }

            table th, table td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: left;
            }

            table th {
                background-color: #f4f4f4;
                text-align: center;
            }

            table td.text-center {
                text-align: center;
            }

            table td.text-right {
                text-align: right;
            }

            .notes {
                margin-top: 30px;
                line-height: 1.6;
            }

            .signature {
                margin-top: 50px;
                text-align: left;
                line-height: 1.6;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
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
                <h4>*მოკლე ინსტრუქცია გადახდაზე*</h4>
                <h1 class="text-gray-700 font-bold">Ana Revazishvili</h1>
                <h1 class="text-gray-700 font-bold">Accountant Assistant</h1>
            </div>
        </div>
    </body>
</html>
