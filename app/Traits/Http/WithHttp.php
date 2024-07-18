<?php

namespace App\Traits\Http;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyHttpResponse;

/**
 * Add class properties and methods to help configuring the Http facade.
 *
 * For all Guzzle options, see:
 * https://docs.guzzlephp.org/en/stable/request-options.html
 */
trait WithHttp
{
    /**
     * Value for the Guzzle 'debug' option.
     *
     * @var bool|null
     */
    protected $httpDebug;

    /**
     * Value for the Guzzle 'allow_redirects.max' option.
     *
     * @var int
     */
    protected $httpMaxRedirects = 10;

    /**
     * Value for the Guzzle 'proxy' (http and https) options.
     *
     * @var string|null
     */
    protected $httpProxyUrl;

    /**
     * Value for the Guzzle timeout.
     *
     * @var int
     */
    protected $httpTimeout;

    public function getHttpDebug(): bool
    {
        return $this->httpDebug ?? false;
    }

    public function getHttpProxy(): string
    {
        return $this->httpProxyUrl ?? '';
    }

    public function getHttpTimeout(): int
    {
        return $this->httpTimeout ?? 0;
    }

    public function setHttpDebug(bool $active): void
    {
        $this->httpDebug = $active;
    }

    public function setHttpMaxRedirects(int $value): int
    {
        $old = $this->httpMaxRedirects;
        $this->httpMaxRedirects = $value;
        return $old;
    }

    public function setHttpProxy(?string $proxyUrl): void
    {
        $this->httpProxyUrl = $proxyUrl;
    }

    public function setHttpTimeout(int $timeout): int
    {
        return $this->httpTimeout = $timeout;
    }

    /**
     * Return a new 'pending request' from the HTTP facade.
     *
     * @param array $guzzleOptions Extra guzzle options
     * @return \Illuminate\Http\Client\PendingRequest
     */
    public function http(array $guzzleOptions = []): PendingRequest
    {
        return Http::withOptions($this->buildGuzzleOptions($guzzleOptions));
    }

    /**
     * @param array $extra
     * @return array Options array
     */
    protected function buildGuzzleOptions(array $extra = null): array
    {
        $options = array_merge([
            'timeout' => $this->getHttpTimeout(),
            'debug' => $this->httpDebug ?? false,
            'proxy' => $this->httpProxyUrl ? [
                'http' => $this->httpProxyUrl,
                'https' => $this->httpProxyUrl,
            ] : [],
            'allow_redirects' => [
                'max' => $this->httpMaxRedirects,
                'strict' => false,
                'referer' => false,
                'protocols' => ['http', 'https'],
                'track_redirects' => false,
            ],
        ], $extra ?? []);
        return $options;
    }

    /**
     * Check if an HTTP response is '401 - Unauthorized'.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @return bool
     */
    public function httpUnauthorized(Response $res): bool
    {
        return $res->status() == SymfonyHttpResponse::HTTP_UNAUTHORIZED;
    }

    /**
     * Check if an HTTP response is '404 - Not Found'.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @return bool
     */
    public function httpNotFound(Response $res): bool
    {
        return $res->status() == SymfonyHttpResponse::HTTP_NOT_FOUND;
    }

    /**
     * Extract the "value" of a cookie based on the cookie name.
     *
     * @param array $cookies Data of multiple cookies (array of arrays)
     * @param string $name Name of a cookie
     * @param bool $caseSensitive Name comparison should be case-sensitive
     */
    public function httpGetCookieValue(
        array $cookies,
        string $name,
        bool $caseSensitive = false
    ): ?string {
        if (!$caseSensitive) $name = Str::lower($name);

        $cookie = collect($cookies)->first(function ($el) use ($name, $caseSensitive) {
            $cookieName = $el['Name'] ?? '';
            if (!$caseSensitive) $cookieName = Str::lower($cookieName);
            return $cookieName === $name;
        });

        return $cookie['Value'] ?? null;
    }

    /**
     * Try to find a `<form>` in the text with the provided ID.
     *
     * @param string $id The expected form ID
     * @param string $text Text used for the search
     * @return bool Whether the form was found or not
     */
    protected function httpHasFormId(string $id, string $text): bool
    {
        $regex = '/<form[^>]* id="' . $id . '"/';
        $firstMatch = $this->first_match($regex, $text);
        return $firstMatch !== null;
    }

    /**
     * Try to find an `<input>` with the provided `name` attribute.
     *
     * @param string $name The input name
     * @param string $text Text used for the search
     * @return bool The input exist or null when not found
     */
    protected function httpHasInputName(string $name, string $text): bool
    {
        $regex = '/<input[^>]* name="' . $name . '"/';
        $firstMatch = $this->first_match($regex, $text);
        return $firstMatch !== null;
    }

    /**
     * Try to get the value of an input with the provided name.
     *
     * @param string $name The input name
     * @param string $text Text used for the search
     * @return string|null The input value or null when not found
     */
    protected function httpGetInputValue(string $name, string $text): ?string
    {
        $regex = '/<input[^>]* name="' . $name . '"[^>]* value="([^"]+)"/';
        return $this->first_match($regex, $text);
    }

    /**
     * Try to get the value of an element's data attribute.
     *
     * @param string $name The data attribute name
     * @param string $text Text used for the search
     * @return string|null The data attribute value or null when not found
     */
    protected function httpGetDataValue(string $name, string $text): ?string
    {
        $regex = '/<[^>]* data-' . $name . '="([^"]+)"/';
        return $this->first_match($regex, $text);
    }

    /**
     * Try to detect the response charset and convert body to an encoding (UTF-8).
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param string $encoding
     * @return string
     */
    protected function httpBody(
        Response $response,
        string $encoding = 'UTF-8',
        string $possibleEncodings = 'ASCII,ISO-8859-1,Windows-1251,UTF-8'
    ): string {
        $body = $response->body();

        // Tenta pegar o 'charset' do header 'Content-Type'
        $contentType = $response->header('Content-Type');
        $charset = $this->first_match('/charset=(.*)(;|$)/', $contentType);
        if (strcasecmp($charset, $encoding) === 0) return $body;

        // Procura no texto se existe alguma tag <meta> indicando o charset
        if (!$charset) {
            $regex = '/<meta [^>]*charset="?([^";]+);?"[^>]*>/';
            $charset = $this->first_match($regex, $body);
        }
        if (strcasecmp($charset, $encoding) === 0) return $body;

        // Tenta 'descobrir' o charset usando o próprio texto
        if (!$charset) {
            $charset = mb_detect_encoding($body, $possibleEncodings, true);
        }
        if (strcasecmp($charset, $encoding) === 0) return $body;

        // Tenta converter o texto do body
        $converted = mb_convert_encoding($body, $encoding, $charset ?? 'auto');
        if ($converted === false) {
            throw new Exception("Error converting HTTP body from {$charset} to {$encoding}");
        }
        return $converted ?? '';
    }

    protected function first_match(string $regex, string $text): ?string
    {
        $matches = [];
        $found = preg_match($regex, $text, $matches);
        return $found ? trim($matches[1] ?? $matches[0]) : null;
    }
}
