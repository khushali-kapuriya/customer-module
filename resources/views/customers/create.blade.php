@extends('layouts.app')
@section('content')

<h3>Create Customer</h3>

<form id="customerForm" action="{{ route('customers.store') }}" method="POST">
@csrf

<div class="row">

    <!-- LEFT SIDE -->
    <div class="col-md-6">

        <div class="mb-3">
            <label>Customer Code *</label>
            <input name="customer_code" class="form-control" required value="{{ old('customer_code') }}">
        </div>

        <div class="mb-3">
            <label>Customer Name *</label>
            <input name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Country *</label>
            <select id="country_select" class="form-control">
                <option value="">-- Select Country --</option>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>State *</label>
            <select id="state_select" name="state_id" class="form-control" disabled></select>
        </div>

        <div class="mb-3">
            <label>State Code</label>
            <input id="state_code" class="form-control" disabled>
        </div>

        <div class="mb-3">
            <label>City *</label>
            <select id="city_select" name="city_id" class="form-control" disabled></select>
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="col-md-6">

        <div class="mb-3">
            <label>Pin Code</label>
            <input name="pin_code" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone No.</label>
            <input name="phone_no" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Web Address</label>
            <input name="web_address" class="form-control">
        </div>

        <div class="mb-3">
            <label>GSTIN</label>
            <input id="gstin" name="gstin" maxlength="15" class="form-control" disabled>
        </div>

        <div class="mb-3">
            <label>PAN</label>
            <input id="pan" name="pan" maxlength="10" class="form-control" disabled>
        </div>

        <!-- MULTIPLE CONTACT PERSONS -->
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Contact Persons</strong>
                <button type="button" id="addContactBtn" class="btn btn-sm btn-success">+ Add Contact</button>
            </div>

            <div class="card-body">
                <div id="contactsContainer"></div>
            </div>
        </div>

    </div>
</div>

<button class="btn btn-primary mt-3">Save</button>
</form>

<!-- Contact Template -->
<template id="contactTemplate">
    <div class="contact-item mb-3 border rounded p-3">

        <div class="d-flex justify-content-between mb-2">
            <strong class="contact-title">Contact #</strong>
            <button type="button" class="btn btn-sm btn-danger remove-contact">Remove</button>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <label>Name *</label>
                <input type="text" name="contacts[__IDX__][name]" class="form-control contact-name" required>
            </div>

            <div class="col-md-6 mb-2">
                <label>Designation</label>
                <input type="text" name="contacts[__IDX__][designation]" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>Phone</label>
                <input type="text" name="contacts[__IDX__][phone]" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>Mobile</label>
                <input type="text" name="contacts[__IDX__][mobile]" class="form-control contact-mobile">
            </div>

            <div class="col-md-4 mb-2">
                <label>Email</label>
                <input type="email" name="contacts[__IDX__][email]" class="form-control contact-email">
            </div>

            <div class="col-12">
                <label class="me-3">SMS:</label>

                <label class="form-check-inline me-3">
                    <input type="checkbox" class="form-check-input contact-sms-report" name="contacts[__IDX__][sms_report]" value="1"> Report
                </label>

                <label class="form-check-inline me-3">
                    <input type="checkbox" class="form-check-input contact-sms-invoice" name="contacts[__IDX__][sms_invoice]" value="1"> Invoice
                </label>

                <label class="ms-4 me-3">Email:</label>

                <label class="form-check-inline me-3">
                    <input type="checkbox" class="form-check-input contact-email-report" name="contacts[__IDX__][email_report]" value="1"> Report
                </label>

                <label class="form-check-inline">
                    <input type="checkbox" class="form-check-input contact-email-invoice" name="contacts[__IDX__][email_invoice]" value="1"> Invoice
                </label>
            </div>
        </div>

    </div>
</template>

@endsection


@section('scripts')
@include('customers.partials.customer_js')
@endsection
