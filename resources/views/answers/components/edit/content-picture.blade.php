<div class="row">
    <div class="container mt-5">
        <div class="card">
          <div class="card-body">
            <div id="picture-drop-area" class="border rounded d-flex justify-content-center align-items-center"
              style="height: 200px; cursor: pointer">
              <div class="text-center">
                <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                <p class="mt-3">
                  {{ ucfirst(__('media.picture.drag-and-drop')) }}
                </p>
              </div>
            </div>
            <input type="file" name="content" id="content" accept="image/*" class="d-none" />
            @error('content')
                <div class="text-danger">{{ __($message) }}</div>
            @enderror
            <div id="gallery" class="container"></div>
          </div>
        </div>
    </div>
</div>