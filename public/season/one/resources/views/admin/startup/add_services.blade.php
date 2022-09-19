@extends('admin.layout.index')

@section('title') Startup Services @endsection

@section('body')

@php
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
                    <h4>All Startup</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/admin">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Startup</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Add/Edit Services</a></li>
                </ol>
            </div>
        </div>
        <!-- Content Body -->
        <div class="row mb-4">
            <div class="col-sm-12">
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-md-4">
                <input class="form-control" type="search" placeholder="search" id="tableSearch" autcomplete="off">
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
                        field: 'Image',
                        title: 'Image',
                        formatter : function ( value, row, index ){
                            return `<img src="{{ asset('storage/uploads/startup/Startup${row.id}.jpg') }}"class="img-fluid" style="width:25px;">`;
                        }
                    }, 
                    {
                        field: 'company_name',
                        title: 'COMPANY NAME',
                        sortable: true
                    },
                    {
                        field: 'company_type',
                        title: 'COMPANY TYPE',
                    },
                    {
                        field: 'Full Name',
                        title: 'Full Name',
                        align: 'center',
                        sortable: true,
                        formatter: (value, row, index) => {
                            return row.startup_login.fullname;
                        }
                    },
                    {
                        field: 'Screening Votes',
                        title: 'Screening Votes',
                        align: 'center',
                        sortable: true,
                        formatter: (value, row, index) => {
                            if(row.screening.length > 0)
                            {
                                let up = 0;
                                let down = 0;
                                for(let value of row.screening)
                                {
                                    if(value.approved === 1) up++
                                    else if(value.approved === 2) down++
                                }
                                return `<div>
                                            <span class="mr-2"><i class="fa fa-arrow-up text-success"></i>&nbsp;${up}</span>
                                            <span><i class="fa fa-arrow-down text-danger"></i>&nbsp;${down}</span>
                                        </div>`;
                            }
                            return '<small>Pending</small>';
                        }
                    },
                    {
                        field: 'Meeting 1 Votes',
                        title: 'Meeting 1 Votes',
                        align: 'center',
                        sortable: true,
                        formatter: (value, row, index) => {
                            if(row.meeting1.length > 0)
                            {
                                let up = 0;
                                let down = 0;
                                for(let value of row.meeting1)
                                {
                                    if(value.approved === 1) up++
                                    else if(value.approved === 2) down++
                                }
                                return `<div>
                                            <span class="mr-2"><i class="fa fa-arrow-up text-success"></i>&nbsp;${up}</span>
                                            <span><i class="fa fa-arrow-down text-danger"></i>&nbsp;${down}</span>
                                        </div>`;
                            }
                            return '<small>Pending</small>';
                        }
                    },
                    {
                        field: 'Meeting 2 Votes',
                        title: 'Meeting 2 Votes',
                        align: 'center',
                        sortable: true,
                        formatter: (value, row, index) => {
                            if(row.meeting2.length > 0)
                            {
                                let up = 0;
                                let down = 0;
                                for(let value of row.meeting2)
                                {
                                    if(value.approved === 1) up++
                                    else if(value.approved === 2) down++
                                }
                                return `<div>
                                            <span class="mr-2"><i class="fa fa-arrow-up text-success"></i>&nbsp;${up}</span>
                                            <span><i class="fa fa-arrow-down text-danger"></i>&nbsp;${down}</span>
                                        </div>`;
                            }
                            return '<small>Pending</small>';
                        }
                    },
                    {
                        field: 'Final Call Votes',
                        title: 'Final Call Votes',
                        align: 'center',
                        sortable: true,
                        formatter: (value, row, index) => {
                            if(row.finalcall.length > 0)
                            {
                                let up = 0;
                                let down = 0;
                                for(let value of row.finalcall)
                                {
                                    if(value.approved === 1) up++
                                    else if(value.approved === 2) down++
                                }
                                return `<div>
                                            <span class="mr-2"><i class="fa fa-arrow-up text-success"></i>&nbsp;${up}</span>
                                            <span><i class="fa fa-arrow-down text-danger"></i>&nbsp;${down}</span>
                                        </div>`;
                            }
                            return '<small>Pending</small>';
                        }
                    },
                    {
                        field: 'Application Request',
                        title: 'Application Request',
                        align: 'center',
                        sortable: true,
                        formatter: (value, row, index) => {
                            return  `<input type="radio" value="1" name="request${row.id}" onclick="changeApproved(${row.id}, this)" ${row.request === 1 ? "checked" : ''}> Acccept &nbsp; &nbsp; 
                                    <input type="radio" value="2" name="request${row.id}" onclick="changeApproved(${row.id}, this)" ${row.request === 2 ? "checked" : ''}> Reject`;
                            
                        }
                    },
                    {
                        field: 'Active',
                        title: 'Active',
                        align: 'center',
                        clickToSelect: false,
                        formatter: (value, row, index) => {
                            return row.is_active === 0 ? `<a href="javascript:void(0)" class="text-secondary" onclick="changeactive(${row.id}, this)" data-sh='1'>Inactive</a>` : `<a href="javascript:void(0)" class="text-success" onclick="changeactive(${row.id}, this)" data-sh='0'>Active</a>`;
                        }
                    },
                    {
                        field: 'Action',
                        title: 'Action',
                        align: 'center',
                        clickToSelect: false,
                        formatter : function ( value, row, index ){
                            return `<div style="width: 150px"><a class="btn btn-sm btn-warning text-white" href="{{ env('APP_URL') }}/admin/startup/view/${row.id}"><i class="la la-eye"></i></a>
                            <a class="btn btn-sm btn-edit" href="{{ env('APP_URL') }}/admin/startup/edit/${row.id}"><i class="la la-pencil"></i></a>
                            <a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="removeEval(${row.id})"><i class="la la-trash-o"></i></a></div>`
                        }
                    }
                ];
            
            

            initializeDatatable({
                Url: '{{env('APP_URL')}}/admin/startup?request=table{{$dateFilter}}{{$aditionalFilter}}',
                Columns: Columns 
            })
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