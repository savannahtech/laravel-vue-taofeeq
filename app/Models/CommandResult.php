<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandResult extends Model
{
    use HasFactory;
    protected $fillable = ['data', 'command_id'];
}
