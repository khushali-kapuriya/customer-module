@extends('layouts.app')
@section('content')
<h3>States <a class="btn btn-sm btn-primary" href="{{ route('states.create') }}">Add</a></h3>
<table class="table table-sm">
<thead><tr><th>State</th><th>State Code</th><th>Country</th><th>Modified By</th><th>Modified On</th><th>Created By</th><th>Created On</th><th>Actions</th></tr></thead>
<tbody>
@foreach($states as $s)
<tr>
<td>{{ $s->name }}</td>
<td>{{ $s->state_code }}</td>
<td>{{ $s->country->name }}</td>
<td>{{ $s->modified_by }}</td>
<td>{{ $s->modified_on }}</td>
<td>{{ $s->created_by }}</td>
<td>{{ $s->created_on }}</td>
<td>
<a href="{{ route('states.edit',$s) }}" class="btn btn-sm btn-secondary">Edit</a>
<form method="POST" action="{{ route('states.destroy',$s) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Del</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $states->links() }}
@endsection
