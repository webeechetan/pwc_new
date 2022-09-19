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

                    <h4>All Seasons</h4>

                </div>

            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/admin">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Seasons</a></li>

                </ol>

            </div>

        </div>

        <!-- Content Body -->

        

        </div>

        <div class="container">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AddSeasonModal">
                Add New Season
              </button>
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th>Season</th>
                        <th>Status</th>
                    </tr>
                    @foreach($seasons as $season)
                        <tr>
                            <td>{{ $season->season }}</td>
                            <td>
                                @if ($season->is_active)
                                    <a href="{{ route('season.change_status',[$season->id,0]) }}"><button type="button" class="btn btn-success">Active</button></a>
                                @else
                                    <a href="{{ route('season.change_status',[$season->id,1]) }}"><button type="button" class="btn btn-danger">In-Active</button></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="AddSeasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Season</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method='post' action="{{ route('season.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" name="season" placeholder="Season">
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
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
        @if(session()->has('success'))
        let msg = "{{ session()->get('success') }}"
        snackbar(msg)
        @endif
    </script>

@endsection