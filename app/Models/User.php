<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;


protected $appends =[
    'product_list'
  ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


 public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }


/*
    public function getProductslist(){
	    $list=[];
	    foreach($this->products()->get() as $product){
	    $list[]=$product->name;
	    }
	return join(',',$list).'ooo';
    
    }
 */


protected function productList(): Attribute
    {
        return Attribute::make(
            get: function (){
            $list=[];
            foreach($this->products()->get() as $product){
            $list[]=$product->name;
            }
        //return join(', ',$list);
        return $list;

    }
,
        );
    }



     public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    

}
