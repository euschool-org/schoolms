<!DOCTYPE html>
<html>
    <head>
        <title>Invoice PDF</title>
    </head>
    <body>
        <table>
            <thead>
                <th>#</th>
                <th>Tuition Fee for {{$student->name}} <br> {{now()->year . '-' . now()->addYear()->year}} Academic Year </th>
                <th>Price</th>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>სწავლის საფასური / Tuition Fee</td>
                    <td>{{$student->yearlyFee(true)}}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>წინა წლის ბალანსი / Last Year Balance</td>
                    <td>{{$student->last_year_balance - $student->year_payment()}}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>გადახდები / Payments</td>
                    <td>{{$student->year_payment() - $student->last_year_balance}}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
