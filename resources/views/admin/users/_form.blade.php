@csrf

<div class="col-xl-4">
    <div class="card mb-4 mb-xl-0">
        <div class="card-header">{{ __('Profile Image') }}</div>
        <div class="card-body">
            @if(isset($user) && $user->avatar)
                <img class="img-account-profile rounded-circle mb-2 mx-auto d-block"
                     src="{{ asset('storage/avatars/'.$user->id.'/'.$user->avatar)}}"
                     style="height: 100px; width: 100px; object-fit: cover;" alt="">
            @else
                <img class="img-account-profile rounded-circle mb-2" src="assets/img/illustrations/profiles/profile-1.png" alt="">
            @endif
            <div class="small font-italic text-center text-muted mb-4">{{ __('JPG or PNG no more than 5 MB') }}</div>

            <div class="custom-file">
                <input type="file" name="image" class="custom-file-input @if ($errors->has('image')) is-invalid @endif" id="validatedCustomFile">
                <label class="custom-file-label" for="validatedCustomFile">{{ __('Select image...') }}</label>
                @if ($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-xl-8">
    <div class="card mb-4">
        <div class="card-header">{{ __('Basic Information') }}</div>
        <div class="card-body">
            <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1" for="inputFirstName">
                        {{ __('Name') }} <span class="small text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control @if ($errors->has('name')) is-invalid @endif"
                           id="inputFirstName" @if(isset($user)) value="{{ old('name', $user->name) }}" @else value="{{ old('name') }}" @endif>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="small mb-1" for="inputLastName">
                        {{ __('Last Name') }} <span class="small text-danger">*</span>
                    </label>
                    <input name="last_name" class="form-control @if ($errors->has('last_name')) is-invalid @endif"
                           id="inputLastName" type="text" @if(isset($user)) value="{{ old('last_name', $user->last_name) }}" @else value="{{ old('last_name') }}" @endif>
                    @if ($errors->has('last_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('last_name') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1" for="inputEmailAddress">
                        {{ __('Email') }} <span class="small text-danger">*</span>
                    </label>
                    <input name="email" class="form-control @if ($errors->has('email')) is-invalid @endif"
                           id="inputEmailAddress" type="email" @if(isset($user)) value="{{ old('email', $user->email) }}" @else value="{{ old('email') }}" @endif>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="small mb-1" for="inputPassword">{{ __('Password') }}</label>
                    <input name="password" class="form-control @if ($errors->has('password')) is-invalid @endif" id="inputPassword" type="password">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    @if(!isset($user))
                        <small class="text-muted">{{ __('You may not complete. The password will be generated automatically.') }}</small>
                    @endif
                </div>
                <div class="col-md-12 top15">
                    <div class="form-group @if ($errors->has('roles')) has-error @endif">
                        {!! Form::label('roles[]', __('Roles'), ['class' => 'form-label']) !!}
                        <div class="row">
                            @foreach($roles as $key => $item)
                                <div class="col-md-2">
                                    <label class="custom-control custom-checkbox">
                                        @if (isset($user))
                                            {!! Form::checkbox('roles[]', $key,
                                                in_array($item, $userRoles),
                                                ['class' => 'custom-control-input']) !!}
                                        @else
                                            {!! Form::checkbox('roles[]', $key, null, ['class' => 'custom-control-input']) !!}
                                        @endif
                                        <span class="custom-control-label">{{ $item }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @if ($errors->has('roles'))
                            <p class="help-block" style="color: #e74a3b">
                                {{ $errors->first('roles') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
        </div>
    </div>
</div>
