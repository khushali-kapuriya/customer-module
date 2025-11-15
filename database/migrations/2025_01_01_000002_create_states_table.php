<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('state_code')->nullable();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->string('created_by')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_on')->nullable();
            $table->timestamps();
            $table->unique(['country_id','state_code']);
        });
    }
    public function down() { Schema::dropIfExists('states'); }
};
