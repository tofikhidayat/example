<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Invoice;
use Auth;
use Product;
class BuyProductController extends Controller
{
    public function store(Request $request){
    	$invoice = new Invoice();
    	$invoice->user_id =  Auth::user()->id;
    	$invoice->invoice = "INV|".date('ymdhims').Auth::user()->id.$request->id;
    	$invoice->amount =  $request->amount;
    	$invoice->price  = Product::find($request->product_id) * $request->amount;
    	$invoice->time = date('y:m:d:h:I:s');
    	$invoice->status =  "buy";
    	$invoice->save();
    	return redirect()->route('user.invoice');

    }
}
