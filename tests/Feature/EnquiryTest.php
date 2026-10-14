<?php

namespace Tests\Feature;

use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class EnquiryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        RateLimiter::clear('enquiries');
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Ada Obi',
            'email' => 'ada@example.com',
            'organisation' => 'Obi Logistics',
            'phone' => '+234 801 234 5678',
            'services' => ['software-development', 'digital-marketing'],
            'stage' => 'planning',
            'timeline' => '1-3-months',
            'message' => 'We need to replace our spreadsheet-based dispatch process with a proper system.',
            'consent' => '1',
            'website' => '',
            'started' => Crypt::encryptString((string) now()->subMinute()->timestamp),
        ], $overrides);
    }

    public function test_a_valid_enquiry_is_stored_and_the_team_is_notified(): void
    {
        $this->post('/contact', $this->payload())
            ->assertRedirect(route('contact').'#enquiry')
            ->assertSessionHas('enquiry_sent', 'Ada Obi');

        $enquiry = Enquiry::sole();
        $this->assertSame(['software-development', 'digital-marketing'], $enquiry->services);
        $this->assertNotNull($enquiry->notified_at);

        Mail::assertSent(EnquiryReceived::class, fn ($mail) => $mail->hasTo('enquiries@example.test')
            && $mail->hasReplyTo('ada@example.com'));

        $this->followRedirects($this->get(route('contact')))->assertOk();
    }

    public function test_the_confirmation_is_shown_after_sending(): void
    {
        $this->withSession(['enquiry_sent' => 'Ada'])
            ->get('/contact')
            ->assertSee('Thank you, Ada. Your brief is with us.')
            ->assertDontSee('Send your brief');
    }

    public function test_required_fields_are_validated_with_helpful_messages(): void
    {
        $this->from('/contact')
            ->post('/contact', $this->payload(['name' => '', 'email' => 'not-an-email', 'message' => 'Too short', 'consent' => null]))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors([
                'name' => 'Please tell us your name.',
                'email' => 'That email address does not look right.',
                'message',
                'consent',
            ]);

        $this->assertDatabaseCount('enquiries', 0);
        Mail::assertNothingSent();
    }

    public function test_unknown_services_and_options_are_rejected(): void
    {
        $this->post('/contact', $this->payload(['services' => ['hacking'], 'stage' => 'whenever']))
            ->assertSessionHasErrors(['services.0', 'stage']);
    }

    public function test_the_honeypot_blocks_bots(): void
    {
        $this->post('/contact', $this->payload(['website' => 'https://spam.example']))
            ->assertSessionHasErrors('website');

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_instant_or_tampered_submissions_are_rejected(): void
    {
        $this->post('/contact', $this->payload(['started' => Crypt::encryptString((string) now()->timestamp)]))
            ->assertSessionHasErrors('started');

        $this->post('/contact', $this->payload(['started' => 'forged']))
            ->assertSessionHasErrors('started');

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_submissions_are_rate_limited(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->post('/contact', $this->payload())->assertRedirect();
        }

        $this->post('/contact', $this->payload())->assertTooManyRequests();
    }

    public function test_a_mail_failure_does_not_lose_the_enquiry(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

        $this->post('/contact', $this->payload())->assertSessionHas('enquiry_sent');

        $this->assertNull(Enquiry::sole()->notified_at);
    }
}
