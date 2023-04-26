<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use LogsActivity;
    
    protected static $logAttributes = ['name', 'email', 'phone', 'address'];
}
