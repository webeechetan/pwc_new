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
                    <h4>Home Page</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Home Page</a></li>
                    <!-- <li class="breadcrumb-item active"><a href="javascript:void(0);"></a></li> -->
                </ol>
            </div>
        </div>
        <!-- Content Body -->
        <div class="">
            <!-- 
            |Banner
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">BANNER</h4>
                </div>
            </div>
            <form name="banner">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <input type="text" name="banner_title" class="form-control" value="{{$homepage->banner_title}}">
                            <small class="text-danger" data-error-home="banner_title"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Caption 1</label>
                            <input type="text" name="banner_caption1" class="form-control" value="{{$homepage->banner_caption1}}">
                            <small class="text-danger" data-error-home="banner_caption1"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Caption 2</label>
                            <input type="text" name="banner_caption2" class="form-control"  value="{{$homepage->banner_caption2}}">
                            <small class="text-danger" data-error-home="banner_caption2"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Subtitle</label>
                            <input type="text" name="banner_subtitle" class="form-control" value="{{$homepage->banner_subtitle}}">
                            <small class="text-danger" data-error-home="banner_subtitle"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Button</label>
                            <input type="text" name="banner_button" class="form-control" value="{{$homepage->banner_button}}">
                            <small class="text-danger" data-error-home="banner_button"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Action</label>
                            <input type="text" name="banner_button_action" class="form-control"  value="{{$homepage->banner_button_action}}">
                            <small class="text-danger" data-error-header="banner_button_action"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-primary" name="header_btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js" defer="true"></script>
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/src/lang/en.js" defer="true"></script>
<script src="{{ asset('/assets/admin/js/textEditor.js') }}"></script>
    <script>
    window.onload = () => {
        let editor1, editor2;
        editor1 = initializeEditor('s2Description');
        editor1.onChange = function (contents, isChanged) {
            s2Description.value = contents;
        }

        editor2 = initializeEditor('s3Description');
        editor2.onChange = function (contents, isChanged) {
            s3Description.value = contents;
        }
    }
    /*
    |Image Upload
    ------------- */
    const imageVariable = ["banner_image", "s2_image"]
    imageVariable.map(v => {
        document.querySelector(`input[name="${v}"]`).addEventListener("change", event => {
            fileUpload(event.target.files[0]).then(response => {
                if(response)document.querySelector(`div[data-append="${v}"]`).innerHTML = `<img src="${response}" class="img-fluid">`;
            })
        })
    })

    /* 
    |Forms
    -------- */
    const updateList = event => {
        event.preventDefault();
        event.target[`${event.target.name}_btn`].innerHTML = `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...`;
        var formData = new FormData(event.target);
        
        const errorHandle = document.querySelectorAll(`small[data-error-about]`)
        for(let eH of errorHandle) eH.innerHTML = ""

        commonAjax({
            "params": formData,
            "page": 'admin/homepage/edit/1',
            "type": "POST"
        }).then(response => {
            event.target[`${event.target.name}_btn`].innerHTML = "Update";
            let success = response.success || false;
            if(success) {
                snackbar(response.message ?? '');
                // getAbout()
                return;
            }
            let errors = response.errors || {};
            for(let [key, name] of Object.entries(errors)) {
                try{
                    document.querySelector(`small[data-error-home='${key}']`).innerHTML = name;
                }catch(err) {console.log(err);}
            }
        })
        .catch(err => event.target[`${event.target.name}_btn`].innerHTML = "Update");
    }
    const formVariable = ["banner", "s1", "s2", "s3", "event", "case_study"];
    formVariable.map(e => {
        document.forms[e].addEventListener("submit", updateList);
    })
    </script>
@endsection