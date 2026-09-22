<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a public listing of published events.
     *
     * Mirrors ProjectController::index() -- same pagination/ordering
     * approach, adapted for Event's own columns (no `display_order`
     * on published-events browsing here since events are naturally
     * ordered by when they happen).
     */
    public function index()
    {
        $events = Event::query()
            ->where('status', EventStatus::Published)
            ->orderByDesc('event_date')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('pages.events.index', [
            'events' => $events,
        ]);
    }

    /**
     * Display a single published event.
     *
     * Same publish-status gating as ProjectController::show(): route-model
     * binding resolves by slug regardless of status, then we explicitly
     * 404 anything not published so draft events are never exposed.
     */
    public function show(Event $event)
    {
        abort_unless($event->status === EventStatus::Published, 404);

        return view('pages.events.show', [
            'event' => $event,
        ]);
    }
}
