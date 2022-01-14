
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
                    @if($from=='client')
                        <input type="hidden" name="client_id" value="{{$client->id}}" class="form-control">
                        <input type="text" readonly value="{{$client->name}}" class="form-control">
                        <input type="hidden" name="_redirect" value="client/{{$client->id}}">
                    @else
                        <input type="hidden" name="_redirect" value="application">
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

                    @endif
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
                                   class="form-control money disabled" required>
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
                                   class="form-control money disabled" required>
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
                                   class="form-control money disabled" required>
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
                                   class="form-control money disabled" required>
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
                            <input type="text" id="total_price_cash" value="{{old('total_price')}}"
                                   name="total_price_cash"
                                   class="form-control money" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Series No.</label>
                            <input type="text" value="{{old('total_price')}}" name="reference_number" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Payment Date</label>
                            <input type="text" id="paid_date"
                                   value="{{old('paid_date', now()->toDateString())}}"
                                   name="paid_date"
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