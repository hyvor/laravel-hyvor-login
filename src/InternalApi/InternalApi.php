<?php

namespace Hyvor\Internal\InternalApi;

use Hyvor\Internal\InternalApi\Exceptions\InternalApiCallFailedException;
use Hyvor\Internal\InternalApi\Exceptions\InvalidMessageException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

/**
 * Call the internal API between components
 */
class InternalApi
{

    /**
     * @param array<mixed> $data
     * @param InternalApiMethod|'GET'|'POST' $method
     * @return array<mixed>
     */
    public static function call(
        ComponentType $to,
        InternalApiMethod|string $method,
        /**
         * This is the part after the `/api/internal/` in the URL
         * ex: set `/delete-user` to call `/api/internal/delete-user`
         */
        string $endpoint,
        array $data = []
    ): array {
        if (is_string($method)) {
            $method = InternalApiMethod::from($method);
        }
        $methodFunction = strtolower($method->value);

        $endpoint = ltrim($endpoint, '/');
        $componentUrl = InstanceUrl::createPrivate()->componentUrl($to);
        $url = $componentUrl . '/api/internal/' . $endpoint;

        $message = self::messageFromData($data);

        $headers = [
            'X-Internal-Api-From' => ComponentType::current()->value,
            'X-Internal-Api-To' => $to->value,
        ];

        try {
            $response = Http::
            withHeaders($headers)
                ->$methodFunction(
                    $url,
                    [
                        'message' => $message,
                    ]
                );
        } catch (ConnectionException $e) {
            throw new InternalApiCallFailedException(
                'Internal API call to ' . $url . ' failed. Connection error: ' . $e->getMessage(),
            );
        }

        if (!$response->ok()) {
            throw new InternalApiCallFailedException(
                'Internal API call to ' . $url . ' failed. Status code: ' .
                $response->status() . ' - ' .
                substr($response->body(), 0, 250)
            );
        }

        return (array)$response->json();
    }

    /**
     * @param array<mixed> $data
     * @throws \Exception
     */
    public static function messageFromData(array $data): string
    {
        $json = json_encode([
            'data' => $data,
            'timestamp' => time(),
        ]);
        if ($json === false) {
            throw new \Exception('Failed to encode data to JSON');
        }

        return Crypt::encryptString($json);
    }

    /**
     * @return array<string, mixed>
     */
    public static function dataFromMessage(
        string $message,
        bool $validateTimestamp = true
    ): array {
        try {
            $decodedMessage = Crypt::decryptString($message);
        } catch (DecryptException) {
            throw new InvalidMessageException('Failed to decrypt message');
        }

        $decodedMessage = json_decode($decodedMessage, true);

        if (!is_array($decodedMessage)) {
            throw new InvalidMessageException('Invalid data');
        }

        $timestamp = $decodedMessage['timestamp'] ?? null;

        if (!is_int($timestamp)) {
            throw new InvalidMessageException('Invalid timestamp');
        }

        if ($validateTimestamp) {
            $diff = time() - $timestamp;
            if ($diff > 60) {
                throw new InvalidMessageException('Expired message');
            }
        }

        $requestData = $decodedMessage['data'] ?? [];

        if (!is_array($requestData)) {
            throw new InvalidMessageException('Data is not an array');
        }

        return $requestData;
    }

    /**
     * Helper to get the requesting component from a request
     */
    public static function getRequestingComponent(Request $request): ComponentType
    {
        $from = $request->header('X-Internal-Api-From');
        assert(is_string($from));
        return ComponentType::from($from);
    }

}
