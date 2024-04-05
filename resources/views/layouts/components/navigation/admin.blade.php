<a class="navbar-brand" href="{{ url('/') }}">
    {{ config('app.name', 'Laravel') }}
</a>
<a class="navbar-brand" href="{{ url('/') }}">
    {{ ucfirst(__('user.users')) }}
</a>
<a class="navbar-brand" href="{{ route('organization.index') }}">
    {{ ucfirst(__('organization.organizations')) }}
</a>