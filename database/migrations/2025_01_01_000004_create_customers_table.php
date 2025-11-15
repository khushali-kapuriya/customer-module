<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code')->unique();
            $table->string('name');
            $table->text('address')->nullable();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->string('pin_code')->nullable();
            $table->foreignId('state_id')->constrained('states');
            $table->integer('state_code')->nullable();
            $table->foreignId('country_id')->constrained('countries');
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('web_address')->nullable();
            $table->string('gstin',15)->nullable();
            $table->string('pan',10)->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('contact_person');
            $table->string('designation')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_email')->nullable();
            $table->boolean('send_sms_report')->default(false);
            $table->boolean('send_sms_invoice')->default(false);
            $table->boolean('send_email_report')->default(false);
            $table->boolean('send_email_invoice')->default(false);
            $table->string('created_by')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_on')->nullable();
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('customers'); }
};
