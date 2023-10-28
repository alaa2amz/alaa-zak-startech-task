<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];


 public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }



}
