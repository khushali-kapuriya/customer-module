<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model {
    use HasFactory;
    protected $fillable = ['name','state_id','state_code','country_id','created_by','created_on','modified_by','modified_on'];
    public function state() { return $this->belongsTo(State::class); }
    public function country() { return $this->belongsTo(Country::class); }
}
