<?php

namespace App\Http\Requests\Order;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Return true if last date more or equal to first date
     */
    // public function checkLastDate(): bool
    // {
    //     $firstDate = $this->firstDate;
    //     $lastDate = $this->lastDate;

    //     return Carbon::parse($firstDate)->lessThanOrEqualTo($lastDate);
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         'name' => ['required', 'string'],
    //         'phone' => ['required', 'size:11'],
    //         'tariff' => ['required', 'exists:tariffs,id'],
    //         'schedule_type' => ['required'],
    //         'first_date' => ['required'],
    //         'last_date' => ['required'],
    //     ];
    // }
}
