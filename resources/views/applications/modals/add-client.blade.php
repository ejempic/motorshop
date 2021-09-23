<div class="modal inmodal fade" id="add_client" data-type="" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content modal-lg">
            <div class="modal-header" style="padding: 15px;">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">New Client</h4>
            </div>
            <div class="modal-body">
                @include('clients.partial.add-form')
            </div>
        </div>
    </div>
</div>