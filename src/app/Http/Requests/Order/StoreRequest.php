<?php

namespace App\Http\Requests\Order;

use Illuminate\Support\Carbon;
use App\Rules\Order\LastDateRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'size:11', 'unique:orders,client_phone'],
            'tariff' => ['required', 'exists:tariffs,id'],
            'schedule_type' => ['required'],
            'firstDate' => ['required'],
            'lastDate' => ['required', (new LastDateRule())->setFirstDate($this->firstDate)->setScheduleType($this->schedule_type)],
        ];
    }

    /**
     * 
     */
    public function messages(): array
    {
        return [
            'phone.unique' => 'Заказ с таким номером телефона уже существует',
        ];
    }
}
