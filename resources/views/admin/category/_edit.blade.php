<div class="col-md-12">
    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert" style="display:none"></div>
</div>

<div class="col-md-12">
    @can('delete categories')
        {!! Form::open([
            'class'=>'delete',
            'url'  => route('admin.categories.destroy', $category->id),
            'method' => 'DELETE',
            ])
        !!}

        <button class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete the entry?') }}')" style="width: 100%">
            {{ __('Delete') }}
        </button>

        {!! Form::close() !!}
    @endcan
</div>

{!! Form::model($category, ['id' => 'categoryForm', 'method' => 'PUT', 'route' => ['admin.categories.update',  $category->id ], 'enctype' => 'multipart/form-data']) !!}

    @php
        $parentId = $category->parent_id;
        $traverse = function ($categories, $prefix = '-') use (&$traverse, $parentId) {
            foreach ($categories as $category) {
                $selected = '';

                if ($parentId == $category->id) {
                    $selected = 'selected';
                }

                echo '<option value="'.$category->id.'"'.$selected.'>';
                echo $prefix.' '.$category->name;
                echo '</option>';

                if (count($category->children) > 0) {
                    $traverse($category->children, '&nbsp'.$prefix.'-');
                }
            }
        };
    @endphp

    <div class="col-md-12">
        <div class="form-group focused @if ($errors->has('name')) has-error @endif">
            {!! Form::label('name', __('Category Name'), ['class' => 'form-control-label']) !!} <span class="small text-danger">*</span>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Category Name')]) !!}
            @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
        </div>
    </div>

    <div class="col-md-12">
        @if (isset($category->image) && !empty($category->image))
            <img src="{{ asset('storage/categories/'.$category->id.'/'.$category->image) }}" class="img img-responsive" style="max-height: 100px; max-width: 100%; margin-bottom: 20px">
        @endif

        <div class="form-group focused @if ($errors->has('file')) has-error @endif">
            {!! Form::file('file', null, ['class' => 'form-control']) !!}
            @if ($errors->has('file')) <p class="help-block">{{ $errors->first('file') }}</p> @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group focused @if ($errors->has('parent_id')) has-error @endif">
            {!! Form::label('parent_id', __('Parent Category'), ['class' => 'form-control-label']) !!}
            <select name="parent_id" id="parent_id" class="form-control">
                <option value=""></option>
                {{ $traverse($nodes) }}
            </select>
            @if ($errors->has('parent_id')) <p class="help-block">{{ $errors->first('parent_id') }}</p> @endif
        </div>
    </div>

    <div class="pl-lg-12" style="padding-left: 0!important">
        <div class="col-md-12">
            <div class="form-group focused @if ($errors->has('slug')) has-error @endif">
                {!! Form::label('slug', __('Slug'), ['class' => 'form-control-label']) !!}
                {!! Form::text('slug', null, ['class' => 'form-control', 'disabled', 'placeholder' => __('Slug')]) !!}
                @if ($errors->has('slug')) <p class="help-block">{{ $errors->first('slug') }}</p> @endif
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group focused @if ($errors->has('description')) has-error @endif">
                {!! Form::label('description', __('Description'), ['class' => 'form-control-label']) !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Category Description'), 'rows' => 3]) !!}
                @if ($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
            </div>
        </div>

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

        <div class="col-md-12">
            <button type="submit" class="btn btn-primary" style="width: 100%">
                {{ __('Save Changes') }}
            </button>
        </div>
    </div>

{!! Form::close() !!}

<script>
    $(document).ready(function () {
       function clear() {
           $('.alert-danger').empty().hide();
           $("p.help-block").remove();
       }

       $('#categoryForm').on('submit', function (e) {
           e.preventDefault();
           var formData = $(this).serialize();

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: $(this).attr('action'),
               method: 'PUT',
               data: formData,
               success: function (response) {
                   if (response.success == true) {
                    location.reload();
                   }
               },
               error: function (err) {
                   if (err.status == 422) {
                       clear();
                       $('.alert-danger').show();

                       $.each(err.responseJSON.errors, function (i, error) {
                           $('.alert-danger').append('<p>' + error[0] + '</p>');
                           var el = $(document).find('[name="' + i + '"]');
                           el.after($('<p class="help-block">' + error[0] + '</p>'));

                           $('.scroll-to-top').click();
                       });
                   }
               }
           })
       });
    });
</script>
