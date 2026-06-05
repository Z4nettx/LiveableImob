<?php

namespace App\Http\Controllers;

use App\Models\PropertyRent;
use Illuminate\Http\Request;

class PropertyRentController extends Controller
{
    public function store(Request $request, Property $property)
    {
        // Cria o aluguel vinculado ao imóvel e ao usuário logado via Sanctum
        $rent = $property->rents()->create([
            'user_id' => $request->user()->id,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'people_count' => $request->people_count,
            'has_pet' => $request->has_pet,
            'details' => $request->details,
        ]);

        return response()->json([
            'message' => 'Imóvel alugado com sucesso!',
            'rent' => $rent
        ], 201);
    }
}
