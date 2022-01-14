<?php

namespace App\Http\Controllers;

use App\Application;
use App\Clients;
use App\Payments;
use App\PaymentSchedule;
use App\Repossessed;
use App\Units;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    //
    public function index()
    {
        return redirect()->route('application-status-active');
    }

    public function active()
    {
//        $this->checkForOverdues();
        $status = 'active';
        $applications = Application::whereDoesntHave('schedules', function ($q) {
            $q->where('due_date', '<', Carbon::now())
                ->where('status', 'unpaid');
        })->where('status', 0)
            ->get();
        return view('applications.overdue', compact('applications', 'status'));
    }

    public function history()
    {
//        $this->checkForOverdues();
        $status = 'completed';
        $applications = Application::where('status', 1)
            ->get();
        return view('applications.overdue', compact('applications', 'status'));
    }

    public function overdue()
    {
//        $this->checkForOverdues();
        $status = 'overdue';
        $applications = Application::whereHas('schedules', function ($q) {
            $q->where('due_date', '<', Carbon::now())
                ->where('status', 'unpaid');
        })
            ->get();
        return view('applications.overdue', compact('applications', 'status'));
    }

    public function checkForOverdues()
    {
        $overDues = PaymentSchedule::with('application')
            ->whereDate('due_date', '<', now()->toDateString())
            ->get();
        foreach ($overDues as $overDue) {
//            if($overDue->status != 'paid'){
//                $overDue->payable_amount = $overDue->application->gross_monthly_rate;
//            }else{
            $overDue->payable_amount = $overDue->application->net_monthly_rate;

//            }
            $overDue->save();
        }
    }

    public function create()
    {
        $clients = Clients::all();
        $units = Units::where('bnew_repo', 'bnew')->get();
        $repo = Units::where('bnew_repo', 'repo')->get();
        return view('applications.create', compact('clients', 'units', 'repo'));
    }

    public function import(Request $request)
    {
        $request->excel->storeAs('temp', 'file.xlsx');
        $reader = ReaderEntityFactory::createXLSXReader()->setShouldFormatDates(true);
        $reader->open(storage_path('app/temp/file.xlsx'));
        $applications = [];
        $colFormatDate = [
            'dob',
            'first_due_date',
            'due_date',
            'date_paid',
            'dob',
            'dob',
        ];
        foreach ($reader->getSheetIterator() as $sheetKey => $sheet) {
            $sheetName = Str::slug($sheet->getName(), '_');
            $application = [];
            $headers = [];

            foreach ($sheet->getRowIterator() as $key => $row) {
                $data = [];
                $errorMessage = '';
                $application_id = '';
                $sampleData = [];

                //check if application id exist
                if (count($row->getCells()) > 0) {
                    if ($row->getCells()[0]) {
                        $application_id = $row->getCells()[0]->getValue();
                    }
                }
                if ($key == 1) {
                    foreach ($row->getCells() as $keyCells => $value) {
                        $headers[] = $value->getValue();
                    }
                } else {
                    foreach ($row->getCells() as $keyCells => $value) {
                        $sampleData[] = $value->getValue();
                    }
                }

                if (!isset($row->getCells()[1]) || $row->getCells()[1] == '') {
                }

                foreach ($row->getCells() as $keyCells => $value) {
//                    $colName = $keyCells;
                    if (isset($headers[$keyCells]) && $headers[$keyCells] != "") {
                        $colName = Str::slug($headers[$keyCells], '_');
                        $data[$colName] = $value->getValue();

                        //if column is date
                        if (in_array($colName, $colFormatDate)) {
                            try {
                                $data[$colName . "_raw"] = $value->getValue();
                                $data[$colName] = Carbon::parse($value->getValue())->toDateString();
                            } catch (\Exception $exception) {

                            }
                        }
                    }
                }
                $applications[$application_id][$sheetName][] = $data;
            }
        }
        $reader->close();
        DB::beginTransaction();

        foreach ($applications as $key => $application) {

            if ($key == "APPLICATION ID" || $key == "") {
                continue;
            }
            $application_id = null;
            $applicationExist = 0;
            $unit = null;
            if (array_key_exists('application', $application)) {

                $array = $application['application'][0];
                if ($array['last_name'] && $array['first_name']) {
                    $client = Clients::firstOrCreate([
                        "lname" => $array["last_name"],
                        "fname" => $array["first_name"],
                        "mname" => $array["middle_name"],
                        "contact_number_1" => $array["mobile_no1"],
                        "contact_number_2" => $array["mobile_no2"],
                        "marital_status" => $array["marital_status"],
                        "dob" => $array["dob"],
                        "address" => $array["address"],
                        "barangay" => $array["barangay"],
                        "city" => $array["municipality"],
                        "province" => "Albay",
                        "remarks" => $array["remarks"]
                    ]);
                }
                if ($array['model'] && $array['brand']) {
                    try {

                        $unit = Units::firstOrCreate([
                            'model' => $array['model'],
                            'brand' => $array['brand'],
                            'engine_no' => $array['engine_no'],
                            'plate_no' => $array['plate_no'],
                            'chassis_no' => $array['chassis_no'] ?? $array['chasis_no'],
                            'color' => $array['color'] ?? $array['color'],
                            'bnew_repo' => strtolower($array['bnew_repo'])
                        ]);

                    } catch (\Exception $exception) {
                        dd($array);
                    }
                }

//                $app_number = sprintf('%08d', Application::count() + 1);
                if ($array['total_payment'] && $array['months']) {

                    try {

                        $app_number = $key;
                        if (Application::firstOrNew(['application_number' => $key])->exists()) {
                            $applicationExist = 1;
                            $modelApplication = Application::firstOrNew(['application_number' => $key]);
                        } else {
                            $modelApplication = new Application();
                        }
                        $array['cash_installment'] = $array['cash_installment'] ?? $array['cash_install'];
                        $array['initial_payment'] = $array['initial_payment'] ?? $array['initial_pay'];

                        $modelApplication->cash_installment = $array['cash_installment'];
                        $modelApplication->client_id = $client->id;
                        $modelApplication->unit_id = $unit->id;
                        $modelApplication->application_number = $app_number;
                        $modelApplication->total_price = $array['total_payment'];

                        if ($array['cash_installment'] != 'cash') {
                            $modelApplication->down_payment = $array['initial_payment'];
                            $modelApplication->terms = $array['months'];
                            $modelApplication->rebate = $array['rebate'];
                            $modelApplication->start_date = Carbon::parse($array['first_due_date'])->toDateString();
                            $totalLessInitialPayment = cleanNum($modelApplication->total_price) - cleanNum($modelApplication->down_payment);
                            $amortization = $totalLessInitialPayment / cleanNum($modelApplication->terms);
                            $modelApplication->amortization = $amortization;
                            $modelApplication->first_payment_due = $amortization;
                            $modelApplication->gross_monthly_rate = $amortization;
                            $modelApplication->net_monthly_rate = $amortization - $modelApplication->rebate;
                            $modelApplication->end_date = Carbon::parse($modelApplication->start_date)->addMonths($modelApplication->terms);
                        }
                        $modelApplication->save();

                        if ($applicationExist) {
                            PaymentSchedule::where('application_id', $modelApplication->id)->delete();
                        }
                        $date = Carbon::parse($modelApplication->start_date);
                        foreach (range(1, $modelApplication->terms) as $index) {

                            $date->addMonth();
                            $paymentSchedules = new PaymentSchedule();
                            $paymentSchedules->application_id = $modelApplication->id;
                            $paymentSchedules->due_date = $date->toDateString();
                            $paymentSchedules->payable_amount = $modelApplication['net_monthly_rate'];
                            $paymentSchedules->status = 'unpaid';
                            $paymentSchedules->paid_date = null;
                            $paymentSchedules->save();
                        }
                        $application_id = $modelApplication->id;
                    } catch (\Exception $exception) {

                        dd(
                            $exception->getMessage(). '; Line: '.$exception->getLine(),
                            $array,
                            $exception,
                        );
                    }
                }


            }
            if (array_key_exists('payment', $application) && $application_id) {

                $payments = $application['payment'];
                //"application_id",
                //"due_date",
                //"amount_paid",
                //"series_no",
                //"date_paid"
                if ($applicationExist) {
                    Payments::where('application_id', $application_id)->delete();
                }
                foreach ($payments as $payment) {

                    $newPayments = new Payments();
                    $newPayments->application_id = $application_id;
                    if (isset($payment['amount_paid'])) {
                        if (cleanNum($payment['amount_paid']) > 0) {
                            $newPayments->paid_amount = cleanNum($payment['amount_paid']);
                            if (isset($payment['series_no'])) {
                                $newPayments->reference_number = $payment['series_no'];
                            }
                            if (isset($payment['date_paid'])) {
                                $newPayments->payment_date = Carbon::parse($payment['date_paid'])->toDateString();
                            }
                            $newPayments->save();
                        }
                    }

                    $paidAmounts = $newPayments->paid_amount;
                    $paymentAmounts = [];

                    $loanScheduleFirst = PaymentSchedule::where('application_id', $application_id)
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
                        $loanSchedule = PaymentSchedule::where('application_id', $application_id)
                            ->whereRaw('paid_amount != payable_amount')
                            ->where('status', 'unpaid')
                            ->first();
                        $loanSchedule->paid_amount += $paymentAmount;
                        $loanSchedule->save();

                        if ($loanSchedule->paid_amount == $loanSchedule->payable_amount) {
                            $loanSchedule->status = 'paid';
                            $loanSchedule->paid_date = Carbon::parse($payment['date_paid'])->toDateString();
                            $loanSchedule->save();
                        }
                    }

                }
            }

            if (array_key_exists('repo_previous_owners', $application)) {
                $repo_owners = $application['repo_previous_owners'];
                foreach ($repo_owners as $array) {
                    if ($array["last_name"] && $unit) {
                        try {

                            $client = Clients::firstOrCreate([
                                "lname" => $array["last_name"],
                                "fname" => $array["first_name"],
                                "mname" => $array["middle_name"],
                                "contact_number_1" => $array["mobile_no1"],
                                "contact_number_2" => $array["mobile_no2"],
                                "marital_status" => $array["marital_status"],
                                "dob" => $array["dob"],
                                "address" => $array["address"],
                                "barangay" => $array["barangay"],
                                "city" => $array["municipality"],
                                "province" => "Albay",
                                "remarks" => $array["remarks"]
                            ]);
                            $repo = Repossessed::firstOrCreate(['unit_id' => $unit->id, 'client_id' => $client->id]);
                        }catch (\Exception $exception){
                            dd(
                                $exception->getMessage(). '; Line: '.$exception->getLine(),
                                $array,
                                $exception,
                            );

                        }
                    }
                }
            }
        }
        DB::commit();
        return redirect()->back()->with('successful', 'Successfully Imported!');
    }

    public function store(Request $request)
    {

        $requestJson = $request->all();
        unset($requestJson['_token']);
        if ($request->cash_installment == 'cash') {
            $requestJson['total_price'] = $requestJson['total_price_cash'];
        }
        $requestJson['application_number'] = sprintf('%08d', Application::count() + 1);
        $type = null;
        if ($request->has('unit_id')) {
            $type = 'unit';
        }
        if ($request->has('repo_id')) {
            $type = 'repo';
        }
        if (!$type) {
            return redirect()->back()
                ->with('danger', 'No Unit/Repo Selected!')->withInput($request->input());
        }
        $requestJson['total_price'] = preg_replace('/,/', '', $requestJson['total_price']);
        $requestJson['down_payment'] = preg_replace('/,/', '', $requestJson['down_payment']);
        $requestJson['gross_monthly_rate'] = preg_replace('/,/', '', $requestJson['gross_monthly_rate']);
        $requestJson['rebate'] = preg_replace('/,/', '', $requestJson['rebate']);
        $requestJson['net_monthly_rate'] = preg_replace('/,/', '', $requestJson['net_monthly_rate']);
        $requestJson['first_payment_due'] = preg_replace('/,/', '', $requestJson['first_payment_due']);
        $requestJson['terms'] = $requestJson['months'];
        $requestJson['amortization'] = $requestJson['net_monthly_rate'];
        $requestJson['start_date'] = $requestJson['first_due_date'];
        $requestJson['end_date'] = Carbon::parse($requestJson['first_due_date'])->addMonth($requestJson['terms'])->toDateString();
//        DB::beginTransaction();
        $new_application = Application::create($requestJson);
        if ($request->cash_installment == 'cash') {
            $payments = new Payments();
            $payments->application_id = $new_application->id;
            $payments->paid_amount = cleanNum($requestJson['total_price']);
            $payments->reference_number = $requestJson['reference_number'];
            $payments->payment_date = Carbon::parse($requestJson['paid_date'])->toDateString();
            $payments->save();
            $new_application->status = 1;
            $new_application->save();
            return redirect()->route('application-status-history');
        } else {
            $date = Carbon::parse($new_application->start_date);
            foreach (range(1, $new_application->terms) as $index) {

                $date->addMonth();
                $paymentSchedules = new PaymentSchedule();
                $paymentSchedules->application_id = $new_application->id;
                $paymentSchedules->due_date = $date->toDateString();
                $paymentSchedules->payable_amount = $new_application['net_monthly_rate'];
                $paymentSchedules->status = 'unpaid';
                $paymentSchedules->paid_date = Carbon::parse()->toDateString();
                $paymentSchedules->save();
            }
        }

        $withOverdue = Application::where('id', $new_application->id)->whereHas('schedules', function ($q) {
            $q->where('due_date', '<', Carbon::now())
                ->where('status', 'unpaid');
        })->exists();
        if ($withOverdue) {
            return redirect()->route('application-status-overdue');
        }

        $redirect = $requestJson['_redirect'];
        if ($redirect != 'application') {
            return redirect()->url($redirect);
        }

        return redirect()->route('application.index');
    }
}
