<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

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


	public function assign(Request $request){
		 $validated = $request->validate([
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);
	#	 var_dump($validated);
	User::find($validated['user_id'])->products()->attach($validated['product_id']);
	$result = User::find($validated['user_id'])->products()->find($validated['product_id']);
	#var_dump($result);
	return $result ? ['result'=>'done'] : ['result'=>'error'];
	}

 	public function remove(Request $request){
                 $validated = $request->validate([
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);
        #        var_dump($validated);
        User::find($validated['user_id'])->products()->detach($validated['product_id']);
        $result = !User::find($validated['user_id'])->products()->find($validated['product_id']);
        #var_dump($result);
        return $result ? ['result'=>'done'] : ['result'=>'error'];
	}


	public function userProducts(Request $request){
	return $request->user()->products()->paginate(10);
	
	}




	}

