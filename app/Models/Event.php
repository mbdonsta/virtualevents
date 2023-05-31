<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public const PUBLIC_STATUS = 1;
    public const PRIVATE_STATUS = 0;
    public const ENABLED_STATUS = 1;
    public const DISABLED_STATUS = 0;
    public const DELETED_STATUS = 1;
    public const AVAILABLE_STATUS = 0;
    public const TITLE_OPTION_SHOW_TITLE = 1;
    public const TITLE_OPTION_SHOW_LOGO_AS_TITLE = 2;
    public const TITLE_OPTION_HIDE_TITLE = 3;

    protected $fillable = [
        'user_id',
        'plan_id',
        'title',
        'title_option',
        'slug',
        'subject',
        'description',
        'media_file_id',
        'begin_datetime',
        'end_datetime',
        'location',
        'is_public',
        'enabled',
        'language_id',
        'design_settings',
        'deleted'
    ];

    public function eventEmail(): HasOne
    {
        return $this->hasOne(EventEmail::class);
    }

    public function eventUsers(): HasMany
    {
        return $this->hasMany(EventUser::class);
    }

    public function mediaFile(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class);
    }

    public function exhibitionGroups(): HasMany
    {
        return $this->hasMany(ExhibitionGroup::class);
    }

    public function eventProgram(): HasMany
    {
        return $this->hasMany(EventProgram::class);
    }

    public function eventPosters(): HasMany
    {
        return $this->hasMany(EventPoster::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', self::ENABLED_STATUS);
    }

    public function scopeAvailable($query)
    {
        return $query->where('deleted', self::AVAILABLE_STATUS);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getVisibility(): string
    {
        return $this->isPublic() ? __('Public') : __('Private');
    }

    public function isPublic(): bool
    {
        return $this->is_public === self::PUBLIC_STATUS;
    }

    public function getUrl(): string
    {
        return route('frontend.events.watch', ['slug' => $this->slug]);
    }

    public function getStatus(): string
    {
        return $this->isEnabled() ? __('Enabled') : __('Disabled');
    }

    public function isEnabled(): bool
    {
        return $this->enabled === self::ENABLED_STATUS;
    }

    public function getStatusSlug(): string
    {
        return $this->isEnabled() ? 'light-success' : 'light-danger';
    }

    public function getTimeAndLocation(): string
    {
        if ($this->isOneDayEvent()) {
            return $this->getBeginDateTime('F d, Y @ H:i') . ' - ' . $this->getEndDateTime('H:i') . ' | ' . $this->location;
        }

        return $this->getBeginDateTime('F d, Y @ H:i') . ' <br>' . $this->getEndDateTime('F d, Y @ H:i') . ' | ' . $this->location;
    }

    public function isOneDayEvent(): bool
    {
        return $this->getBeginDateTime('Y-m-d') === $this->getEndDateTime('Y-m-d');
    }

    public function getBeginDateTime(string $format): string
    {
        return date($format, strtotime($this->begin_datetime));
    }

    public function getEndDateTime(string $format): string
    {
        return date($format, strtotime($this->end_datetime));
    }

    public function eventRooms(): HasMany
    {
        return $this->hasMany(EventRoom::class);
    }

    public function hasRooms(): bool
    {
        return count($this->getRooms());
    }

    public function getRooms(): array
    {
        $eventRooms = [];

        foreach ($this->eventRooms as $eventRoom) {
            if (auth()->user()->can('view', $eventRoom)) {
                $eventRooms[] = $eventRoom;
            }
        }

        return $eventRooms;
    }

    public function hasProgramDays(): bool
    {
        return !$this->eventProgram->isEmpty();
    }

    public function isLive(): bool
    {
        // timezone check
        $currentDateTime = strtotime(date('Y-m-d H:i:s'));
        $eventBegin = strtotime($this->getBeginDateTime('Y-m-d H:i:s'));
        $eventEnd = strtotime($this->getEndDateTime('Y-m-d H:i:s'));

        return $currentDateTime >= $eventBegin && $currentDateTime <= $eventEnd;
    }

    public function showTitle(): bool
    {
        return $this->title_option === self::TITLE_OPTION_SHOW_TITLE;
    }

    public function showLogo(): bool
    {
        return $this->title_option === self::TITLE_OPTION_SHOW_LOGO_AS_TITLE;
    }

    public function hideTitle(): bool
    {
        return $this->title_option === self::TITLE_OPTION_HIDE_TITLE;
    }

    public function designSettings(): array
    {
        $settings = $this->design_settings ? json_decode($this->design_settings, true) : [];

        return [
            'title_fontsize' => $settings['title_fontsize'] ?? 42,
            'title_logo_size' => $settings['title_logo_size'] ?? 50,
            'title_margin_bottom' => $settings['title_margin_bottom'] ?? 20,
            'title_color' => $settings['title_color'] ?? '#000000',
            'title_effect' => $settings['title_effect'] ?? '',
            'title_shadow_color' => $settings['title_shadow_color'] ?? '#000000',
            'bg_color' => $settings['bg_color'] ?? '#f7f7f7',
            'show_days' => $settings['show_days'] ?? 1,
            'show_rooms' => $settings['show_rooms'] ?? 1,
            'day_button_bg' => $settings['day_button_bg'] ?? '#7239ea',
            'day_button_text' => $settings['day_button_text'] ?? '#ffffff',
            'room_button_bg' => $settings['room_button_bg'] ?? '#7239ea',
            'room_button_text' => $settings['room_button_text'] ?? '#ffffff',
            'time_col_bg_even' => $settings['time_col_bg_even'] ?? '#f7f7f7',
            'time_col_text_even' => $settings['time_col_text_even'] ?? '#000000',
            'time_col_bg_odd' => $settings['time_col_bg_odd'] ?? '#ffffff',
            'time_col_text_odd' => $settings['time_col_text_odd'] ?? '#000000',
            'border_color' => $settings['border_color'] ?? '#000000',
            'border_style' => $settings['border_style'] ?? 'dotted',
            'item_title' => $settings['item_title'] ?? '#000000',
            'item_subtitle' => $settings['item_subtitle'] ?? '#000000',
            'item_button_bg' => $settings['item_button_bg'] ?? '#ffffff',
            'item_button_text' => $settings['item_button_text'] ?? '#000000',
            'nav_bg_color' => $settings['nav_bg_color'] ?? '',
            'nav_buttons_color' => $settings['nav_buttons_color'] ?? '',
            'nav_buttons_border_color' => $settings['nav_buttons_border_color'] ?? '',
        ];
    }
}
