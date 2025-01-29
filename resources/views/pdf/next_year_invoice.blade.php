<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h2>INVOICE #***</h2>
        <div class="title">
            <h1>EUROPEAN SCHOOL LTD</h1>
            <h1>Legal address: l, skhirtlafze av. 2</h1>
            <h1>Company ID: 205172917</h1>
        </div>
        <h1 class="date">Date:27.08.2024</h1>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        Tuition Fee for {{$student->name}}<br> {{now()->year}}-{{now()->addYear()->year}}
                    </th>
                    <th>
                        Semester I
                    </th>
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

        {{--    <tfoot>--}}
        {{--    <tr>--}}
        {{--        <td>5</td>--}}
        {{--        <td class="total">Total</td>--}}
        {{--        <td class="moneyTotal">--}}
        {{--            € 1,350.00--}}
        {{--        </td>--}}
        {{--    </tr>--}}
        {{--    </tfoot>--}}
        </table>
        <div class="tuitionFees">
            <h3>სწავლის საფასურის 100%-ის გადახდის ვადაა 31 მაისი.</h3>
            <h3> 100% of the tuiton fee must be paid until 31st of may</h3>
        </div>
        <h4 class="instruction">*მოკლე ინსტრუქცია გადახდაზე*</h4>
        <div class="Assistant">
            <h4>Ana Revazishvili</h4>
            <h4 class="block">Accountant Assistant</h4>
            <img src="../beched.jpeg" alt="">
        </div>
    </body>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin-left: 400px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            text-align: center;
            padding: 10px;
        }
        h4{
            margin: 0px;
        }
        h2{
            text-align: center;
        }
        .title{
            font-size: 8px;
            margin-left: 22%;
            margin-top: 4%;
        }
        .date{
            font-size: 18px;
            margin-left: 22%;
            margin-top: 2%;
            margin-bottom: 20px;
        }
        .money{
            text-align: left;
        }
        .total{
            text-align: right;
            font-size: 25px;
            font-weight: bold;
        }
        .moneyTotal{
            text-align: left;
            font-weight: bold;
            font-size: 25px;
        }
        .tuitionFees{
            font-size: 15px;
            margin-left: 22%;
        }
        .instruction{
            text-align: center;
            margin-top: 150px;
            margin-bottom: 100px;
        }
        .Assistant{
            margin-left: 22%;
        }
        img{
            width: 15%;
            margin-left: 15%;
            margin-top: -6%;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
        }
    </style>
</html>
