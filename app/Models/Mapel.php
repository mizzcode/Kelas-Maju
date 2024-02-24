<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasUuids, HasFactory;
    
    protected $table = "mapels";
    
    public $incrementing = false;
    
    protected $keyType = "string";

    protected $fillable = [
        "name",
        "teacher_id",
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}