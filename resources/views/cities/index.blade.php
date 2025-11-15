@extends('layouts.app')
@section('content')
<h3>Cities <a class="btn btn-sm btn-primary" href="{{ route('cities.create') }}">Add</a></h3>
<table class="table table-sm">
<thead><tr><th>City</th><th>State</th><th>State Code</th><th>Country</th><th>Modified By</th><th>Modified On</th><th>Created By</th><th>Created On</th><th>Actions</th></tr></thead>
<tbody>
@foreach($cities as $c)
<tr>
<td>{{ $c->name }}</td>
<td>{{ $c->state->name }}</td>
<td>{{ $c->state_code }}</td>
<td>{{ $c->country->name }}</td>
<td>{{ $c->modified_by }}</td>
<td>{{ $c->modified_on }}</td>
<td>{{ $c->created_by }}</td>
<td>{{ $c->created_on }}</td>
<td>
<a href="{{ route('cities.edit',$c) }}" class="btn btn-sm btn-secondary">Edit</a>
<form method="POST" action="{{ route('cities.destroy',$c) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Del</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $cities->links() }}
@endsection
