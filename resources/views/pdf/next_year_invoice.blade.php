<!DOCTYPE html>
<html>
    <head>
        <title>Invoice PDF</title>
    </head>
    <body>
    {{$sti}}
        <h1>Invoice for დავითი</h1>
        <p>Amount Due: 100$</p>

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
                <td>{{$student->activeBalance() > 0 ? 'გადახდა' : 'დავალიანება'}}</td>
                <td>{{$student->activeBalance()}}</td>
            </tr>
        </tbody>
    </table>
    </body>
</html>
