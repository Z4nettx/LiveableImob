<?php

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class {
    public function up()
    {
        Schema::create('property_rents', function (Blueprint $table) {
            $table->id();
            $table->date('checkin');
            $table->date('checkout');
            $table->boolean('has_pet');
            $table->integer('people_qtd');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Property::class);
            $table->string('details');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_rents');
    }
};
