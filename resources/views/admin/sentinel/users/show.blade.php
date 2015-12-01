@extends('admin.template')

@section('body')
<div class="container-fluid">
    <h3>{{ $user->name }}</h3>
    <h4 class="red">Email</h4>
    <ul class="list-unstyled"><li>{{ $user->email }}</li></ul>
    <h4 class="red">Roles</h4>
    <ul class="list-unstyled">
        <li>
            @if ($user->roles->first())
                {{ $user->roles->first()->name }}
            @else
                <span class="label label-danger label-sm">No Role</span>
            @endif    
        </li> 
    </ul>
    <h4 class="red">Permission</h4>
    <!-- this should be remove if you choice is to show non accessible controller -->
    @if ($user->roles->first())
    <?php /* @if ($user->permissions) */ ?>
        <div class="container-fluid">
            <div class="col-lg-8">
            {!! Form::open(['route'=>['admin.permissions.change',$user->id],'method'=>'POST','class'=>'form-horizontal','role'=>'form','id'=>'permissions_update']) !!}
            {!! Form::hidden('user_form',csrf_token()) !!}
            <ul class="list-unstyled">

            @foreach ($acl as $key => $values)                
                <li>         
                    <h4 class="row red">{{ head(array_keys($values)) }}<hr class="hr"/></h4>
                    <div class="control-group"> 
                        <div class="form-group">
                            <div class="checkbox-handler">   
                                @foreach ($values as $b => $key_access)
                                    @foreach ($key_access as $tmp_access => $tmp)
                                    <h5 class="green">{{ key($tmp) }}</h5>
                                    <?php 
                                    foreach (current($tmp)['method'] as $access) {                        
                                        // Set default variable checking
                                        $is_admin = true; // Set this to false if we want to set superadmin disallowed to change admin permissions
                                        $readonly = '';
                                        $message  = '';
                                         
                                        // Check current user if they are admin or not
                                        if( !Auth::inRole('admin') ) {
                                            $is_admin = false;
                                        }
                                        // Check if module is passed
                                        if($key == 'Users' || $key == 'Roles' || $key == 'Permissions') {
                                            $readonly   = $is_admin ? '' : ' disabled';
                                            $message    = '&nbsp;<small class="btn btn-success btn-xs disabled"><i class="ace-icon fa fa-exclamation-triangle"></i> SUPERADMIN ONLY</small>';
                                        } ?>  
                                        @if (array_get($user->permissions, $access))
                                            <input type="checkbox" class="checked" id="access_permission[{{$access}}]" name="access_permission[{{$access}}]" checked value="true" {{ $readonly }} />
                                            @if ($readonly)                                            
                                                <input type="hidden" value="true" name="access_permission[{{$access}}]"/>
                                            @endif
                                        @else                        
                                            <input type="checkbox" class="checked" id="access_permission[{{$access}}]" name="access_permission[{{$access}}]" value="false" {{ $readonly }} />
                                        @endif
                                        <label for="access_permission[{{$access}}]">{{ ucwords(str_replace('.',' ',$access)) }}</label><br/>
                                    <?php 
                                    }
                                    ?>
                                    @endforeach    
                                @endforeach
                                <div class="input-sm">
                                    <input type="checkbox" name="check_all[{{$key}}]" id="check_all[{{$key}}]" {{ $readonly }} />
                                    <label class="blue" for="check_all[{{$key}}]">Check All</label>
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
    <?php 
    /*    
    @else 
        <span class="label label-danger label-sm">No Access</span>   
    @endif
    */
    ?>
    @else 
        <span class="label label-danger label-sm">No Access</span>       
    @endif
    <p class="lead">
        {{ $user->about }}
    </p>
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('users.index') }}" class="btn btn-info btn-xs">Back to all users</a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-xs">Edit user</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['users.destroy', $user->id]
            ]) !!}
                {!! Form::submit('Delete this user?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop