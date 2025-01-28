<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tailwind CSS Example</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <h1 class="text-2xl font-bold text-center mt-16 mb-16">INVOICE #***</h1>
        <div class="ml-[466px] mt-10 ">
            <h1 class="text-black">EUROPEAN SCHOOL LTD</h1>
            <h1 class="text-black">Legal address: l, skhirtladze av. 2</h1>
            <h1 class="text-black">Company ID: 205172917</h1>
        </div>
        <h1 class="font-medium ml-[466px] mt-10">Date:27.08.2024</h1>

        <table class="w-1/2 table-auto mt-6 text-sm border-collapse border border-gray-300 mx-auto">
            <thead>
                <tr>
                    <th class="border border-gray-300 p-2 ">#</th>
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
                    <td class="border border-gray-300 p-2 text-center ">
                        {{($student->year_payment() > $student->last_year_balance + $student->yearlyFee()) ? 'გადახდა' : 'დავალიანება'}}
                    </td>
                    <td class="border border-gray-300 p-1 text-left text-black font-bold">{{abs($student->year_payment() - $student->last_year_balance - $student->yearlyFee())}}</td>
                </tr>
            </tbody>
{{--            <tfoot>--}}
{{--            <tr>--}}
{{--                <td class="text-black border p-2 font-bold text-center">5</td>--}}
{{--                <td class="text-black border text-2xl p-2 text-right font-bold">Total</td>--}}
{{--                <td class="text-black border text-2xl p-2  font-bold">--}}
{{--                    <span class="text-left">€</span>--}}
{{--                    <span class="text-right">1,350.00</span>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--            </tfoot>--}}
        </table>
        <div class="ml-[466px]">
            <h3 class="mt-5">სწავლის საფასურის 100%-ის გადახდის ვადაა 31 მაისი.</h3>
            <h3> 100% of the tuiton fee must be paid until 31st of may</h3>
        </div>
        <h4 class="ml-[466px] pl-36 mt-36">*მოკლე ინსტრუქცია გადახდაზე*</h4>
        <div class="ml-[466px]">
            <h1 class="text-gray-700 font-bold mt-36">Ana Revazishvili</h1>
            <h1 class="text-gray-700 font-bold">Accountant Assistant</h1>
        </div>
    </body>
</html>
