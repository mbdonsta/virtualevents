<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventEmail extends Model
{
    use HasFactory;

    public const DEFAULTS = [
        'email_address' => 'conference@seventips.lt',
        'sender' => 'Conference Secretariat',
        'reply_to' => 'conference@seventips.lt',
        'subject' => 'Invitation to event',
        'text' => 'Dear [Event_User_Firstname],',
        'email_styles' => [
            'bg_color' => '#edf2f7',
            'content_bg_color' => "#ffffff",
            "content_text_color" => "#000000"
        ]
    ];

    protected $fillable = [
        'event_id',
        'email_address',
        'sender',
        'reply_to',
        'subject',
        'text',
        'email_styles'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getStyles(): array
    {
        return $this->email_styles ? json_decode($this->email_styles, true) : self::DEFAULTS['email_styles'];
    }
}
