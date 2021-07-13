<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Temperature
 * @package App\Models
 * @property Collection $services
 * @property Address $address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property float $value
 */
class Temperature extends Model
{

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function services():BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'temperature_services')->withPivot('value');
    }

    public function type():BelongsTo
    {
        return $this->belongsTo(TemperatureType::class, 'temperature_type_id');
    }

}
