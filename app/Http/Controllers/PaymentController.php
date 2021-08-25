<?php

namespace App\Http\Controllers;

use App\Application;
use App\Clients;
use App\Payments;
use App\PaymentSchedule;
use App\Units;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //
    public function index()
    {
    }//

    public function create()
    {
    }

    public function store(Request $request)
    {
        $requestJson = $request->all();
        DB::beginTransaction();
        $payments = new Payments();
        $payments->application_id = $requestJson['application_id'];
        $payments->paid_amount = preg_replace('/,/', '', $requestJson['paid_amount']);
        $payments->reference_number = $requestJson['reference_number'];
        $payments->save();

        $paidAmounts = $payments->paid_amount;
        $paymentAmounts = [];

        $loanScheduleFirst = PaymentSchedule::where('application_id', $payments->application_id)
            ->where('status', 'unpaid')
            ->first();
        $loanAmor = $loanScheduleFirst->payable_amount;
        $loanRemainingLast = 0;
        if ($loanScheduleFirst->paid_amount > 0) {
            $loanRemainingLast = $loanScheduleFirst->payable_amount - $loanScheduleFirst->paid_amount;
        }
        do {
            if ($loanRemainingLast > 0) {
                if ($paidAmounts > $loanRemainingLast) {
                    $paymentAmounts[] = $loanRemainingLast;
                    $paidAmounts -= $loanRemainingLast;
                }
                $loanRemainingLast = 0;
            } else {
                if ($paidAmounts < $loanAmor) {
                    $paymentAmounts[] = $paidAmounts;
                } else {
                    $paymentAmounts[] = $loanAmor;
                }
                $paidAmounts -= $loanAmor;
            }
        } while ($paidAmounts > 0);

        foreach ($paymentAmounts as $paymentAmount) {
            $loanSchedule = PaymentSchedule::where('application_id', $request->application_id)
                ->whereRaw('paid_amount != payable_amount')
                ->first();
            $loanSchedule->paid_amount += $paymentAmount;
            $loanSchedule->save();

            if ($loanSchedule->paid_amount == $loanSchedule->payable_amount) {
                $loanSchedule->status = 'paid';
                $loanSchedule->save();
            }
        }

        DB::commit();
        return redirect()->back();
    }
}
