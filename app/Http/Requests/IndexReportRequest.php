<?php

namespace App\Http\Requests;

use App\Http\Services\Enums\StrategyType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IndexReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'strategy' => [new Enum(StrategyType::class)],
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }


    public function getStrategyType(): ?StrategyType
    {
        return StrategyType::tryFrom($this->input('strategy'));
    }

    public function getStartDate(): ?Carbon
    {
        if(!$this->input('start_date')) return null;

        return Carbon::parse($this->input('start_date'));
    }

    public function getEndDate(): ?Carbon
    {
        if(!$this->input('end_date')) return null;
        
        return Carbon::parse($this->input('end_date'));
    }
}
