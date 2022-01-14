@extends('layouts.master')

@section('title', 'History')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="\">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#import_application">Import</a>
                <a href="{{ route('application.create') }}" class="btn btn-primary">New Application</a>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>@yield('title')</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                           placeholder="Search in table">
                                </div>
                            </div>
                        </div>

                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                            <tr>
                                <th>Client</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Brand New/Repo</th>
                                <th>Cash/Installment</th>
                                <th class="text-right" data-sort-ignore="true"><i class="fa fa-cogs text-success"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applications as $data)
                                <tr>
                                    <td>{{ $data->client->name }}</td>
                                    <td>{{ $data->unit->engine_no .' - '. $data->unit->model }}</td>
                                    <td>{{ currency_format($data->total_price) }}</td>
                                    <td>{{ $data->unit->bnew_repo_display }}</td>
                                    <td>{{ ucfirst($data->cash_installment) }}</td>
                                    <td class="text-right">
                                        <div class="btn-group text-right">
                                            <button class="action btn-white btn btn-xs sched_modal_trigger"
                                                    data-schedule="{{$data->schedules}}" data-app="{{$data}}"><i
                                                        class="fa fa-calendar text-success"></i> Schedules
                                            </button>
                                        </div>
{{--                                        <a href="#" class="btn btn-primary btn-xs payment_modal_trigger"--}}
{{--                                           data-amount_monthly="{{currency_format($data->amortization)}}"--}}
{{--                                           data-amount_semimonthly="{{currency_format($data->amortization/2)}}"--}}
{{--                                           data-amount_max="{{currency_format($data->total_price)}}"--}}
{{--                                           data-id="{{$data->id}}"--}}
{{--                                           data-status="{{$data->status}}"--}}
{{--                                        ><i class="fa fa-money"></i> Pay </a>--}}
                                        <a href="#" class="btn btn-warning btn-xs payment_history_modal_trigger"
                                           data-payments="{{$data->payments}}"
                                           data-status="{{$data->status}}"
                                        ><i
                                                    class="fa fa-list"></i> Payments </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('modals.payment_schedules')
    @include('modals.payment_verification')
    @include('modals.payment_history')
    @include('modals.import')

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
@endsection

@section('scripts')
    {!! Html::script('js/template/plugins/footable/footable.all.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).on('click', '.payment_history_modal_trigger', function () {
            $('#payment_history_modal').modal('show');
            var data_payments = $(this).data('payments');
            var data_status = $(this).data('status');
            console.log(data_payments)

            $('#payment_history_tbody').empty();


            for (let i = 0; i < data_payments.length; i++) {
                const dataPayment = data_payments[i];
                console.log(dataPayment)
                let setRows = '<tr>';
                setRows += '<td class="text-right">';
                setRows += numberWithCommas(dataPayment.paid_amount);
                setRows += '</td>';
                setRows += '<td>';
                setRows += dataPayment.reference_number;
                setRows += '</td>';
                setRows += '<td>';
                setRows += dataPayment.paid_date_formatted;
                setRows += '</td>';
                setRows += '</tr>';
                $('#payment_history_tbody').append(setRows);
            }
        });
        $(document).on('click', '.payment_modal_trigger', function () {
            var verify_payment_modal = $('#verify_payment_modal');
            verify_payment_modal.modal('show');
            var data_semimonthly = $(this).data('amount_semimonthly');
            var data_monthly = $(this).data('amount_monthly');
            var data_max = $(this).data('amount_max');
            var data_id = $(this).data('id');
            var data_status = $(this).data('status');
            $('#verify_payment_show').hide();
            if (data_status == 'Active') {
                $('#verify_payment_show').show();
            }
            $('.verify_amount_fast_semi').attr('data-amount', data_semimonthly);
            $('.verify_amount_fast_monthly').attr('data-amount', data_monthly);
            $('.verify_amount_fast_max').attr('data-amount', data_max);
            $('#verify_loan_id').val(data_id);
        });
        $(document).on('click', '#verify_payment_show', function () {
            $('#verify_payment').show();
            $(this).hide();

        });
        $(document).on('click', '.verify_amount_fast_btn', function () {
            var data_amount = $(this).data('amount');
            $('#verify_amount').val(data_amount);
        });
        $(document).on('click', '.sched_modal_trigger', function () {
            var sched_modal = $('#sched_modal');
            sched_modal.modal('show');
            $('#schedules_tbody').empty();
            var data_schedules = $(this).data('schedule')
            var data_app = $(this).data('app')
            if (data_app) {

                var rem_bal = data_app.rem_bal;
                var total_paid = data_app.total_paid;
                var total_payable = data_app.total_payable;
                console.log(rem_bal)
                console.log(total_paid)
                console.log(total_payable)

                if (rem_bal && total_payable) {

                    $('#sched_rem_bal').html(numberWithCommas(rem_bal.toFixed(2)));
                    $('#sched_total_paid').html(numberWithCommas(total_paid.toFixed(2)));
                    $('#sched_total_payable').html(numberWithCommas(total_payable.toFixed(2)));
                }


                for (let i = 0; i < data_schedules.length; i++) {
                    const dataSchedule = data_schedules[i];

                    var tr_classes = dataSchedule.is_overdue ? 'overdue' : '';

                    let setRows = '<tr class="' + tr_classes + '">';
                    setRows += '<td>';
                    setRows += dataSchedule.due_date_display;
                    setRows += '</td>';
                    setRows += '<td class="text-right">';
                    setRows += numberWithCommas(dataSchedule.payable_amount);
                    setRows += '</td>';
                    // setRows += '<td class="text-right">';
                    // setRows += numberWithCommas(data_app.rebate);
                    // setRows += '</td>';
                    // setRows += '<td class="text-right">';
                    // setRows += numberWithCommas(data_app.gross_monthly_rate);
                    // setRows += '</td>';
                    setRows += '<td class="text-right">';
                    if (dataSchedule.paid_amount > 0) {
                        setRows += numberWithCommas(dataSchedule.paid_amount);
                    }
                    setRows += '</td>';
                    setRows += '<td>';
                    setRows += dataSchedule.status_display;
                    setRows += '</td>';
                    setRows += '</tr>';
                    $('#schedules_tbody').append(setRows);
                }
            }

        });
        $(document).ready(function () {
            {{--var modal = $('#modal');--}}

            $('.footable').footable();

            var mem = $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                placement: 'bottom'
            });

        });
    </script>
@endsection
