<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model {
    use HasFactory;
    protected $fillable = ['name','created_by','created_on','modified_by','modified_on'];
    public function states() { return $this->hasMany(State::class); }
    public function cities() { return $this->hasManyThrough(City::class, State::class); }
}
