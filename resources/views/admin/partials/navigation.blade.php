      <div id="sidebar" class="sidebar responsive">
        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
          <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
              <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
              <i class="ace-icon fa fa-pencil"></i>
            </button>

            <button class="btn btn-warning">
              <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
              <i class="ace-icon fa fa-cogs"></i>
            </button>
          </div>

          <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
          </div>
        </div><!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list">
        <!--li class="active">
          <a href="{{ URL::to($admin_url.'/dashboard') }}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
          </a>

          <b class="arrow"></b>
        </li-->
        @foreach (config('setting.acl') as $key => $values)                
            <li class="">         
                <a href="#" class="dropdown-toggle">
                  <!--i class="menu-icon fa fa-users"></i-->&nbsp;&nbsp;
                  <span class="menu-text">{{ head(array_keys($values)) }}</span>
                  <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                  @foreach ($values as $b => $key_access)
                      @foreach ($key_access as $tmp_access => $tmp)
                        @foreach (current($tmp)['action'] as $access)                                   
                           <li class="{{ str_contains(Route::getCurrentRoute()->getName(), $access) ? 'active' : '' }}">
                            <a href="{{ route("admin.{$access}") }}">
                              <i class="menu-icon fa fa-caret-right"></i>{{ key($tmp) }}<!--b class="arrow fa fa-user"></b-->
                            </a>
                            <b class="arrow"></b>
                          </li> 
                        @endforeach
                      @endforeach    
                  @endforeach
                </ul>                  
            </li>
        @endforeach

        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
          <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
      </div>