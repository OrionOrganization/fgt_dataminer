<?php

namespace App\Integrations\Client;

use App\Traits\Http\WithHttp;
use Exception;
use Illuminate\Http\Client\Response;

/**
 * https://brasilapi.com.br/api/
 */
class BrasilApiClient
{
    use WithHttp;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var \Illuminate\Http\Client\Response|null
     */
    protected $lastResponse;

    /**
     * @var callable
     */
    protected $responseMiddleware;

    public function __construct(
        string $baseUrl = 'https://brasilapi.com.br/api/'
    ) {
        $this->baseUrl = $baseUrl;
        //$this->httpDebug = true;
    }

    /**
     * Distrito por município
     *
     * Obtém o conjunto de distritos do Brasil a partir dos identificadores dos municípios
     * https://brasilapi.com.br/api/cnpj/v1/
     */
    public function getCnpj($cnpj)
    {
        return $this->send("cnpj/v1/$cnpj");
    }

    /**
     * Get CEP
     *
     * Versão 2 do serviço de busca por CEP com múltiplos providers de fallback.
     * https://brasilapi.com.br/api/cep/v2/{cep}
     */
    public function getCep($cep)
    {
        return $this->send("cep/v2/$cep");
    }

    /**
     *
     */
    public function send($path, $method = "GET", $body = null, $baseUrl = null): ?array
    {
        if (!$baseUrl) $baseUrl = $this->baseUrl;

        $url = $baseUrl . $path;

        $headers = [
            //'authorization' => 'Bearer ' . $this->token
        ];

        switch ($method) {
            case 'GET':
                return $this->handleResponse($this->http()->withHeaders($headers)->get($url, $body));
            case 'POST':
                return $this->handleResponse($this->http()->withHeaders($headers)->asJson()->post($url, $body));
            case 'delete':
                return $this->handleResponse($this->http()->withHeaders($headers)->delete($url, $body));
            default:
                throw new Exception(
                    'Token não configurado'
                );
        }

        return null;
    }

    /**
     * @param Response $response
     *
     * @return array
     */
    protected function handleResponse(Response $response): array
    {
        if ($response->failed() || $response->serverError()) {
            $url = strval($response->effectiveUri());
            throw new Exception('BrasilApiClient'
                . " - {$url} "
                . " - Body: {$response->body()}");
        }

        return $response->json() ?? [];
    }
}
