@extends('admin.layout.index')



@section('title') Admin @endsection



@section('body')



@php

    $myRole = getUserRole();



    $dateFilter = $aditionalFilter = '';

    if(Request::get('from')) $dateFilter .= "&from=".Request::get('from');

    if(Request::get('to')) $dateFilter .= "&to=".Request::get('to');

    if(Request::get('registered')) $aditionalFilter .= "&registered=".Request::get('registered');

    if(Request::get('approved')) $aditionalFilter .= "&approved=".Request::get('approved');

    if(Request::get('rejected')) $aditionalFilter .= "&rejected=".Request::get('rejected');

    if(Request::get('pending')) $aditionalFilter .= "&pending=".Request::get('pending');

@endphp



<div class="content-body">

    <!-- Container -->

    <div class="container-fluid">

        <!-- Breadcrumbs -->

        <div class="row page-titles mx-0">

            <div class="col-sm-6 p-md-0">

                <div class="welcome-text">

                    <h4>All Pilot</h4>

                </div>

            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/admin">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Pilot</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">All Pilot</a></li>

                </ol>

            </div>

        </div>

        <!-- Content Body -->

        {{-- <div class="row mb-4">

            <div class="col-sm-12">

                <div class="row">

                    <div class="col-sm-6">

                        <div class="row">

                            <div class="col-md-6 mb-2">

                                <a href="{{env('APP_URL')}}/admin/startup?registered=true{{$dateFilter}}">

                                    <div class="card shadow h-100 py-2 d-flex align-items-center justify-content-center">

                                        <span class="text-center">

                                            <h5 class="mb-0">Registered</h5>

                                            <div class="text-orange h3 mb-0 font-weight-bold text-orange">{{$data_registered}}</div>

                                        </span>

                                    </div>

                                </a>

                            </div>

                            <div class="col-md-6 mb-2">

                                <a href="{{env('APP_URL')}}/admin/startup?pending=true{{$dateFilter}}">

                                    <div class="card shadow h-100 py-2 d-flex align-items-center justify-content-center">

                                        <span class="text-center">

                                            <h5 class="mb-0">Pending</h5>

                                            <div class="text-orange h3 mb-0 font-weight-bold text-orange">{{$data_pending}}</div>

                                        </span>

                                    </div>

                                </a>

                            </div>

                            <div class="col-md-6 mb-2">

                                <a href="{{env('APP_URL')}}/admin/startup?approved=true{{$dateFilter}}">

                                    <div class="card shadow h-100 py-2 d-flex align-items-center justify-content-center">

                                        <span class="text-center">

                                            <h5 class="mb-0">Approved</h5>

                                            <div class="text-orange h3 mb-0 font-weight-bold text-orange">{{$data_approved}}</div>

                                        </span>

                                    </div>

                                </a>

                            </div>

                            <div class="col-md-6 mb-2">

                                <a href="{{env('APP_URL')}}/admin/startup?rejected=true{{$dateFilter}}">

                                    <div class="card shadow h-100 py-2 d-flex align-items-center justify-content-center">

                                        <span class="text-center">

                                            <h5 class="mb-0">Rejected</h5>

                                            <div class="text-orange h3 mb-0 font-weight-bold text-orange">{{$data_rejected}}</div>

                                        </span>

                                    </div>

                                </a>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6">

                        <form name="date" method="GET">

                        <div class="row align-items-end">

                                <div class="col-lg-4 mb-2">

                                    <label>From</label>

                                    <input type="date" name="from" required class="form-control" value="{{Request::get('from')}}">

                                </div>

                                <div class="col-lg-4 mb-2">

                                    <label>To</label>

                                    <input type="date" name="to" required class="form-control" value="{{Request::get('to')}}">

                                </div>

                                <div class="col-lg-4 mb-2 text-center">

                                    <input type="submit" class="btn btn-sm btn-outline-primary">

                                    <a href="{{env('APP_URL')}}/admin/startup" class="text-success ml-2">Reset</a>

                                </div>

                                <div class="col-10">

                                    @if(count($pilots) !== 0)

                                        <small class="text-success">{{count($data_recent)}} New startup Added Today</small>

                                        <div class="row fw-bold text-center">

                                            <div class="col"><small>IMAGE</small></div>

                                            <div class="col"><small>COMPANY NAME</small></div>

                                            <div class="col"><small>STATE</small></div>

                                            <div class="col-12"><hr></div>

                                        </div>

                                        @foreach($data_recent as $key => $dR)

                                            @php

                                                if($key > 2) break;

                                            @endphp

                                            <div class="row text-center align-items-center">

                                                <div class="col"><small><img src="{{asset('storage/uploads/startup/Startup'.$dR->id.'.jpg')}}" alt="ACMA PWC" class="img-fluid rounded-circle" style="width: 40px"></small></div>

                                                <div class="col"><a href="{{ env('APP_URL') }}/admin/startup/view/{{$dR->id}}" target="_blank"><small>{{$dR->company_name}}</small></a></div>

                                                <div class="col"><small>{{$dR->state}}</small></div>

                                            </div>

                                        @endforeach

                                    @endif



                                    @if(count($pilots) === 0)

                                        <small class="text-success">No Recent Startup Added</small>

                                    @endif

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div> --}}

        <div class="row justify-content-end">

            <div class="col-md-4">

                <input class="form-control" type="search" placeholder="search" id="search_event" autcomplete="off">

            </div>

            <div class="col-12">

                <div id="tableToolbar">

                    <button  type="button" id="tableRefreshBtn" class="btn btn-primary btn-sm" >Refresh <i class="fas fa-sync"></i></button>

                    <button type="button" class="btn btn-sm"  id="tableUpdatedDate"></button>

                </div>

                <table

                  id="tableList"

                  data-height="600"

                  data-search="true"

                  data-visible-search="true"

                  data-toolbar="#tableToolbar"

                  data-ajax-options="eventAjax"

                  data-search-selector="#search_event"

                  data-show-columns="true"

                  data-show-columns-search="true"

                  data-show-export="true"

                  data-buttons-prefix="btn-sm btn btn-success"

                  data-pagination="true"

                  data-side-pagination="client"

                  data-server-sort="false"

                  data-pagination-v-align="top"

                  class="table-borderless table-hover fonts_size font_family">

                  <thead style="background-color:#3b7dd8;color:white"></thead>

                </table>

            </div>

        </div>

    </div>

</div>
<div style="display: none" >
    <table id="forExport">
        <tr>
            <th>Company Name</th>
            <th>Members</th>
            <th>Email</th>
            <th>Designation</th>
        </tr>
        <tbody id="dataForPrint">
        </tbody>
    </table>
</div>
@endsection

@section('script')

    <!--bootstrap table  -->

    <link href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css" rel="stylesheet">

    <link href="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.css" rel="stylesheet">



    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>

    <script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF/jspdf.min.js"></script>

    <script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>

    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.js"></script>

    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/export/bootstrap-table-export.min.js"></script>

    <script src="{{asset('/assets/admin/js/bootstrapDatatable.js')}}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    <script>

        window.onload = () => {
            const Columns = [

                    {
                        field: 's_no',

                        title: 'SL. NO.',

                        formatter : function ( value, row, index ){
                            return ++index;

                        }

                    },
                    {

                        field: 'name',

                        title: 'company',

                    },
                    {

                        field: 'members',

                        title: 'Members',

                        formatter : function ( value, row, index ){
                            var mem = "";
                           for (x of row.members){
                               mem += x.name + "<br>"
                           }
                           return mem;
                        }

                    },
                    {

                        field: 'designation',

                        title: 'Designation',

                        formatter : function ( value, row, index ){
                              var mem = "<div class='pilot_desg'>";
                        for (x of row.members){

                            mem += "<div> <span class='text-orange'>"+x.name+"</span> - "+x.designation + "</div>"
                        }
                        mem += "</div>";
                        return mem;
                      }
                    },
                    {

                        field: 'screening',

                        title: 'Screening',

                        formatter : function ( value, row, index ){
                            var totalScreeningYes = 0;
                            var totalScreeningNo = 0;

                            for (x of row.approved_company){
                                if(x.stage=='screening'){
                                    if(x.approved==1){
                                        totalScreeningYes = +totalScreeningYes + 1
                                    }else{
                                        totalScreeningNo = +totalScreeningNo + 1
                                    }
                                }
                                
                            }

                           return  `<div style="width: 90px;">

                                <span class="mr-2"><i class="fa fa-arrow-up text-success"></i>&nbsp;${totalScreeningYes}</span>

                                <span><i class="fa fa-arrow-down text-danger"></i>&nbsp;${totalScreeningNo}</span>

                            </div>`;
                    }
                },
                {

                    field: 'meeting 1',

                    title: 'Meeting 1',

                    formatter : function ( value, row, index ){
                        var totalMeeting1Yes = 0;
                        var totalMeeting1No = 0;

                        for (x of row.approved_company){
                           
                            if(x.stage=='meeting1'){
                                if(x.approved==1){
                                    totalMeeting1Yes = +totalMeeting1Yes + 1
                                }else{
                                    totalMeeting1No = +totalMeeting1No + 1
                                }
                            }
                        }

                    return  `<div style="width: 90px;">

                            <span class="mr-2"><i class="fa fa-arrow-up text-success"></i>&nbsp;${totalMeeting1Yes}</span>

                            <span><i class="fa fa-arrow-down text-danger"></i>&nbsp;${totalMeeting1No}</span>

                        </div>`;
                    }
                },
                {

                    field: 'meeting 2',

                    title: 'Meeting 2',

                    formatter : function ( value, row, index ){
                        var totalMeeting2Yes = 0;
                        var totalMeeting2No = 0;

                        for (x of row.approved_company){
                        
                            if(x.stage=='meeting1'){
                                if(x.approved==1){
                                    totalMeeting2Yes = +totalMeeting2Yes + 1
                                }else{
                                    totalMeeting2No = +totalMeeting2No + 1
                                }
                            }
                        }

                    return  `<div style="width: 90px;">

                            <span class="mr-2"><i class="fa fa-arrow-up text-success"></i>&nbsp;${totalMeeting2Yes}</span>

                            <span><i class="fa fa-arrow-down text-danger"></i>&nbsp;${totalMeeting2No}</span>

                        </div>`;
                    }
                },
                {
                    field: 'Download',
                    title: 'Doenloads',
                    formatter: function ( value, row, index ){
                        var name = row.name;
                        var members = "";
                        var designation = "";
                        var email = "";

                        for (x of row.members){
                            members+=x.name+", ";
                        }
                        for (x of row.members){
                            designation+=x.designation+", ";
                        }
                        for (x of row.members){
                            email+=x.email+", ";
                        }
                        return `<button style="width:90px;" onclick="printCompanyInfo(this)" data-name='${name}' data-members='${members}' data-designation='${designation}' data-email='${email}' class="btn btn-sm btn-primary py-1 px-2"><small>Company Info</small></button>`;
                    }
                },
                {
                    field: 'Action',
                    title: 'Action',
                    formatter: function ( value, row, index ){
                        return `<a class="btn btn-sm btn-warning text-white" href="{{ env('APP_URL') }}/admin/pilot/${row.id}"><i class="la la-eye"></i></a>`;
                    }
                },
                   

                ];

            

            



            initializeDatatable({

                Url: '{{env('APP_URL')}}/admin/pilots?request=table{{$dateFilter}}{{$aditionalFilter}}',

                Columns: Columns 

            })

        }

        function printCompanyInfo(data){
            var tr = `
                    <tr>
                        <td>${data.dataset.name}</td>
                        <td>${data.dataset.members}</td>
                        <td>${data.dataset.email}</td>
                        <td>${data.dataset.designation}</td>
                    </tr>    
                `;
                $('#dataForPrint').html(tr);
                XLExport("forExport")
        }


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
                tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // remove input params
                sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
                return (sa);
        }

        const removeEval = (d) => {

            commonAjax({

                "page": `admin/startup/${d}?_token={{ csrf_token() }}`,

                "type": 'DELETE'

            }).then(response => {

                let success = response.success || false;

                if(success) {

                    // location.reload();

                    tableRefreshBtn.click();

                    snackbar(response.message ?? '');

                    return;

                }

                snackbar(response.message ?? '');

            }); 

        }



        function changeactive(e, t) {

                const active = t.getAttribute('data-sh') || 0;

                const id = e || 0;

                let tableURL = 'admin/startup/active/'+id+'?active='+active+'&_token={{ csrf_token() }}';

                commonAjax({

                    page: tableURL,

                    type: 'PUT'

                })

                .then(response => {

                    if(response['success'] === true) {

                        if(response.active === 1) {

                            ca_change({ "active": 0, "add": "text-success", "remove": "text-secondary", "title": "Active" });

                            return;

                        }

                        ca_change({"active": 1, "add": "text-secondary", "remove": "text-success", "title": "Inactive"});

                        return;

                    }

                    snackbar(response?.message || 'Something went wrong');

                })

                .catch(err => {

                    console.log(err);

                })

                

                function ca_change(e) {

                    t.setAttribute("data-sh", e.active);

                    t.classList.add(e.add);

                    t.classList.remove(e.remove);

                    t.innerHTML = e.title;

                }

            }

        function changecertified(e, t) {



            const certified = t.getAttribute('data-sh') || 'no';

            const id = e || 0;

            commonAjax({

                page: 'admin/startup/certified/'+id+'?certified='+certified+'&_token={{ csrf_token() }}',

                type: 'PUT'

            })

            .then(response => {

                if(response['success'] === true) {

                    if(response.certified === 'yes') {

                        cc_change({ "certified": "no", "add": "text-success", "remove": "text-secondary", "title": "Yes" });

                        return;

                    }

                    cc_change({"certified": "yes", "add": "text-secondary", "remove": "text-success", "title": "No"});

                    return;

                }

                snackbar(response?.message || "Something went wrong");

            })

            .catch(err => {

                console.log(err);

            })

            

            function cc_change(e) {

                t.setAttribute("data-sh", e.certified);

                t.classList.add(e.add);

                t.classList.remove(e.remove);

                t.innerHTML = e.title;

            }

        }

        function changeApproved(e, t) {

            const Id =  e || 0

            const approved = t.value

            commonAjax({

                page: 'admin/startup/approved/'+Id+'?approved='+approved+'&_token={{ csrf_token() }}',

                type: 'PUT'

            })

            .then(response => {

                snackbar(response?.message || "Something went wrong");

                if(response['success']) {

                    let color = response.approved === 1 ? "text-success" : "text-danger";

                    return;

                }

                tableRefreshBtn.click();

            })

            .catch(err => {

                console.log(err);

            })

        }

    </script>

@endsection