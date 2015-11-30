@extends('admin.template')

@section('body')
<div class="container-fluid">
    <h3>{{ $role->name }}</h3>
    <h4 class="red">Roles</h4>
    <ul class="list-unstyled">
        <li>
            @if ($role->permissions)
                @foreach ($role->permissions as $permissions => $permission)
                    {{ ucfirst($permissions) }}
                @endforeach
            @else
                <span class="label label-danger label-sm">No Role</span>
            @endif    
        </li> 
    </ul>
    <h4 class="red">Permission</h4>
    <!-- this should be remove if you choice is to show non accessible controller -->
    @if (is_array($role->permissions))
        <div class="container-fluid">
            <div class="col-lg-8">
            {!! Form::open(['route'=>['admin.roles.update',$role->id],'method'=>'POST','class'=>'form-horizontal','role'=>'form','id'=>'permissions_update']) !!}
            <ul class="list-unstyled">
                <?php 
                /*
                    @foreach ($role->permissions as $permissions => $permission)
                    <li>
                        {{ ucfirst($permissions) }}
                    </li>    
                    @endforeach    
                */
                ?>
                    @foreach ($acl as $key => $values)    
                    <?php $access = head(array_keys($values)); ?>
                        <li>         
                            <h4 class="row red">{{ $access }}<hr class="hr"/></h4>
                            <div class="control-group"> 
                                <div class="form-group">
                                    <div class="checkbox-handler">   
                                        <h5 class="green">{{ @key($tmp) }}</h5>
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
                                        @if (array_get($role->permissions, strtolower($access)) == 1)
                                            <input type="checkbox" class="checked" id="access_permission[{{@$access}}]" name="access_permission[{{@$access}}]" checked value="true" {{ $readonly }} />
                                            @if ($readonly)
                                                <input type="hidden" value="true" name="access_permission[{{@$access}}]"/>
                                            @endif
                                        @else
                                            <input type="checkbox" class="checked" id="access_permission[{{@$access}}]" name="access_permission[{{@$access}}]" value="false" {{ $readonly }} />
                                        @endif
                                        <label for="access_permission[{{@$access}}]">{{ ucwords(str_replace('.',' ',@$access)) }}</label><br/>                      
                                        <div class="input-sm">
                                            <input type="checkbox" name="check_all[{{@$key}}]" id="check_all[{{@$key}}]" {{ @$readonly }} />
                                            <label class="blue" for="check_all[{{@$key}}]">Check All</label>
                                            {!! $message !!}
                                        </div>       
                                        <div class="space-10"></div>                         
                                    </div>
                                </div>
                            </div>                    
                        </li>
                    @endforeach 
            </ul>
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
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-xs">Edit user</a>
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