<div class="modal fade" id="verify_payment_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
     data-category="" data-variant="" data-bal="">
    <div id="modal-size" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px;">
                <h3 class="modal-title">Payment</h3>
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary" id="verify_payment_show">Verify Payment</button>
                <div class="ibox" id="verify_payment">
                    @include('modals.partial.payment', ['redirect'=>'back'])
                </div>
            </div>
            <div class="modal-footer">
                {{--                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>--}}
                {{--                    <button type="button" class="btn btn-primary" id="modal-save-btn">Ver</button>--}}
            </div>
        </div>
    </div>
</div>
