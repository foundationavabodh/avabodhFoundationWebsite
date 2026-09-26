<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\WebsiteSetting;
use App\Notifications\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * Handles the "Send Us A Message" form on /contact. Validates the input
     * (see StoreContactMessageRequest), then emails a copy of the message to
     * the foundation's own inbox (Website Settings' header_email) with the
     * visitor's address set as Reply-To, so replying to the notification
     * email replies straight to the visitor.
     *
     * The message itself isn't stored anywhere else (no database table was
     * requested for this) -- the notification email *is* the record of it,
     * so a mail failure is reported back to the visitor as an error (with
     * their input preserved) rather than silently swallowed.
     */
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $recipient = WebsiteSetting::current()->header_email ?: 'info@donat.com';

        try {
            Notification::route('mail', $recipient)->notify(new ContactFormSubmitted($data));
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('contactError', "Sorry, something went wrong sending your message. Please try again in a moment, or reach us directly by phone or email.");
        }

        return redirect()
            ->route('contact')
            ->with('contactMessageSent', true);
    }
}
