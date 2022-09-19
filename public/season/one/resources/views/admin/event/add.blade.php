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
                    <h4>Event</h4>
                </div>
            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Event</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Event</a></li>
                </ol>
            </div>
        </div>
        <!-- Form -->

        <form class="bg-white p-4" name="event" method="POST" action="/admin/event/add" enctype="multipart/form-data">
        @csrf()
            <!-- Image Section -->
            <div class="row">
                <div class="col-12">
                    <h4 class="text-white p-3 bg-primary"><b>Event Images</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="event_image" />
                            <label class="custom-file-label">Choose file</label>
                            <small class="d-block badge text-secondary text-left">Event image size should be 370px*238px</small>
                        </div>
                        <div class="shadow-sm text-center p-3" data-append="event_image"></div>
                        <small class="text-danger d-block" data-error-event="event_image"></small>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Banner Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="event_banner_image" />
                            <label class="custom-file-label">Choose file</label>
                            <small class="d-block badge text-secondary text-left">Event Banner image size should be 1920px*300px</small>
                        </div>
                        <div class="shadow-sm text-center p-3" data-append="event_banner_image"></div>
                        <small class="text-danger d-block" data-error-event="event_banner_image"></small>
                    </div>
                </div>
            </div>
            <!-- Event Details -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 text-white p-3 bg-primary"><b>Event Basic Information</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Title*</label>
                        <input type="text" class="form-control" name="title" required />
                    </div>
                    <small class="text-danger" data-error-event="title"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Email (comma separated)</label>
                        <input type="text" class="form-control" name="extra_email" placeholder="example1@gmail.com,example2@gmail.com,"/>
                    </div>
                    <small class="text-danger" data-error-event="title"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Category*</label>
                        <select class="form-control" name="category" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                    </div>
                    <small class="text-danger" data-error-event="category"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Type*</label>
                        <select class="form-control" name="type" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="paid">Paid</option>
                            <option value="free">Free</option>
                        </select>
                    </div>
                    <small class="text-danger" data-error-event="type"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Price</label>
                        <input type="text" class="form-control" name="price" required value="0" />
                    </div>
                    <small class="text-danger" data-error-event="price"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event For *</label>
                        <select class="form-control" name="event_for" required data-event="event-for">
                            <option value="" disabled selected>Select Event For</option>
                            <option value="startup">For Startups</option>
                            <option value="pilot">For Pilot Companies</option>
                            <option value="both">For Startups and Pilot Companies</option>
                            <option value="public">For All</option>
                        </select>
                    </div>
                    <small class="text-danger" data-error-event="event_for"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" data-div="startup-companies" style="display: none">
                    <label class="form-label">
                        Startup List
                        <small>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-select="startup-companies" data-action="select">Select all</a>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-clear="startup-companies" data-action="clear">Clear</a>
                        </small>
                    </label>
                    <select class="form-control selectpicker" multiple data-live-search="true" name="startup_id[]" data-search="startup-companies">
                        @if($data_startup)
                            @foreach($data_startup as $d)
                                <option value="{{$d->startup_id}}">{{$d->startup_login->email.' ('.$d->company_name.')'}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6" data-div="pilot-companies" style="display: none">
                    <label class="form-label">
                        Pilot Companies List
                        <small>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-select="pilot-companies" data-action="select">Select all</a>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-clear="pilot-companies" data-action="clear">Clear</a>
                        </small>
                    </label>
                    <select class="form-control selectpicker" multiple data-live-search="true" name="pilot_companies_id[]" data-search="pilot-companies">
                        @if($data_pilot)
                            @foreach($data_pilot as $d)
                                <option value="{{$d->id}}">{{$d->email.' ('.$d->name.')'}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <!-- Event Date and Time -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 text-white p-3 bg-primary"><b>Event Date and Time</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event From*</label>
                        <input type="date" class="form-control" name="event_from" required />
                    </div>
                    <small class="text-danger" data-error-event="event_from"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event To</label>
                        <input type="date" class="form-control" name="event_to" />
                    </div>
                    <small class="text-danger" data-error-event="event_to"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Duration Start*</label>
                        <input type="time" class="form-control" name="event_start" required />
                    </div>
                    <small class="text-danger" data-error-event="event_start"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Duration End*</label>
                        <input type="time" class="form-control" name="event_end" required />
                    </div>
                    <small class="text-danger" data-error-event="event_end"></small>
                </div>
            </div>
            <!-- Event Description -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 text-white p-3 bg-primary"><b>Event Description</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label class="form-label">Short Description*</label>
                        <textarea class="form-control" name="short_description"  required rows="12"></textarea>
                    </div>
                    <small class="text-danger" data-error-event="short_description"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label class="form-label">Description*</label>
                        <textarea class="form-control" name="description" id="event_description" required rows="12"></textarea>
                    </div>
                    <small class="text-danger" data-error-event="description"></small>
                </div>
            </div>
            <!--|Collateral|-->
            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 text-white p-3 bg-primary"><b>Collaterals</b></h4>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="custom-file">
                        <input type="file" class="form-control" data-sh="collateral" multiple>
                    </div>
                    <div data-sh="collateral-data"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-4" name="submit">Submit</button>
                </div>
            </div>
            <input type="hidden" name="mailstatus" value="false">
            <input type="hidden" name="maildescription" value="">
        </form>
    </div>
</div>
<!-- Content body end -->

<!-- |Email Send Confirmation| -->
<div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <!-- <p>Would you like to send update emails to existing Google Calendar guests?</p> -->
        <p>Would you like to send invitation emails to guests?</p>
        <textarea class="form-control" cols="4" data-description="maildescription" placeholder="Add an optional message for guests"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-outline-dark _eventupdate" data-send-status="cancel" data-bs-dismiss="modal">Back to editing</button>
        <button type="button" class="btn btn-sm btn-outline-dark _eventupdate" data-send-status="no">Don't Send</button>
        <button type="button" class="btn btn-sm btn-primary _eventupdate" data-send-status="yes">Send</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js" defer="true"></script>
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/src/lang/en.js" defer="true"></script>
<script src="{{ asset('/assets/admin/js/textEditor.js') }}"></script>
<!--selectpicker-->
<script src="{{ asset('assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
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
    document.forms.event.event_image.addEventListener("change", renderImage)
    document.forms.event.event_banner_image.addEventListener("change", renderImage)

    let editor;
    window.onload = () => {
        editor = initializeEditor('event_description');
        editor.onChange = function (contents, isChanged) {
            document.forms.event.description.value = contents;
        }
    }
    
    /*
    |Multiple Image Upload
    ---------------------- */
    const multipleImage = (e, f) => {
        const files = e.files;
        let b, element, input, temp;
        for(let i = 0; i < files.length; i++) {
                b = new ClipboardEvent("").clipboardData || new DataTransfer();
                b.items.add(files[i]);
                element = document.createElement('div');
                element.classList.add("d-flex")
                element.setAttribute("data-sh-collateral", `${files[i].name}`);
                    input = document.createElement('input');
                    input.setAttribute("name", f+'[]');
                    input.setAttribute("type", "file");
                    input.files = b.files;
                    input.classList.add("d-none");
                element.innerHTML = `<div>${files[i].name}</div>
                                    <div onclick="this.parentElement.remove();"><i class="fa fa-trash ml-2 text-danger"></div>`;
                element.appendChild(input);
                document.querySelector(`div[data-sh="collateral-data"]`).appendChild(element);
        }
        this.value = '';
    }
    document.querySelector(`input[data-sh="collateral"]`).addEventListener('change', function() { multipleImage(this, 'collateral') });
    
    /*
    |On Change Event For
    ---------------------- */
    document.querySelector(`select[data-event="event-for"]`).addEventListener('change', event=>{
        document.querySelector(`div[data-div="startup-companies"]`).style.display = "none";
        document.querySelector(`div[data-div="pilot-companies"]`).style.display = "none";
        document.querySelector(`select[data-search="startup-companies"]`).required = false;
        document.querySelector(`select[data-search="pilot-companies"]`).required = false;

        if(event.target.value === 'startup')
        {
            document.querySelector(`div[data-div="startup-companies"]`).style.display = "block";
            document.querySelector(`select[data-search="startup-companies"]`).required = true;
        }
        else if(event.target.value === 'pilot') 
        {
            document.querySelector(`div[data-div="pilot-companies"]`).style.display = "block";
            document.querySelector(`select[data-search="pilot-companies"]`).required = true;
        }
        else if(event.target.value === 'both'){
            document.querySelector(`div[data-div="startup-companies"]`).style.display = "block";
            document.querySelector(`div[data-div="pilot-companies"]`).style.display = "block";
            document.querySelector(`select[data-search="startup-companies"]`).required = true;
            document.querySelector(`select[data-search="pilot-companies"]`).required = true;
        }
    })

    /*
    | Select all and clear
    ----------------------- */
    const changePickerAction = event => {
        let selectedAction = event.target.getAttribute('data-clear');
        let flag = false;
        if(event.target.getAttribute('data-action') === 'select')
        {
            selectedAction = event.target.getAttribute('data-select');
            flag = true;
        }
        document.querySelectorAll(`select[data-search="${selectedAction}"] option`).forEach(object => {
            object.selected = flag
        });
        $(`select[data-search="${selectedAction}"]`).trigger('change');
    }
    window.onload = () => {
        const _selectpicker = document.getElementsByClassName('_selectpicker')
        for(let object of _selectpicker) object.addEventListener("click", changePickerAction)

        const _eventupdate = document.getElementsByClassName('_eventupdate')
        for(let object of _eventupdate) object.addEventListener("click", event => {
            if(event.target.getAttribute('data-send-status') === 'cancel')
            {
                confirmFlag = 0;
                return;
            }
            document.forms.event.mailstatus.value = event.target.getAttribute('data-send-status') === 'yes' ? 'true' : 'false';
            document.forms.event.maildescription.value = document.querySelector('textarea[data-description="maildescription"]').value;
            confirmFlag = 1;
            document.forms.event.submit.click();
        })
    }

    let confirmFlag = 0;
    const submitForm = event => {
        event.preventDefault();
        if(confirmFlag === 0 && event.target.event_for.value != 'public' && event.target.event_for.value != '')
        {
            $('#eventModal').modal('show')
            return;
        }
        event.target.submit.innerHTML = `<div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>`
        const fd = new FormData(event.target);
        commonAjax({
            page: 'admin/event/add',
            params: fd
        }).then(response => {
            event.target.submit.innerHTML = "Submit"
            snackbar(response?.message || "Something went wrong");
            if(response?.success)window.location.href="./";
            let errors = response.errors || {};
            for(let [key, name] of Object.entries(errors)) {
                document.querySelector(`small[data-error-event='${key}']`).innerHTML = name;
            }
        })
        .catch(err => {snackbar("Something went wrong"); event.target.submit.innerHTML = "Submit"})
    }
    document.forms.event.addEventListener("submit", submitForm)
</script>
@endsection