@section('additional-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>
    <style>
        #cke_1_contents {
            min-height: 400px;
        }
    </style>
@endsection

@section('additional-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/locales/bootstrap-datepicker.{{ app()->getLocale() }}.js"></script>
    <script>
        $('#published_at').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            language: '{{ app()->getLocale() }}'
        });
    </script>
@endsection

<div class="row">
    <div class="col-md-8 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('News') }}</h6>
            </div>

            <div class="pl-lg-4" style="padding-left: 0!important; margin-top: 20px">
                <div class="col-lg-12">
                    <div class="form-group focused @if ($errors->has('title')) has-error @endif">
                        {!! Form::label('title', __('Title'), ['class' => 'form-control-label']) !!} <span class="small text-danger">*</span>
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Title')]) !!}
                        @if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group @if ($errors->has('text')) has-error @endif">
                        {!! Form::label('text', __('Text'), ['class' => 'form-control-label']) !!} <span class="small text-danger">*</span>
                        <textarea class="form-control" id="news-text" name="text" style="min-height: 400px">
                            @if (isset($article->text))
                                {!! $article->text !!}
                            @endif
                         </textarea>
                        @if ($errors->has('text')) <p class="help-block">{{ $errors->first('text') }}</p> @endif
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group focused @if ($errors->has('published_at')) has-error @endif">
                        {!! Form::label('published_at', __('Published At'), ['class' => 'form-control-label']) !!} <span class="small text-danger">*</span>
                        {!! Form::text('published_at', null, ['class' => 'form-control', 'placeholder' => __('Published At')]) !!}
                        @if ($errors->has('published_at')) <p class="help-block">{{ $errors->first('published_at') }}</p> @endif
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
        </div>
    </div>

    <div class="col-md-4 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Photo') }}</h6>
            </div>

            <div class="pl-lg-12" style="padding-left: 0!important; margin-top: 20px">
                <div class="col-md-12">
                    @if (isset($article->image) && !empty($article->image))
                        <img src="{{ asset('storage/news/'.$article->id.'/'.$article->image) }}" class="img img-responsive" style="max-height: 200px; max-width: 100%; margin-bottom: 20px">
                    @endif

                    <div class="form-group focused @if ($errors->has('file')) has-error @endif">
                        {!! Form::file('file', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('file')) <p class="help-block">{{ $errors->first('file') }}</p> @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Metadata') }}</h6>
            </div>

            <div class="pl-lg-12" style="padding-left: 0!important; margin-top: 20px">
                <div class="col-md-12">
                    <div class="form-group focused @if ($errors->has('meta_title')) has-error @endif">
                        {!! Form::label('meta_title', __('Meta Title'), ['class' => 'form-control-label']) !!}
                        {!! Form::text('meta_title', null, ['class' => 'form-control', 'placeholder' => __('Meta Title')]) !!}
                        @if ($errors->has('meta_title')) <p class="help-block">{{ $errors->first('meta_title') }}</p> @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group focused @if ($errors->has('meta_description')) has-error @endif">
                        {!! Form::label('meta_description', __('Meta Description'), ['class' => 'form-control-label']) !!}
                        {!! Form::text('meta_description', null, ['class' => 'form-control', 'placeholder' => __('Meta Description')]) !!}
                        @if ($errors->has('meta_description')) <p class="help-block">{{ $errors->first('meta_description') }}</p> @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group focused @if ($errors->has('meta_keywords')) has-error @endif">
                        {!! Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'form-control-label']) !!}
                        {!! Form::text('meta_keywords', null, ['class' => 'form-control', 'placeholder' => __('Meta Keywords')]) !!}
                        @if ($errors->has('meta_keywords')) <p class="help-block">{{ $errors->first('meta_keywords') }}</p> @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Action') }}</h6>
            </div>

            <div class="pl-lg-12" style="padding-left: 0!important; margin-top: 20px">
                <div class="col-md-12">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 20px">
                            @if (!isset($article))
                                {{ __('Add') }}
                            @else
                                {{ __('Save Changes') }}
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
