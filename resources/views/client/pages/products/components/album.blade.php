@if (isset($product) && $product->album)
    @php
        $album = is_string($product->alubm) ? json_decode($product->album, true) : $product->album;
    @endphp
    @if (is_array($album))
        @foreach ($album as $item)
        @endforeach
    @endif
@endif
