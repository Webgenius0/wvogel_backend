<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\HorseShareForSale;
use Illuminate\Http\Request;

class PaymetHistoryController extends Controller
{
    public function index(){
        $payments = HorseShareForSale::with(['user', 'horse'])->get();
        // dd($payments);
        return view('backend.layouts.payment.index', compact('payments'));
    }

    public function destroy($id){
        $payment = HorseShareForSale::find($id);
        $payment->delete();
        return redirect()->route('payment.index')->with('t-success', ' Payment History deleted Successfully.');
    }
}


