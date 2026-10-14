New project enquiry from the website

Name:          {{ $enquiry->name }}
Email:         {{ $enquiry->email }}
Organisation:  {{ $enquiry->organisation ?: '—' }}
Phone:         {{ $enquiry->phone ?: '—' }}
Services:      {{ collect($enquiry->services)->map(fn ($s) => app(\App\Support\Content::class)->service($s)['name'] ?? $s)->implode(', ') ?: '—' }}
Stage:         {{ \App\Models\Enquiry::STAGES[$enquiry->stage] ?? '—' }}
Timing:        {{ \App\Models\Enquiry::TIMELINES[$enquiry->timeline] ?? '—' }}

Message
-------
{{ $enquiry->message }}

--
Received {{ $enquiry->created_at->format('j M Y, H:i T') }} · Enquiry #{{ $enquiry->id }}
Reply to this email to respond directly to {{ $enquiry->name }}.
