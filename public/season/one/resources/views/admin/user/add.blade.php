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
                    <h4>User</h4>
                </div>
            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">User</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Add User</a></li>
                </ol>
            </div>
        </div>
        <!-- Form -->

        <form class="bg-white p-4" name="user" method="POST" enctype="multipart/form-data">
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
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="fullname" required />
                    </div>
                    <small class="text-danger" data-error-user="fullname"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Role *</label>
                        <select class="form-control" name="role" required>
                            <option value="" disabled selected>Select Role</option>
                            @if($roles && count($roles) > 0)
                                @foreach($roles as $r)
                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <small class="text-danger" data-error-user="role"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" required />
                    </div>
                    <small class="text-danger" data-error-user="email"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control" name="password" required />
                    </div>
                    <small class="text-danger" data-error-user="password"></small>
                </div>
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
            page: 'admin/user/add',
            params: fd
        }).then(response => {
            snackbar(response?.message || "Something went wrong");
            if(response?.success)window.location.href="./";
            let errors = response.errors || {};
            console.log(errors)
            for(let [key, name] of Object.entries(errors)) {
                try {
                    document.querySelector(`small[data-error-user='${key}']`).innerHTML = name.toString();
                }catch(err){console.log(err)}
            }
        })
        .catch(err => snackbar("Something went wrong"))
    }
    document.forms.user.addEventListener("submit", submitForm)
</script>
@endsection