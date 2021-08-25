@extends('layouts.master')

@section('title', 'Add Client')

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
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>@yield('title')</h5>
                    </div>
                    <div class="ibox-content">
                        {{Form::open(['route'=>'client.store'])}}
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Client</label>
                                    <select name="client_id" id="" class="form-control">
                                        @forelse($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                        @empty
                                            <option value="" selected disabled>No Clients Yet</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Unit</label>
                                    <select name="unit_id" id="" class="form-control">
                                        @forelse($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->chassis_no.' '.$unit->model.' '.$unit->color}}</option>
                                        @empty
                                            <option value="" selected disabled>No Clients Yet</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Total Price</label>
                                    <input type="text"  id="total_price" name="total_price" class="form-control money">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Initial Payment</label>
                                    <input type="text"  id="down_payment" name="down_payment" class="form-control money">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Total less Initial Payment</label>
                                    <input type="text" disabled id="total_less_downpayment" name="total_less_downpayment" class="form-control money">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Months</label>
                                    <input type="text" id="months" name="months" class="form-control" data-mask="0#">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Years</label>
                                    <input type="text" disabled id="years" name="years" class="form-control money">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Gross Monthly Rate</label>
                                    <input type="text" disabled id="gross_monthly_rate" name="gross_monthly_rate" class="form-control money">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Less: Rebate</label>
                                    <input type="text"  id="rebate" name="rebate" class="form-control money">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Net Monthly Rate</label>
                                    <input type="text" disabled id="net_monthly_rate" name="net_monthly_rate" class="form-control money">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">First due date of amount (Gross)</label>
                                    <input type="text" id="first_payment_due" name="first_payment_due" class="form-control money">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">First Due Date </label>
                                    <input type="text" id="first_due_date" name="first_due_date" class="form-control datepicker">
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

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
{{--    {!! Html::script('') !!}--}}
{{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
{{--    {!! $dataTable->scripts() !!}--}}
{{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
{{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $(document).on('input', '#total_price,#down_payment,#total_less_downpayment',function(){
            var total_price = $('#total_price').val();
            total_price = parseFloat(total_price.replace(/,/g, ''))
            var down_payment = $('#down_payment').val();
            down_payment = parseFloat(down_payment.replace(/,/g, ''))
            var total_less_downpayment = total_price - down_payment;
            $('#total_less_downpayment').val(numberWithCommas(total_less_downpayment));
        });
        $(document).on('input', '#months',function(){
            var month = $('#months').val()
            if(parseInt(month) > 1){
                $("#years").val(month /12);
            }
        });
        $(document).on('click', '#submit_application',function(){
            $('input').prop('disabled',false)
        });
        $(document).on('input', '#months,#total_price,#down_payment',function(){
            var month = $('#months').val();
            var total_price = $('#total_price').val();
            total_price = parseFloat(total_price.replace(/,/g, ''))
            var down_payment = $('#down_payment').val();
            down_payment = parseFloat(down_payment.replace(/,/g, ''))
            var total_less_downpayment = total_price - down_payment;
            // console.log(total_less_downpayment)
            // console.log(month)
            var gross_monthly_rate = numberWithCommas(parseFloat(total_less_downpayment/parseInt(month)).toFixed(2));
            // console.log(gross_monthly_rate)
            if(total_less_downpayment && month > 0){
                $("#first_payment_due").val(gross_monthly_rate);
                $('#gross_monthly_rate').val(gross_monthly_rate);
            }
        });
        $(document).on('input', '#rebate',function(){
            var gross_monthly_rate = $('#gross_monthly_rate').val();
            gross_monthly_rate = parseFloat(gross_monthly_rate.replace(/,/g, ''));
            var rebate = parseFloat(this.value.replace(/,/g, ''));
            var net_monthly_rate = gross_monthly_rate - rebate;
            net_monthly_rate = numberWithCommas(parseFloat(net_monthly_rate).toFixed(2));
            $('#net_monthly_rate').val(net_monthly_rate);
        });
        $(document).ready(function(){
            {{--var modal = $('#modal');--}}



            var mem = $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                placement: 'bottom'
            });

            $('.money').mask("#,##0.00", {reverse: true});
            // $(document).on('input', '', function(){
            //     modal.modal({backdrop: 'static', keyboard: false});
            //     modal.modal('toggle');
            // });

{{--             var table = $('#table').DataTable({--}}
{{--                 processing: true,--}}
{{--                 serverSide: true,--}}
{{--                 ajax: {--}}
{{--                     url: '{!! route('') !!}',--}}
{{--                     data: function (d) {--}}
{{--                         d.branch_id = '';--}}
{{--                     }--}}
{{--                 },--}}
{{--                 columnDefs: [--}}
{{--                     { className: "text-right", "targets": [ 0 ] }--}}
{{--                 ],--}}
{{--                 columns: [--}}
{{--                     { data: 'name', name: 'name' },--}}
{{--                     { data: 'action', name: 'action' }--}}
{{--                 ]--}}
{{--             });--}}

            {{--table.ajax.reload();--}}

        });
    </script>
@endsection
