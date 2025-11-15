<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\City;

class StoreCustomerRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $rules = [
            'customer_code' => ['required','string','max:50', Rule::unique('customers','customer_code')->ignore($this->customer)],
            'name' => ['required','string','max:150'],
            'city_id' => ['required','exists:cities,id'],
            'pin_code' => ['nullable','string','max:10'],
            'phone_no' => ['nullable','string','max:15'],
            'email' => ['nullable','email','max:150'],
            'web_address' => ['nullable','url','max:150'],
            'contact_person' => ['nullable','string','max:100'], // kept for single-contact legacy
            'contact_mobile' => ['nullable','digits_between:7,15'],
            'contact_email' => ['nullable','email'],
            'send_sms_report' => ['boolean'],
            'send_sms_invoice' => ['boolean'],
            'send_email_report' => ['boolean'],
            'send_email_invoice' => ['boolean'],
            // contacts array validation (each contact)
            'contacts' => ['nullable','array'],
            'contacts.*.name' => ['required_with:contacts','string','max:100'],
            'contacts.*.designation' => ['nullable','string','max:50'],
            'contacts.*.phone' => ['nullable','string','max:15'],
            'contacts.*.mobile' => ['nullable','string','max:15'],
            'contacts.*.email' => ['nullable','email','max:150'],
            'contacts.*.sms_report' => ['nullable','boolean'],
            'contacts.*.sms_invoice' => ['nullable','boolean'],
            'contacts.*.email_report' => ['nullable','boolean'],
            'contacts.*.email_invoice' => ['nullable','boolean'],
        ];

        // GST/PAN rules depending on country (same as before)
        if ($this->filled('city_id')) {
            $city = City::with('country')->find($this->city_id);
            if ($city && strcasecmp($city->country->name,'India') === 0) {
                $rules['gstin'] = ['nullable','size:15'];
                $rules['pan'] = ['nullable','size:10'];
            } else {
                $rules['gstin'] = ['nullable','prohibited'];
                $rules['pan'] = ['nullable','prohibited'];
            }
        }

        return $rules;
    }

    /**
     * Add conditional rules for contacts (server-side enforcement):
     * - If any sms checkbox for a contact is true -> mobile required
     * - If any email checkbox for a contact is true -> email required
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $contacts = $this->input('contacts', []);
            foreach ($contacts as $idx => $c) {
                // if sms flags present and truthy
                $smsReport = isset($c['sms_report']) && $this->boolean("contacts.$idx.sms_report");
                $smsInvoice = isset($c['sms_invoice']) && $this->boolean("contacts.$idx.sms_invoice");
                $emailReport = isset($c['email_report']) && $this->boolean("contacts.$idx.email_report");
                $emailInvoice = isset($c['email_invoice']) && $this->boolean("contacts.$idx.email_invoice");

                if (($smsReport || $smsInvoice) && empty(trim($c['mobile'] ?? ''))) {
                    $validator->errors()->add("contacts.$idx.mobile", "Mobile is required when SMS options are selected for contact #".($idx+1));
                }

                if (($emailReport || $emailInvoice) && empty(trim($c['email'] ?? ''))) {
                    $validator->errors()->add("contacts.$idx.email", "Email is required when Email options are selected for contact #".($idx+1));
                }
            }
        });
    }
}
