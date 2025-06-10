<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lessons extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $primaryKey = 'lessons_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'course_id',
        'title',
        'progress',
        'lastaccessedpage',
        'lastaccessedquiz'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lessonpage()
    {
        return $this->hasMany(LessonsPage::class, 'lessons_id');
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'lessons_id');
    }
}
