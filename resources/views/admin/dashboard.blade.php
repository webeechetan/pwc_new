@extends('admin.layout.index')

@section('title') Admin @endsection

@section('body')
<link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
<div class="content-body">
    <!-- Container -->
    <div class="container-fluid">
        <!-- Breadcrumbs -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Home</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                </ol>
            </div>
        </div>
        <!-- Content Body -->
        <div class="row">
            <!-- |Total Startup| -->
            <div class="col-md-3" id='exportStartup'>
                <a href="javascript:void(0)">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <div class="media ai-icon">
                                <span class="mr-3">
                                    <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" style="stroke-dasharray: 66, 86; stroke-dashoffset: 0;"></path>
                                        <path d="M14,2L14,8L20,8" style="stroke-dasharray: 12, 32; stroke-dashoffset: 0;"></path>
                                        <path d="M16,13L8,13" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                        <path d="M16,17L8,17" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                        <path d="M10,9L9,9L8,9" style="stroke-dasharray: 2, 22; stroke-dashoffset: 0;"></path>
                                    </svg>
                                </span>
                                <div class="media-body">
                                    <p class="mb-1">Total Startup Registered</p>
                                    <h4 class="mb-0">{{$data_startup}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- |Total Pilot Companies| -->
            <div class="col-md-3">
            <a href="javascript:void(0)">
                <div class="widget-stat card">
                    <div class="card-body">
                        <div class="media ai-icon">
                            <span class="mr-3">
                                <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" style="stroke-dasharray: 66, 86; stroke-dashoffset: 0;"></path>
                                    <path d="M14,2L14,8L20,8" style="stroke-dasharray: 12, 32; stroke-dashoffset: 0;"></path>
                                    <path d="M16,13L8,13" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                    <path d="M16,17L8,17" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                    <path d="M10,9L9,9L8,9" style="stroke-dasharray: 2, 22; stroke-dashoffset: 0;"></path>
                                </svg>
                            </span>
                            
                            <div class="media-body">
                                <p class="mb-1" id="abc" title="Download Sheet">Total Pilot Companies</p>
                                <h4 class="mb-0">{{$data_pilot}} <i class="la la-eye show_pilots" title="View Sheet"></i></h4>
                                
                            </div>
                        </div>
                        <div class="text-center">
                            <!--<button class="btn btn-primary btn-sm show_pilots"><i class="la la-eye"></i></button>-->
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <!-- |Total Events| -->
            <div class="col-md-3">
            <a href="{{env('APP_URL')}}/admin/event/">
                <div class="widget-stat card">
                    <div class="card-body">
                        <div class="media ai-icon">
                            <span class="mr-3">
                                <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" style="stroke-dasharray: 66, 86; stroke-dashoffset: 0;"></path>
                                    <path d="M14,2L14,8L20,8" style="stroke-dasharray: 12, 32; stroke-dashoffset: 0;"></path>
                                    <path d="M16,13L8,13" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                    <path d="M16,17L8,17" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                    <path d="M10,9L9,9L8,9" style="stroke-dasharray: 2, 22; stroke-dashoffset: 0;"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Total Events</p>
                                <h4 class="mb-0">{{$data_event}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <!-- |Total Queries| -->
            <div class="col-md-3">
            <a href="{{env('APP_URL')}}/admin/contact/">
                <div class="widget-stat card">
                    <div class="card-body">
                        <div class="media ai-icon">
                            <span class="mr-3">
                                <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" style="stroke-dasharray: 66, 86; stroke-dashoffset: 0;"></path>
                                    <path d="M14,2L14,8L20,8" style="stroke-dasharray: 12, 32; stroke-dashoffset: 0;"></path>
                                    <path d="M16,13L8,13" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                    <path d="M16,17L8,17" style="stroke-dasharray: 8, 28; stroke-dashoffset: 0;"></path>
                                    <path d="M10,9L9,9L8,9" style="stroke-dasharray: 2, 22; stroke-dashoffset: 0;"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Total Queries</p>
                                <h4 class="mb-0">{{$data_query}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
        </div>
        <!--<button data-bs-toggle="modal" href="#exampleModalToggle">Show</button>-->
        
        
        <!--report-->
        <div class="row pilot_list" style="display:none">
             <div class="widget-stat card">
               @php
                    echo $table;
               @endphp
            </div>
        </div>
        <br />
        
        <div class="col-12" style="display:none">
            <table  border="1px" id='startupList'>
                <tr>
                    <th>SL.NO</th>
                    <th>COMPANY NAME</th>
                    <th>Company TYPE</th>
                    <th>Company SIZE</th>
                    <th>RESULT AFTER SCREENING</th>
                    <th>INTERESTED AFTER 1ST PHYSICAL MEETING</th>
                    <th>FINAL RESULT</th>
                </tr>
                <tbody id='startupsData'>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade modal-fullscreen" style="width:100%" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Modal 1</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Show a second modal and hide this one with the button below.
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button>
      </div>
    </div>
  </div>
</div>


<div style="display:none">
    @php
    echo $tableForExport;
    @endphp
</div>


@endsection
<script>
    function exportData(){
        let dataTable = document.getElementById('dataTable');
        let fptr = XLSX.utils.table_to_book(dataTable, {sheet: 'abc'});
        XLSX.write(fptr, {
            bookType: 'xlsx',
            type: 'base64',
        }),
        XLSX.writeFile(fptr, `pilot voting list.xlsx`);
    }
   
</script>
@php
    $dateFilter = '';
    $aditionalFilter = '';
@endphp
@section('script')
<!-- <link href="{{ asset('assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="//cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script src="{{asset('/assets/admin/js/textEditor.js')}}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js" integrity="sha512-DaMQrMxgirR5T0Zu+d7EABoP1uD7e2Sv6OBjifMM8RADf1orW42COfJgwZ8xsLRV6NhgR/erzCfodeqJmA3NtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script>
    $("#abc").click(function(){
       XLExport("exportTable")
   })
   $("#exportStartup").click(function(){
       XLExport("startupList")
   })

   function XLExport(tableId) {
       var tab_text = "<table border='2px'>";
       var textRange;
       var j = 0;
       tab = document.getElementById(tableId);
       for (j = 0 ; j < tab.rows.length ; j++) {
           tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
       }
       tab_text = tab_text + "</table>";
       tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
       tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
       tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // remove input params'
       sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
       return (sa);
   }

   window.onload = function (){
       $.get("/admin/startup?request=table",function(data,status){
            // console.log(data);
           let tr = '';
           let i = 0;
           for(x of data){
               console.log(x)
               i++;
               tr += '<tr>';
                    tr += '<td>'+i+'</td>';
                    tr += '<td>'+x.company_name+'</td>';
                    tr += '<td>'+x.company_type+'</td>';
                    tr += '<td>'+x.company_size+'</td>';
                    let up = 0;
                    let down = 0;
                    for(y of x.screening){
                        if(y.approved==1){
                            up++;
                        }
                        if(y.approved==2){
                            down++;
                        }
                    }
                    tr += '<td>Y='+up+' N='+down+'</td>';
                    up=0;
                    down=0;
                    for(y of x.meeting1){
                        if(y.approved==1){
                            up++;
                        }
                        if(y.approved==2){
                            down++;
                        }
                    }
                    tr += '<td>Y='+up+' N='+down+'</td>';
                    up=0;
                    down=0;
                    // for(y of x.meeting2){
                    //     if(y.approved==1){
                    //         up++;
                    //     }
                    //     if(y.approved==2){
                    //         down++;
                    //     }
                    // }
                    // tr += '<td>Y='+up+' N='+down+'</td>';
                    tr += '<td>Pending</td>';
                tr += '</tr>';

           }
           $("#startupsData").html(tr);
       })
   }
   $(document).ready( function () {
        $('#dataTable').DataTable({
            "scrollX": true,
            "pageLength": 50,
        });
        $(".show_pilots").click(function(){
            $(".pilot_list").toggle();
        });
        
    } );

   </script>
@endsection

