<div class="modal fade" id="import_application" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
     data-category="" data-variant="" data-bal="">
    <div id="modal-size" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px;">
                <h3 class="modal-title">Import Applications</h3>
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('application.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="ibox-content">
                        <div class="form-group">
                            <label>File</label>
                            <input name="excel" id="myFileInput"
                                   class="form-control" type="file"
                                   accept="application/vnd.ms-excel,.xlsx,.xls;capture=camera" style="line-height: 18px;">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-green w-100" id="verify_payment_submit">Upload</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                {{--                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>--}}
                {{--                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>
