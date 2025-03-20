<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\WinChampion;
use Illuminate\Http\Request;

class WinChampionController extends Controller
{

    public function index(){
        $winChampions = WinChampion::all();{
            return view('backend.layouts.win-champion.index', compact('winChampions'));
        }
    }
    public function create(){
        return view('backend.layouts.win-champion.create');
    }
    public function store(Request $request){
        $request->validate([
            'champion_title' => 'required|string|max:255',
            'champion_date' => 'required|date',
            'champion_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
       // Upload the horse image if provided
        if ($request->hasFile('champion_image')) {
            $champion_image_path = $request->file('champion_image')->store('champion_image', 'public');
            $validatedData['champion_image'] = $champion_image_path;
        }

        WinChampion::create([
            'champion_title' => $request->champion_title,
            'champion_date' => $request->champion_date,
            'champion_image' => $champion_image_path
        ]);
        return redirect()->route('winchampion.index')->with('success', 'New win champion added successfully');

}

    public function edit($id){
        $winChampion = WinChampion::find($id);
        return view('backend.layouts.win-champion.edit', compact('winChampion'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'champion_title' => 'required|string|max:255',
            'champion_date' => 'required|date',
            'champion_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $champion_image_path = null;
        // Upload the horse image if provided
        if ($request->hasFile('champion_image')) {
            $champion_image_path = $request->file('champion_image')->store('champion_image', 'public');
            $validatedData['champion_image'] = $champion_image_path;
        }
        $winChampion = WinChampion::find($id);
        $winChampion->champion_title = $request->champion_title;
        $winChampion->champion_date = $request->champion_date;
        if ($champion_image_path) {
            $winChampion->champion_image = $champion_image_path;
        }
        $winChampion->save();
        return redirect()->route('winchampion.index')->with('success', 'Win champion updated successfully');
    }
    public function destroy($id){
        $winChampion = WinChampion::find($id);
        $winChampion->delete();
        return redirect()->route('winchampion.index')->with('success', 'Win champion deleted successfully');
    }
}
