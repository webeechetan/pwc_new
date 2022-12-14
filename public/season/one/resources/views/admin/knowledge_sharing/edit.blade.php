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
                    <h4>Knowledge Sharing</h4>
                </div>
            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Knowledge Sharing</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Knowledge Sharing</a></li>
                </ol>
            </div>
        </div>
        <!-- Form -->

        <form class="bg-white p-4" name="case" enctype="multipart/form-data" method="post" action="{{ route('knowledge_sharing.update') }}">
        @csrf()
            <!-- Image Section -->
            <div class="row">
                <div class="col-12">
                    <h4 class="text-white p-3 bg-primary"><b>Knowledge Sharing Images</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Overview Image*</label>
                        <div class="custom-file">
                            <input type="file" class="form-control" name="overview_image" />
                        </div>
                        <div class="shadow-sm text-center p-3" data-append="overview_image">
                            <img src="{{ asset('uploads/knowledge_sharing') }}/{{ $KnowledgeSharing->overview_image }}">
                        </div>
                        <small class="text-danger d-block" data-error-case="overview_image"></small>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Banner Image*</label>
                        <div class="custom-file">
                            <input type="file" class="form-control" name="banner_image" />
                        </div>
                        <div class="shadow-sm text-center p-3" data-append="banner_image">
                            <img src="{{ asset('uploads/knowledge_sharing') }}/{{ $KnowledgeSharing->banner_image }}">
                        </div>
                        <small class="text-danger d-block" data-error-case="banner_image"></small>
                    </div>
                </div>
            </div>
            <!-- Event Details -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 text-white p-3 bg-primary"><b>Knwoledge Sharing Basic Information</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Title*</label>
                        <input type="text" class="form-control" name="title" required value="{{ $KnowledgeSharing->title }}" />
                    </div>
                    <small class="text-danger" data-error-case="title"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label class="form-label">Overview*</label>
                        <textarea class="form-control" name="overview" id="overview" required rows="12">{{ $KnowledgeSharing->overview }}</textarea>
                    </div>
                    <small class="text-danger" data-error-case="overview"></small>
                </div>
            </div>
            <!-- Event Description -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 text-white p-3 bg-primary"><b>Knwoledge Sharing Description</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label class="form-label">Description*</label>
                        <textarea class="form-control" name="description" id="description" required rows="12">{{ $KnowledgeSharing->description }}</textarea>
                    </div>
                    <small class="text-danger" data-error-case="description"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label class="form-label">Files*</label>
                        <input type="file" name="ppts[]" class="form-control"  multiple />
                    </div>
                    @php
                        $files = explode(',',$KnowledgeSharing->files)
                    @endphp
                    @foreach($files as $file)
                        <a href="{{ asset('uploads/knowledge_sharing') }}/{{ $file }}">{{$file}}</a> <a href="{{ route('knowledge_sharing.delete_image',[$KnowledgeSharing->id,$file]) }}" title='Delete Image'><i class="la la-trash-o"></i></a>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="id" value="{{ $KnowledgeSharing->id }}">
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
<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js" defer="true"></script>
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/src/lang/en.js" defer="true"></script>
<script src="{{ asset('/assets/admin/js/textEditor.js') }}"></script>
<script>
    const renderImage = event => {
        if(event.target.files.length > 0)
        {
            fileUpload(event.target.files[0]).then(response => {
                document.querySelector(`div[data-append='${event.target.name}']`).innerHTML
                = `<img src="${response}" class="img-fluid" style="max-height: 300px">`;
            })
        }
    }
    document.forms.case.overview_image.addEventListener("change", renderImage)
    document.forms.case.banner_image.addEventListener("change", renderImage)

    let editor1, editor2;
    window.onload = () => {
        // editor1 = initializeEditor('overview');
        // editor1.onChange = function (contents, isChanged) {
        //     document.forms.case.overview.value = contents;
        // }

        editor2 = initializeEditor('description');
        editor2.onChange = function (contents, isChanged) {
            document.forms.case.description.value = contents;
        }
    }

   
</script>
@endsection