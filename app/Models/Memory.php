<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name", "phone_number", "done"
    ];

    public function user()
    {
        return $this->belongsTo('User' , 'creator_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class , 'memorie_user', 'memorie_id', 'user_id');
    }

    public function memoryAffectedTo()
    {
        return $this->belongsTo('App\Models\User' , 'operateur_id');
    }

    public function memoryAffectedBy()
    {
        return $this->belongsTo('App\Models\User' , 'affectedBy_id');
    }
    public function status()
    {
        return $this->belongsTo(CvStatus::class, 'cv_status_id');
    }
}
