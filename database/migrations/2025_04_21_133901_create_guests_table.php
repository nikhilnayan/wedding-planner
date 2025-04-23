<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wedding_id'); // Use unsignedBigInteger for the foreign key
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('relationship')->nullable();
            $table->integer('party_size')->default(1);
            $table->enum('rsvp_status', ['pending', 'attending', 'declined'])->default('pending');
            $table->boolean('invitation_sent')->default(false);
            $table->text('dietary_restrictions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Add the foreign key constraint after ensuring the correct column type
            $table->foreign('wedding_id')->references('id')->on('weddings')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
