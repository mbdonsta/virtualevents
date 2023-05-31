<?php

namespace App\Services;

use App\Models\EventEmail;
use App\Models\User;
use Mail;
use App\Mail\SendEventInvitation;

class MailService
{
    public function sendInvitation(string $address, EventEmail $eventEmail, User $user): void
    {
        $emailContent = $this->replacePlaceholders($eventEmail->text, $eventEmail, $user);
        Mail::to($address)->send(new SendEventInvitation($eventEmail, $user, $emailContent));
    }

    private function replacePlaceholders(string $content, EventEmail $eventEmail, User $user): string
    {
        $placeholders = [
            '[Event_URL]' => $eventEmail->event->getUrl(),
            '[Event_Subject]' => $eventEmail->event->subject,
            '[Event_Description]' => $eventEmail->event->description,
            '[Event_BeginTime]' => $eventEmail->event->getBeginDateTime('F d, Y @ H:i'),
            '[Event_EndTime]' => $eventEmail->event->getEndDateTime('F d, Y @ H:i'),
            '[Event_Loc]' => $eventEmail->event->location,
            '[Event_Lang]' => $eventEmail->event->language->name,
            '[Event_Email]' => $eventEmail->email_address,
            '[Event_User_Email]' => $user->email,
            '[Event_User_Firstname]' => $user->profile->firstname,
            '[Event_User_Lastname]' => $user->profile->lastname
        ];

        foreach ($placeholders as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        return $content;
    }
}
