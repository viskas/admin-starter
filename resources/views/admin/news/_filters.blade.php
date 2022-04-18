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
                            <div class="col-md-6">
                                <label class="inner-title">{{ __('Entries per page') }}</label>
                                <select class="form-control" name="per_page">
                                    <option value="20" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 20) ? 'selected' : '' }}>20 {{ __('entries') }}</option>
                                    <option value="30" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 30) ? 'selected' : '' }}>30 {{ __('entries') }}</option>
                                    <option value="50" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 50) ? 'selected' : '' }}>50 {{ __('entries') }}</option>
                                    <option value="100" {{ (isset($_GET['per_page']) && $_GET['per_page'] == 100) ? 'selected' : '' }}>100 {{ __('entries') }}</option>
                                </select>
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
                                    <label class="inner-title">{{ __('Title') }}</label>
                                    <input type="text" name="title" class="form-control" value="{{ (isset($_GET['title']) && !empty($_GET['title'])) ? $_GET['title'] : '' }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="inner-title">{{ __('Slug') }}</label>
                                    <input type="text" name="slug" class="form-control" value="{{ (isset($_GET['slug']) && !empty($_GET['slug'])) ? $_GET['slug'] : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="inner-title">{{ __('Status') }}</label>
                                    <select class="form-control" name="status">
                                        <option></option>
                                        <option value="active" {{ (isset($_GET['status']) && $_GET['status'] == 'active') ? 'selected' : '' }}>{{ __('Active') }}</option>
                                        <option value="inactive" {{ (isset($_GET['status']) && $_GET['status'] == 'inactive') ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-info">
                            <i class="fas fa-search"></i>
                            {{ __('Search') }}
                        </button>

                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary float-right">
                            <i class="fas fa-eraser"></i>
                            {{ __('Clear') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
