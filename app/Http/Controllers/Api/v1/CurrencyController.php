<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ConvertCurrencyRequest;
use App\Http\Requests\Api\GetCurrencyRequest;
use App\Http\Resources\CurrencyExchangeResource;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CurrencyController extends Controller
{
    /**
     * @param GetCurrencyRequest $request
     * @return JsonResponse
     */
    public function index(GetCurrencyRequest $request): JsonResponse
    {
        $currencies = Currency::query()
            ->filter($request->all())
            ->orderBy('exchange_rate')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => CurrencyResource::collection($currencies)
        ], ResponseAlias::HTTP_OK);
    }

    /**
     * @param ConvertCurrencyRequest $request
     * @return JsonResponse
     */
    public function exchange(ConvertCurrencyRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        // Extract variables
        $currencyFrom = $validatedData['currency_from'];
        $currencyTo = $validatedData['currency_to'];
        $value = (float) $validatedData['value'];

        // Определяем валюту для получения обменного курса
        $currency = ($currencyFrom !== Currency::BTC) ? $currencyFrom : $currencyTo;

        $exchangeRate = Currency::getExchangeRate($currency);

        // Вычисляем сконвертированное значение
        $convertedValue = ($currencyFrom !== Currency::BTC) ?
            number_format($value / $exchangeRate, 10) :
            $value * $exchangeRate;

        $calcConvertedValue = ($currencyFrom === Currency::BTC) ?
            round(Currency::calculateCommission($convertedValue), 2) :
            Currency::calculateCommission($convertedValue);

        $data = [
            'currency_from' => $currencyFrom,
            'currency_to' => $currencyTo,
            'value' => $value,
            'converted_value' => $calcConvertedValue,
            'rate' => $exchangeRate,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], ResponseAlias::HTTP_OK);
    }
}
