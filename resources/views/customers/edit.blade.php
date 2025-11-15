@extends('layouts.app')
@section('content')
<h3>Edit Customer</h3>
<form id="customerForm" action="{{ route('customers.update',$customer) }}" method="POST">@csrf @method('PUT')
<div class="row">
<div class="col-md-6">
<div class="mb-3"><label>Customer Code *</label><input name="customer_code" class="form-control" required value="{{ $customer->customer_code }}"></div>
<div class="mb-3"><label>Customer Name *</label><input name="name" class="form-control" required value="{{ $customer->name }}"></div>
<div class="mb-3"><label>Address</label><textarea name="address" class="form-control">{{ $customer->address }}</textarea></div>
<div class="mb-3">
<label>Country *</label>
<select id="country_select" class="form-control">
<option value="">-- Select Country --</option>
@foreach($countries as $c)<option value="{{ $c->id }}" {{ $c->id == $customer->country_id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
</select>
</div>
<div class="mb-3">
<label>State *</label>
<select id="state_select" name="state_id" class="form-control"></select>
</div>
<div class="mb-3"><label>State Code</label><input id="state_code" class="form-control" disabled value="{{ $customer->state_code }}"></div>
<div class="mb-3">
<label>City *</label>
<select id="city_select" name="city_id" class="form-control"></select>
</div>
</div>
<div class="col-md-6">
<div class="mb-3"><label>Pin Code</label><input name="pin_code" class="form-control" value="{{ $customer->pin_code }}"></div>
<div class="mb-3"><label>Phone No.</label><input name="phone_no" class="form-control" value="{{ $customer->phone_no }}"></div>
<div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" value="{{ $customer->email }}"></div>
<div class="mb-3"><label>Web Address</label><input name="web_address" class="form-control" value="{{ $customer->web_address }}"></div>
<div class="mb-3"><label>GSTIN</label><input id="gstin" name="gstin" maxlength="15" class="form-control" value="{{ $customer->gstin }}"></div>
<div class="mb-3"><label>PAN</label><input id="pan" name="pan" maxlength="10" class="form-control" value="{{ $customer->pan }}"></div>
<div class="mb-3"><label>Contact Person *</label><input name="contact_person" class="form-control" required value="{{ $customer->contact_person }}"></div>
<div class="mb-3"><label>Designation</label><input name="designation" class="form-control" value="{{ $customer->designation }}"></div>
<div class="mb-3"><label>Contact Mobile</label><input name="contact_mobile" class="form-control" id="contact_mobile" value="{{ $customer->contact_mobile }}"></div>
<div class="mb-3"><label>Contact Email</label><input name="contact_email" type="email" class="form-control" id="contact_email" value="{{ $customer->contact_email }}"></div>
<div class="form-check"><input type="checkbox" id="send_sms_report" name="send_sms_report" class="form-check-input" {{ $customer->send_sms_report ? 'checked' : '' }}><label class="form-check-label">Send SMS For Report</label></div>
<div class="form-check"><input type="checkbox" id="send_email_report" name="send_email_report" class="form-check-input" {{ $customer->send_email_report ? 'checked' : '' }}><label class="form-check-label">Send Email For Report</label></div>
<button class="btn btn-primary mt-3">Update</button>
</div>
</div>
</form>
@endsection

@section('scripts')
<script>
async function fetchStates(countryId, selectedStateId=null){
    const stateSelect = document.getElementById('state_select');
    stateSelect.innerHTML = '';
    if(!countryId){ stateSelect.disabled = true; return; }
    const res = await axios.get(`/api/countries/${countryId}/states`);
    stateSelect.disabled = false;
    stateSelect.innerHTML = '<option value="">-- Select State --</option>';
    res.data.forEach(s => {
        const opt = document.createElement('option'); opt.value = s.id; opt.text = s.name; opt.dataset.stateCode = s.state_code;
        if(selectedStateId && selectedStateId == s.id) opt.selected = true;
        stateSelect.appendChild(opt);
    });
}

async function fetchCities(stateId, selectedCityId=null){
    const citySelect = document.getElementById('city_select');
    citySelect.innerHTML = '';
    if(!stateId){ citySelect.disabled = true; return; }
    const res = await axios.get(`/api/states/${stateId}/cities`);
    citySelect.disabled = false;
    citySelect.innerHTML = '<option value="">-- Select City --</option>';
    res.data.forEach(c => {
        const opt = document.createElement('option'); opt.value = c.id; opt.text = c.name;
        if(selectedCityId && selectedCityId == c.id) opt.selected = true;
        citySelect.appendChild(opt);
    });
}

document.addEventListener('DOMContentLoaded', async function(){
    const country_select = document.getElementById('country_select');
    const state_select = document.getElementById('state_select');
    const city_select = document.getElementById('city_select');

    const selectedCountry = country_select.value;
    await fetchStates(selectedCountry, {{ $customer->state_id }});
    await fetchCities({{ $customer->state_id }}, {{ $customer->city_id }});

    state_select.addEventListener('change', function(){
        const stateCode = state_select.options[state_select.selectedIndex].dataset.stateCode || '';
        document.getElementById('state_code').value = stateCode;
        fetchCities(this.value);
    });

    country_select.addEventListener('change', function(){ fetchStates(this.value); });
});
</script>
<script>
window.existingContacts = @json($customer->contacts->map(function($c){
    return [
        'name' => $c->name,
        'designation' => $c->designation,
        'phone' => $c->phone,
        'mobile' => $c->mobile,
        'email' => $c->email,
        'sms_report' => (bool)$c->sms_report,
        'sms_invoice' => (bool)$c->sms_invoice,
        'email_report' => (bool)$c->email_report,
        'email_invoice' => (bool)$c->email_invoice,
    ];
}));
</script>

@endsection
