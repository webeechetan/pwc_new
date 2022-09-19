@extends('admin.layout.index')

@section('title') Admin @endsection

@section('body')
<!-- Content body start -->
<div class="content-body">
    <!-- Container -->
    <div class="container-fluid">
        <!-- Breadcrumbs -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Role</h4>
                </div>
            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Role</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Role</a></li>
                </ol>
            </div>
        </div>
        <!-- Form -->

        <form class="bg-white p-4" name="role" method="POST" enctype="multipart/form-data">
        @csrf()
            <!-- Event Details -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 text-white p-3 bg-primary"><b>Basic Information</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Role Name *</label>
                        <input type="text" class="form-control" name="name" required />
                    </div>
                    <small class="text-danger" data-error-role="name"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Alias Name *</label>
                        <input type="text" class="form-control" name="slug" required />
                    </div>
                    <small class="text-danger" data-error-role="slug"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <h2>Modules</h2>
                </div>
            </div>
            <div class="row">
                @foreach($roles as $r)
                    <div class="col-md-12 mb-2">
                        <h5>{{$r->name}}</h5>
                    </div>
                    @foreach($r->allactions as $aa)
                        <div class="col-md-2 mb-2">
                            <label>
                                <input type="checkbox" value="{{$aa->id}}" name="action[{{$r->id}}][]"> &nbsp;{{$aa->name}}
                            </label>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Content body end -->
@endsection
@section('script')
<script>
    const submitForm = event => {
        event.preventDefault();
        const fd = new FormData(event.target);
        commonAjax({
            page: 'admin/role/add',
            params: fd
        }).then(response => {
            snackbar(response?.message || "Something went wrong");
            if(response?.success)window.location.href="./";
            let errors = response.errors || {};
            console.log(errors)
            for(let [key, name] of Object.entries(errors)) {
                try {
                    document.querySelector(`small[data-error-role='${key}']`).innerHTML = name.toString();
                }catch(err){console.log(err)}
            }
        })
        .catch(err => snackbar("Something went wrong"))
    }
    document.forms.role.addEventListener("submit", submitForm)
</script>
@endsection