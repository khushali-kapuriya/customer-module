@extends('layouts.app')
@section('content')
<h3>Create Country</h3>
<form method="POST" action="{{ route('countries.store') }}">@csrf
<div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
<button class="btn btn-primary">Save</button>
</form>
@endsection
