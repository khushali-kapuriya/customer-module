<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\CustomerContact; 


class CustomerController extends Controller {
    public function index() {
        $customers = Customer::with(['city.state.country'])->paginate(25);
        return view('customers.index', compact('customers'));
    }

    public function create() {
        $countries = Country::orderBy('name')->get();
        return view('customers.create', compact('countries'));
    }

    public function store(StoreCustomerRequest $request) {
        $city = City::with('state.country')->findOrFail($request->city_id);
        $data = $request->validated();
        $data['state_id'] = $city->state->id;
        $data['state_code'] = $city->state->state_code;
        $data['country_id'] = $city->country->id;
        $data['created_by'] = auth()->check() ? auth()->user()->name : 'system';
        $data['created_on'] = now();

        // create customer
        $customer = Customer::create($data);

        // create contacts if provided
        $contacts = $request->input('contacts', []);
        foreach ($contacts as $c) {
            $c['customer_id'] = $customer->id;
            $c['sms_report'] = !empty($c['sms_report']) ? 1 : 0;
            $c['sms_invoice'] = !empty($c['sms_invoice']) ? 1 : 0;
            $c['email_report'] = !empty($c['email_report']) ? 1 : 0;
            $c['email_invoice'] = !empty($c['email_invoice']) ? 1 : 0;
            $c['created_by'] = auth()->check() ? auth()->user()->name : 'system';
            $c['created_on'] = now();
            CustomerContact::create($c);
        }

        return redirect()->route('customers.index')->with('success','Customer saved.');
    }

    public function edit(Customer $customer) {
        $countries = Country::orderBy('name')->get();
        return view('customers.edit', compact('customer','countries'));
    }

    public function update(StoreCustomerRequest $request, Customer $customer) {
        $city = City::with('state.country')->findOrFail($request->city_id);
        $data = $request->validated();
        $data['state_id'] = $city->state->id;
        $data['state_code'] = $city->state->state_code;
        $data['country_id'] = $city->country->id;
        $data['modified_by'] = auth()->check() ? auth()->user()->name : 'system';
        $data['modified_on'] = now();

        $customer->update($data);

        // Replace contacts: delete existing and create new ones
        $customer->contacts()->delete();

        $contacts = $request->input('contacts', []);
        foreach ($contacts as $c) {
            $c['customer_id'] = $customer->id;
            $c['sms_report'] = !empty($c['sms_report']) ? 1 : 0;
            $c['sms_invoice'] = !empty($c['sms_invoice']) ? 1 : 0;
            $c['email_report'] = !empty($c['email_report']) ? 1 : 0;
            $c['email_invoice'] = !empty($c['email_invoice']) ? 1 : 0;
            $c['created_by'] = auth()->check() ? auth()->user()->name : 'system';
            $c['created_on'] = now();
            CustomerContact::create($c);
        }

        return redirect()->route('customers.index')->with('success','Customer updated.');
    }

    public function destroy(Customer $customer) {
        $customer->delete();
        return back()->with('success','Deleted');
    }
}
