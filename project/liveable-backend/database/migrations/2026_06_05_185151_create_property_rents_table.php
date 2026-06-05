<?php

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('property_rents', function (Blueprint $table) {
            $table->id();
            $table->integer('people_count');
            $table->date('checkin');
            $table->date('checkout');
            $table->foreignIdFor(Property::class);
            $table->foreignIdFor(User::class);
            $table->text('details')->nullable();
            $table->boolean('has_pet')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_rents');
    }
};
