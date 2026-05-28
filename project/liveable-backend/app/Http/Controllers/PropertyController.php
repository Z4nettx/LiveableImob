<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\PropertyImage;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return response()->json($properties, 200);
    }
    #[Authorize('admin')]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'local' => 'required|string',
            'type' => 'required|string',
            'beds_qtd' => 'required|integer',
            'toilette' => 'required|integer',
            'area' => 'required|integer',
            'owner_contact' => 'required|string',
            'property_title' => 'required|string',
            'wifi' => 'boolean',
            'tv' => 'boolean',
            'cooler' => 'boolean',
            'air_conditioning' => 'boolean',
            'washer' => 'boolean',
            'microwave' => 'boolean',
            'contract' => 'required|string',
            'images' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $property = Property::create($request->only([
            'local', 'type', 'beds_qtd', 'toilette', 'area', 'owner_contact',
            'property_title', 'wifi', 'tv', 'cooler', 'air_conditioning',
            'washer', 'microwave', 'contract'
        ]));

        if (count($request->images) > 0) {
            $titleDirectory = $request->property_title;
            $directory = "assets/images/properties/$titleDirectory";
            Storage::disk('public')->makeDirectory($directory);

            foreach ($request->images as $image) {
                $property_image_path = $image->storeAs($directory, $image->getClientOriginalName(), 'public');
                $newImage = PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => $property_image_path,
                ]);
                if (!isset($property->property_image_id)) {
                    $property->update(['property_image_id' => $newImage->id]);
                }
            }
        }

        return response()->json(['Property Created'], 201);
    }
    public function show(Property $property)
    {
        $property = Property::findOrFail($property->id);
        return response()->json(['Propriedade' => $property]);
    }
    #[Authorize('admin')]
    public function update(Request $request, Property $property)
    {
        $validator = Validator::make($request->all(), [
            'local' => 'required|string',
            'type' => 'required|string',
            'beds_qtd' => 'required|integer',
            'toilette' => 'required|integer',
            'area' => 'required|integer',
            'owner_contact' => 'required|string',
            'property_title' => 'required|string',
            'wifi' => 'boolean',
            'tv' => 'boolean',
            'cooler' => 'boolean',
            'air_conditioning' => 'boolean',
            'washer' => 'boolean',
            'microwave' => 'boolean',
            'contract' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($property->update($request->all())) {
            return response()->json(['message' => 'Propriedade atualizada com sucesso!'], 201);
        }
        return response()->json(['message' => 'Erro ao atualizar propriedade!'], 401);
    }
    #[Authorize('admin')]
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(['message' => 'Propriedade deletada com sucesso!'], 201);
    }
}
