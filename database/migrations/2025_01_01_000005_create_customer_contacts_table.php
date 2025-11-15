<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerContactsTable extends Migration
{
    public function up()
    {
        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->boolean('sms_report')->default(false);
            $table->boolean('sms_invoice')->default(false);
            $table->boolean('email_report')->default(false);
            $table->boolean('email_invoice')->default(false);
            $table->string('created_by')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_on')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_contacts');
    }
}
