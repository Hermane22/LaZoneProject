<?php

namespace App\Models;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;
    protected $fillable = ['annee', 'etablissement', 'diplome', 'cv_id'];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

}
