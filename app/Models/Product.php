<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Product extends Model
{

protected $appends =[
    'user_list'
  ];



    use HasFactory;
    protected $guarded=[];


 public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
protected function userList(): Attribute
    {
        return Attribute::make(
            get: function (){
            $list=[];
            foreach($this->users()->get() as $user){
            $list[]=$user->first_name.' '.$user->last_name;
            }
        //return join(', ',$list);
        return $list;

    }
,
        );
    }



}
