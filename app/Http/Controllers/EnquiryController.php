<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use App\Support\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class EnquiryController extends Controller
{
    public function create(Request $request, Content $content): View
    {
        $services = $content->services();

        return view('pages.contact', [
            'services' => $services,
            'selected' => collect((array) $request->query('service'))
                ->filter(fn ($slug) => is_string($slug) && $services->has($slug))
                ->values()
                ->all(),
            'stages' => Enquiry::STAGES,
            'timelines' => Enquiry::TIMELINES,
            'started' => Crypt::encryptString((string) now()->timestamp),
        ]);
    }

    public function store(StoreEnquiryRequest $request): RedirectResponse
    {
        $enquiry = Enquiry::create($request->safe()->except('consent', 'website', 'started') + [
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 250, ''),
        ]);

        // The enquiry is already stored, so a mail failure must not lose it or
        // show the visitor an error; it is logged and can be followed up.
        if ($inbox = config('site.contact.inbox')) {
            try {
                Mail::to($inbox)->send(new EnquiryReceived($enquiry));
                $enquiry->forceFill(['notified_at' => now()])->save();
            } catch (Throwable $e) {
                Log::error('Enquiry notification failed', ['enquiry' => $enquiry->id, 'error' => $e->getMessage()]);
            }
        }

        return to_route('contact')
            ->with('enquiry_sent', $enquiry->name)
            ->withFragment('enquiry');
    }
}
