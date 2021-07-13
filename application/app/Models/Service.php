<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * @package App\Models
 * @property int id
 * @property string name
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Service extends Model
{

    protected $fillable = ['name'];

}
