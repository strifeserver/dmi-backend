@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
        {{-- vendor css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
         {{-- Page Css files --}}
         <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
         <style>
          .panel > .list-group .list-group-item:first-child {
              /*border-top: 1px solid rgb(204, 204, 204);*/
          }

          .select2-container .select2-selection {
            height: 125px !important;  
            overflow-y: scroll !important;
          }
         
      
        
         </style>
@endsection

@section('content')
  <!-- Basic example section start -->

<section id="basic-examples">

  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
           
            <div> <!-- ag-grid-btns d-flex justify-content-between flex-wrap mb-1 -->
               
              
                
                <form class="form form-horizontal" id="formId" method="{{$method}}" action='{{route("sms_compose.store","")}}' 
                      enctype="multipart/form-data">
                      {{csrf_field()}}

                      <div class="row">
                          <div class="col-md-2 text-right">
                            <label class="mt-1" id="upload_blast_label">Upload Template:</label>
                          </div>
                          <div class="col-md-10">
                            <div class="row">
                            <div class="col-md-11 mx-0">
                            
                              <div id ="via_upload">  
                                
                                  <input type="file" id="fileUpload" name="file[]"  class="form-control" multiple />
                                  <div id="selectedFiles"></div><br>
                              </div>
                            <!-- style="display: none;" -->
                            <div id="via_phonebook" class="row mb-1" style="display: none;">                     
                                  <div class="col-md-6 mb-1 mt-1">
                                    <label for="validationServer013">Group</label>
                                       <select class="form-control"  id="group" name="group" >
                                              <option value="" style="">Please Select Group ....</option>
                                              @foreach ($group as $value) 
                                              <option value="{{ $value->group }}" {{ ($value->group == old('group')) ? 'selected' : '' }} >{{ $value->group }} [{{ $value->ctr }}]</option>
                                              @endforeach
                                      </select>
                                  </div>

                                  <div class="col-md-6 mb-1 mt-1">
                                    <label for="validationServer023">Sub Group</label>
                                     <select class="form-control"  id="subgroup" name="sub_group" >
                                              <option value="" >Please Select SubGroup....</option>
                                              @foreach ($subgroup as $value) 
                                              <option value="{{ $value->sub_group }}" {{ ($value->sub_group == old('subgroup')) ? 'selected' : '' }} >{{ $value->sub_group }} [{{ $value->ctr }}]</option>
                                              @endforeach
                                      </select>
                                  </div>
                                   

                                   <div class="col-md-12 col-sm-12 col-xs-12" id="pb_div">
                                    <select class="select2-data-ajax_custom form-control" style="height: 400px !important" multiple="multiple">
                                    </select>
                                  </div>
                            </div>
                          </div>

                          <div class="col-md-1 pl-0" >
                              <button id="contacts" type="button" class="btn btn-outline-primary bg-gradient-primary btn-sm"><i class="feather icon-user"></i> Phone Book</button>
                              <button type="button" id="close_pb" style="display:none;" class="btn btn-icon rounded-circle bg-gradient-primary">
                              <i class="feather icon-x"></i></button>
                          </div>
                            </div>
                          </div>
                          
                      </div>


                      <div class="row mb-1">
                        <div class="col-md-2 text-right">
                          <label for="">Email Account:</label>
                        </div>
                        <div class="col-md-10">
                        <select class="form-control " onchange="getMessage(this)" id="sample" name="template" autofocus>
                                <option value="" style="display:none;">Please Select ....</option>
                                
                        </select>
                        </div>
                      </div>
                      

                      <div class="row mb-1">
                        <div class="col-md-2 text-right">
                          <label for="">Subject:</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control">
                        </div>
                      </div>

                      <div class="row">
                            <div class="col-md-6 col-12 mb-1" >
                              <div class="row">
                                <div class="col-md-4 text-right">
                                  <label  for="dateToSend">Date To Send:</label>
                                </div>
                                
                                <div class="col-md-8">
                                  <input type="text" class=" form-control pickadate-limits_custom" value="" name="dateToSend" />
                                </div>
                                
                              </div>
                              
                              
                          </div>

                          <div class="col-md-6 col-12 mb-1">
                            <div class="row">
                              <div class="col-md-4 text-right">
                                 <label for="timeToSend">Time To Send:</label>
                              </div>

                              <div class="col-md-8">
                                <input type="text" value="" class="form-control pickatime-min-max_custom" name="timeToSend">
                              </div>

                            </div>
                           
                            
                          </div>
                      </div>

                      <div class="row mb-1">
                        <div class="col-md-2 text-right">
                          <label for="">Dynamic Date Column:</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control">
                        </div>
                      </div>

                       <div class="row mb-1">
                        <div class="col-md-2 text-right">
                          <label for="">Website:</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control">
                        </div>
                      </div>

                       <div class="row mb-1">
                        <div class="col-md-2 text-right">
                          <label for="">Message:</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor"></textarea>
                        </div>
                      </div>
                      
                </form>

                 <!-- <input type="submit" name="submit_sample" value="Sample"> -->
            </div>
          </div>
        </div>

  
  
        
        <div class="modal fade" id="modal" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Error Found!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div id="modal_msg"class="modal-body" style="color: black;">
              
              </div>
              
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- // Basic example section end -->


@endsection
@section('vendor-script')
{{-- vendor files --}}
        <!-- <script src="{{ asset(mix('vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js')) }}"></script> -->
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        
@endsection


@section('page-script')
<script src="{{ asset(mix('js/scripts/pickers/dateTime/pick-a-datetime.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>


<script>

CKEDITOR.replace( 'summary-ckeditor');



$(function () {

    $('#unselectAll').click(function(){
        if($(this).prop("checked") == true){
            $('#group').val("");
            $('#subgroup').val("");
            $('#pb_div').show()
        }
    });  

  /////////////////////////////
  var SELECT_ALL_LIMIT = 70;
  var selectedID_arr = [];
  

$.fn.select2.amd.define('select2/selectAllAdapter', [
  'select2/utils',
  'select2/dropdown',
  'select2/dropdown/attachBody'
], function(Utils, Dropdown, AttachBody) {
  function SelectAll() {}

  SelectAll.prototype.render = function(decorated) {
    var $rendered = decorated.call(this);
    var self = this;
    var $selectAll = $('<button class="btn btn-primary btn-md" type="button"> Select All</button>');
    var checkOptionsCount = function() {
      var count = $('.select2-results__option').length;
      $selectAll.text('Select All');
      $selectAll.prop('disabled', count > SELECT_ALL_LIMIT);
    }

    var $container = $('.select2-container');
    $container.bind('keyup click', checkOptionsCount);
    var $dropdown = $rendered.find('.select2-dropdown')
    
    $dropdown.prepend($selectAll);
    $selectAll.on('click', function(e) {
      var $_selectedData = $select_custom.select2('data');
      for (var a = 0; a < $_selectedData.length; a++) {
        selectedID_arr.push($_selectedData[a].id)
      }
      
      for (var b = 0; b < selected_data.length; b++) {
        if( (in_array(selected_data[b].id,selectedID_arr) != -1) == false ) {
          var option = new Option(selected_data[b].text, selected_data[b].id, true, true);
          $select_custom.append(option).trigger('change');
          
          $select_custom.trigger({
              type: 'select2:select',
              params: {
                  data: selected_data[b]
              }
          });

          
        }
      }
      self.trigger('close');
    });
    return $rendered;
  };

  return Utils.Decorate(
    Utils.Decorate(
      Dropdown,
      AttachBody
    ),
    SelectAll
  );
})
  /////////////////////////////  
  var selected_data = []; 
  var param_data = [];
  
  var $select_custom = $(".select2-data-ajax_custom").select2({
      dropdownAutoWidth: true,
      width: '100%',
      containerCssClass: 'select-lg',
      ajax: {
        headers: {'X-CSRF-TOKEN' : $('input[name="_token"]').val()},
        url: "/getPhonebookList",
        type: "POST",
        dataType: 'json',
        delay: 150,
        data: function (params) {
          return {
            search: params.term, // search term
            page: params.page
          };
        },
        processResults: function (data,params) {
          selected_data = data.all 
          params.page = params.page || 1;
          return {
            results: data.paginate.data,
            pagination: {
              more: (params.page * 10) < data.paginate.total
            }
          };
        },
        cache: true
      },
      allowClear:true,
      placeholder: 'Enter mobile number,email,name',
      escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 0,
      templateResult: formatRepo_custom,
      templateSelection: formatRepoSelection_custom,
      dropdownAdapter: $.fn.select2.amd.require('select2/selectAllAdapter')
    });

    $('#subgroup,#group').on("change", function (e) {
      e.preventDefault();
      $("#unselectAll"). prop("checked", false);
      var id = $(this).attr('id')
      var val = $(this).val();
      if(id == 'group' && $('#group').val() != ""){
          $.get('getSubgroup',{data:val,data1:''}, function(data){
            var obj = JSON.parse(data)
            window.param_data = obj.data 
            $('#subgroup').empty();
            $('#subgroup').append('<option value="" style="">Please Select SubGroup ....</option>')
            for (var i = 0; i < obj.subgroup.length; i++) {
              $('#subgroup').append('<option value="'+obj.subgroup[i]['sub_group']+'" style="">'+obj.subgroup[i]['sub_group']+ ' ['+obj.subgroup[i]['ctr']+']</option>')
            }
          })
      }

      if(id == 'subgroup'){
          $.get('getSubgroup',{data:$('#group').val(),data1:val}, function(data){
            var obj = JSON.parse(data)
            window.param_data = obj.data 
          })
      }
      
      if( $('#subgroup').val() == "" &&  $('#group').val() == ""){
         $('#pb_div').show()
      }else{
        $('#pb_div').hide()
        $('.select2-data-ajax_custom').val(null).trigger("change");
      }
       
    })
    
    $("#contacts").on("click", function (e) {
      e.preventDefault();
      $('#via_phonebook').show();
      $('#pb_div').show();
      $('#via_upload').hide();
      $('#upload_blast_label').hide()
      //$select_custom.select2("open");
      //$('.select2-search__field').val('');
      //$('.select2-search__field').trigger("keyup");
      $('#fileUpload').val('');
      $('#contacts').hide();
      $('#close_pb').show();
    });  
      
    // $('.select2-data-ajax_custom').on("select2:open",function(e){
    //   e.preventDefault();
    //   // $('.select2-search__field').val('');
    //   // $('#contacts').trigger("click");
    // }); 

    $('#close_pb').on('click',function(e){
      e.preventDefault()
      $('#via_phonebook').hide();
      $('#upload_blast_label').show()
      $('#via_upload').show();
      $('#contacts').show();
      $('#close_pb').hide();
      $('#group').val('');
      $('#subgroup').val('');
      $('.select2-data-ajax_custom').val(null).trigger("change");
      selectedID_arr = [];
      window.param_data = [];
    }); 
    
    function formatRepo_custom (repo) {
      if (repo.loading) return repo.text;
      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.text +"</div>";

      markup += "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='icon-code-fork mr-0'></i> "+repo.id+ "</div>" +
                "</div>" +
            "</div></div>";

      return markup;
    }

    function formatRepoSelection_custom (repo) {
      return repo.text;
    }  
    
  });

  /////revshare
  $('.pickadate-limits_custom').pickadate({
        format: 'yyyy-mm-dd',
        min: [{{$datenow}}],
  });

  $('.pickatime-min-max_custom').pickatime({
        min: [{{$timeLimit}}]
  });


  $('.pickadate-limits_custom').on('change', function () {
     var defDate = $('#defDateMin').val();
     var defTime = $('#defTimeLimit').val();
     if(defDate != $(this).val()){
      $('.pickatime-min-max_custom').pickatime('picker').clear().set('min',0);
      $('.pickatime-min-max_custom').pickatime('picker').set('select',[0,0]);
     }else{
      var a = defTime.split(',');
      $('.pickatime-min-max_custom').pickatime('picker').clear().set('min',[a[0],a[1]]);
      $('.pickatime-min-max_custom').pickatime('picker').set('select',[a[0],a[1]])
    
     }
  });

  
  function in_array(needle, haystack){
    var found = 0;
    for (var i=0, len=haystack.length;i<len;i++) {
        if (haystack[i] == needle) return i;
            found++;
    }
    return -1;
  } 

  function CSVtoArray(text) {
    var re_valid = /^\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*(?:,\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*)*$/;
    var re_value = /(?!\s*$)\s*(?:'([^'\\]*(?:\\[\S\s][^'\\]*)*)'|"([^"\\]*(?:\\[\S\s][^"\\]*)*)"|([^,'"\s\\]*(?:\s+[^,'"\s\\]+)*))\s*(?:,|$)/g;
    // Return NULL if input string is not well formed CSV string.
    if (!re_valid.test(text)) return null;
    var a = [];                     // Initialize array to receive values.
    text.replace(re_value, // "Walk" the string using replace with callback.
        function(m0, m1, m2, m3) {
            // Remove backslash from \' in single quoted values.
            if      (m1 !== undefined) a.push(m1.replace(/\\'/g, "'"));
            // Remove backslash from \" in double quoted values.
            else if (m2 !== undefined) a.push(m2.replace(/\\"/g, '"'));
            else if (m3 !== undefined) a.push(m3);
            return ''; // Return empty string.
        });
    // Handle special case of empty last value.
    if (/,\s*$/.test(text)) a.push('');
    return a;
  };


  function Upload(param) {
        $('#Output_div').empty();  
        var param = param - 1
        var fileUpload = document.getElementById("fileUpload");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;

        if (regex.test(fileUpload.value.toLowerCase())) {
            if($('textarea[name ="tpl_msg"]').val() != ''){ /////may laman ung template
              clear();
              if (typeof (FileReader) != "undefined") {
                  var dvCSV = document.getElementById("dvCSV");
                 
                  for (var io = 0; io < fileUpload.files.length; io++) {
                    var ab = 0;
                    var tmpname = fileUpload.files[io].name;
                    var substr = tmpname.substr(-4, 4);
                    var res_tmpname = tmpname.replace(substr, "");
                    var html = '';
                    var html2 = '';
                    var active = (io == 0) ? 'active' : '';
                    html +='<li class="nav-item">';
                    html += '<a class="nav-link '+active+'" id="'+res_tmpname+'-tab" data-toggle="tab" href="#'+res_tmpname+'" aria-controls="'+res_tmpname+'"';
                    html +='role="tab" aria-selected="true">'+res_tmpname+'</a></li>';
                    $("#_tab_list").append(html);
                  
                    html2+='<div class="tab-pane '+active+'"  id="'+res_tmpname+'" aria-labelledby="'+res_tmpname+'-tab" role="tabpanel">';
                    html2+='<div id="dvCSV'+io+'"></div></div>';
                    $("#_tab_content").append(html2);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var tmp_table = '<table style="color:black;">';
                        var rows = e.target.result.split("\n");
                        var tpl_msg_data = $('textarea[name ="tpl_msg"]').val();
                        var ctr = 1;
                        for (var i = 0; i < rows.length -1; i++) {
                            if(param >= i){
                              var cells = CSVtoArray(rows[i])
                                if (cells.length > 1) {

                                    tmp_table+='<tr>';
                                    var mobile = '';
                                    for (var j = 0; j < cells.length; j++) {
                                        mobile = cells[0];
                                        var template = tpl_msg_data.replace('%'+j+'%', cells[j]);
                                        tpl_msg_data = template;
                                    }
                                    tmp_table+='<td> '+ctr+'.] '+mobile+', '+template+'</td>';
                                    tmp_table+='</tr>';
                                    var tpl_msg_data = $('textarea[name ="tpl_msg"]').val();
                                }

                            }else{
                              break;
                            }
                            ctr++;
                        }
                        tmp_table+='</table>';  
                        $("#dvCSV"+ab).append(tmp_table);
                        tmp_table = '';
                        ab++;
                    }
                    reader.readAsText(fileUpload.files[io],"UTF-8");
                  }
              } else {
                  alert("This browser does not support HTML5.");
              }
            }
        } else {
            
            var x_contact = $('.select2-data-ajax_custom').select2('data');
            x_contact = (x_contact.length == 0) ? window.param_data : x_contact

            if(x_contact.length > 0){
                var tpl_msg_data = $('textarea[name ="tpl_msg"]').val();  
                if(tpl_msg_data != ''){
                  clear();
                  var html ='<li class="nav-item">';
                  html += '<a class="nav-link active" id="Phonebook-tab" data-toggle="tab" href="#Phonebook" aria-controls="Phonebook"';
                  html +='role="tab" aria-selected="true">Phonebook</a></li>';
                  $("#_tab_list").append(html);
                
                  var html2 ='<div class="tab-pane active"  id="Phonebook" aria-labelledby="Phonebook-tab" role="tabpanel">';
                  html2+='<div id="dvCSV0"></div></div>';
                  $("#_tab_content").append(html2);

                  var tmp_table = '<table style="color:black;">';
                  var ctr = 1;
                  for (var j = 0; j < x_contact.length; j++) {
                    if(param >= j){
                      tmp_table+='<tr>';
                      var tmp_mes = tpl_msg_data
                      var mobile = x_contact[j]['id'];
                      var template = tmp_mes.replace('%0%', mobile);
                      tmp_mes = template;
                      tmp_table+='<td> '+ctr+'.] '+mobile+', '+template+'</td>';
                      tmp_table+='</tr>';
                      
                    }else{
                      break;
                    }
                    ctr++;
                  }

                  tmp_table+='</table>';  
                  $("#dvCSV0").append(tmp_table); 
                }
            }else{
              $('#modal_msg').empty();
              $('#modal_msg').append('<p>Please upload a valid CSV file or select contacts from phonebook.</p>')
              $('#modal').modal('show');
              
            }
            
        }
  }


  function clear(){
    $('#upload_10').show();
    $('#send').show();
    $('#_tab_list').empty();
    $('#_tab_content').empty();
  }

  function cleanAll(){
    $('#_tab_content').empty();
    $('#_tab_list').empty();
    $('#formId')[0].reset();
    $('#upload_10').hide();
    $('#send').hide();
    $('#pb_div').show()
    $('.list-group-item').removeClass("active");
    $('.select2-data-ajax_custom').val(null).trigger("change");
    $('#group').val('');
    $('#subgroup').val('');
  }

  $('#fileUpload').on('change',function(){
    $('#_tab_content').empty();
    $('#_tab_list').empty();
    $('#upload_10').hide();
    $('#send').hide();
    $('.select2-data-ajax_custom').val(null).trigger("change");
  });



  $('#formId').on('submit', function(e){
    e.preventDefault();
    $('#modal_msg').empty();
    $("#loader").css("display", "inline-block");
    
    var fdata = new FormData(this)
    var x_contactlist = $('.select2-data-ajax_custom').select2('data');
    x_contactlist = (x_contactlist.length == 0) ? window.param_data : x_contactlist
    
    var x_contactlist = JSON.stringify(x_contactlist);

    fdata.append('phonebook',x_contactlist)
    //new FormData(this)
    $.ajax({
        type: "POST",
        url: "/sms_compose/",
        headers: {'X-CSRF-TOKEN' : $('input[name="_token"]').val()},
        success: function (data) {
            
          console.log(data);  
          
          $("#loader").css("display", "none");
           if(data.status=='1'){
            $('#Output_div').append(data.output)
             cleanAll();
           }else{
            $.each(data.errors, function(index, value) {
              $('#modal_msg').append(value[0]+'<br>')
            });
            $('#modal').modal('show');
           }
        },
        error: function (error) {},
        async: true,
        data: fdata,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
  });

  ////revshare

  function getMessage(message){
    var message = message.value;
    console.log(message)
    $.get('getSmsMessage',{data:message}, function(data){
      console.log(data)
      $('.tplmsg').val(data);
    })
  } 

</script>

@endsection

