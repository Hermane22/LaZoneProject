<?php

namespace App\Models;


use App\Models\User;
use App\Models\CvStatus;
use App\Models\Education;
use App\Models\Experience;
use App\Models\AddInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cv extends Model
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
        return $this->belongsTo('App\Models\User');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function agentpublic()
    {
        return $this->belongsTo('App\Models\User', 'agentpublic_id');
    }

    public function assignToAgentpublic()
    {
        
        $agentpublics = User::whereHas('roles', function($query) {
            $query->where('name', 'agentpublic');
        })->get();

        foreach ($agentpublics as $agentpublic) {
            $agentpublic->cvs()->save($this);
        }
    }

    public function cvAffectedTo()
    {
        return $this->belongsTo('App\Models\User' , 'operateur_id');
    }

    public function cvAffectedBy()
    {
        return $this->belongsTo('App\Models\User' , 'affectedBy_id');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function addInformations(): HasMany
    {
        return $this->hasMany(AddInformation::class);
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
