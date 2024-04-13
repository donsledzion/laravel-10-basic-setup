@if(\Auth::user()->isAllowed('create_scenario',$organization))
            <a href="{{ route('scenario.create-for-organization',[$organization]) }}" class="btn btn-info">{{ ucfirst(__('organization.scenarios.add-new')) }}</a>
            @endif
