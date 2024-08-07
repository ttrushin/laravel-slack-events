<?php

namespace Lisennk\LaravelSlackEvents;

use Illuminate\Http\Request as IlluminateRequest;

class RequestSignature
{
    const SLACK_REQUEST_VERSION = 'v0';

    public function create(IlluminateRequest $request): string
    {
        return self::SLACK_REQUEST_VERSION
            .'='
            .hash_hmac(
                'sha256',
                $this->createBaseString($request),
                config('slack-events.signing_secret')
            );
    }

    private function createBaseString(IlluminateRequest $request): string
    {
        return implode(':', $this->getSignatureData($request));
    }

    private function getSignatureData(IlluminateRequest $request): array
    {
        $requestBody = $this->normalizeRequestBody($request->all());

        return [
            self::SLACK_REQUEST_VERSION,
            $request->header('X-Slack-Request-Timestamp'),
            http_build_query($requestBody),
        ];
    }

    private function normalizeRequestBody(array $requestBody): array
    {
        return array_map(function ($item) {
            return $item === null ? '' : $item;
        }, $requestBody);
    }
}
