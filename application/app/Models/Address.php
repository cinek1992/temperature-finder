<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package App\Models
 * @property int id
 * @property string country
 * @property string city
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Address extends Model
{

    protected $fillable = ['country', 'city'];

}
