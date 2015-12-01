@extends('admin.template')

@section('body')
<div class="container-fluid">
    <h4 class="red">Name</h4>
    <div>{{ $role->name }}</div>
    <h4 class="red">Access Rights</h4>
    <ul class="list-unstyled">
        <li>
            @if ($role->permissions)
                @foreach ($role->permissions as $permissions => $permission)
                    [{{ ucfirst($permissions) }}] 
                @endforeach
            @else
                <span class="label label-danger label-sm">No Role</span>
            @endif    
        </li> 
    </ul>
    <h4 class="red">Permissions</h4>
    <!-- this should be remove if you choice is to show non accessible controller -->
    @if (is_array($role->permissions))
        <div class="container-fluid">
            <div class="col-lg-8">
            {!! Form::open(['route'=>['admin.permissions.change',$role->id],'method'=>'POST','class'=>'form-horizontal','role'=>'form','id'=>'permissions_update']) !!}
            {!! Form::hidden('role_form',csrf_token()) !!}            
            <div class="checkbox-handler">
                <ul class="list-unstyled">            
                @foreach ($acl as $key => $values)    
                    <?php 
                    $access = head(array_keys($values)); 
                    $_access = strtolower($access); 
                    ?>
                    <li>         
                        <h4 class="row green">{{ $access }}</h4>
                        <div class="control-group"> 
                            <div class="form-group">   
                                    <?php 
                                    // Set default variable checking
                                    $is_admin = true; // Set this to false if we want to set superadmin disallowed to change admin permissions
                                    $readonly = '';
                                    $message  = '';                                             
                                    // Check current user if they are admin or not
                                    if( !Auth::inRole('admin') ) {
                                        $is_admin = false;
                                    }
                                    // Check if main module is passed
                                    if ($access == 'Admin') {
                                        $readonly   = $is_admin ? '' : ' disabled';
                                        $message    = '&nbsp;<small class="btn btn-success btn-xs disabled"><i class="ace-icon fa fa-exclamation-triangle"></i> SUPERADMIN ONLY</small>';
                                    }   
                                    ?>  
                                    @if (isset($role->permissions[$_access]) && array_get($role->permissions, $_access) == 1)
                                        <input type="checkbox" class="checked" id="role_permission[{{$_access}}]" name="role_permission[{{$_access}}]" checked value="true" {{ $readonly }} />
                                        @if ($readonly)
                                            <input type="hidden" value="true" name="role_permission[{{$_access}}]"/>
                                        @endif
                                    @else
                                        <input type="checkbox" class="checked" id="role_permission[{{$_access}}]" name="role_permission[{{$_access}}]" value="false" {{ $readonly }} />
                                    @endif
                                    <label for="role_permission[{{$_access}}]">{{ ucwords(str_replace('.',' ',$_access)) }}</label>                            
                            </div>
                        </div>                    
                    </li>
                @endforeach 
                    <li>
                        <div class="input-sm">
                            <input type="checkbox" name="check_all" id="check_all" />
                            <label class="blue" for="check_all">Check All</label>
                            {!! $message !!}
                        </div>       
                        <div class="space-10"></div>    
                    </li>
                </ul>
            </div>    
            <div class="pull-right">{!! Form::submit('Save All Permissions',['class'=>'btn btn-primary btn-sm']) !!}</div>
            {!! Form::close() !!}
            </div>
        </div>
        <hr/>
    @else 
        <span class="label label-danger label-sm">No Permissions</span>
    @endif
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-info btn-xs">Back to all roles</a>
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-xs">Edit role</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.roles.trash', $role->id]
            ]) !!}
                {!! Form::submit('Delete this role?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop