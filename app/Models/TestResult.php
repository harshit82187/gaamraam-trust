<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestResult extends Model
{
    use HasFactory;
    protected $table = 'test_results';
    protected $guarded = [];   

    
    public function question(){
        return $this->belongsTo(QuestionBank::class, 'question_id');
    }

    public function testSeriesDetail(){
        return $this->belongsTo(TestSeries::class, 'test_series_id');
    }


 
}
