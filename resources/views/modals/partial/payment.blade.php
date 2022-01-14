
<form action="{{route('pay')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="application_id" id="verify_loan_id">
    <input type="hidden" name="_redirect" value="{{$redirect}}">
    <div class="ibox-content">
        {{--                                <label>Proof of Payment</label>--}}
        {{--                                <input name="proof_of_payment" id="myFileInput" class="form-control" type="file" accept="image/*;capture=camera">--}}
        {{--                            </div>--}}
        {{--                            <div class="form-group">--}}
        {{--                                <label>Mode of Payment</label>--}}
        {{--                                <select name="payment_method" id="payment_method" class="form-control">--}}
        {{--                                    <option value="gcash">GCash</option>--}}
        {{--                                    <option value="bpi">BPI</option>--}}
        {{--                                    <option value="palawan">Palawan</option>--}}
        {{--                                </select>--}}
        {{--                            </div>--}}
        <div class="form-group">
{{--            <div class="btn-group btn-group-sm float-right">--}}
{{--                <button type="button" class="btn btn-info verify_amount_fast_btn verify_amount_fast_semi" data-amount="">Cut Off</button>--}}
{{--                <button type="button" class="btn btn-primary verify_amount_fast_btn verify_amount_fast_monthly" data-amount="">Monthly</button>--}}
{{--                <button type="button" class="btn btn-danger verify_amount_fast_btn verify_amount_fast_max" data-amount="">Max</button>--}}
{{--            </div>--}}
            <label>Paid Amount</label>
            <input name="paid_amount" id="verify_amount" type="text" class="form-control money" autocomplete="off">
        </div>
        <div class="form-group">
            <label>Payment Date</label>
            <input name="paid_date" type="text" class="form-control datepicker" autocomplete="off">
        </div>
        <div class="form-group">
            <label>Receipt/Series No.</label>
            <input name="reference_number" type="text" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-green w-100" id="verify_payment_submit">Pay</button>
        </div>
    </div>
</form>