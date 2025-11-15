@extends('layouts.app')
@section('content')
<h3>Edit State</h3>
<form method="POST" action="{{ route('states.update',$state) }}">@csrf @method('PUT')
<div class="mb-3">
<label>Country</label>
<select name="country_id" id="countrySelect" class="form-control" required>
@foreach($countries as $c)<option value='{{ $c->id }}' {{ $c->id== $state->country_id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
</select>
</div>
<div class="mb-3"><label>State Name</label><input name="name" class="form-control" value="{{ $state->name }}" required></div>
<div class="mb-3"><label>State Code (only for India)</label><input name="state_code" class="form-control" id="state_code" value="{{ $state->state_code }}"></div>
<button class="btn btn-primary">Update</button>
</form>
@endsection
@section('scripts')
<script>
document.getElementById('countrySelect').addEventListener('change', function(){
    const txt = this.options[this.selectedIndex].text.trim().toLowerCase();
    const sc = document.getElementById('state_code');
    if(txt === 'india') sc.removeAttribute('disabled'); else sc.setAttribute('disabled','disabled');
});
window.dispatchEvent(new Event('change'));
</script>
@endsection
