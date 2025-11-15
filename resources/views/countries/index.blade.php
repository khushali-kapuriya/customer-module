@extends('layouts.app')
@section('content')
<h3>Countries <a class="btn btn-sm btn-primary" href="{{ route('countries.create') }}">Add</a></h3>
<table class="table table-sm">
<thead><tr><th>Country</th><th>Modified By</th><th>Modified On</th><th>Created By</th><th>Created On</th><th>Actions</th></tr></thead>
<tbody>
@foreach($countries as $c)
<tr>
<td>{{ $c->name }}</td>
<td>{{ $c->modified_by }}</td>
<td>{{ $c->modified_on }}</td>
<td>{{ $c->created_by }}</td>
<td>{{ $c->created_on }}</td>
<td>
<a href="{{ route('countries.edit',$c) }}" class="btn btn-sm btn-secondary">Edit</a>
<form method="POST" action="{{ route('countries.destroy',$c) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Del</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $countries->links() }}
@endsection
