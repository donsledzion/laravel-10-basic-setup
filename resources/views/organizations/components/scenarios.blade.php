@if(\Auth::user()->isAllowed('view_all_scenarios',$organization))
<h4 class="card-title mb-4">{{ ucfirst(__('organization.scenarios.scenarios')) }}</h4>
            <div class="tab-content p-4">
                <div class="tab-pane active show" id="tasks-tab" role="tabpanel">
                    @foreach($organization->scenarios as $scenario)
                        @include('organizations.components.scenario',['scenario' => $scenario])
                    @endforeach
                </div><!-- end tab pane -->
</div>
@endif