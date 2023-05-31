<?php

namespace App\Services;

use App\Models\EventEmail;

class EventEmailService
{
    public function create(array $data): EventEmail
    {
        return EventEmail::create($data);
    }

    public function update(EventEmail $eventEmail, array $data): void
    {
        $eventEmail->update($data);
    }
}
