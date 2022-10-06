<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    public $table = "messages";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["_id", "sender_id", "receiver_id", "body"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $with = ["user"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["id"];

    /** User relation */
    public function user(){
        return $this->belongsTo(User::class, "sender_id");
    }

    /** Posts Filtering Queries */
    public function scopeFilter($query, array $filters)
    {
        /* Filter by search */
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn ($query) =>
                $query
                    ->orWhere('body', 'like', '%' . $search . '%')
        ));

        /* Filter by user */
        $query->when($filters['user'] ?? false, fn($query, $user) =>
            $query->whereHas('user', fn($query) =>
                $query->where('_id', $user)
            )
        );
    }
}
