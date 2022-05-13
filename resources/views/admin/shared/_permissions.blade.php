<div class="card my-2">
    <div class="card-header" role="tab" id="{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
        <h4 class="mb-0">
            <a role="button" data-toggle="collapse" href="#dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}" aria-expanded="{{ isset($closed) ? 'true' : 'false' }}" aria-controls="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
                {{ $title ?? 'Override Permissions' }} {!! isset($user) ? '<span class="text-danger">(' . $user->getDirectPermissions()->count() . ')</span>' : '' !!}
            </a>
        </h4>
    </div>
    <div id="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}" class="card-collapse collapse {{ $closed ?? 'in' }}" role="tabcard" aria-labelledby="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
        <div class="card-body">
            <div class="row">
                @foreach($permissions as $key => $items)
                    <div class="col-md-3">
                        <ul class="treeview" style="list-style-type: none;">
                            <li>
                                <input type="checkbox" name="{{ $key }}" id="{{ $key }}" {{ $role->name === 'Admin' ? 'disabled checked' : '' }}>
                                <label for="{{ $key }}" class="custom-unchecked">{{ $key }}</label>
                                <ul style="list-style-type: none;">
                                    @foreach($items as $key => $item)
                                        @php
                                            $per_found = null;
                                            if( isset($role) ) {
                                                $per_found = $role->hasPermissionTo($item['name']);
                                            }
                                            if( isset($user)) {
                                                $per_found = $user->hasDirectPermission($item['name']);
                                            }
                                        @endphp
                                        <li>
                                            {!! Form::checkbox("permissions[]", $item['name'], $per_found, isset($options) ? $options : []) !!}
                                            <label for="{{ $item['name'] }}-{{ $key }}" class="custom-unchecked">
                                                {{ $item['description'] }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

