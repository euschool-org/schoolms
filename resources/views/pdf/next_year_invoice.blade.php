<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CSS Example</title>
        <style>
            body {
                font-family: 'DejaVu Sans', sans-serif;
            }

            h1 {
                font-size: 1.5rem;
                font-weight: 700;
            }

            .text-center {
                text-align: center;
            }

            .mt-16 {
                margin-top: 4rem;
            }

            .mb-16 {
                margin-bottom: 4rem;
            }

            .ml-466px {
                margin-left: 466px;
            }

            .mt-10 {
                margin-top: 2.5rem;
            }

            .font-medium {
                font-weight: 500;
            }

            .w-1\/2 {
                width: 50%;
            }

            .table-auto {
                table-layout: auto;
            }

            .mt-6 {
                margin-top: 1.5rem;
            }

            .text-sm {
                font-size: 0.875rem;
            }

            .border-collapse {
                border-collapse: collapse;
            }

            .border {
                border-width: 1px;
                border-color: #d1d5db;
                border-style: solid;
            }

            .border-gray-300 {
                border-color: #d1d5db;
            }

            .p-2 {
                padding: 0.5rem;
            }

            .p-1 {
                padding: 0.25rem;
            }

            .text-black {
                color: black;
            }

            .font-bold {
                font-weight: 700;
            }

            .text-left {
                text-align: left;
            }

            .text-right {
                text-align: right;
            }

            .text-gray-700 {
                color: #374151;
            }

            .mt-5 {
                margin-top: 1.25rem;
            }

            .mt-36 {
                margin-top: 9rem;
            }

            .pl-36 {
                padding-left: 9rem;
            }
        </style>
    </head>
    <body>
        <h1 class="text-center mt-16 mb-16">INVOICE #***</h1>
        <div class="ml-466px mt-10">
            <h1 class="text-black">EUROPEAN SCHOOL LTD</h1>
            <h1 class="text-black">Legal address: l, skhirtladze av. 2</h1>
            <h1 class="text-black">Company ID: 205172917</h1>
        </div>
        <h1 class="font-medium ml-466px mt-10">Date:27.08.2024</h1>

        <table class="w-1/2 table-auto mt-6 text-sm border-collapse border border-gray-300 mx-auto">
            <thead>
            <tr>
                <th class="border border-gray-300 p-2">#</th>
                <th class="border text-black border-gray-300 p-2 text-center">
                    Tuition Fee for {{$student->name}}
                    <h1>({{now()->year . '-' . now()->addYear()->year}} Academic Year)</h1>
                </th>
                <th class="border text-black border-gray-300 p-2 text-left">
                    Semester I
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border border-gray-300 p-2 text-center">1</td>
                <td class="border p-1 text-center">სწავლის საფასური / Tuition Fee</td>
                <td class="border border-gray-300 p-1 text-left text-black font-bold">{{$student->yearlyFee(true)}}</td>
            </tr>
            <tr>
                <td class="border border-gray-300 p-2 text-center">2</td>
                <td class="border border-gray-300 p-2 text-center">
                    {{($student->year_payment() > $student->last_year_balance + $student->yearlyFee()) ? 'გადახდა' : 'დავალიანება'}}
                </td>
                <td class="border border-gray-300 p-1 text-left text-black font-bold">{{abs($student->year_payment() - $student->last_year_balance - $student->yearlyFee())}}</td>
            </tr>
            </tbody>
        </table>
        <div class="ml-466px">
            <h3 class="mt-5">სწავლის საფასურის 100%-ის გადახდის ვადაა 31 მაისი.</h3>
            <h3>100% of the tuiton fee must be paid until 31st of May</h3>
        </div>
        <h4 class="ml-466px pl-36 mt-36">*მოკლე ინსტრუქცია გადახდაზე*</h4>
        <div class="ml-466px">
            <h1 class="text-gray-700 font-bold mt-36">Ana Revazishvili</h1>
            <h1 class="text-gray-700 font-bold">Accountant Assistant</h1>
        </div>
    </body>
</html>
