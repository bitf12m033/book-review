@if($rating)
    @for($i = 1; $i <= 5; $i++)
    {{ $i <= round($rating) ? '★' : '☆' }}
    @endfor
@else
    Not rating yet
@endif
<div>
    <!-- Order your soul. Reduce your wants. - Augustine -->

</div>