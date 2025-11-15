<?php
namespace App\Http\Controllers;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller {
    public function index() {
        $countries = Country::paginate(25);
        return view('countries.index', compact('countries'));
    }
    public function create() { return view('countries.create'); }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:100|unique:countries,name']);
        Country::create(['name'=>$request->name,'created_by'=>auth()->check()?auth()->user()->name:'system','created_on'=>now()]);
        return redirect()->route('countries.index')->with('success','Country created.');
    }
    public function edit(Country $country) { return view('countries.edit', compact('country')); }
    public function update(Request $request, Country $country) {
        $request->validate(['name'=>'required|string|max:100|unique:countries,name,'.$country->id]);
        $country->update(['name'=>$request->name,'modified_by'=>auth()->check()?auth()->user()->name:'system','modified_on'=>now()]);
        return redirect()->route('countries.index')->with('success','Country updated.');
    }
    public function destroy(Country $country){ $country->delete(); return back()->with('success','Deleted'); }
}
