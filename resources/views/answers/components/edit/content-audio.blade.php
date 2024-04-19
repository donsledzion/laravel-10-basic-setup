<div class="row">
    <div class="container mt-5">
        <div class="card">
          <div class="card-body">
            <div id="audio-drop-area" class="border rounded d-flex justify-content-center align-items-center"
              style="height: 200px; cursor: pointer">
              <div class="text-center">
                <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                <p class="mt-3">
                  {{ ucfirst(__('media.audio.drag-and-drop')) }}
                </p>
              </div>
            </div>
            <input type="file" name="content" id="content" accept="audio/*" class="d-none"/>
            @error('content')
                <div class="text-danger">{{ __($message) }}</div>
            @enderror
            <div id="audio-preview" class="container"></div>
          </div>
        </div>
      </div>
      <audio id="audio" controls="controls">
        <source id="audioSource" src="{{ asset('organizations'.'/'.$answer->quiz->scenario->organization->id.'/audios/'.$answer->content) }}">
      </audio>    
</div>