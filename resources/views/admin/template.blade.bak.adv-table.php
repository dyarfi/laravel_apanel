<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{{ isset($title) ? $title : '' }} {{ isset($title) ? ' | '. $admin_app : $admin_app }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets.admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets.admin/font-awesome/4.2.0/css/font-awesome.min.css') }}" /> 
    <!-- page specific plugin styles -->
    <!--link rel="stylesheet" href="{{ asset('assets.admin/css/jquery-ui.custom.min.css') }}" /-->
    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('assets.admin/fonts/fonts.googleapis.com.css') }}" />    
    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('assets.admin/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />
    <!--[if lte IE 9]>
      <link rel="stylesheet" href="{{ asset('assets.admin/css/css/ace-part2.min.css') }}" class="ace-main-stylesheet" />
    <![endif]-->
    <!--[if lte IE 9]>
      <link rel="stylesheet" href="{{ asset('assets.admin/css/ace-ie.min.css') }}" />
    <![endif]-->
@if(isset($styles))
  @foreach ($styles as $style => $css) {!! Html::style($$css, ['rel'=>$style]) !!} @endforeach 
@endif
    <!-- inline styles related to this page -->
    <script>var base_url = '{{ url() }}';</script>
    <!-- ace settings handler -->
    <script src="{{ asset('assets.admin/js/ace-extra.min.js') }}"></script>
    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
    <script src="{{ asset('assets.admin/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('assets.admin/assets/js/respond.min.js') }}"></script>
    <![endif]-->
  </head>
  <body class="no-skin">
    <div id="navbar" class="navbar navbar-default">
      <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
      </script>
      <!-- <div class="navbar-container" id="navbar-container"> -->
      <div class="navbar" id="navbar-container">  
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
          <span class="sr-only">Toggle sidebar</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
          <a href="{{ URL::to($admin_url) }}" class="navbar-brand">
            <small>
              <i class="fa fa-leaf"></i>
              Apanel
            </small>
          </a>
        </div>
        @include('admin.partials.property')
      </div><!-- /.navbar-container -->
    </div>

    <div class="main-container" id="main-container">

      <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>

      @include('admin.partials.navigation')

      <div class="main-content">
        <div class="main-content-inner">
          <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            
            @if ($controller && $action)
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ URL::to($admin_url.'/dashboard') }}">Home</a>
              </li>
              <li class="active">
                <a href="{{ route('admin.'.strtolower($controller).'.index') }}">{{ ucfirst($controller) }}</a>
              </li>
                @if($action)
                <li class="">
                  {{ ucfirst($action) }}
                </li>
                @endif
            </ul><!-- /.breadcrumb -->
            @endif            

            <!--div class="nav-search" id="nav-search">
              <form class="form-search">
                <span class="input-icon">
                  <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                  <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
              </form>
            </div--><!-- /.nav-search -->
          </div>
          <div class="page-content">

            <div class="ace-settings-container" id="ace-settings-container">
              <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                <i class="ace-icon fa fa-cog bigger-130"></i>
              </div>

              <div class="ace-settings-box clearfix" id="ace-settings-box">
                <div class="pull-left width-50">
                  <div class="ace-settings-item">                    
                    <div class="pull-left">                      
                      <select id="skin-colorpicker" class="hide">
                      <?php  
                      if (config('setting.attributes')) {
                        foreach (config('setting.attributes') as $setting => $attribute) {
                          if ($setting == 'skins') {
                            $d=1;
                            foreach ($attribute as $attr => $val) {
                                if (@app('App\Db\User')->find(Auth::getUser()->id)->attributes->skins && app('App\Db\User')->find(Auth::getUser()->id)->attributes->skins == $attr) { ?>
                                  <option data-skin="no-skin" value="{{$attr}}" checked="checked" data-skin="no-skin">{{$attr}}</option>
                              <?php } else { ?>
                                  <option data-skin="skin-{{$d}}" value="{{$attr}}">{{$attr}}</option>
                              <?php }
                              $d++;                              
                            }
                          }                      
                        }
                      }
                      ?>
                      </select>
                    </div>
                    <span>&nbsp; Choose Skin</span>
                  </div>

                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                    <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                  </div>

                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                    <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                  </div>

                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                    <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                  </div>

                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                    <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                  </div>

                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                    <label class="lbl" for="ace-settings-add-container">
                      Inside
                      <b>.container</b>
                    </label>
                  </div>
                </div><!-- /.pull-left -->

                <div class="pull-left width-50">
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                    <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                  </div>

                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                    <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                  </div>

                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                    <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                  </div>
                </div><!-- /.pull-left -->
              </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->

            <!--div class="page-header">
              <h1>
                {{ $admin_app }}
                <small>
                  <i class="ace-icon fa fa-angle-double-right"></i>
                  overview &amp; stats
                </small>
              </h1>
            </div--><!-- /.page-header -->

            <div class="space-16"></div>

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                
                <!--div class="alert alert-block alert-success">
                  <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                  </button>

                  <i class="ace-icon fa fa-check green"></i>

                  Welcome to
                  <strong class="green">
                    Ace
                    <small>(v1.3.3)</small>
                  </strong>,
  легкий, много-функциональный и простой в использовании шаблон для админки на bootstrap 3.3. Загрузить исходники с <a href="https://github.com/bopoda/ace">github</a> (with minified ace js files).
                </div-->

                @include('admin.partials.notification')

                @yield('body')

                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->
      <div class="footer">
        <div class="footer-inner">
          <div class="footer-content">
            <span class="bigger-120">
              <span class="blue bolder">Apanel</span>
              Application &copy; 2013-2014
            </span>

            &nbsp; &nbsp;
            <span class="action-buttons">
              <a href="#">
                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
              </a>

              <a href="#">
                <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
              </a>

              <a href="#">
                <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
              </a>
            </span>
          </div>
        </div>
      </div>

      <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
      </a>
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="{{ asset('assets.admin/js/jquery.2.1.1.min.js') }}"></script>
    <!-- <![endif]-->

    <!--[if IE]>
      <script src="{{ asset('assets.admin/js/jquery.1.11.1.min.js') }}"></script>
    <![endif]-->

    <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='{{ asset('assets.admin/js/jquery.min.js') }}>"+"<"+"/script>");
    </script>
    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
     window.jQuery || document.write("<script src='{{ asset('assets.admin/js/jquery1x.min.js') }}>"+"<"+"/script>");
    </script>
    <![endif]-->

    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets.admin/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
    </script>
    <script src="{{ asset('assets.admin/js/bootstrap.min.js') }}"></script>

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
      <script src="{{ asset('assets.admin/js/excanvas.min.js') }}"></script>
    <![endif]-->

@if(isset($scripts)) @foreach($scripts as $script => $js) {!! Html::script($js, ['rel'=>$script]) !!} @endforeach @endif

    <!-- boostrap assets -->
    <!--script src="{{ asset('assets.admin/js/jquery-ui.custom.min.js') }}"></script-->
    <script src="{{ asset('assets.admin/js/bootbox.min.js') }}"></script>
    <script src="{{ asset('assets.admin/js/jquery-ui.custom.min.js') }}"></script>
    <script src="{{ asset('assets.admin/js/jquery.ui.touch-punch.min.js') }}"></script>
    
    <!-- ace scripts -->
    <script src="{{ asset('assets.admin/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets.admin/js/ace.min.js') }}"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {

        // ---------------------- ADMINISTRATOR Javascript Custom Function -- start [ --------------------------        

        // Add active class to current page menu
        $('.submenu').find('.active').parents('li').addClass('active').find('b').removeClass('arrow fa fa-angle-down');
        
        $('#permissions_update input[class="checked"]').change(function(){
          if( $(this).is(':checked')) {
            $(this).attr('value',true);
          } else {
            $(this).attr('value',false);
          }
        });

        // Set method to check all or uncheck all on permission checkbox
        $('#permissions_update input[name^="check_all"]').change(function(){          
          var $form  = $(this).parents('div.checkbox-handler');
          var $label = $(this).next('label');
          if( $(this).is(':checked')) {
              $form.find('input[class="checked"]:not(:disabled)').prop('checked',true);
              $form.find('input[class="checked"]:not(:disabled)').attr('value',true);
              $label.text('Unchecked All');
          } else {
              $form.find('input[class="checked"]:not(:disabled)').prop('checked',false);
              $form.find('input[class="checked"]:not(:disabled)').attr('value',false);
              $label.text('Check All');
          }
        });
        
        // Set to check if checkbox parent is all checked up or false on permission checkbox
        $('#permissions_update input[name^="check_all"]').each(function( index ) {
          //console.log( index + ": " + $( this ).text() );
          var $form    = $(this).parents('div.checkbox-handler');
          var $input   = $form.find('input[class="checked"]').length;
          var $checked = $form.find('input[class="checked"]:checked').length;
          var $label   = $(this).next('label');
          if ($input === $checked) {
            $(this).prop('checked',true);
            $label.text('Unchecked All');
          } else {            
            $(this).prop('checked',false);
          }
        });

        // Send ajax post on permissions controller
        $('#permissions_update').submit(function(){
          var $form = $(this);          
          $.ajax({
              method:'POST',
              url: $form.attr('action'),
              data:$form.serialize(),   
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  bootbox.alert(errorThrown, function(result) {
                    //if (result === null) {                      
                    //} else {                      
                    //}
                  });
              }  
          }).done(function(message) {
              if (message.status == 200) {
                bootbox.alert(message.message, function(result) {});
                location.reload();
              }
          });
          return false;
        });
        
        // Set and find form Slug input from Name input
        if ($('input[id="name"], input[id="title"]').size() > 0 && $('input[id="slug"]').size() > 0) {
          // Detects if user type on the input
          $('input[id="name"], input[id="title"]').on('keyup blur',function(){
              var re  = /[^a-z0-9]+/gi;
              var re2 = /^-*|-*$/g;
              var value = $(this).val();
              value = value.replace(re2, '').toLowerCase();
              value = value.replace(re, '-');
              // Set Slug form
              $('input[id="slug"]').val(value);            
          });

        }



        // TABLE ----------------------------------------- 
        

        if ($('#dynamic-table').size() > 0) {
          //initiate dataTables plugin
          var oTable1 = 
          $('#dynamic-table')
          //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
          .dataTable( {
            bAutoWidth: false,
            "aoColumns": [
              { "bSortable": false },
              // It seems depends on column count or will be alerting some error
              null, null, null, null, 
              { "bSortable": false }
            ],
            // set the initial value
            "iDisplayLength": 10,
            "aaSorting": [],        
            //,
            //"sScrollY": "200px",
            //"bPaginate": false,
        
            //"sScrollX": "100%",
            //"sScrollXInner": "120%",
            //"bScrollCollapse": true,
            //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
            //you may want to wrap the table inside a "div.dataTables_borderWrap" element
        
            //"iDisplayLength": 50
            } );
          //oTable1.fnAdjustColumnSizing();
        
        
          //TableTools settings
          TableTools.classes.container = "btn-group btn-overlap";
          TableTools.classes.print = {
            "body": "DTTT_Print",
            "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
            "message": "tableTools-print-navbar"
          }
        
          //initiate TableTools extension
          var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
            "sSwfPath": base_url +"/assets.admin/swf/copy_csv_xls_pdf.swf",
            
            "sRowSelector": "td:not(:last-child)",
            "sRowSelect": "multi",
            "fnRowSelected": function(row) {
              //check checkbox when row is selected
              try { $(row).find('input[type=checkbox]').get(0).checked = true }
              catch(e) {}
            },
            "fnRowDeselected": function(row) {
              //uncheck checkbox
              try { $(row).find('input[type=checkbox]').get(0).checked = false }
              catch(e) {}
            },
        
            "sSelectedClass": "success",
                "aButtons": [
              {
                "sExtends": "copy",
                "sToolTip": "Copy to clipboard",
                "sButtonClass": "btn btn-white btn-primary btn-bold",
                "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
                "fnComplete": function() {
                  this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
                    <p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
                    1500
                  );
                }
              },
              
              {
                "sExtends": "csv",
                "sToolTip": "Export to CSV",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
              },
              
              {
                "sExtends": "pdf",
                "sToolTip": "Export to PDF",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
              },
              
              {
                "sExtends": "print",
                "sToolTip": "Print view",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",
                
                "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",
                
                "sInfo": "<h3 class='no-margin-top'>Print view</h3>\
                      <p>Please use your browser's print function to\
                      print this table.\
                      <br />Press <b>escape</b> when finished.</p>",
              }
                ]
            } );
          //we put a container before our table and append TableTools element to it
            $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
          
          //also add tooltips to table tools buttons
          //addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
          //so we add tooltips to the "DIV" child after it becomes inserted
          //flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
          setTimeout(function() {
            $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
              var div = $(this).find('> div');
              if(div.length > 0) div.tooltip({container: 'body'});
              else $(this).tooltip({container: 'body'});
            });
          }, 200);
          
          
          
          //ColVis extension
          var colvis = new $.fn.dataTable.ColVis( oTable1, {
            "buttonText": "<i class='fa fa-search'></i>",
            "aiExclude": [0, 6],
            "bShowAll": true,
            //"bRestore": true,
            "sAlign": "right",
            "fnLabel": function(i, title, th) {
              return $(th).text();//remove icons, etc
            }
            
          }); 
          
          //style it
          $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')
          
          //and append it to our table tools btn-group, also add tooltip
          $(colvis.button())
          .prependTo('.tableTools-container .btn-group')
          .attr('title', 'Show/hide columns').tooltip({container: 'body'});
          
          //and make the list, buttons and checkboxed Ace-like
          $(colvis.dom.collection)
          .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
          .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
          .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');
        
        
          
          /////////////////////////////////
          //table checkboxes
          $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
          
          //select/deselect all rows according to table header checkbox
          $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header
            
            $(this).closest('table').find('tbody > tr').each(function(){
              var row = this;
              if(th_checked) tableTools_obj.fnSelect(row);
              else tableTools_obj.fnDeselect(row);
            });
          });
          
          //select/deselect a row when the checkbox is checked/unchecked
          $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
            var row = $(this).closest('tr').get(0);
            if(!this.checked) tableTools_obj.fnSelect(row);
            else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
          });
          
        
          
          
            $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            e.preventDefault();
          });
          
          
          //And for the first simple table, which doesn't have TableTools or dataTables
          //select/deselect all rows according to table header checkbox
          var active_class = 'active';
          $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header
            
            $(this).closest('table').find('tbody > tr').each(function(){
              var row = this;
              if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
              else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
          });
          
          //select/deselect a row when the checkbox is checked/unchecked
          $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
            var $row = $(this).closest('tr');
            if(this.checked) $row.addClass(active_class);
            else $row.removeClass(active_class);
          });
        
          
        
          /********************************/
          //add tooltip for small view action buttons in dropdown menu
          $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
          
          //tooltip placement on right or left
          function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            if ($parent.size > 0) {
              var off1 = $parent.offset();
              var w1 = $parent.width();
          
              var off2 = $source.offset();
              //var w2 = $source.width();

              if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            }
            return 'left';
          }
        }                  
        // TABLE DATA ---------------------------------------       




        var FormStatus = function () {
          
          var handleStatusForm = function () {    
              $('#select_action').change(
                function () {
                  $(this).parents('form').submit();
                }
              );  
          }
          
            return {
                //main function to initiate the module
                init: function () {
              handleStatusForm();
                }

            };

        }();
        
        FormStatus.init();

        // ---------------------- ADMINISTRATOR Javascript Custom Function -- end ] --------------------------        

        $('[data-rel=tooltip]').tooltip();

        if ($('.easy-pie-chart.percentage').size() > 0 ) {

            $('.easy-pie-chart.percentage').each(function(){
              var $box = $(this).closest('.infobox');
              var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
              var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
              var size = parseInt($(this).data('size')) || 50;
              $(this).easyPieChart({
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size/10),
                animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                size: size
              });
            })

          
            $('.sparkline').each(function(){
              var $box = $(this).closest('.infobox');
              var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
              $(this).sparkline('html',
                       {
                        tagValuesAttribute:'data-values',
                        type: 'bar',
                        barColor: barColor ,
                        chartRangeMin:$(this).data('min') || 0
                       });
            });
          
          
            //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
            //but sometimes it brings up errors with normal resize event handlers
            //$.resize.throttleWindow = false;
          
            var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
            var data = [
            { label: "social networks",  data: 38.7, color: "#68BC31"},
            { label: "search engines",  data: 24.5, color: "#2091CF"},
            { label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
            { label: "direct traffic",  data: 18.6, color: "#DA5430"},
            { label: "other",  data: 10, color: "#FEE074"}
            ]
            function drawPieChart(placeholder, data, position) {
              $.plot(placeholder, data, {
              series: {
                pie: {
                  show: true,
                  tilt:0.8,
                  highlight: {
                    opacity: 0.25
                  },
                  stroke: {
                    color: '#fff',
                    width: 2
                  },
                  startAngle: 2
                }
              },
              legend: {
                show: true,
                position: position || "ne", 
                labelBoxBorderColor: null,
                margin:[-30,15]
              }
              ,
              grid: {
                hoverable: true,
                clickable: true
              }
             })
           }
           drawPieChart(placeholder, data);
          
           /**
           we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
           so that's not needed actually.
           */
           placeholder.data('chart', data);
           placeholder.data('draw', drawPieChart);
          
          
            //pie chart tooltip example
            var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
            var previousPoint = null;
          
            placeholder.on('plothover', function (event, pos, item) {
            if(item) {
              if (previousPoint != item.seriesIndex) {
                previousPoint = item.seriesIndex;
                var tip = item.series['label'] + " : " + item.series['percent']+'%';
                $tooltip.show().children(0).text(tip);
              }
              $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
            } else {
              $tooltip.hide();
              previousPoint = null;
            }
            
           });
          
            /////////////////////////////////////
            $(document).one('ajaxloadstart.page', function(e) {
              $tooltip.remove();
            });
          
          
          
          
            var d1 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
              d1.push([i, Math.sin(i)]);
            }
          
            var d2 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
              d2.push([i, Math.cos(i)]);
            }
          
            var d3 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.2) {
              d3.push([i, Math.tan(i)]);
            }
            
          
            var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
            $.plot("#sales-charts", [
              { label: "Domains", data: d1 },
              { label: "Hosting", data: d2 },
              { label: "Services", data: d3 }
            ], {
              hoverable: true,
              shadowSize: 0,
              series: {
                lines: { show: true },
                points: { show: true }
              },
              xaxis: {
                tickLength: 0
              },
              yaxis: {
                ticks: 10,
                min: -2,
                max: 2,
                tickDecimals: 3
              },
              grid: {
                backgroundColor: { colors: [ "#fff", "#fff" ] },
                borderWidth: 1,
                borderColor:'#555'
              }
            });
      
        }


        $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
          var $source = $(source);
          var $parent = $source.closest('.tab-content')
          var off1 = $parent.offset();
          var w1 = $parent.width();
      
          var off2 = $source.offset();
          //var w2 = $source.width();
          if ($parent.size() > 0) {
            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
          }
          //return 'left';
          return 'right';
        }
      
      
        $('.dialogs,.comments').ace_scroll({
          size: 300
          });
        
        
        //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
        //so disable dragging when clicking on label
        var agent = navigator.userAgent.toLowerCase();
        if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
          $('#tasks').on('touchstart', function(e){
          var li = $(e.target).closest('#tasks li');
          if(li.length == 0)return;
          var label = li.find('label.inline').get(0);
          if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
        });
      
        $('#tasks').sortable({
          opacity:0.8,
          revert:true,
          forceHelperSize:true,
          placeholder: 'draggable-placeholder',
          forcePlaceholderSize:true,
          tolerance:'pointer',
          stop: function( event, ui ) {
            //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
            $(ui.item).css('z-index', 'auto');
          }
          }
        );
        $('#tasks').disableSelection();
        $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
          if(this.checked) $(this).closest('li').addClass('selected');
          else $(this).closest('li').removeClass('selected');
        });
      
      
        //show the dropdowns on top or bottom depending on window height and menu position
        $('#task-tab .dropdown-hover').on('mouseenter', function(e) {
          var offset = $(this).offset();
      
          var $w = $(window)
          if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
            $(this).addClass('dropup');
          else $(this).removeClass('dropup');
        });

///////////////////
          
        //typeahead.js
        //example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
        var substringMatcher = function(strs) {
          return function findMatches(q, cb) {
            var matches, substringRegex;
           
            // an array that will be populated with substring matches
            matches = [];
           
            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');
           
            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
              if (substrRegex.test(str)) {
                // the typeahead jQuery plugin expects suggestions to a
                // JavaScript object, refer to typeahead docs for more info
                matches.push({ value: str });
              }
            });
      
            cb(matches);
          }
         }
        /*
         $('input.typeahead').typeahead({
          hint: true,
          highlight: true,
          minLength: 1
         }, {
          name: 'types',
          displayKey: 'value',
          debug:true,          
          //source: substringMatcher(ace.vars['US_STATES'])
          source:substringMatcher(["text","textarea","option","radio"]),          
         }).on('change', function () { 
            //if($(this).val() == 'textarea') {
            //$('input#value').val(); 
            //}
        });          
        */
        ///////////////


        $('.btn-list').on('click',function(e) {
          var listing = $(this).parent().find('.table-head');
          e.preventDefault();

          var l = $('#dynamic-table th').size() - 1;
          var html = '';
          $('#dynamic-table th').each(function(index) {
            if (index < l && index != 0) {
              html += '<li><a href="javascript:;">'+$( this ).text()+'</a></li>';
            }
          });

          listing.html(html);

        });

        $('#dynamic-table').on('ready', function(e){
            var columnNumber, rowNumber, headerText;
            columnNumber = $(e.target).index() + 1;
            rowNumber = $(e.target).parent().index() + 1;
            headerText = $('th:nth-child(' + columnNumber + ')').text();
            $('.columns').html(columnNumber);
            $('.rows').html(rowNumber);
            $('.headers').html(headerText);
        });
      
      })
    </script>
  </body>
</html>
