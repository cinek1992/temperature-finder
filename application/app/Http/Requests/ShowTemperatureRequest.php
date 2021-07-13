<?php

namespace App\Http\Requests;

use App\Constants\TemperatureTypes;
use Illuminate\Foundation\Http\FormRequest;

class ShowTemperatureRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $temperatureTypes = config('temperatureformat.formats');
        return [
            'country' => 'required|min:3',
            'city' => 'required|min:3',
            'type' => 'required|in:' . implode(',', array_keys($temperatureTypes))
        ];
    }
}
