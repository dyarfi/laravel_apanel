
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
          <li class="active">
            <a href="{{ URL::to($admin_url.'/dashboard') }}">
              <i class="menu-icon fa fa-tachometer"></i>
              <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
          </li>

          <li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-users"></i>
              <span class="menu-text">Administration</span>
              <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
              <li class="">
                <a href="{{ URL::to($admin_url.'/users') }}">
                  <i class="menu-icon fa fa-caret-right"></i>Users
                  <b class="arrow fa fa-user"></b>
                </a>
                <b class="arrow"></b>
              </li>

              <li class="">
                <a href="{{ URL::to($admin_url.'/roles') }}">
                  <i class="menu-icon fa fa-caret-right"></i>Roles
                  <b class="arrow fa fa-leaf"></b>
                </a>
                <b class="arrow"></b>
              </li>

              <li class="">
                <a href="{{ URL::to($admin_url.'/permissions') }}">
                  <i class="menu-icon fa fa-caret-right"></i>Permissions
                  <b class="arrow fa fa-lock"></b>
                </a>
                <b class="arrow"></b>
              </li>

              <li class="">
                <a href="{{ URL::to($admin_url.'/settings') }}">
                  <i class="menu-icon fa fa-caret-right"></i>Settings
                  <b class="arrow fa fa-cogs"></b>
                </a>
                <b class="arrow"></b>
              </li>

              <li class="">
                <a href="{{ URL::to($admin_url.'/logs') }}">
                  <i class="menu-icon fa fa-caret-right"></i>Logs
                  <b class="arrow fa fa-exchange"></b>
                </a>
                <b class="arrow"></b>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="{{ URL::to($admin_url.'/pages') }}" class="dropdown-toggle">
              <i class="menu-icon fa fa-pencil-square-o"></i>
              <span class="menu-text"> Page </span>
              <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
              <li class="">
                <a href="{{ URL::to($admin_url.'/dashboard') }}">
                  <i class="menu-icon fa fa-caret-right"></i>
                  Menu
                </a>
                <b class="arrow"></b>
              </li>
              <li class="">
                <a href="{{ URL::to($admin_url.'/dashboard') }}">
                  <i class="menu-icon fa fa-caret-right"></i>
                  Pages
                </a>
                <b class="arrow"></b>
              </li>
            </ul>
          </li>
        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
          <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
      </div>