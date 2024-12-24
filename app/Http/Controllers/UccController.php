<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class UccController extends Controller
{
    public function ucc(Request $request)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><debt-response/>');
        try {
            switch ($request->get('action')) {
                case 'debt':
                    $this->debt($request, $xml);
                    break;
                case 'pay':
                    $this->pay($request, $xml);
                    break;
                default:
                    return 'no action';
            }
        } catch (\Exception $e) {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><debt-response/>');
            $xml->addChild('status', 2);
        }

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    }

    private function debt(Request $request, $xml)
    {
        if ($request->get('user') != env('UCC_USER')){
            $xml->addChild('status',6);
        } elseif ($request->get('hash') != $this->hash($request->get('action'), $request->get('abonentCode'))){
            $xml->addChild('status',5);
        } else {
            $student = Student::where('private_number',$request->abonentCode)->first();
            if ($student == null){
                $xml->addChild('status',1);
            } else {
                $debt = $this->getDebt($student);
                $xml->addChild('status', 0);
                $xml->addChild('debt', $debt);
                $xml->addChild('name', $student->name);
            }
        }
    }

    public function pay(Request $request, $xml)
    {
        if ($request->user != env('UCC_USER')){
            $xml->addChild('status',6);
        } elseif ($request->hash != $this->hash($request->get('action'), $request->get('abonentCode'),$request->get('paymentId'), $request->get('amount'))){
            $xml->addChild('status',5);
        } elseif(Payment::where('payment_id',$request->get('paymentId'))->exists()){
            $xml->addChild('status',4);
        } else {
            $student = Student::where('private_number',$request->get('abonentCode'))->first();
            if ($student == null){
                $xml->addChild('status',1);
            } else {
                $statusCode = $this->registerPayment($student, $request->get('paymentId'), $request->get('amount'));
                $xml->addChild('status', $statusCode);
            }
        }
    }

    private function getDebt($student)
    {
        return 15;
    }

    private function registerPayment($student, $paymentId, $amount)
    {
        if (Payment::where('payment_id', $paymentId)->first()){
            return 4;
        }

        Payment::create([
            'student_id' => $student->id,
            'payment_id' => $paymentId,
            'payment_date' => now()->format('Y-m-d H:i:s'),
            'payment_amount' => $amount,
            'nominal_amount' => $amount / $student->currency->rate_to_gel,
            'currency_rate' => $student->currency->rate_to_gel,
            'discount' => 0,
        ]);

        return 0;
    }

    private function hash($action, $abonentCode, $paymentId = null, $amount = null)
    {
        $user = env('UCC_USER');
        $secretKey = env('UCC_SECRET');

        // Concatenate in specified order
        $stringToHash = $action . $abonentCode . $paymentId . $amount . $user . $secretKey;

        // Generate MD5 hash
        return md5($stringToHash);
    }
}
