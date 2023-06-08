<?php

namespace App\Models;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvStatus extends Model
{
    use HasFactory;

    public function cvs()
    {
        return $this->hasMany(Cv::class, 'cv_status_id');
    }

}
