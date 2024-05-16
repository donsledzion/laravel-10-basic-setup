@if(\Auth::user()->isAllowed('view_all_scenarios',$organization) || 
\Auth::user()->isAllowed('view_organization_scenarios',$organization) ||
\Auth::user()->isAllowed('view_owned_scenarios',$organization)
)
<h4 class="card-title mb-4">{{ ucfirst(__('organization.scenarios.scenarios')) }}</h4>
<div class="tab-content p-4">
    <div class="tab-pane active show" id="tasks-tab" role="tabpanel">
        @foreach($organization->scenarios as $scenario)                    
            @if(\Auth::user()->isAllowed('view_all_scenarios',$organization) || 
            \Auth::user()->isAllowed('view_organization_scenarios',$organization) ||
            (\Auth::user()->isAllowed('view_owned_scenarios',$organization) && $scenario->owner->id == \Auth::user()->id))
                @include('organizations.components.scenario',['scenario' => $scenario])
            @endif
        @endforeach
    </div><!-- end tab pane -->
</div>
@endif