<div class="modal fade" id="sched_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
     data-category="" data-variant="" data-bal="">
    <div id="modal-size" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px;">
                <h3 class="modal-title">Payment Schedules</h3>
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col text-right">
                                        <dt>Total Balance</dt>
                                    </div>
                                    <div class="col">
                                        <dd id="sched_rem_bal"></dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <dt>Total Payment</dt>
                                    </div>
                                    <div class="col">
                                        <dd id="sched_total_paid"></dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <dt>Total Due Amount</dt>
                                    </div>
                                    <div class="col">
                                        <dd id="sched_total_payable"></dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Due Date</th>
                        <th class="text-right">Amount</th>
                        {{--                        <th class="text-right">Rebate</th>--}}
                        {{--                        <th class="text-right">Overdue Amount</th>--}}
                        <th class="text-right">Paid Amount</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="schedules_tbody">

                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                {{--                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>--}}
                {{--                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>