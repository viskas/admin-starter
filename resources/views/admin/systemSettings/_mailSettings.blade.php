<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Mail Settings') }}</h6>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.systemSettings.update') }}" autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="row">
                <div class="col-md-12">
                    @foreach($mailSettings as $key => $mailSetting)
                        <div class="form-group focused">
                            <label class="form-control-label" for="{{ $key }}">
                                {{ $key }}
                                <span class="small text-danger">*</span>
                            </label>
                            <input type="text" id="{{ $key }}" class="form-control" name="{{ $key }}" value="{{ $mailSetting['value'] }}">
                        </div>
                    @endforeach
                </div>
            </div>

            @can('update system settings')
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('{{ __('Are you sure you want to make new settings?') }}')">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </div>
            @endcan
        </form>
    </div>
</div>
