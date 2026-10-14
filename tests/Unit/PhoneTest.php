<?php

namespace Tests\Unit;

use App\Support\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function test_local_nigerian_numbers_become_international(): void
    {
        $this->assertSame('+2349022016978', Phone::e164('09022016978'));
        $this->assertSame('+2347045414419', Phone::e164('0704 541 4419'));
        $this->assertSame('+2349022016978', Phone::e164('+234 902 201 6978'));
    }

    public function test_numbers_are_grouped_for_display(): void
    {
        $this->assertSame('0902 201 6978', Phone::display('09022016978'));
        $this->assertSame('+234 902 201 6978', Phone::display('+234 902 201 6978'));
    }
}
