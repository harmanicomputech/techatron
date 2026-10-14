<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    public const STAGES = [
        'idea' => 'An idea I want to explore',
        'planning' => 'Planning, with requirements in progress',
        'in-progress' => 'A project already under way',
        'existing' => 'An existing system that needs help',
    ];

    public const TIMELINES = [
        'asap' => 'As soon as possible',
        '1-3-months' => 'Within 1 to 3 months',
        '3-6-months' => 'Within 3 to 6 months',
        'flexible' => 'Flexible',
    ];

    protected $fillable = [
        'name', 'email', 'organisation', 'phone', 'services', 'stage',
        'timeline', 'message', 'ip_address', 'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'notified_at' => 'datetime',
        ];
    }
}
