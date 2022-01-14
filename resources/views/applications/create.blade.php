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
                        @include('applications.partials.create-form', ['from' => 'create'])
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
            // $('.money').mask("#,##0", {reverse: true, :2});
        });
    </script>
@endsection
