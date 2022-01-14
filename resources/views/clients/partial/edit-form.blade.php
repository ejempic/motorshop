{{Form::open(['route'=>['client.update',$client->id],'files'=>true,'method'=>'put'])}}

<img src="{{$client->image_primary}}" alt="" id="image_preview" class="mb-4" style="height: 174px;">
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Photo</label>
    <div class="col-sm-10">
        <input accept="image/*" type="file" class="form-control" id="image" name="image" style="line-height: 18px;">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Last Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="lname" value="{{$client->lname}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">First Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="fname" value="{{$client->fname}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Middle Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="mname" value="{{$client->mname}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Mobile No. 1</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="contact_number_1" value="{{$client->contact_number_1}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Mobile No. 2 (optional)</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="contact_number_2" value="{{$client->contact_number_2}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Email-Address</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="email" value="{{$client->email}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Marital Status</label>
    <div class="col-sm-10">
        <select name="marital_status" data-title="Civil Status" class="profile_info form-control required">
            <option value="" readonly></option>
            <option value="Single" {{$client->marital_status == 'Single'?'selected':''}}>Single</option>
            <option value="Married" {{$client->marital_status == 'Married'?'selected':''}}>Married</option>
            <option value="Widow/er" {{$client->marital_status == 'Widow/er'?'selected':''}}>Widower</option>
            <option value="Separated" {{$client->marital_status == 'Separated'?'selected':''}}>Separated</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Date of Birth</label>
    <div class="col-sm-10">
        <input name="dob" value="{{$client->dob}}" type="text" data-title="Date of Birth" class="profile_info dob-input form-control required" id="dob" autocomplete="">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">House No./St/Phase/Subd</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="address" value="{{$client->address}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Barangay</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="barangay" value="{{$client->barangay}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">City</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="city" value="{{$client->city}}" value="Daraga" readonly>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Province</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="province" value="{{$client->province}}" value="Albay" readonly>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Remarks</label>
    <div class="col-sm-10">
        <textarea name="remarks" id="" cols="30" rows="10" class="form-control" style="resize: none">{!! $client->remarks !!}</textarea>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <button class="btn btn-success" id="submit_application">Submit</button>
    </div>
</div>
{{Form::close()}}