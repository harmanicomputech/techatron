@php($responseTime = config('site.contact.response_time'))
<ol class="next-steps">
    <li class="next-step" data-reveal style="--i: 0">
        <p class="label label--accent">01 · You</p>
        <h3 class="h4">Tell us about the challenge</h3>
        <p>A short brief through our form or by email. Rough ideas are fine; you do not need a specification.</p>
    </li>
    <li class="next-step" data-reveal style="--i: 1">
        <p class="label label--accent">02 · Conversation</p>
        <h3 class="h4">A conversation, not a pitch</h3>
        <p>@if ($responseTime) We reply {{ $responseTime }} to arrange @else We reply personally to arrange @endif a call with someone who understands both the technology and the business question.</p>
    </li>
    <li class="next-step" data-reveal style="--i: 2">
        <p class="label label--accent">03 · Proposal</p>
        <h3 class="h4">A clear written proposal</h3>
        <p>Scope, approach, timeline and cost, with the assumptions and risks stated plainly so you can compare and decide.</p>
    </li>
    <li class="next-step" data-reveal style="--i: 3">
        <p class="label label--accent">04 · Delivery</p>
        <h3 class="h4">We start building</h3>
        <p>A kick-off, an agreed plan and regular demos of working software from the first weeks of the project.</p>
    </li>
</ol>
