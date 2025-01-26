<!DOCTYPE html>
<html>
    <head>
        <title>Invoice PDF</title>
        <style>
            body {
                font-family: 'DejaVu Sans', sans-serif;
            }
        </style>
    </head>
    <body>
        <h1>Invoice for დავითი</h1>
        <p>Amount Due: 200$</p>
    <table>
        <thead>
            <th>#</th>
            <th>Tuition Fee for {{$student->name}} <br> {{now()->year . '-' . now()->addYear()->year}} Academic Year</th>
            <th>Price</th>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>სწავლის საფასური / Tuition Fee</td>
                <td>{{$student->yearlyFee(true)}}</td>
            </tr>
            <tr>
                <td></td>
                <td>{{($student->year_payment() > $student->last_year_balance + $student->yearlyFee()) ? 'გადახდა' : 'დავალიანება'}}</td>
                <td>{{abs($student->year_payment() - $student->last_year_balance - $student->yearlyFee())}}</td>
            </tr>
        </tbody>
    </table>
    </body>
</html>
