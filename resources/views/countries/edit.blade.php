@extends('layouts.app')
@section('content')
<h3>Edit Country</h3>
<form method="POST" action="{{ route('countries.update',$country) }}">@csrf @method('PUT')
<div class="mb-3"><label>Name</label><input name="name" class="form-control" value="{{ $country->name }}" required></div>
<button class="btn btn-primary">Update</button>
</form>
@endsection
