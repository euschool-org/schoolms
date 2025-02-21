<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateFeesRequest;
use App\Http\Requests\UpdateQuantityRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\StudentsImport;
use App\Models\Currency;
use App\Models\MonthlyFee;
use App\Models\Student;
use App\Services\AttachmentService;
use App\Services\StudentService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public const VALID_COLUMNS = [
        'grade_label',
        'group',
        'sector',
        'contract_start_date',
        'contract_end_date',
        'parent_name',
        'parent_mail',
        'parent_number',
        'currency_label',
        'parent_account',
        'income_account',
        'payment_quantity',
        'additional_information',
        'last_year_balance',
        'yearly_fee',
        'debt',
        'first_half',
        'second_half',
        'yearly_payments_sum',
        'yearly_5p_discounts_sum',
        'yearly_10p_discounts_sum',
        'yearly_individual_discounts_sum',
    ];
    public $attachmentService;

    public $studentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
        $this->studentService = new StudentService();
    }
    public function dashboard(Authenticatable $user, Request $request)
    {
        $data = $this->studentService->getStudents($request);
        return view('dashboard', [
            'students' => $data['students'],
            'total_students' => $data['total_students'],
            'selectedColumns' => $user->column_preferences ? json_decode($user->column_preferences,true) : self::VALID_COLUMNS,
            'allColumns' => self::VALID_COLUMNS,
        ]);
    }

    public function form(Student $student = null)
    {
        if ($student) {
            $student->load([
                'payments' => function ($query) {
                    $query->orderBy('payment_date', 'desc');
                },
                'attachments.user',
                'currency',
                'monthly_fees' => function ($query) {
                    $query->orderBy('month', 'asc');
                },
            ]);
            $update = true;
        } else {
            $student = new Student([
                'name' => '',
                'private_number' => '',
                'grade' => null,
                'group' => '',
                'sector' => '',
                'pupil_status' => null,
                'additional_information' => ''
            ]);
            $update = false;
        }
        return view('student.form',[
            'student' => $student,
            'update' => $update,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());
        if ($student){
            return redirect()->route('student.edit',$student->id)->with('success','Student created successfully');
        } else {
            return redirect()->route('student.create')->with('error','Something went wrong');
        }
    }

    public function generateFeeTable(Student $student)
    {
        if ($student->contract_start_date || $student->contract_end_date){
            $this->studentService->syncStudentFees($student);
            return redirect()->route('student.edit',$student->id)->with('success','Fee table created successfully');
        } else {
            return redirect()->route('student.edit',$student->id)->with('error','Fill Contract Dates');
        }
    }

    public function update(Student $student, UpdateStudentRequest $request)
    {
        $data = $request->validated();
        $data['currency_id'] = isset($data['currency']) ? Currency::where('code',$data['currency'])->first()->id : 1;
        if ($student->update($data)){
            $this->studentService->syncStudentFees($student);
            return redirect()->route('student.edit',$student->id)->with('success','Student updated successfully');
        } else {
            return redirect()->route('student.edit',$student->id)->with('error','Student update failed');
        }
    }

    public function destroy(Student $student)
    {
        foreach ($student->attachments as $attachment){
            $this->attachmentService->deleteAttachment($attachment->filename);
        }

        if ($student->delete()){
            return redirect()->route('dashboard')->with('success','Student deleted successfully');
        } else {
            return redirect()->route('dashboard')->with('error','Student delete failed');
        }
    }

    public function import(ImportRequest $request)
    {
        Excel::import(new StudentsImport, $request->file('file'));

        return back()->with('success', 'Excel file imported successfully.');
    }

    public function export(Request $request)
    {
        $filters = $request->only([
            'name',
            'private_number',
            'grade',
            'group',
            'sector',
            'parent_name',
            'parent_mail',
            'parent_number',
            'pupil_status',
            'additional_information',
            'contract_start_date',
            'contract_end_date',
            'payment_schedule',
            'yearly_payment_from',
            'yearly_payment_to',
            'currency',
            'parent_account',
            'income_account',
            'payment_quantity',
            'custom_discount',
        ]);

        return Excel::download(new StudentExport($filters), 'students.xlsx');
    }

    public function updateFees(UpdateFeesRequest $request)
    {
        $fees = collect($request->validated()['fees']);

        MonthlyFee::whereIn('id', $fees->pluck('id'))
            ->get()
            ->each(function ($fee) use ($fees) {
                $data = $fees->firstWhere('id', $fee->id);
                $fee->update([
                    'fee' => $data['fee'],
                    'month' => $data['month'],
                ]);
            });

        return redirect()->back()->with('success', __('Fees updated successfully.'));
    }

    public function updateQuantity(UpdateQuantityRequest $request)
    {
        $schoolYear = $request->input("school_year");
        $quantity = $request->input("quantity");

        $oldQuantity = MonthlyFee::where('school_year', $schoolYear)->count();

        if ($quantity == $oldQuantity) {
            return redirect()->back()->with('success', __('Fees updated successfully.'));
        }

        // Delete all records for the given school year
        MonthlyFee::where('school_year', $schoolYear)->delete();

        $months = $this->studentService->defaultMonths($quantity, $schoolYear);

        // Create new records with the given quantity
        for ($i = 0; $i < $quantity; $i++) {
            MonthlyFee::create([
                'student_id' => $request->input("student_id"),
                'school_year' => $schoolYear,
                'month' => $months[$i] ?? null,
            ]);
        }

        return redirect()->back()->with('success', __('Fees updated successfully.'));
    }
}
