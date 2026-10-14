<?php

namespace App\Http\Requests;

use App\Models\Enquiry;
use App\Support\Content;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreEnquiryRequest extends FormRequest
{
    /** Humans take longer than this to fill in the form. */
    private const MIN_SECONDS = 3;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email:rfc', 'max:190'],
            'organisation' => ['nullable', 'string', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40', 'regex:/^[0-9+()\-.\s]{6,40}$/'],
            'services' => ['nullable', 'array', 'max:10'],
            'services.*' => ['string', Rule::in(app(Content::class)->services()->keys())],
            'stage' => ['nullable', Rule::in(array_keys(Enquiry::STAGES))],
            'timeline' => ['nullable', Rule::in(array_keys(Enquiry::TIMELINES))],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'consent' => ['accepted'],
            // Spam traps: a hidden field bots fill in, and when the form was rendered.
            'website' => ['nullable', 'max:0'],
            'started' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'email.required' => 'We need an email address to reply to you.',
            'email.email' => 'That email address does not look right.',
            'phone.regex' => 'Please use digits and + ( ) - only.',
            'message.required' => 'Tell us a little about what you need.',
            'message.min' => 'A few more details will help us reply usefully (at least 20 characters).',
            'consent.accepted' => 'Please confirm we may use these details to respond.',
            'website.max' => 'Your enquiry could not be sent.',
            'started.required' => 'Your enquiry could not be sent. Please reload the page and try again.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                try {
                    $started = (int) Crypt::decryptString($this->input('started'));
                } catch (DecryptException) {
                    $started = 0;
                }

                if ($started === 0 || now()->timestamp - $started < self::MIN_SECONDS) {
                    $validator->errors()->add('started', 'Your enquiry could not be sent. Please wait a moment and try again.');
                }
            },
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(collect($this->only('name', 'email', 'organisation', 'phone', 'message'))
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->all());
    }
}
