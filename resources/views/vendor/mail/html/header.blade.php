@props(['url'])
<tr>
<td class="header">
    <a href="{{ $url }}" style="display: inline-block;">
        <img src="{{ asset(config('adminlte.logo_img')) }}"
             alt="{{ config('adminlte.logo_img_alt') }}" height="50">
    @if (trim($slot) === 'Laravel')
        <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
    @else
        {{ $slot }}
    @endif
</a>
</td>
</tr>
