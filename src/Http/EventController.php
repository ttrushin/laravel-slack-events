<?php

namespace Lisennk\LaravelSlackEvents\Http;

use Illuminate\Http\Request;
use \Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Lisennk\LaravelSlackEvents\EventCreator;
use Lisennk\LaravelSlackEvents\Events\Base\SlackEvent;

/**
 * Class EventController
 *
 * @package Lisennk\LaravelSlackEvents
 */
class EventController extends Controller
{
    /**
     * EventController constructor.
     */
    public function __construct()
    {
        $this->middleware(EventMiddleware::class);
    }

    /**
     * Fire slack event
     *
     * @param Request $request
     * @param EventCreator $events
     * @return SlackEvent
     */
    public function fire(Request $request, EventCreator $events)
    {
        try {
            $event = $events->make($request->input('event.type'), $request->input('event.channel_type', ''));
            $event->setFromRequest($request);

            event($event);
        } catch (\Exception $e) {
            report($e);

            return response('Unknown event', 200);
        }

        return response('Event received', 200);
    }
}
