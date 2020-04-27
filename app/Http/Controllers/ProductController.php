<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

/**
 * @group Products controller server side
 * 
 * Part of the API that interacts with the Database
 */
class ProductController extends Controller
{

    /**
     * update Database
     * 
     * this is an example of what to expect from the api when you update the database
     * 
     * 
     * @response{
     * Data => (
     *          [
                    "id" => $update_arr['id'],
                    "name" => $update_arr['name'],
                    "cost" => $update_arr['cost'],
                    "category" => $update_arr['category'],
                    "stock" => $update_arr['stock'],
                    "item_image" => $update_arr['iimage'],
                    "image" => $update_arr['image'],
                    "audio" => $update_arr['audio'],
                    "creator" => $update_arr['creator']
                ]
           );
     * }
     */
    //
    public function searchByName(Request $request)
    {
        // $request->validate(['query' =>'required|min:3',]);

        $query = $request->input('query');

        $products =  Products::where('name','like',"%$query%")->get();

        return response()->json(
            $products
        );
    }
    public function disp()
    {
        $products = Products::all();

        return response()->json(
            $products
        );

    }
    public function display()
    {
        $products = Products::all();

        return response()->json(
            $products
        );
    }
    public function update(Request $r)
    {

        $id = $r->input('id');
        $products = Products::find($id);

        $update_arr =array(
            "id" => $id,
            "name" => request('name'),
            "cost" => request('cost',0),
            "category" => request('category','snack'),
            "stock" => request('stock'),
            "item_image" => request('item_image'),
            "image" => request('image'),
            "audio" => request('audio'),
            "created_by" => request('created_by')
        );
        $numberOfRecordsAffected = Products::where('id',$id)
                                           ->update($update_arr);
        $isSuccessful = $numberOfRecordsAffected > 0;
        return response()->json(
            $update_arr
        );
    }
    public function destroy($id)
    {
        $products = Products::findOrFail($id);
        $products->delete();
        return response()->json(
            $products
        );
    }

    public function store(Request $r)
    {
        $products = new Products();
        
        $create_arr =array(
            "name" => request('name'),
            "cost" => request('cost'),
            "category" => request('category'),
            "stock" => request('stock'),
            "item_image" => request('iimage'),
            "image" => request('image'),
            "audio" => request('audio'),
            "created_by" => request('creator', 'sean')
        );
        $products = Products::create($create_arr);
        
        return response()->json(
            $create_arr
        );
    }

}
