<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\onboard;
use Illuminate\Http\Request;

class OnboardController extends Controller
{
    public function index(){
        $onboards = onboard::with('user')->get();
        return view('backend.layouts.onboard.index',compact('onboards'));
    }

    public function destroy($id){
        $onboard = onboard::find($id);
        $onboard->delete();
        return back();
    }
}
