<?php

namespace App\Http\Controllers;

use App\Application;
use App\Clients;
use App\PaymentSchedule;
use App\Units;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    //
    public function index()
    {
        $this->checkForOverdues();
        $applications = Application::all();
        return view('applications.index', compact('applications'));
    }

    public function active()
    {
        $this->checkForOverdues();
        $applications = Application::whereDoesntHave('schedules',function($q){
            $q->where('due_date','<',Carbon::now())
                ->where('status','unpaid');
        })
            ->get();
//        return $applications;
//
//        dd($applications);
        return view('applications.active', compact('applications'));
    }

    public function overdue()
    {
        $this->checkForOverdues();
        $applications = Application::whereHas('schedules',function($q){
            $q->where('due_date','<',Carbon::now())
                ->where('status','unpaid');
        })
            ->get();
        return view('applications.overdue', compact('applications'));
    }

    public function checkForOverdues()
    {
        $overDues = PaymentSchedule::with('application')->whereDate('due_date', '<', now()->toDateString())->get();
        foreach($overDues as $overDue){
            $overDue->payable_amount = $overDue->application->gross_monthly_rate;
            $overDue->save();
        }
    }

    public function create()
    {
        $clients = Clients::all();
        $units = Units::all();
        return view('applications.create', compact('clients', 'units'));
    }

    public function store(Request $request)
    {

        $requestJson = $request->all();
        unset($requestJson['_token']);
        $requestJson['application_number'] =  sprintf('%08d', Application::count()+1);

        $requestJson['total_price'] = preg_replace('/,/','', $requestJson['total_price']);
        $requestJson['down_payment'] = preg_replace('/,/','', $requestJson['down_payment']);
        $requestJson['gross_monthly_rate'] = preg_replace('/,/','', $requestJson['gross_monthly_rate']);
        $requestJson['rebate'] = preg_replace('/,/','', $requestJson['rebate']);
        $requestJson['net_monthly_rate'] = preg_replace('/,/','', $requestJson['net_monthly_rate']);
        $requestJson['first_payment_due'] = preg_replace('/,/','', $requestJson['first_payment_due']);
        $requestJson['terms'] = $requestJson['months'];
        $requestJson['amortization'] = $requestJson['net_monthly_rate'];
        $requestJson['start_date'] = $requestJson['first_due_date'];
        $requestJson['end_date'] = Carbon::parse($requestJson['first_due_date'])->addMonth($requestJson['terms'])->toDateString();
//        DB::beginTransaction();
        $new_application = Application::create($requestJson);
        $date = Carbon::parse($new_application->start_date);
        foreach(range(1, $new_application->terms) as $index){

            $date->addMonth();
            $paymentSchedules = new PaymentSchedule();
            $paymentSchedules->application_id = $new_application->id;
            $paymentSchedules->due_date = $date->toDateString();
            $paymentSchedules->payable_amount = $new_application['net_monthly_rate'];
            $paymentSchedules->status = 'unpaid';
            $paymentSchedules->paid_date = Carbon::parse()->toDateString();
            $paymentSchedules->save();
        }

        return redirect()->route('application.index');
    }
}
