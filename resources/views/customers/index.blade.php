@extends('layouts.app')
@section('content')
<h3>Customers <a class="btn btn-sm btn-primary" href="{{ route('customers.create') }}">Add</a></h3>
<table class="table table-sm">
<thead><tr><th>Customer</th><th>Code</th><th>City</th><th>State</th><th>Country</th><th>Phone</th><th>Email</th><th>Web</th><th>GSTIN</th><th>Modified By</th><th>Modified On</th><th>Created By</th><th>Created On</th><th>Actions</th></tr></thead>
<tbody>
@foreach($customers as $c)
<tr>
<td>{{ $c->name }}</td>
<td>{{ $c->customer_code }}</td>
<td>{{ $c->city->name }}</td>
<td>{{ $c->state->name }}</td>
<td>{{ $c->country->name }}</td>
<td>{{ $c->phone_no }}</td>
<td>{{ $c->email }}</td>
<td>{{ $c->web_address }}</td>
<td>{{ $c->gstin }}</td>
<td>{{ $c->modified_by }}</td>
<td>{{ $c->modified_on }}</td>
<td>{{ $c->created_by }}</td>
<td>{{ $c->created_on }}</td>
<td>
<a href="{{ route('customers.edit',$c) }}" class="btn btn-sm btn-secondary">Edit</a>
<form method="POST" action="{{ route('customers.destroy',$c) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Del</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $customers->links() }}
@endsection
