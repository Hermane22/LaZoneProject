<?php

namespace App\Models;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddInformation extends Model
{
    use HasFactory;
    protected $fillable = ['competence', 'loisirs', 'langue', 'cv_id'];

    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }
}
