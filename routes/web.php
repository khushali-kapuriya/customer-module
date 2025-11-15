<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;

Route::resource('countries', CountryController::class)->except(['show']);
Route::resource('states', StateController::class);
Route::resource('cities', CityController::class);
Route::resource('customers', CustomerController::class);

// AJAX helpers
Route::get('api/countries/{country}/states', [StateController::class,'byCountry']);
Route::get('api/states/{state}/cities', [CityController::class,'byState']);
Route::get('api/cities/{city}', function(App\Models\City $city){
    return $city->load('state.country');
});
