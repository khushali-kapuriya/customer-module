@extends('layouts.app')
@section('content')
<h3>Create State</h3>
<form method="POST" action="{{ route('states.store') }}">@csrf
<div class="mb-3">
<label>Country</label>
<select name="country_id" id="countrySelect" class="form-control" required>
<option value=''>--Select--</option>
@foreach($countries as $c)<option value='{{ $c->id }}'>{{ $c->name }}</option>@endforeach
</select>
</div>
<div class="mb-3"><label>State Name</label><input name="name" class="form-control" required></div>
<div class="mb-3"><label>State Code (only for India)</label><input name="state_code" class="form-control" id="state_code"></div>
<button class="btn btn-primary">Save</button>
</form>
@endsection
@section('scripts')
<script>
document.getElementById('countrySelect').addEventListener('change', function(){
    const txt = this.options[this.selectedIndex].text.trim().toLowerCase();
    const sc = document.getElementById('state_code');
    if(txt === 'india') sc.removeAttribute('disabled'); else sc.setAttribute('disabled','disabled');
});
</script>
@endsection
