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


        .instruction {
            margin-top: 30px;
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
        <h1 class="title">INVOICE {{substr(Str::uuid()->toString(), 0, 8)}}</h1>
    </div>

    <div class="company-info">
        <h1>EUROPEAN SCHOOL LTD</h1>
        <h1>Legal address: l, skhirtladze av. 2</h1>
        <h1>Company ID: 205172917</h1>
    </div>

    <div class="date">
        Date: {{now()->format('d/m/Y')}}
    </div>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Tuition Fee for {{$student->name}}<br>({{now()->year}}-{{now()->addYear()->year}} Academic Year)</th>
            <th>Semester I</th>
            <th>Semester 2</th>
        </tr>
        </thead>
        @php
            $symbol = match((int)$student->currency_id){
               1 => '€',
               2 => '$',
               3 => '₾',
           };
           $discount = $student->individual_discount ?? 0;
           $nextYearFee = $student->upcoming_yearly_fee;
           $semesterFee = $nextYearFee/2;
           $balance = $student->yearly_payments_sum - $student->last_year_balance - $student->yearly_fee;
           $firstHalfBalance = max($semesterFee - $balance - $discount, 0);
           $secondHalfBalance = min($semesterFee, $nextYearFee - $balance - $discount);
        @endphp
        <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="text-center">სწავლის საფასური / Tuition Fee</td>
            <td class="text-right font-bold">{{$semesterFee . ' ' . $symbol}} </td>
            <td class="text-right font-bold">{{$semesterFee . ' ' . $symbol}}</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td class="text-center">
                {{($balance > 0) ? 'გადახდა / Payment ' : 'დავალიანება / Debt'}}
            </td>
            <td class="text-right font-bold">
                {{-$balance . ' ' . $symbol}}
            </td>
            <td class="text-right font-bold">
            </td>
        </tr>
        @if($student->individual_discount)
        <tr>
            <td class="text-center">3</td>
            <td class="text-center">
                ფასდაკლება / Discount
            </td>
            <td class="text-right font-bold">
                -{{$student->individual_discount . ' ' . $symbol}}
            </td>
            <td class="text-right font-bold">

            </td>
        </tr>
        @endif
        <tr>

        </tr>
        <tr>
            <td class="text-center">4</td>
            <td class="text-right font-bold">
                ჯამი / Subtotal
            </td>
            <td class="text-right font-bold">
                {{$firstHalfBalance . ' ' . $symbol}}
            </td>
            <td class="text-right font-bold">
                {{$secondHalfBalance . ' ' . $symbol}}
            </td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td class="text-center">5</td>
            <td class="text-center font-bold" colspan="2">
                სრული თანხა / Total
            </td>
            <td class="text-right font-bold" >
                {{$nextYearFee - $balance - $discount}} {{$symbol}}
            </td>
        </tr>
        </tbody>
    </table>

    <div class="notes">
        @if($student->next_payment_quantity == 1)
        <div>სწავლის საფასურის 100%-ის გადახდის ვადაა 31 მაისი.</div>
        <div>100% of the tuition fee must be paid until 31st of May.</div>
        @elseif($student->next_payment_quantity == 2)
            @if(now()->month > 6 && !$student->eligibleToDiscount())
            <div>
                სწავლის საფასურის 50%-ის გადახდის ვადაა 31 მაისი, დარჩენილი 50%-ის – 15 დეკემბერი.
            </div>
            <div>
                50% of the tuiton fee must be paid until 31st of May, the remaining 50% - until 15th of December.
            </div>
            @else
            <div>
                სწავლის საფასურის 50%-ის გადახდის ვადაა 31 მაისი, დარჩენილი 50%-ის – 15 დეკემბერი.<br>
                (არჩევითი 5%-იანი ფასდაკლება: როდესაც პირველი ნახევარი გადახდილია დროულად, სრული თანხის მხოლოდ 45% შეგიძლიათ გადაიხადოთ 1-ელ აგვისტომდე.)
            </div>
            <div>
                50% of the tuiton fee must be paid until 31st of May, the remaining 50% - until 15th of December.<br>
                (Optional 5% discount: if the first 50% is paid in due time, only the 45% of the annual tuition fee can be paid no later than 1st of August.)
            </div>
            @endif
        @elseif($student->next_payment_quantity == 10)
        <div>
            სწავლის საფასურის 1/10 გადახდილი უნდა იქნას ყოველი თვის ბოლოს, სექტემბრიდან ივნისის ჩათვლით.
        </div>
        <div>
            1/10 of the annual tuition fee must be paid at the end of each month, from September to June.
        </div>
        @endif
    </div>

    <div class="instruction">
        <span>თანხის გადასახდელად შეგიძლიათ გამოიყენოთ ბანკის მობილური აპლიკაცია/სწრაფი გადახდის ტერმინალი. გადახდაში აირჩიეთ <b>განათლება</b>, მოძებნეთ <b>ევროპული სკოლა</b> და მიუთითეთ მოსწავლის იდენტიფიკატორი.
            <br>
            To pay the amount, you can use the bank's mobile application/Paybox. In Payment select <b>Education</b>, search for <b>European School</b> and enter the student identifier.
        </span>
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
