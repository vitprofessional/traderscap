@if($testimonials->isNotEmpty())
<div class="testimonials">
    @foreach($testimonials as $t)
    <div class="testimonial">
        @if($t->avatar)
            <img src="{{ asset('storage/' . $t->avatar) }}" alt="{{ $t->name }}" class="testimonial-avatar" />
        @endif
        <div class="testimonial-body">
            <strong>{{ $t->name }}</strong>
            @if($t->position || $t->company)
                <div class="testimonial-meta">{{ trim($t->position . ' ' . $t->company) }}</div>
            @endif
            <p>{{ $t->message }}</p>
        </div>
    </div>
    @endforeach
</div>
@endif
