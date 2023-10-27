<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
	   $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'image' => 'required|string',
            'description' => 'required|string',
        ]);
 
	   return Product::create($validated)?:['result'=>'failure'];
 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    return Product::find($id)?: ['status'=>'failure'];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
	    //return "grgrgr";
	$validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'image' => 'required|string',
            'description' => 'required|string',
        ]);

	  $result =Product::where('id',$id)->update($validated)?['result'=>'ok'] :['result'=>'failure'];
	    return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $result =Product::where('id',$id)->delete()?['result'=>'ok'] :['result'=>'failure'];
            return $result;
    }
}
