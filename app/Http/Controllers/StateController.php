<?php
namespace App\Http\Controllers;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStateRequest;

class StateController extends Controller {
    public function index() {
        $states = State::with('country')->paginate(25);
        return view('states.index', compact('states'));
    }

    public function create() {
        $countries = Country::orderBy('name')->get();
        return view('states.create', compact('countries'));
    }

    public function store(StoreStateRequest $request) {
        // dd($request);
        $data = $request->only(['name','state_code','country_id']);
        $data['created_by'] = auth()->check() ? auth()->user()->name : 'system';
        $data['created_on'] = now();
        State::create($data);
        return redirect()->route('states.index')->with('success','State created.');
    }

    public function edit(State $state) {
        $countries = Country::orderBy('name')->get();
        return view('states.edit', compact('state','countries'));
    }

    public function update(StoreStateRequest $request, State $state) {
        $data = $request->only(['name','state_code','country_id']);
        $data['modified_by'] = auth()->check() ? auth()->user()->name : 'system';
        $data['modified_on'] = now();
        $state->update($data);
        return redirect()->route('states.index')->with('success','State updated.');
    }

    public function destroy(State $state) {
        $state->delete();
        return back()->with('success','Deleted');
    }

    public function byCountry(Request $request, $countryId) {
        $states = State::where('country_id',$countryId)->orderBy('name')->get();
        return response()->json($states);
    }
}
