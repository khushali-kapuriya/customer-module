@extends('layouts.app')
@section('content')
<h3>Edit City</h3>
<form method="POST" action="{{ route('cities.update',$city) }}">@csrf @method('PUT')
<div class="mb-3">
<label>Country</label>
<select id="country_select" class="form-control">
<option value="">-- Select Country --</option>
@foreach($countries as $c)<option value="{{ $c->id }}" {{ $c->id == $city->country_id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
</select>
</div>
<div class="mb-3">
<label>State</label>
<select id="state_select" name="state_id" class="form-control" required>
<option value="{{ $city->state->id }}">{{ $city->state->name }}</option>
</select>
</div>
<div class="mb-3"><label>City Name</label><input name="name" class="form-control" value="{{ $city->name }}" required></div>
<button class="btn btn-primary">Update</button>
</form>
@endsection
@section('scripts')
<script>
document.getElementById('country_select').addEventListener('change', async function(){
    const countryId = this.value;
    const stateSelect = document.getElementById('state_select');
    stateSelect.innerHTML = '';
    if(!countryId){ stateSelect.disabled = true; return; }
    try {
        const res = await axios.get(`/api/countries/${countryId}/states`);
        stateSelect.disabled = false;
        stateSelect.innerHTML = '<option value="">-- Select State --</option>';
        res.data.forEach(s => {
            const opt = document.createElement('option'); opt.value = s.id; opt.text = s.name; stateSelect.appendChild(opt);
        });
    } catch(e){ console.error(e); }
});
</script>
@endsection
