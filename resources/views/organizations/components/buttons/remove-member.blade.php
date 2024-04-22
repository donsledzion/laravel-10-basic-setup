@if(\Auth::user()->isAllowed('remove_member'))
<button class="btn btn-danger remove-member" data-id="{{ $user->id }}" data-organization-id="{{ $organization->id }}">
    <i class="fa-regular fa-trash-can"></i>
</button>
@endif