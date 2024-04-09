<div style="display: none;" class="template-text2text">
    <div class="row px-4 mt-4">
        <div class="col-8">
            <div class="form-outline">
                <label class="form-label" >{{ ucfirst(__('quiz.form.answer_text')) }}</label>
                <input form="quiz_form" type="text" name="answer[][content]" class="form-control" value="{{ old('answer[][content]') }}" />
                @error('answer[][content]')
                    <div class="text-danger">{{ __($message) }}</div>
                @enderror
            </div>
        </div>
        <div class="col-4">
            <div class="form-check my-4">
                <input form="quiz_form" class="form-check-input answer-checkbox" type="checkbox" value="false" name="answer[][is_correct]">
                <label class="form-check-label" for="is_correct">
                {{ ucfirst(__('quiz.form.is_answer_correct')) }}?
                </label>
            </div>
        </div>
        
        <hr class="hr mb-4" />
    </div>
</div>