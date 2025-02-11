<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrganogram extends Model
{
    use HasFactory;

    protected $table = 'organogram_user';

    protected $fillable = ['user_id', 'organogram_id'];

    public function users(){
        return $this->belongsToMany(User::class, 'organogram_user', 'user_id', 'organogram_id');
     }
}
