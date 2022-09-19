@extends('admin.layout.index')

@section('title') Admin @endsection

@section('body')
<div class="content-body">
    <!-- Container -->
    <div class="container-fluid">
        <!-- Breadcrumbs -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>All Role</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Role</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">All Role</a></li>
                </ol>
            </div>
        </div>
        <!-- Content Body -->
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
                        field: 'name',
                        title: 'Name',
                        sortable: true
                    },
                    {
                        field: 'slug',
                        title: 'Alias',
                        sortable: true
                    },
                    {
                        field: 'Action',
                        title: 'Action',
                        align: 'center',
                        clickToSelect: false,
                        formatter : function ( value, row, index ){
                            return `<div><a class="btn btn-sm btn-edit" href="{{env('APP_URL')}}/admin/role/edit/${row.id}"><i class="la la-pencil"></i></a>
                            <a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="removeRole(${row.id})"><i class="la la-trash-o"></i></a></div>`
                        }
                    }
                ];
            initializeDatatable({
                Url: '{{env('APP_URL')}}/admin/role?request=table',
                Columns: Columns 
            })
        }
        const removeRole = (d) => {
        commonAjax({
            "page": `admin/role/${d}?_token={{ csrf_token() }}`,
            "type": 'DELETE'
        }).then(response => {
            let success = response.success || false;
            if(success) {
                // location.reload();
                snackbar(response.message ?? '');
                tableRefreshBtn.click();
                return;
            }
            snackbar(response.message ?? '');
        }); 
    }
    </script>
@endsection