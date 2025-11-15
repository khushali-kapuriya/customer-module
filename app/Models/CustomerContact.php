<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id','name','designation','phone','mobile','email',
        'sms_report','sms_invoice','email_report','email_invoice',
        'created_by','created_on','modified_by','modified_on'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
