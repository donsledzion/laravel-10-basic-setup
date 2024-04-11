<a class="navbar-brand" href="{{ url('/') }}">
    {{ config('app.name', 'Laravel') }}
</a>
<a class="navbar-brand" href="{{ route('user.show',[\Auth::user()]) }}">
    {{ ucfirst(__('user.my-profile')) }}
</a>
<a class="navbar-brand" href="{{ route('organization.index') }}">
    {{ ucfirst(__('organization.organizations')) }}
</a>