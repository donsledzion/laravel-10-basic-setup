<a class="navbar-brand" href="{{ url('/') }}">
    {{ config('app.name', 'Laravel') }}
</a>
<a class="navbar-brand" href="{{ route('user.index') }}">
    {{ ucfirst(__('user.users')) }}
</a>
<a class="navbar-brand" href="{{ route('permission.index') }}">
    {{ ucfirst(__('permission.permissions')) }}
</a>
<a class="navbar-brand" href="{{ route('multimedia.index') }}">
    {{ ucfirst(__('multimedia.multimedia')) }}
</a>
<a class="navbar-brand" href="{{ route('answeringInteractionType.index') }}">
    {{ ucfirst(__('answering-interactions.interactions')) }}
</a>
<a class="navbar-brand" href="{{ route('user.show',[\Auth::user()]) }}">
    {{ ucfirst(__('user.my-profile')) }}
</a>
<a class="navbar-brand" href="{{ route('organization.index') }}">
    {{ ucfirst(__('organization.organizations')) }}
</a>
