<?php

namespace App\Models;

use App\Models\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasUuids;

    protected $table = "teachers";

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        "nip",
        "education",
        "gender",
        "user_id"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mapels(): HasMany
    {
        return $this->hasMany(Mapel::class, "teacher_id");
    }
}