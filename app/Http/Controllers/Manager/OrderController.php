<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Auth;

class OrderController extends Controller
{

	public function index()
	{
		$orders = Auth()->user()->orders;
		return view('manager.order.index', compact('orders'));
	}




	public function show($id)
	{
		$order = Order::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
		return view('manager.order.show', compact('order'));
	}

}