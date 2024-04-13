@if(\Auth::user()->isAllowed('edit_organization',$organization))
    <a href="{{ route('organization.edit',[$organization]) }}"><button class="btn btn-warning">{{ ucfirst(__('organization.edit')) }}</button></a>
@endif
