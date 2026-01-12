<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @section('title', 'Poo | Your Poo Link is Here!')
    @section('description', 'You have been sent a Poo link! Click to proceed to the destination.')
    @include('partials.meta')
</head>
<body>
<p>If you are not redirected automatically, please click below...</p>
<br>
<a href="{{ $targetUrl }}">Go!</a>
<script>
    // Wait for the page to load and redirect to the original URL (This allows links to have custom metadata)
    document.addEventListener('DOMContentLoaded', function () {
        window.location.href = "{{ $targetUrl }}";
    });
</script>
</body>
</html>
