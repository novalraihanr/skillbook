<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lessons;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course';

    protected $primaryKey = 'course_id';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'title',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'usercourse', 'course_id', 'user_id')
            ->withPivot('totalscore', 'progress', 'created_at', 'updated_at')
            ->withTimestamps();
    }

    public function lessons()
    {
        return $this->hasMany(Lessons::class, 'course_id');
    }
}
