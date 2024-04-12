<a class="navbar-brand" href="{{ url('/') }}">
    {{ config('app.name', 'Laravel') }}
</a>
<a class="navbar-brand" href="{{ route('user.show',[\Auth::user()]) }}">
    {{ ucfirst(__('user.my-profile')) }}
</a>
<a class="navbar-brand" href="{{ route('scenario.index') }}">
    {{ ucfirst(__('scenario.scenarios')) }}
</a>
<a class="navbar-brand" href="{{ route('organization.index') }}">
    {{ ucfirst(__('organization.organizations')) }}
</a>