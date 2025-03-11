<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\RacingResult;
use Illuminate\Http\Request;

class RacingResultController extends Controller
{
    public function index(){
        $racingResults = RacingResult::all();
        return view('backend.layouts.racing_result.index',compact('racingResults'));
    }
    public function create(){
        return view('backend.layouts.racing_result.create');
    }
    public function store(Request $request){
        $request->validate([
            'racing_result_start' => 'required',
            'racing_result_win' => 'required',
            'racing_result_place' => 'required',
            'racing_result_show' => 'required',
            'racing_result_win_percentage' => 'required',
            'racing_result_wps_percentage' => 'required',
            'racing_result_purses_percentage' => 'required',
            'racing_result_earning_percentage' => 'required',
        ]);
        //create racing result
        RacingResult::create($request->all());
        return redirect()->route('racing_result.index')->with('success','Racing Result created successfully');
    }
    public function edit($id){
        $racingResult = RacingResult::find($id);
        return view('backend.layouts.racing_result.edit',compact('racingResult'));
    }
    public function update(Request $request,$id){
        $request->validate([
            'racing_result_start' => 'required',
            'racing_result_win' => 'required',
            'racing_result_place' => 'required',
            'racing_result_show' => 'required',
            'racing_result_win_percentage' => 'required',
            'racing_result_wps_percentage' => 'required',
            'racing_result_purses_percentage' => 'required',
            'racing_result_earning_percentage' => 'required',
        ]);
        //update racing result
        RacingResult::find($id)->update($request->all());
        return redirect()->route('racing_result.index')->with('success','Racing Result updated successfully');
    }
    public function destroy($id){
        RacingResult::find($id)->delete();
        return redirect()->route('racing_result.index')->with('success','Racing Result deleted successfully');
    }
}
