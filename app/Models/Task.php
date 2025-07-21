<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
use HasFactory;
protected $fillable=['title','description','assigned_to','status','due_date'];

public function assignee() :BelongsTo
{
return $this->belongsTo(User::class,'assigned_to');
}

}
