<div class="pl-lg-4" style="padding-left: 0!important; margin-top: 20px">
    <div class="col-lg-12">
        <div class="form-group focused @if ($errors->has('title')) has-error @endif">
            {!! Form::label('title', __('Title'), ['class' => 'form-control-label']) !!} <span class="small text-danger">*</span>
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Title')]) !!}
            @if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group focused @if ($errors->has('file')) has-error @endif">
            {!! Form::label('file', __('Photo'), ['class' => 'form-control-label']) !!}
            {!! Form::file('file', null, ['class' => 'form-control']) !!}
            @if ($errors->has('file')) <p class="help-block">{{ $errors->first('file') }}</p> @endif
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group @if ($errors->has('text')) has-error @endif">
            {!! Form::label('text', __('Text'), ['class' => 'form-control-label']) !!} <span class="small text-danger">*</span>
                <textarea class="form-control" id="text" name="text">
                    @if (isset($article->text))
                        {!! $article->text !!}
                    @endif
                </textarea>
            @if ($errors->has('text')) <p class="help-block">{{ $errors->first('text') }}</p> @endif
        </div>
    </div>


    <div class="col-lg-12">
        <div class="form-group focused @if ($errors->has('meta_title')) has-error @endif">
            {!! Form::label('meta_title', __('Meta Title'), ['class' => 'form-control-label']) !!}
            {!! Form::text('meta_title', null, ['class' => 'form-control', 'placeholder' => __('Meta Title')]) !!}
            @if ($errors->has('meta_title')) <p class="help-block">{{ $errors->first('meta_title') }}</p> @endif
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group focused @if ($errors->has('meta_description')) has-error @endif">
            {!! Form::label('meta_description', __('Meta Description'), ['class' => 'form-control-label']) !!}
            {!! Form::text('meta_description', null, ['class' => 'form-control', 'placeholder' => __('Meta Description')]) !!}
            @if ($errors->has('meta_description')) <p class="help-block">{{ $errors->first('meta_description') }}</p> @endif
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group focused @if ($errors->has('meta_keywords')) has-error @endif">
            {!! Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'form-control-label']) !!}
            {!! Form::text('meta_keywords', null, ['class' => 'form-control', 'placeholder' => __('Meta Keywords')]) !!}
            @if ($errors->has('meta_keywords')) <p class="help-block">{{ $errors->first('meta_keywords') }}</p> @endif
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group focused @if ($errors->has('status')) has-error @endif">
            {!! Form::label('status', __('Status'), ['class' => 'form-control-label']) !!}
            {!! Form::select('status', [
                'active' => __('Active'),
                'inactive' => __('Inactive')
            ], [isset($article) ? $article->status : ''], ['class' => 'form-control']) !!}
            @if ($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
        </div>
    </div>
</div>
