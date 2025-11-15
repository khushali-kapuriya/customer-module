<?php
namespace App\Http\Controllers;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCityRequest;

class CityController extends Controller {
    public function index() {
        $cities = City::with('state.country')->paginate(25);
        return view('cities.index', compact('cities'));
    }

    public function create() {
        $countries = Country::orderBy('name')->get();
        return view('cities.create', compact('countries'));
    }

    public function store(StoreCityRequest $request) {
        $state = State::findOrFail($request->state_id);
        $city = City::create([
            'name' => $request->name,
            'state_id' => $state->id,
            'state_code' => $state->state_code,
            'country_id' => $state->country_id,
            'created_by' => auth()->check() ? auth()->user()->name : 'system',
            'created_on' => now()
        ]);
        return redirect()->route('cities.index')->with('success','City created.');
    }

    public function edit(City $city) {
        $countries = Country::orderBy('name')->get();
        return view('cities.edit', compact('city','countries'));
    }

    public function update(StoreCityRequest $request, City $city) {
        $state = State::findOrFail($request->state_id);
        $city->update([
            'name' => $request->name,
            'state_id' => $state->id,
            'state_code' => $state->state_code,
            'country_id' => $state->country_id,
            'modified_by' => auth()->check() ? auth()->user()->name : 'system',
            'modified_on' => now()
        ]);
        return redirect()->route('cities.index')->with('success','City updated.');
    }

    public function destroy(City $city) {
        $city->delete();
        return back()->with('success','Deleted');
    }

    public function byState($stateId) {
        $cities = City::where('state_id',$stateId)->orderBy('name')->get();
        return response()->json($cities);
    }
}
