<?php

namespace Lisennk\LaravelSlackEvents\Http;

use Closure;
use Illuminate\Http\Request;
use Lisennk\LaravelSlackEvents\RequestSignature;

/**
 * Event validation
 *
 * @package Lisennk\LaravelSlackEvents\Http
 */
class EventMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Validate the request
        if ($token = config("slack-events.token", null)) {
            if ($request->input('token') !== $token) {
                return response('Wrong token', 200);
            }
        } else {
            $signature = app(RequestSignature::class)->create($request);

            if ($request->header('X-Slack-Signature') !== $signature) {
                return response('Wrong signature', 200);
            }
        }

        if ($request->input('type') === 'url_verification') {
            return response($request->input('challenge'), 200);
        }

        return $next($request);
    }
}
