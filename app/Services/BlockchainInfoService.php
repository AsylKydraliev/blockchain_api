<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BlockchainInfoService
{
    private Client $client;
    private array $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }

    /**
     * @return JsonResponse|mixed|void
     * @throws GuzzleException
     */
    public function getCurrencies()
    {
        try {
            $response = $this->client->get(env('BLOCKCHAIN_INFO_URL'), [
                'headers' => $this->headers,
            ]);

            if ($response->getStatusCode() === ResponseAlias::HTTP_OK) {
                $body = $response->getBody()->getContents();
                $response_json = json_encode($body);

                return json_decode($response_json, true);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
