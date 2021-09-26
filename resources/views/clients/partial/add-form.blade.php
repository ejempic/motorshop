
{{Form::open(['route'=>'client.store','files'=>true,'id'=>'client-store-form','class'=>'form-ajax','data-url'=>route('client.store')])}}

<img src="{{url('img/blank-landscape.jpg')}}" alt="" id="image_preview" class="mb-4" style="height: 174px;">
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Photo</label>
    <div class="col-sm-10">
        <input accept="image/*" type="file" class="form-control" id="image" name="image" style="line-height: 18px;">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Last Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="lname">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">First Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="fname">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Middle Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="mname">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Mobile No. 1</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="contact_number_1">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Mobile No. 2 (optional)</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="contact_number_2">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Email-Address</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="email">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Marital Status</label>
    <div class="col-sm-10">
        <select name="marital_status" data-title="Civil Status" class="profile_info form-control required">
            <option value="" readonly></option>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Widow/er">Widower</option>
            <option value="Separated">Separated</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Date of Birth</label>
    <div class="col-sm-10">
        <input name="dob" type="text" data-title="Date of Birth" class="profile_info dob-input form-control required datepicker" id="dob" autocomplete="">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">House No./St/Phase/Subd</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="address">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Barangay</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="barangay">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">City/Municipality</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="city">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Province</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="province" value="Albay" readonly>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Remarks</label>
    <div class="col-sm-10">
        <textarea name="remarks" id="" cols="30" rows="5" class="form-control" style="resize: none"></textarea>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <button class="btn btn-success" id="submit_application">Submit</button>
    </div>
</div>
{{Form::close()}}
@push('short_scripts')
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
    </script>
@endpush