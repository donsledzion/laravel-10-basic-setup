@if(\Auth::user()->isAllowed('create_organization_trainer',$organization))
    <a href="{{ route('organization.create.trainer',[$organization]) }}" class="btn btn-success mt-1">{{ ucfirst(__('organization.members.add.trainer')) }}</a>
@endif
