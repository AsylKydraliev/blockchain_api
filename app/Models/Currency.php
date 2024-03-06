<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 * @property float $exchange_rate
 *
 * @mixin Builder
 */
class Currency extends Model
{
    use HasFactory;

    public const BTC = 'BTC';

    /**
     * @param Builder $query
     * @param array $data
     * @return void
     */
    public function scopeFilter(Builder $query, array $data): void
    {
        if (isset($data['currency'])) {
            $currencies = explode(',', $data['currency']);

            $query->whereIn('name', $currencies);
        }
    }

    /**
     * @param string $currency
     * @return mixed
     */
    public static function getExchangeRate(string $currency): mixed
    {
        return self::query()->where('name', $currency)->value('exchange_rate');
    }

    /**
     * @param mixed $exchange_rate
     * @return float
     */
    public static function calculateCommission(mixed $exchange_rate): float
    {
        return $exchange_rate * 1.02;
    }
}
