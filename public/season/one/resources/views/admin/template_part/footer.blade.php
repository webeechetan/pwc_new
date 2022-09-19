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
                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Footer</a></li>
                </ol>
            </div>
        </div>
        <!-- Content Body -->
        <div class="">
            <!-- 
            |Footer Overview
            ---------------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Footer Overview</h4>
                </div>
            </div>
            <form name="overview">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="m-0">Footer Description</label>
                            <textarea  name="description" id="description" rows="10" class="form-control">{{$footer->description}}</textarea>
                            <small class="text-danger" data-error-footer="description"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" name="section" value="overview">
                        <button type="submit" class="btn btn-sm btn-primary" name="overview_btn">Update</button>
                    </div>
                </div>
            </form>
            
            <!-- 
            |Footer Quick Links
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Footer Quick Links</h4>
                </div>
            </div>
            <form name="quick">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <input type="text" name="quick_link_title" class="form-control" value="{{$footer->quick_link_title}}">
                            <small class="text-danger" data-error-footer="quick_link_title"></small>
                        </div>
                    </div>
                </div>
                <div data-append="quick_links">
                    @foreach($quick_links as $ql)
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="m-0">Menu</label>
                                    <input type="text" name="menu[]" class="form-control" value="{{$ql -> content1}}">
                                    <small class="text-danger" data-error-footer="menu"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="m-0">Url</label>
                                    <input type="text" name="url[]" class="form-control" value="{{$ql -> content2}}">
                                    <input type="hidden" name="id[]" class="form-control" value="{{$ql -> id}}">
                                    <small class="text-danger" data-error-footer="link"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <i class="fa fa-trash btn btn-outline-danger" onclick="this.parentElement.parentElement.remove()"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-sm btn-outline-warning" data-button="quick_links">Add Quick Link <i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" name="section" value="quick">
                        <button type="submit" class="btn btn-sm btn-primary" name="quick_btn">Update</button>
                    </div>
                </div>
            </form>
            
            <!-- 
            |Footer Copyright
            ---------------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Footer Copyright</h4>
                </div>
            </div>
            <form name="copyright">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <textarea name="copyright_title" id="copyright" class="form-control" rows="10">{{$footer->copyright_title}}</textarea>
                            <small class="text-danger" data-error-footer="copyright_title"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Facebook Url</label>
                            <input type="text" name="fb" class="form-control" value="{{$footer->fb}}">
                            <small class="text-danger" data-error-footer="fb"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Twitter Url</label>
                            <input type="text" name="twitter" class="form-control" value="{{$footer->twitter}}">
                            <small class="text-danger" data-error-footer="twitter"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">LinkedIn Url</label>
                            <input type="text" name="linkedin" class="form-control" value="{{$footer->linkedin}}">
                            <small class="text-danger" data-error-footer="linkedin"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Youtube Url</label>
                            <input type="text" name="youtube" class="form-control" value="{{$footer->youtube}}">
                            <small class="text-danger" data-error-footer="youtube"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" name="section" value="copyright">
                        <button type="submit" class="btn btn-sm btn-primary" name="copyright_btn">Update</button>
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
        editor1 = initializeEditor('description');
        editor1.onChange = function (contents, isChanged) {
            description.value = contents;
        }
        
        editor2 = initializeEditor('copyright');
        editor2.onChange = function (contents, isChanged) {
            document.getElementById('copyright').value = contents;
        }
    }
    
    document.querySelector(`button[data-button="quick_links"]`).addEventListener("click", () => {
        let element = '';
        element = `<div class="row mb-2 align-items-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Menu</label>
                            <input type="text" name="menu[]" class="form-control">
                            <small class="text-danger" data-error-footer="menu"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="m-0">Url</label>
                            <input type="text" name="url[]" class="form-control">
                            <input type="hidden" name="id[]" value="0" class="form-control">
                            <small class="text-danger" data-error-footer="link"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <i class="fa fa-trash btn btn-outline-danger" onclick="this.parentElement.parentElement.remove()"></i>
                    </div>
                </div>`
        $(`div[data-append="quick_links"]`).append(element);
    });
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
            "page": 'admin/footer/edit/1',
            "type": "POST"
        }).then(response => {
            event.target[`${event.target.name}_btn`].innerHTML = "Update";
            let success = response.success || false;
            if(success) {
                snackbar(response.message ?? '');
                // getAbout()
                try{
                if(response.section === 'quick') {
                    const quickLink_arr = response?.quick_links || [];
                    let element = '';
                    for(let ql of quickLink_arr)
                    {
                        element += `<div class="row mb-2 align-items-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="m-0">Menu</label>
                                        <input type="text" name="menu[]" class="form-control" value="${ql.content1}">
                                        <small class="text-danger" data-error-footer="menu"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="m-0">Url</label>
                                        <input type="text" name="url[]" class="form-control" value="${ql.content2}">
                                        <input type="hidden" name="id[]" class="form-control" value="${ql.id}">
                                        <small class="text-danger" data-error-footer="link"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <i class="fa fa-trash btn btn-outline-danger" onclick="this.parentElement.parentElement.remove()"></i>
                                </div>
                            </div>`
                    }
                    $(`div[data-append="quick_links"]`).html(element);
                }
            } catch(err) {
                console.log(err)
            }
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
    const formVariable = ["overview", "quick", "copyright"];
    formVariable.map(e => {
        document.forms[e].addEventListener("submit", updateList);
    })
    </script>
@endsection