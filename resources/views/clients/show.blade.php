@extends('layouts.master')

@section('title', 'Client')

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
                {{Form::open(['route'=>['client.destroy', $client->id], 'method'=>'delete'])}}
                <button class="btn btn-danger">Delete</button>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                @include('alerts.validation')
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{$client->name}}</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-5 col-md-12 col-sm-12">
                                <div class="contact-box">
                                    <a class="row" href="{{route('client.edit',$client->id)}}">
                                        <div class="col-4">
                                            <div class="text-center">
                                                <img alt="image" class="rounded-circle m-t-xs img-fluid"
                                                     src="{{$client->image_primary}}">
                                                {{--                                                <div class="m-t-xs font-bold">Graphics designer</div>--}}
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <h3><strong>{{$client->name}}</strong></h3>
                                            <p>
                                                <i class="fa fa-motorcycle"></i> {{$client->application?$client->application->unit->chassis_no:''}}
                                            </p>
                                            <address>
                                                {{--                                                <strong>Twitter, Inc.</strong><br>--}}
                                                {{$client->address}}, {{$client->barangay}}<br>
                                                {{$client->city}}, {{$client->province}}<br>
                                                {{$client->contact_number_1.($client->contact_number_2?'/'.$client->contact_number_2:'')}}
                                            </address>
                                        </div>
                                    </a>
                                </div>
                                @foreach($client->applicationsSortStatus as $key => $application)
                                    {{--                                    <pre>{{json_encode($key, 128)}}</pre>--}}
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="heading{{$application->id}}">
                                                <h4 class="panel-title d-flex justify-content-between align-items-center">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapse{{$application->id}}" aria-expanded="true"
                                                       aria-controls="collapse{{$application->id}}">
                                                        {{$application->application_number .' - '. $application->unit->engine_no}}
                                                    </a>
                                                    @if($application->status == 0)
                                                        <a href="#"
                                                           class="btn btn-primary btn-xs payment_modal_trigger float-right text-white"
                                                           data-amount_monthly="{{currency_format($application->amortization)}}"
                                                           data-amount_semimonthly="{{currency_format($application->amortization/2)}}"
                                                           data-amount_max="{{currency_format($application->total_price)}}"
                                                           data-id="{{$application->id}}"
                                                           data-status="{{$application->status}}"
                                                        ><i class="fa fa-money"></i> Pay </a>
                                                    @endif
                                                </h4>
                                            </div>
                                            <div id="collapse{{$application->id}}"
                                                 class="panel-collapse collapse in {{$key==0?($application->status==0?'show':''):''}}"
                                                 role="tabpanel"
                                                 aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="ibox">
                                                        <div class="ibox-content">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <dt>Total Balance</dt>
                                                                </div>
                                                                <div class="col">
                                                                    <dd id="">{{$application->rem_bal}}</dd>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <dt>Total Payment</dt>
                                                                </div>
                                                                <div class="col">
                                                                    <dd id="">{{$application->total_paid}}</dd>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <dt>Total Due Amount</dt>
                                                                </div>
                                                                <div class="col">
                                                                    <dd id="">{{$application->total_payable}}</dd>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($application->cash_installment == 'installment')
{{--                                                    <pre>{{json_encode($application->schedules, 128)}}</pre>--}}
                                                    <table class="table table-bordered footable" data-page-size="8" data-filter=#filter>

                                                        <thead>
                                                        <tr>
                                                            <th>Due Date</th>
                                                            <th class="text-right">Rebate</th>
                                                            <th class="text-right">Amount</th>
                                                            <th class="text-right">Paid Amount</th>
                                                            <th>Status</th>
                                                            <th>Paid Date</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($application->schedules as $schedule)
                                                            <tr>
                                                                <td>{{$schedule->due_date_display}}</td>
                                                                <td class="text-right">{{$application->rebate}}</td>
                                                                <td class="text-right">{{$schedule->payable_amount}}</td>
                                                                <td class="text-right">{{$schedule->paid_amount>0?$schedule->paid_amount:''}}</td>
                                                                <td>{{ucfirst($schedule->status)}}</td>
                                                                <td>{{$schedule->paid_date_display}}</td>
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
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-7">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        @include('applications.partials.create-form', ['from' => 'client'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    @include('modals.payment_verification')
    @include('applications.modals.add-client')
    @include('applications.modals.add-unit')

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
{{--    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}--}}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2.min.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2-bootstrap4.min.css') !!}
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    <style>
        .panel-heading {
            padding: 0;
        }

        .panel-heading h4 {
            padding: 10px 5px;
            margin: 0;
        }
        #installment, #cash
        {
            display: none;
        }
    </style>
@endsection


@section('scripts')
    {!! Html::script('js/template/plugins/footable/footable.all.min.js') !!}
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/plugins/select2/select2.full.min.js') !!}
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
{{--    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}--}}
    {!! Html::script('https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js') !!}

    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>


        Inputmask.extendAliases({
            money: {
                prefix: "",
                groupSeparator: ".",
                alias: "numeric",
                placeholder: "0",
                autoGroup: true,
                digits: 2,
                digitsOptional: true,
                clearMaskOnLostFocus: false
            }
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).on('input', '#total_price,#down_payment,#total_less_downpayment', function () {
            var total_price = $('#total_price').val();
            total_price = parseFloat(total_price.replace(/,/g, ''))
            var down_payment = $('#down_payment').val();
            down_payment = parseFloat(down_payment.replace(/,/g, ''))
            var total_less_downpayment = total_price - down_payment;
            $('#total_less_downpayment').val(numberWithCommas(total_less_downpayment));
        });
        $(document).on('input', '#months', function () {
            var month = $('#months').val()
            if (parseInt(month) > 1) {
                $("#years").val(month / 12);
            }
        });
        $(document).on('click', '#submit_application', function () {
            $('input').prop('disabled', false)
        });
        $(document).on('input', '#months,#total_price,#down_payment', function () {
            var month = $('#months').val();
            var total_price = $('#total_price').val();
            total_price = parseFloat(total_price.replace(/,/g, ''))
            var down_payment = $('#down_payment').val();
            down_payment = parseFloat(down_payment.replace(/,/g, ''))
            var total_less_downpayment = total_price - down_payment;
            // console.log(total_less_downpayment)
            // console.log(month)
            var gross_monthly_rate = numberWithCommas(parseFloat(total_less_downpayment / parseInt(month)).toFixed(2));
            // console.log(gross_monthly_rate)
            if (total_less_downpayment && month > 0) {
                $("#first_payment_due").val(gross_monthly_rate);
                $('#gross_monthly_rate').val(gross_monthly_rate);
            }
        });
        $(document).on('input', '#rebate', function () {
            var gross_monthly_rate = $('#gross_monthly_rate').val();
            gross_monthly_rate = parseFloat(gross_monthly_rate.replace(/,/g, ''));
            var rebate = parseFloat(this.value.replace(/,/g, ''));
            var net_monthly_rate = gross_monthly_rate - rebate;
            net_monthly_rate = numberWithCommas(parseFloat(net_monthly_rate).toFixed(2));
            $('#net_monthly_rate').val(net_monthly_rate);
        });

        $(document).on('submit', '.form-ajax', function (e) {
            e.preventDefault()
            const form = $(this);
            const url = form.data('url');
            const form_id = form.attr('id');
            console.log(form_id)
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize() + '&_token={{csrf_token()}}',
                success: function (res) {
                    if (form_id === 'unit-store-form') {
                        $('#unit_id').append('<option value="' + res.id + '">' +
                            res.chassis_no + ' ' + res.model + ' ' + res.color
                            + '</option>');
                        changeUnitRepo('unit', res.id);

                    }
                    if (form_id === 'client-store-form') {
                        $('#client_id').append('<option value="' + res.id + '">' +
                            res.lname + ' ' + res.fname
                            + '</option>');

                        $('#client_id option[value="' + res.id + '"]').prop('selected', true);
                    }
                    $('.modal').modal('hide');
                }
            });
        });

        function changeUnitRepo(type, id) {
            if (type == 'unit') {
                $('#unit_id option[value="' + id + '"]').prop('selected', true);
                $('#repo_id').val('');
            } else {
                $('#repo_id option[value="' + id + '"]').prop('selected', true);
                $('#unit_id').val('');
            }
        }

        $(document).ready(function () {

            $('.footable').footable();

            $(".select2").select2({
                // theme: 'bootstrap3',
            });
            var mem = $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                placement: 'bottom'
            });
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('.installment_trigger').on('ifChecked', function() {
                $("#installment").show();
                $("#cash").hide();

                $("#installment").find('input').prop('required', true)
                $("#installment").find('input').prop('disabled', false)
                $("#installment").find('input.disabled').prop('disabled', true)

                $("#cash").find('input').prop('disabled', true)
                $("#cash").find('input').prop('required', false)
            });
            $('.cash_trigger').on('ifChecked', function() {
                $("#installment").hide();
                $("#cash").show();
                $("#cash").find('input').prop('disabled', false)
                $("#cash").find('input').prop('required', true)
                $("#installment").find('input').prop('disabled', true)
                $("#installment").find('input').prop('required', false)
            });

            $(".money").inputmask({
                alias: "money"
            });

            $('.dob-input').datepicker({
                startView: 2,
                todayBtn: false,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "mm/dd/yyyy"
            });

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
        $(document).on('input', '#total_price,#down_payment,#total_less_downpayment', function () {
            var total_price = $('#total_price').val();
            total_price = parseFloat(total_price.replace(/,/g, ''))
            var down_payment = $('#down_payment').val();
            down_payment = parseFloat(down_payment.replace(/,/g, ''))
            var total_less_downpayment = total_price - down_payment;
            $('#total_less_downpayment').val(numberWithCommas(total_less_downpayment));
        });
        $(document).on('input', '#months', function () {
            var month = $('#months').val()
            if (parseInt(month) > 1) {
                $("#years").val(month / 12);
            }
        });
        $(document).on('click', '#submit_application', function () {
            // $('input').prop('disabled', false)
        });
        $(document).on('input', '#months,#total_price,#down_payment', function () {
            var month = $('#months').val();
            var total_price = $('#total_price').val();
            total_price = parseFloat(total_price.replace(/,/g, ''))
            var down_payment = $('#down_payment').val();
            down_payment = parseFloat(down_payment.replace(/,/g, ''))
            var total_less_downpayment = total_price - down_payment;
            // console.log(total_less_downpayment)
            // console.log(month)
            var gross_monthly_rate = numberWithCommas(parseFloat(total_less_downpayment / parseInt(month)).toFixed(2));
            // console.log(gross_monthly_rate)
            if (total_less_downpayment && month > 0) {
                $("#first_payment_due").val(gross_monthly_rate);
                $('#gross_monthly_rate').val(gross_monthly_rate);
            }
        });
        $(document).on('input', '#rebate', function () {
            var gross_monthly_rate = $('#gross_monthly_rate').val();
            gross_monthly_rate = parseFloat(gross_monthly_rate.replace(/,/g, ''));
            var rebate = parseFloat(this.value.replace(/,/g, ''));
            var net_monthly_rate = gross_monthly_rate - rebate;
            net_monthly_rate = numberWithCommas(parseFloat(net_monthly_rate).toFixed(2));
            $('#net_monthly_rate').val(net_monthly_rate);
        });
    </script>
@endsection
