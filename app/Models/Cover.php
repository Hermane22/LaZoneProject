<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cover extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes; 
    protected $guarded =[];

    protected $fillable = [
        "name", "phone_number", "done"
    ];

    public function user()
    {
        return $this->belongsTo('User' , 'creator_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function coverAffectedTo()
    {
        return $this->belongsTo('App\Models\User' , 'operateur_id');
    }

    public function coverAffectedBy()
    {
        return $this->belongsTo('App\Models\User' , 'affectedBy_id');
    }

    public function status()
    {
        return $this->belongsTo(CvStatus::class, 'cv_status_id');
    }

    public function cvStatuses()
    {
        return $this->hasMany(CvStatus::class);
    }
}
