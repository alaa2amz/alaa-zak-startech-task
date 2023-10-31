<?php
           
namespace App\Http\Controllers;
            
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AssignAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
  
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
//                    ->addColumn('action', function($row){
//			    $form='<form action="/doassign" method="POST"><input type="hidden" id="product_id" name="product_id" value=""><input type="hidden" id="user_id" name="user_id" value="'.$row->id.'"><input type="submit" value="CHOOSE"></form>';
			    //$form='<form action="/doassign" method="POST"><input type="hidden" id="product_id" name="product_id" value="'.$request->product_id.'"><input type="hidden" id="user_id" name="user_id" value="'.$row->id.'"><input type="submit" value="CHOOSE"></form>';
   
//    
//                            return $form;
//                    })
//                    ->rawColumns(['action'])
                    ->make(true);
        }
        
 		$product=Product::find($request->product_id); 
        return view('assignAjax',['product'=>$product]);
    }
       
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $user=User::find($request->user_id); 
	    $user->products()->attach($request->product_id);
	    $result=$user->products->find($request->product_id);
	    return $result? 'success' : 'failure';
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
      
        return response()->json(['success'=>'User deleted successfully.']);
    }
}


