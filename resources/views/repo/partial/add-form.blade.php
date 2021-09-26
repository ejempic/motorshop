{{Form::open(['route'=>'repo.store','files'=>true,'id'=>'unit-store-form','class'=>'form-ajax','data-url'=>route('unit.store')])}}
<img src="{{url('img/blank-landscape.jpg')}}" alt="" id="image_preview" class="mb-4" style="height: 174px;">
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Photo</label>
    <div class="col-sm-10">
        <input accept="image/*" type="file" class="form-control" id="image" name="image" style="line-height: 18px;">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Model</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="model">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Brand</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="brand">
    </div>
</div>
{{--<div class="form-group row">--}}
{{--    <label class="col-sm-2 col-form-label">Type</label>--}}
{{--    <div class="col-sm-10">--}}
{{--        <select name="type" class="form-control required">--}}
{{--            <option value="" readonly></option>--}}
{{--            <option value="Cruiser">Cruiser</option>--}}
{{--            <option value="Off-road">Off-road</option>--}}
{{--            <option value="Scooters">Scooters</option>--}}
{{--            <option value="Sport">Sport</option>--}}
{{--            <option value="Standard">Standard</option>--}}
{{--            <option value="Touring">Touring</option>--}}
{{--            <option value="Utility">Utility</option>--}}
{{--        </select>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Engine No</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="engine_no">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Plate No</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="plate_no">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Chassis No</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="chassis_no">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Color(s)</label>
    <div class="col col-xs-12">
        <input type="text" class="form-control" name="color[]">
    </div>
    <div class="col col-xs-12">
        <input type="text" class="form-control" name="color[]">
    </div>
    <div class="col col-xs-12">
        <input type="text" class="form-control" name="color[]">
    </div>
    <div class="col col-xs-12">
        <input type="text" class="form-control" name="color[]">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Remarks</label>
    <div class="col-sm-10">
        <textarea name="remarks" id="" cols="30" rows="5" class="form-control" style="resize: none"></textarea>
    </div>
</div>

<div class="row">
    <label class="col-sm-2 col-form-label">Past Owners</label>
    <div class="col-sm-10">
        <div class="ibox-content">
            <h4 class="mb-3">
                <button type="button"
                        class="btn btn-success btn-sm"
                        data-target="#add_client"
                        data-toggle="modal">Add Client and Past Owner
                </button>
                <button type="button"
                        class="btn btn-primary btn-sm float-right" id="add_past_owner">Add Past Owner
                </button>
            </h4>
            <div class="form-group d-none" id="orig_repo_user_div">
                <div class="input-group">
                    <select name="repo_user[]" class="form-control select2" disabled>
                        @forelse($clients as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>
                        @empty
                            <option value="" selected disabled>No Clients Yet</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="repo_user_div">
                <div class="form-group">
                    <div class="input-group">
                        <select name="repo_user[]" class="form-control select2"
                                required>
                            @forelse($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @empty
                                <option value="" selected disabled>No Clients Yet</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <br>

        <button class="btn btn-success" id="submit_application">Submit</button>
    </div>
</div>
{{Form::close()}}
@include('applications.modals.add-client')
@push('short_scripts')
    <script>
        $(document).on('click', '#add_past_owner', function () {
            let clone =  $('#orig_repo_user_div').clone().removeClass('d-none').removeAttr('id');
            clone.appendTo('.repo_user_div');
            clone.find('input,select').prop('disabled', false)
        });
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
    </script>
@endpush