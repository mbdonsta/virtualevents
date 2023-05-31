<?php

namespace App\Http\Controllers\Backend;

use App\Mail\SendEventInvitation;
use App\Services\MailService;
use Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventEmailStoreRequest;
use App\Models\Event;
use App\Models\EventEmail;
use App\Services\EventEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventEmailController extends Controller
{
    public function edit(Event $event): View
    {
        $this->authorize('edit', [EventEmail::class, $event]);

        $eventEmail = $event->eventEmail;
        $pageTitle = __('Edit Event Email');

        if (!$eventEmail) {
            $data = EventEmail::DEFAULTS;
            $data['event_id'] = $event->id;
            $data['email_styles'] = json_encode($data['email_styles']);
            $eventEmail = (new EventEmailService)->create($data);
        }

        return view('backend.emails.edit', compact('event', 'eventEmail', 'pageTitle'));
    }

    public function update(EventEmailStoreRequest $request, EventEmail $eventEmail): RedirectResponse
    {
        $this->authorize('update', $eventEmail);

        $attributes = $request->validated();
        (new EventEmailService)->update($eventEmail, $attributes);
        session()->flash('success', __('Invitation email settings was updated successfully.'));

        return redirect()->route('backend.emails.edit', ['event' => $eventEmail->event_id]);
    }

    public function sendTest(Request $request, EventEmail $eventEmail, MailService $mailService): RedirectResponse
    {
        $this->authorize('send', $eventEmail);

        $mailService->sendInvitation($request->email, $eventEmail, auth()->user());
        session()->flash('success', __('Test email was sent.'));

        return back();
    }
}
