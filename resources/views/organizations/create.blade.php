@extends('layouts.app')

@section('head')
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('organization.add')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('organization.store') }}">
                        @csrf
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="name" name="name" class="form-control" />
                              <label class="form-label" for="name">{{ ucfirst(__('organization.name')) }}</label>
                                @error('name')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="prefix" name="prefix" class="form-control" />
                              <label class="form-label" for="prefix">{{ ucfirst(__('organization.prefix')) }}</label>
                            </div>
                          </div>
                        </div>

                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="headset_login" name="headset_login" class="form-control" />
                              <label class="form-label" for="headset_login">{{ ucfirst(__('organization.headset.login')) }}</label>
                            </div>
                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="headset_pin" name="headset_pin" class="form-control" placeholder="organization.placeholder.pin" value="{{ old('headset_pin') }}"/>
                              <label class="form-label" for="headset_pin">{{ ucfirst(__('organization.headset.pin')) }}</label>
                            </div>
                          </div>
                        </div>


                        <div data-mdb-input-init class="form-outline mb-4">
                            <input id="expires_at" name="expires_at" width="276" />
                            <label class="form-label" for="expires_at">{{ ucfirst(__('organization.expires_at')) }}</label>
                        </div>

                        <div class="container my-5">
                            <div class="card">
                              <div class="card-body">
                                <div id="drop-area" class="border rounded d-flex justify-content-center align-items-center"
                                  style="height: 200px; cursor: pointer">
                                  <div class="text-center">
                                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                                    <p class="mt-3">
                                      {{ ucfirst(__('organization.logo.drop')) }}
                                    </p>
                                  </div>
                                </div>
                                <input type="file" id="logo" name="logo" multiple accept="image/*" class="d-none" />
                                <div id="gallery"></div>
                              </div>
                            </div>
                        </div>
                        

                      
                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('organization.create')) }}</button>
                      </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
<script>
    $('#expires_at').datepicker({
        uiLibrary: 'bootstrap5'
    });
  let dropArea = document.getElementById('drop-area');
  let fileElem = document.getElementById('logo');
  let gallery = document.getElementById('gallery');

  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
  });

  ['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
  });

  dropArea.addEventListener('drop', handleDrop, false);

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  function highlight(e) {
    dropArea.classList.add('highlight');
  }

  function unhighlight(e) {
    dropArea.classList.remove('highlight');
  }

  function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
  }

  dropArea.addEventListener('click', () => {
    fileElem.click();
  });

  fileElem.addEventListener('change', function (e) {
    handleFiles(this.files);
  });

  function handleFiles(files) {
    files = [...files];
    files.forEach(previewFile);
  }

  function previewFile(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function () {
      let img = document.createElement('img');
      img.src = reader.result;
      gallery.appendChild(img);
    }
  }
</script>


@endsection
