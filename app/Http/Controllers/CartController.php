<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Cart;
use App\User;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CartController extends Controller
{

    /*public function confirm($items, $sale, $RQuantity)
    {
        $sales = new Sales();
        $products = Products::all();

        //product update
        $newStock = Products::where('name', $items->name)->decrement('stock', $RQuantity);

        //sales store
        $sales_arr = array(
            "name" => $items->name,
            "sale" => $sale
        );
        $sales = Sales::create($sales_arr);

        return response()->json(
            $sales_arr, $newStock
        );
    }*/

    /*public function index()
    {

        $userID = 1;
        $cartItems = Cart::session($userID)->getContent();

        return response()->json("This returns the cart");
    }*/

    public function add(Products $product){

        //testing ||| dd($product);
        //adding to cart

        $userID = 1;
        Cart::session($userID)->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->cost,
            'quantity' => 1
        ));

        return response()->json(
            $product
        );

    }

    public function cart(){
        $params = [
            'title' => 'Shopping Cart Checkout',
        ];

        return view('cart')->with($params);
        return response()->json(
            $params
        );
    }

    public function clear(){
        Cart::clear();

        return back()->with('success',"The shopping cart has successfully beed added to the shopping cart!");
        return response()->json("Cart cleared"
        );
    }

    public function destroy($itemId)
    {
        $userID = 1;
        Cart::session($userID)->remove($itemId);
        return response()->json(
            $itemId
        );
    }

    public function update($rowId)
    {
        $userID = 1;
        Cart::session($userID)->update($rowId, [
            'quantity' => array(
                'relative' => false,
                'value' => request('quantity')
            )
        ]);
        return response()->json(
            $rowId
        );
    }

    public function confirm($itemId)
    {
        $userID = 1;

        $items = Cart::session($userID)->get($itemId);
        $sale = Cart::session($userID)->get($itemId)->getPriceSum();

        $RQuantity = $items->quantity;
        //dd($RQuantity);
        Products::where('name', $items->name)->decrement('stock', $RQuantity);
        DB::table('sales')->get();
        DB::table('sales')->insert([
            'name' => $items->name,
            'sale' => $sale
        ]);
        return response()->json(
            $itemId
        );
    }
    public function clearCart()
    {
        $userID = 1;
        Cart::clear();
        Cart::session($userID)->clear();

        return response()->json("All cart clear"
        );
    }

    public function store(Request $request)
    {

        if( auth()-> attempt(request(['firstname','password'])) == false)
        {
            return back()->withErrors([
                'message' => 'the username or password is incorrect please try again'
            ]);
        }

        $userID = 1;
        $q = $request->get('firstname');
        $sale = Cart::session($userID)->getTotal();
        User::where('firstname', $q)->decrement('balance', $sale);
        Cart::clear();
        Cart::session($userID)->clear();
        return redirect('products')->with('alert', 'Purchase Successful!, Please clear any ');
    }

    public function index()
    {
        $report = Sales::all();

        DB::table('sales')->get();
        $total_coffee = DB::table('sales')->where('name','coffee')->sum('sale');
        $total_hamburger = DB::table('sales')->where('name','hamburger')->sum('sale');
        $total_biscuit = DB::table('sales')->where('name','biscuit')->sum('sale');
        $total_drink = DB::table('sales')->where('name','drink')->sum('sale');
        $total_cappuchino = DB::table('sales')->where('name','cappuchino')->sum('sale');
        
        $chart = new reportChart;
        $chart->labels(['Coffee', 'Hamburger', 'Drink', 'Biscuit', 'Cappuchino']);
        $chart->dataset('Products', 'bar', [$total_coffee,$total_hamburger,$total_drink,$total_biscuit,$total_cappuchino]);

        return response()->json(
            $report, $chart
        );
    }

    protected function sendLockoutResponse(Request $request)
    {
        return response()->json(
            $request
        );
    }
}
