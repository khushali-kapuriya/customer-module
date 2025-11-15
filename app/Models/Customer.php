<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model {
    use HasFactory;
    protected $fillable = [
        'customer_code','name','address','city_id','pin_code','state_id','state_code','country_id',
        'phone_no','email','web_address','gstin','pan','payment_terms','contact_person','designation',
        'contact_phone','contact_mobile','contact_email',
        'send_sms_report','send_sms_invoice','send_email_report','send_email_invoice',
        'created_by','created_on','modified_by','modified_on'
    ];

    public function city() { return $this->belongsTo(City::class); }
    public function state() { return $this->belongsTo(State::class); }
    public function country() { return $this->belongsTo(Country::class); }
    public function contacts(){return $this->hasMany(CustomerContact::class);}

}
