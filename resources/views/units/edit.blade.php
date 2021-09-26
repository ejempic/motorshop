@extends('layouts.master')

@section('title', 'Edit Unit')

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
                {{Form::open(['route'=>['unit.destroy', $data->id], 'method'=>'delete'])}}
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
                        <h5>@yield('title')</h5>
                    </div>
                    <div class="ibox-content">
                        {{Form::open(['route'=>['unit.update',$data->id],'files'=>true,'method'=>'put'])}}

                        <img src="{{$data->image_primary}}" alt="" id="image_preview" class="mb-4" style="height: 174px;">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Photo</label>
                            <div class="col-sm-10">
                                <input accept="image/*" type="file" class="form-control" id="image" name="image" style="line-height: 18px;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Model</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="model" value="{{$data->model}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Brand</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="brand" value="{{$data->brand}}">
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-sm-2 col-form-label">Type</label>--}}
{{--                            <div class="col-sm-10">--}}
{{--                                <select name="type" class="form-control required">--}}
{{--                                    <option value="" readonly></option>--}}
{{--                                    <option {{$data->type=="Cruiser"?'selected':''}} value="Cruiser">Cruiser</option>--}}
{{--                                    <option {{$data->type=="Off-road"?'selected':''}} value="Off-road">Off-road</option>--}}
{{--                                    <option {{$data->type=="Scooters"?'selected':''}} value="Scooters">Scooters</option>--}}
{{--                                    <option {{$data->type=="Sport"?'selected':''}} value="Sport">Sport</option>--}}
{{--                                    <option {{$data->type=="Standard"?'selected':''}} value="Standard">Standard</option>--}}
{{--                                    <option {{$data->type=="Touring"?'selected':''}} value="Touring">Touring</option>--}}
{{--                                    <option {{$data->type=="Utility"?'selected':''}} value="Utility">Utility</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Engine No</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="engine_no" value="{{$data->engine_no}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Plate No</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="plate_no" value="{{$data->plate_no}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Chassis No</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="chassis_no" value="{{$data->chassis_no}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Color(s)</label>
                            <div class="col col-xs-12">
                                <input type="text" class="form-control" name="color[]" value="{{$data->color[0]}}">
                            </div>
                            <div class="col col-xs-12">
                                <input type="text" class="form-control" name="color[]" value="{{optional($data->color)[1]}}">
                            </div>
                            <div class="col col-xs-12">
                                <input type="text" class="form-control" name="color[]" value="{{optional($data->color)[2]}}">
                            </div>
                            <div class="col col-xs-12">
                                <input type="text" class="form-control" name="color[]" value="{{optional($data->color)[3]}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Remarks</label>
                            <div class="col-sm-10">
                                <textarea name="remarks" id="" cols="30" rows="10" class="form-control" style="resize: none">{!! $data->remarks !!}</textarea>
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
        var imgInp = document.getElementById('image');
        var imgPre = document.getElementById('image_preview');

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                imgPre.src = URL.createObjectURL(file)
            }
        }
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
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


            $('.dob-input').datepicker({
                startView: 2,
                todayBtn: false,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "mm/dd/yyyy"
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
