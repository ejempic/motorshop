@extends('layouts.master')

@section('title', 'Add Application')

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
                {{--                <a href="#" class="btn btn-primary">This is action area</a>--}}
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                @include('alerts.validation')
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>@yield('title')</h5>
                    </div>
                    <div class="ibox-content">
                        {{Form::open(['route'=>'application.store'])}}
                        <div class="row">
                            <div class="col-12">
                                <h4>1. Select Client or Create New</h4>
                            </div>
                            <div class="col-sm-12">
                                <div class="ibox-content my-3">
                                    <div class="form-group">
                                        <label for="">Client</label>
                                        <div class="input-group">
                                            <select name="client_id" id="client_id" class="form-control select2"
                                                    required>
                                                @forelse($clients as $client)
                                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                                @empty
                                                    <option value="" selected disabled>No Clients Yet</option>
                                                @endforelse
                                            </select>
                                            <span class="input-group-append"> <button type="button"
                                                                                      class="btn btn-primary"
                                                                                      data-target="#add_client"
                                                                                      data-toggle="modal">Add New
                                        </button>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>2. Select Unit/Repossesed or Create New</h4>
                            </div>
                            <div class="col-sm-12">
                                <div class="ibox-content my-3">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">2. Unit</label>
                                                <div class="input-group">
                                                    <select name="unit_id" id="unit_id" class="form-control select2"
                                                            onchange="changeUnitRepo('unit', this.value)">
                                                        <option value="" selected disabled></option>
                                                        @forelse($units as $unit)
                                                            <option value="{{$unit->id}}">{{$unit->chassis_no.' '.$unit->model.' '.$unit->color}}</option>
                                                        @empty
                                                            <option value="" selected disabled>No Units Yet</option>
                                                        @endforelse
                                                    </select>
                                                    <span class="input-group-append"> <button type="button"
                                                                                              class="btn btn-primary"
                                                                                              data-target="#new_unit"
                                                                                              data-toggle="modal">Add New
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Reposessed</label>
                                                <div class="input-group">
                                                    <select name="repo_id" id="repo_id" class="form-control select2"
                                                            onchange="changeUnitRepo('repo', this.value)">
                                                        <option value="" selected disabled></option>
                                                        @forelse($repo as $unit)
                                                            <option value="{{$unit->id}}">{{$unit->chassis_no.' '.$unit->model.' '.$unit->color}}</option>
                                                        @empty
                                                            <option value="" selected disabled>No Repo Yet</option>
                                                        @endforelse
                                                    </select>
                                                    <span class="input-group-append"> <button type="button"
                                                                                              class="btn btn-primary">Add New
                                            </button>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>4. Payment</h4>
                            </div>
                            <div class="col-sm-12">
                                <div class="ibox-content my-3">
                                    <div class="form-group">
                                        <div class="i-checks">
                                            <label class="mr-3"><input type="radio" class="installment_trigger" name="cash_installment" value="installment"> <i></i> Installment</label>
                                            <label><input type="radio" class="cash_trigger" name="cash_installment" value="cash"> <i></i> Cash </label>
                                        </div>
                                    </div>
                                    <div class="ibox-content" id="installment">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Total Price</label>
                                                    <input type="text" id="total_price" value="{{old('total_price')}}"
                                                           name="total_price"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Initial Payment</label>
                                                    <input type="text" id="down_payment" value="{{old('down_payment')}}"
                                                           name="down_payment"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Total less Initial Payment</label>
                                                    <input type="text" disabled id="total_less_downpayment"
                                                           value="{{old('total_less_downpayment')}}"
                                                           name="total_less_downpayment"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Months</label>
                                                    <input type="text" id="months" value="{{old('months')}}"
                                                           name="months"
                                                           class="form-control"
                                                           data-mask="0#" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Years</label>
                                                    <input type="text" disabled id="years" value="{{old('years')}}"
                                                           name="years"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Gross Monthly Rate</label>
                                                    <input type="text" disabled id="gross_monthly_rate"
                                                           value="{{old('gross_monthly_rate')}}"
                                                           name="gross_monthly_rate"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Less: Rebate</label>
                                                    <input type="text" id="rebate" value="{{old('rebate')}}"
                                                           name="rebate"
                                                           class="form-control money"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Net Monthly Rate</label>
                                                    <input type="text" disabled id="net_monthly_rate"
                                                           value="{{old('net_monthly_rate')}}" name="net_monthly_rate"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">First due date of amount (Gross)</label>
                                                    <input type="text" id="first_payment_due"
                                                           value="{{old('first_payment_due')}}"
                                                           name="first_payment_due"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">First Due Date </label>
                                                    <input type="text" id="first_due_date"
                                                           value="{{old('first_due_date')}}"
                                                           name="first_due_date"
                                                           class="form-control datepicker" required autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ibox-content" id="cash">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Paid Amount</label>
                                                    <input type="text" id="total_price" value="{{old('total_price')}}"
                                                           name="total_price"
                                                           class="form-control money" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Payment Date</label>
                                                    <input type="text" id="first_due_date"
                                                           value="{{old('first_due_date', now()->toDateString())}}"
                                                           name="first_due_date"
                                                           class="form-control datepicker" required autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <button class="btn btn-success" id="submit_application">Submit</button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('applications.modals.add-client')
    @include('applications.modals.add-unit')


@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2.min.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2-bootstrap4.min.css') !!}
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    <style>
        #installment, #cash
        {
            display: none;
        }
    </style>
@endsection

@section('scripts')
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/plugins/select2/select2.full.min.js') !!}
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}

    {!! Html::script('https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js') !!}
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>

        Inputmask.extendAliases({
            pesos: {
                prefix: "₱ ",
                groupSeparator: ".",
                alias: "numeric",
                placeholder: "0",
                autoGroup: true,
                digits: 2,
                digitsOptional: false,
                clearMaskOnLostFocus: false
            },
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
                $("#cash").find('input').prop('required', false)
                $("#cash").find('input').prop('disabled', true)
            });
            $('.cash_trigger').on('ifChecked', function() {
                $("#installment").hide();
                $("#cash").show();
                $("#installment").find('input').prop('required', false)
                $("#installment").find('input').prop('disabled', true)
            });

            $(".money").inputmask({
                alias: "money"
            });
            // $('.money').mask("#,##0", {reverse: true, :2});
        });
    </script>
@endsection
