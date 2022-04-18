<div class="row top20">
    <div class="col-md-12">
        <p>
            <a class="" data-toggle="collapse" href="#collapseFilters" role="button" aria-expanded="false" aria-controls="collapseExample">
                {{ __('Filters') }}
            </a>
        </p>
        <div class="col-md-6 collapse @if(isset($_GET['per_page'])) show @endif" id="collapseFilters">
            <form method="GET">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="inner-title">{{ __('Entries per page') }}</label>
                                <select class="form-control" name="per_page">
                                    <option value="20" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 20) ? 'selected' : '' }}>20 {{ __('entries') }}</option>
                                    <option value="30" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 30) ? 'selected' : '' }}>30 {{ __('entries') }}</option>
                                    <option value="50" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 50) ? 'selected' : '' }}>50 {{ __('entries') }}</option>
                                    <option value="100" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 100) ? 'selected' : '' }}>100 {{ __('entries') }}</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="inner-title">{{ __('Sort by') }}</label>
                                        <select class="form-control" name="sort">
                                            <option></option>
                                            <option value="name" {{ (isset($_GET['sort']) && $_GET['sort'] == 'name') ? 'selected' : '' }}>{{ __('Name') }}</option>
                                            <option value="last_name" {{ (isset($_GET['sort']) && $_GET['sort'] == 'last_name') ? 'selected' : '' }}>{{ __('Last Name') }}</option>
                                            <option value="email" {{ (isset($_GET['sort']) && $_GET['sort'] == 'email') ? 'selected' : '' }}>{{ __('Email') }}</option>
                                            <option value="created_at" {{ (isset($_GET['sort']) && $_GET['sort'] == 'created_at') ? 'selected' : '' }}>{{ __('Created At') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="inner-title">{{ __('Direction') }}</label>
                                        <select class="form-control" name="direction">
                                            <option value="asc" {{ (isset($_GET['direction']) && $_GET['direction'] == 'asc') ? 'selected' : '' }}>{{ __('Ascending') }}</option>
                                            <option value="desc" {{ (isset($_GET['direction']) && $_GET['direction'] == 'desc' || !isset($_GET['direction'])) ? 'selected' : '' }}>{{ __('Descending') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row top15">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="inner-title">{{ __('Search') }}</label>
                                    <input type="text" name="search" class="form-control" value="{{ (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="inner-title">{{ __('Name') }}</label>
                                    <input type="text" name="name" class="form-control" value="{{ (isset($_GET['name']) && !empty($_GET['name'])) ? $_GET['name'] : '' }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="inner-title">{{ __('Last Name') }}</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ (isset($_GET['last_name']) && !empty($_GET['last_name'])) ? $_GET['last_name'] : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="inner-title">{{ __('Email') }}</label>
                                    <input type="text" name="email" class="form-control" value="{{ (isset($_GET['email']) && !empty($_GET['email'])) ? $_GET['email'] : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-info">
                            <i class="fas fa-search"></i>
                            {{ __('Search') }}
                        </button>

                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary float-right">
                            <i class="fas fa-eraser"></i>
                            {{ __('Clear') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
