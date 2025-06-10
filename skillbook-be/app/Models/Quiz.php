<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $primaryKey = 'quiz_id';

    public $incrementing = true;

    protected $keyType = 'int';

    // Mass assignable fields
    protected $fillable = [
        'lessons_id',
        'question',
        'answer_a',
        'answer_b',
        'answer_c',
        'answer_d',
        'score',
        'correct_ans',
        'page'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lessons::class, 'lessons_id', 'lessons_id');
    }
}
