@if(\Auth::user()->isAllowed('create_organization'))
    <a href="{{ route('organization.create') }}"><button class="btn btn-info">{{ ucfirst(__('organization.add')) }}</button></a>
@endif
