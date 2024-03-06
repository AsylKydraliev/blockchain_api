<?php

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $name
 * @property float $exchange_rate
 *
 */
class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $calcExchangeRate = Currency::calculateCommission($this->exchange_rate);

        return [
            'name' => $this->name,
            'exchange_rate' => round($calcExchangeRate, 2),
        ];
    }
}
