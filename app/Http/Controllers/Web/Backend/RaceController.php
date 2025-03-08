<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Race;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index()
    {
        $races =Race::all();
        return view('backend.layouts.races.index', compact('races'));
    }

    public function create()
    {
        return view('backend.layouts.races.create');
    }

    public function store(Request $request)
    {

        // dd($request);
        $request->validate([
            'race_name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|integer',
            'video' => 'nullable|file|mimes:mp4,mov,avi',
        ]);
        // dd($request);

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('races', 'public');
        }
        // dd($videoPath);

        $race = Race::create([
        'race_name' => $request->race_name,
        'date' => $request->date,
        'location' => $request->location,
        'price' => $request->price,
        'video' => $videoPath,
    ]);

 return redirect()->route('race.index')->with('success', 'Race created successfully.');
}

    public function edit($id)
    {
        $race = Race::findOrFail($id);
        return view('backend.layouts.races.edit', compact('race'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'race_name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|integer',
            'video' => 'nullable|file|mimes:mp4,mov,avi',
        ]);
        $race = Race::findOrFail($id);
        $race->race_name = $request->race_name;
        $race->date = $request->date;
        $race->location = $request->location;
        $race->price = $request->price;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('races', 'public');
            $race->video = $videoPath;
        }
        $race->save();
        return redirect()->route('race.index')->with('success', 'Race updated successfully.');
    }

    public function destroy($id)
    {
        $race = Race::findOrFail($id);
        $race->delete();
        return redirect()->route('race.index')->with('success', 'Race deleted successfully.');
    }
}
