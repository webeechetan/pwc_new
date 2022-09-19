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
                        <label class="form-label">Banner Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="banner_image" accept=".png, .jpg, .jpeg, .jfif">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <small class="text-secondary font-weight-light d-block">(Banner image size should be 1920px*875px)</small>
                        <div data-append="banner_image">
                            <img src="{{ asset('storage/uploads/homepage/banner.jpg') }}" class="img-fluid">
                        </div>
                        <small class="text-danger d-block" data-error-home="banner_image"></small>
                    </div>
                </div>
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
                            <small class="text-danger" data-error-home="banner_button_action"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" value="banner" name="section">
                        <input type="hidden" value="{{ $homepage->id }}" name="id">
                        <button type="submit" class="btn btn-sm btn-primary" name="banner_btn">Update</button>
                    </div>
                </div>
            </form>

            <!-- 
            |Section 1
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Section 1</h4>
                </div>
            </div>
            <form name="s1">
                @csrf()
                <div class="row mb-2">
                    <!-- First -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Count 1</label>
                            <input type="text" name="s1_count1" class="form-control" value="{{$homepage->s1_count1}}">
                            <small class="text-danger" data-error-home="s1_count1"></small>
                        </div>
                        <div class="form-group">
                            <label class="m-0">Heading 1</label>
                            <input type="text" name="s1_heading1" class="form-control" value="{{$homepage->s1_heading1}}">
                            <small class="text-danger" data-error-home="s1_heading1"></small>
                        </div>
                    </div>
                    <!-- Second -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Count 2</label>
                            <input type="text" name="s1_count2" class="form-control" value="{{$homepage->s1_count2}}">
                            <small class="text-danger" data-error-home="s1_count2"></small>
                        </div>
                        <div class="form-group">
                            <label class="m-0">Heading 2</label>
                            <input type="text" name="s1_heading2" class="form-control" value="{{$homepage->s1_heading2}}">
                            <small class="text-danger" data-error-home="s1_heading2"></small>
                        </div>
                    </div>
                    <!-- Third -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Count 3</label>
                            <input type="text" name="s1_count3" class="form-control" value="{{$homepage->s1_count3}}">
                            <small class="text-danger" data-error-home="s1_count3"></small>
                        </div>
                        <div class="form-group">
                            <label class="m-0">Heading 3</label>
                            <input type="text" name="s1_heading3" class="form-control" value="{{$homepage->s1_heading3}}">
                            <small class="text-danger" data-error-home="s1_heading3"></small>
                        </div>
                    </div>
                    <!-- Fourth -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Count 4</label>
                            <input type="text" name="s1_count4" class="form-control" value="{{$homepage->s1_count4}}">
                            <small class="text-danger" data-error-home="s1_count4"></small>
                        </div>
                        <div class="form-group">
                            <label class="m-0">Heading 4</label>
                            <input type="text" name="s1_heading4" class="form-control" value="{{$homepage->s1_heading4}}">
                            <small class="text-danger" data-error-home="s1_heading4"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" value="s1" name="section">
                        <input type="hidden" value="{{ $homepage->id }}" name="id">
                        <button type="submit" class="btn btn-sm btn-primary" name="s1_btn">Update</button>
                    </div>
                </div>
            </form>


            <!-- 
            |Section 2
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Section 2</h4>
                </div>
            </div>
            <form name="s2">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Heading</label>
                            <input type="text" name="s2_heading" class="form-control" value="{{$homepage->s2_heading}}">
                            <small class="text-danger" data-error-home="s2_heading"></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <input type="text" name="s2_title" class="form-control" value="{{$homepage->s2_title}}">
                            <small class="text-danger" data-error-home="s2_title"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="m-0">Description</label>
                            <textarea rows="10" name="s2_description" id="s2Description" class="form-control">{{$homepage->s2_description}}</textarea>
                            <small class="text-danger" data-error-home="s2_description"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="form-label">Right Side Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="s2_image" accept=".png, .jpg, .jpeg, .jfif">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <small class="text-secondary font-weight-light d-block">(Banner image size should be 737px*737px)</small>
                        <div data-append="s2_image">
                            <img src="{{ asset('storage/uploads/homepage/s2_image.jpg') }}" class="img-fluid">
                        </div>
                        <small class="text-danger d-block" data-error-home="s2_image"></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" value="s2" name="section">
                        <input type="hidden" value="{{ $homepage->id }}" name="id">
                        <button type="submit" class="btn btn-sm btn-primary" name="s2_btn">Update</button>
                    </div>
                </div>
            </form>
            
            <!-- 
            |Upcoming Events
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Upcoming Events</h4>
                </div>
            </div>
            <form name="event">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <input type="text" name="event_title" class="form-control" value="{{$homepage->event_title}}">
                            <small class="text-danger" data-error-home="event_title"></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Sub Title</label>
                            <input type="text" name="event_subtitle" class="form-control" value="{{$homepage->event_subtitle}}">
                            <small class="text-danger" data-error-home="event_subtitle"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" value="event" name="section">
                        <input type="hidden" value="{{ $homepage->id }}" name="id">
                        <button type="submit" class="btn btn-sm btn-primary" name="event_btn">Update</button>
                    </div>
                </div>
            </form>
            
            <!-- 
            |Case Study
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Case Study</h4>
                </div>
            </div>
            <form name="case_study">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <input type="text" name="case_study_title" class="form-control" value="{{$homepage->case_study_title}}">
                            <small class="text-danger" data-error-home="case_study_title"></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Sub Title</label>
                            <input type="text" name="case_study_subtitle" class="form-control" value="{{$homepage->case_study_subtitle}}">
                            <small class="text-danger" data-error-home="case_study_subtitle"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" value="case_study" name="section">
                        <input type="hidden" value="{{ $homepage->id }}" name="id">
                        <button type="submit" class="btn btn-sm btn-primary" name="case_study_btn">Update</button>
                    </div>
                </div>
            </form>
            
            
            <!-- 
            |Knowledge Sharing
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Knowledge Sharing</h4>
                </div>
            </div>
            <form name="knowledge_sharing">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <input type="text" name="knowledge_title" class="form-control" value="{{$homepage->knowledge_title}}">
                            <small class="text-danger" data-error-home="knowledge_title"></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Sub Title</label>
                            <input type="text" name="knowledge_subtitle" class="form-control" value="{{$homepage->knowledge_subtitle}}">
                            <small class="text-danger" data-error-home="knowledge_subtitle"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" value="knowledge_sharing" name="section">
                        <input type="hidden" value="{{ $homepage->id }}" name="id">
                        <button type="submit" class="btn btn-sm btn-primary" name="knowledge_sharing_btn">Update</button>
                    </div>
                </div>
            </form>
            

            <!-- 
            |Section 3
            ----------- -->
            <div class="row mb-3">
                <div class="col">
                    <h4 class="mt-4 text-white p-3 bg-primary">Contact us</h4>
                </div>
            </div>
            <form name="s3">
                @csrf()
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Heading</label>
                            <input type="text" name="s3_heading" class="form-control" value="{{$homepage->s3_heading}}">
                            <small class="text-danger" data-error-home="s3_heading"></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Title</label>
                            <input type="text" name="s3_title" class="form-control" value="{{$homepage->s3_title}}">
                            <small class="text-danger" data-error-home="s3_title"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="m-0">Description</label>
                            <textarea rows="10" name="s3_description" id="s3Description" class="form-control">{{$homepage->s3_description}}</textarea>
                            <small class="text-danger" data-error-home="s3_description"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Support</label>
                            <input type="text" name="s3_email" class="form-control" value="{{$homepage->s3_email}}">
                            <small class="text-danger" data-error-home="s3_email"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Contact Heading</label>
                            <input type="text" name="s3_contact_heading" class="form-control" value="{{$homepage->s3_contact_heading}}">
                            <small class="text-danger" data-error-home="s3_contact_heading"></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="m-0">Contact Sub Heading</label>
                            <input type="text" name="s3_contact_subheading" class="form-control" value="{{$homepage->s3_contact_subheading}}">
                            <small class="text-danger" data-error-home="s3_contact_subheading"></small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="hidden" value="s3" name="section">
                        <input type="hidden" value="{{ $homepage->id }}" name="id">
                        <button type="submit" class="btn btn-sm btn-primary" name="s3_btn">Update</button>
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
    const formVariable = ["banner", "s1", "s2", "s3", "event", "case_study","knowledge_sharing"];
    formVariable.map(e => {
        document.forms[e].addEventListener("submit", updateList);
    })
    </script>
@endsection