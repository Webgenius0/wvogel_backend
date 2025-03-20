<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Horses;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class HorsesController extends Controller
{

    public function index()
    {
            $horses = Horses::all();
            return view('backend.layouts.horses.index', compact('horses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.layouts.horses.create', compact('categories'));
    }


    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'about_horse' => 'nullable|string',
                'horse_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Optional field (assuming it stores a file path)
                'racing_start' => 'required|integer|min:0', // Must be an integer, default 0
                'racing_win' => 'required|integer|min:0', // Must be an integer, default 0
                'racing_place' => 'required|integer|min:0', // Must be an integer, default 0
                'racing_show' => 'required|integer|min:0', // Must be an integer, default 0
                'breed' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'age' => 'required|string|max:255',
                'trainer' => 'required|string|max:255',
                'owner' => 'required|string|max:255',
                'price' => 'required|integer',
            ]);

            // Upload the horse image if provided
            if ($request->hasFile('horse_image')) {
                $horse_image_path = $request->file('horse_image')->store('horse_image', 'public');
                $validatedData['horse_image'] = $horse_image_path;
            }

            // Create a new horse record
            $storehorse = Horses::create([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'about_horse' => $validatedData['about_horse'] ?? null,
                'horse_image' => $validatedData['horse_image'] ?? null,
                'racing_start' => $validatedData['racing_start'],
                'racing_win' => $validatedData['racing_win'],
                'racing_place' => $validatedData['racing_place'],
                'racing_show' => $validatedData['racing_show'],
                'breed' => $validatedData['breed'],
                'gender' => $validatedData['gender'],
                'age' => $validatedData['age'],
                'trainer' => $validatedData['trainer'],
                'owner' => $validatedData['owner'],
                'price' => $validatedData['price'],
            ]);

            // Return the created horse record
            return redirect()->route('horse.index')->with('t-success', ' Horse created Successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function edit($id)
    {
        $categories = Category::all();
        $horse = Horses::findOrFail($id);
        return view('backend.layouts.horses.edit', compact('horse', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'about_horse' => 'nullable|string',
                'horse_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Optional field (assuming it stores a file path)
                'racing_start' => 'required|integer|min:0',
                'racing_win' => 'required|integer|min:0',
                'racing_place' => 'required|integer|min:0',
                'racing_show' => 'required|integer|min:0',
                'breed' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'age' => 'required|string|max:255',
                'trainer' => 'required|string|max:255',
                'owner' => 'required|string|max:255',
                'price' => 'required|integer',
            ]);

            // Find the horse
            $horse = Horses::findOrFail($id);

            // Handle horse image update
            if ($request->hasFile('horse_image')) {
                // Delete old image if it exists
                if ($horse->horse_image) {
                    Storage::delete('public/' . $horse->horse_image);
                }
                // Store new image
                $horse_image_path = $request->file('horse_image')->store('horse_image', 'public');
                $validatedData['horse_image'] = $horse_image_path;
            } else {
                // Keep old image if no new one is uploaded
                $validatedData['horse_image'] = $horse->horse_image;
            }

            // Update the horse record
            $horse->update($validatedData);

            // Return success message
            return redirect()->route('horse.index')->with('t-success', 'Horse updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating horse: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $horse = Horses::findOrFail($id);
        $horse->delete();
        return redirect()->route('horse.index')->with('t-success', ' Horse deleted Successfully.');
    }
}
