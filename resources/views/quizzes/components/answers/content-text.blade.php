<div class="row">
    <div class="form-outline">
    <label class="form-label" for="content">{{ ucfirst(__('quiz.form.answer.text')) }}</label>
    <input type="text" id="content" name="content" class="form-control" value="{{ old('content') }}" />
    @error('content')
        <div class="text-danger">{{ __($message) }}</div>
    @enderror
    </div>
</div>