<?php

namespace App\Models\Inventory;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItemApprovalHistory extends Model
{
    use HasFactory;
    protected $table = 'inv_request_item_approval_history';

    protected $fillable = [
        'request_item_id',
        'user_id',
        'type',
        'comments',
        'created_at', 'updated_at'
    ];

    /**
     * Get the location that owns the request item.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
