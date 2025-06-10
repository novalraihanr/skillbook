<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonsPage extends Model
{
    use HasFactory;

    protected $table = 'lessonspage';

    protected $primaryKey = 'lessonspage_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'lessons_id',
        'page',
        'content_1',
        'code_1',
        'content_2',
        'code_2',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lessons::class, 'lessons_id', 'lessons_id');
    }
}
