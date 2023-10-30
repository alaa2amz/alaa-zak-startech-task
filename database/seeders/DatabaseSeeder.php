<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use  App\Models\User;
use App\Models\Product;
use  App\Models\Role;


class DatabaseSeeder extends Seeder
{
	static public $user_count=10;
	static public $product_count=50;
	static public $product_user_count=7;
	use WithoutModelEvents;    
	/**
     * Seed the application's database.
     */
    public function run(): void
    {
	    $admin=User::create(['first_name'=>'admin',
		    'last_name'=>'admin',
		    'email' => 'admin@admin.com',
		    'phone_number'=>'0011111111111',
		    'email_verified_at'=>now(),
		    'password'=>'password',

	    ]);   

	     $notadmin=User::create(['first_name'=>'notadmin',
                    'last_name'=>'notadmin',
                    'email' => 'notadmin@notadmin.com',
                    'phone_number'=>'00222222222',
                    'email_verified_at'=>now(),
                    'password'=>'password',

            ]);
	    
	    $admin->roles()->attach('1');

         User::factory(self::$user_count)->create();
   	 Product::factory(self::$product_count)->create();
	 $total_product_count=Product::all()->count(); 
	 foreach (User::latest()->take(self::$product_count)->get() as $user){
		 $j=rand(0,self::$product_user_count);
		 for($i=0;$i<$j;$i++){
			 $user->products()->attach(rand(1,$total_product_count));
		 }
	 }
    } 
	 
	 
	 
	 //srand(floor(time() / (60*60*24)));	
// \App\Models\User::factory(10)->hasProducts(Str::random(10))->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

/*
 $user = User::factory()
            ->hasRoles(1, [
                'name' => 'Editor'
            ])
	    ->create();
 */
