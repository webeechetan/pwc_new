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
                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Event</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Edit Event</a></li>
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
                        <div class="shadow-sm text-center p-3" data-append="event_image">
                            <img src="{{ asset('storage/uploads/event/Event'.request()->id.'.jpg') }}" class="img-fluid">
                        </div>
                        <small class="text-danger d-block" data-error-event="event_image"></small>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Banner Image*</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="event_banner_image" />
                            <label class="custom-file-label">Choose file</label>
                            <small class="d-block badge text-secondary text-left">Event Banner image size should be 1920px*300px</small>
                        </div>
                        <div class="shadow-sm text-center p-3" data-append="event_banner_image"><img src="{{ asset('storage/uploads/event/EventBanner'.request()->id.'.jpg') }}"class="img-fluid" onerror="this.remove()"></div>
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
                        <input type="text" class="form-control" name="title" required value="{{$data->title}}"/>
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
                        <input type="text" class="form-control" name="price" required value="{{$data->price}}"/>
                    </div>
                    <small class="text-danger" data-error-event="price"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event For *</label>
                        <select class="form-control" name="event_for" data-event="event-for" required>
                            <option value="" disabled selected>Select Event For</option>
                            <option value="startup">For Startups</option>
                            <option value="pilot">For Pilot Members</option>
                            <option value="both">For Startups and Pilot Companies</option>
                            <option value="public">For All</option>
                        </select>
                    </div>
                    <small class="text-danger" data-error-event="event_for"></small>
                </div>
            </div>
            @php
                $event_pilot_companies = $data->pilot_companies != null && $data->pilot_companies != '' ? explode(',', $data->pilot_companies) : [];
                $event_startup_id = $data->startup_id != null && $data->startup_id != '' ? explode(',', $data->startup_id) : [];
            @endphp
            <div class="row">
                <div class="col-md-4" data-div="startup-companies" style="{{$data->event_for === 'both' || $data->event_for === 'startup' ? '' : 'display: none'}}">
                    <label class="form-label">
                        Startup List
                        <small>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-select="startup-companies" data-action="select">Select all</a>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-clear="startup-companies" data-action="clear">Clear</a>
                        </small>
                    </label>
                    <select class="form-control selectpicker" multiple data-live-search="true" name="startup_id[]" data-search="startup-companies" {{$data->event_for === 'both' || $data->event_for === 'startup' ? "required" : ''}}>
                        @if($data_startup)
                            @foreach($data_startup as $d)
                                <option value="{{$d->startup_id}}" {{ in_array($d->startup_id, $event_startup_id) ? 'selected' : '' }}>{{$d->startup_login->email.' ('.$d->company_name.')'}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4" data-div="pilot-companies" style="{{$data->event_for === 'both' || $data->event_for === 'pilot' ? '' : 'display: none'}}">
                    <label class="form-label">
                        Pilot Companies List
                        <small>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-select="pilot-companies" data-action="select">Select all</a>
                            <a href="javascript:void(0)" class="text-primary mx-2 _selectpicker" data-clear="pilot-companies" data-action="clear">Clear</a>
                        </small>
                    </label>
                    <select class="form-control selectpicker" multiple data-live-search="true" name="pilot_companies_id[]" data-search="pilot-companies" {{$data->event_for === 'both' || $data->event_for === 'pilot' ? "required" : ''}}>
                        @if($data_pilot)
                            @foreach($data_pilot as $d)
                                <option value="{{$d->id}}" {{ in_array($d->id, $event_pilot_companies) ? 'selected' : '' }}>{{$d->email.' ('.$d->name.')'}}</option>
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
                        <input type="date" class="form-control" name="event_from" required value="{{$data->event_from}}"/>
                    </div>
                    <small class="text-danger" data-error-event="event_from"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event To</label>
                        <input type="date" class="form-control" name="event_to" required value="{{$data->event_to}}"/>
                    </div>
                    <small class="text-danger" data-error-event="event_to"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Duration Start*</label>
                        <input type="time" class="form-control" name="event_start" required value="{{date('h:i', strtotime($data->event_start))}}"/>
                    </div>
                    <small class="text-danger" data-error-event="event_start"></small>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group">
                        <label class="form-label">Event Duration End*</label>
                        <input type="time" class="form-control" name="event_end" required value="{{date('h:i', strtotime($data->event_end))}}"/>
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
                        <textarea class="form-control" name="short_description"  required rows="12">{{$data->short_description}}</textarea>
                    </div>
                    <small class="text-danger" data-error-event="short_description"></small>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label class="form-label">Description*</label>
                        <textarea type="time" class="form-control" name="description" id="event_description" required rows="12">{{$data->description}}</textarea>
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
            @php
                    $collateral = !empty($data) ? explode(",", $data->collateral) : [];
            @endphp
            <div class="row">
                @foreach($collateral as $c)
                @if($c != '')
                <div class="col-md-3">
                    <div class="shadow-sm">
                        <a href="{{ asset('storage/uploads/event/'.$c) }}" target="_blank">
                            <div class="d-flex align-items-center justify-content-center" style="height: 100px">
                                <i class="fa fa-file-o fa-2x"></i>
                            </div>
                            <hr class="mb-0">
                            <div class="text-center"><i class="fa fa-file-o mr-2"></i><small>{{$c}}</small></div>
                        </a>
                        <input type="hidden" name="uploadedcollateral[]" value="{{$c}}">
                        <button type="button" class="btn btn-sm btn-danger form-control text-white" onclick="this.parentElement.parentElement.remove()">Delete</button>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-4" name="submit">Submit</button>
                </div>
            </div>
            <input type="hidden" name="mailstatus" value="false">
            <input type="hidden" name="maildescription" value="">
            <input type="hidden" name="mailchanges" value="false">
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
        <p data-para="mailpara">Would you like to send invitation emails to guests?</p>
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

    let editor;
    window.onload = () => {
        editor = initializeEditor('event_description');
        editor.onChange = function (contents, isChanged) {
            document.forms.event.description.value = contents;
        }
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

        Array.prototype.diff = function(arr2) { return this.filter(x => !arr2.includes(x)); }
    }

    let emailPara = "";
    const validateEvent = e => {
        document.forms.event.mailchanges.value = 'false'
        let status = {
            add: 0,
            remove: 0,
            change: 0
        };
        // debugger;
        if(
            e.title.value.trim() != `{{$data->title}}`.trim() ||
            e.category.value.trim() != `{{$data->category}}`.trim() ||
            e.type.value.trim() != `{{$data->type}}`.trim() ||
            e.price.value.trim() != `{{$data->price}}`.trim() ||
            e.event_for.value.trim() != `{{$data->event_for}}`.trim() ||
            e.event_from.value.trim() != `{{$data->event_from}}`.trim() ||
            e.event_to.value.trim() != `{{$data->event_to}}`.trim() ||
            e.event_start.value.trim() != `{{date('h:i', strtotime($data->event_start))}}`.trim() ||
            e.event_end.value.trim() != `{{date('h:i', strtotime($data->event_end))}}`.trim() ||
            e.description.value.trim() != `{!! $data->description !!}`.trim()
        ) status.change = 1;

        let old_startup_id = [];
        

        let new_startup_id = "{{trim(implode(',', $event_startup_id))}}".trim('') != '' ? "{{trim(implode(',', $event_startup_id))}}".trim('').split(',') : [];
        
        document.querySelectorAll('select[name="startup_id[]"] option').forEach(ob => {
            if(ob.selected) old_startup_id.push(ob.value);
        })
        
        
        if([...old_startup_id].diff([...new_startup_id]).length > 0) status.add = 1
        if([...old_startup_id].filter(x => [...new_startup_id].includes(x)).length !== new_startup_id.length) status.remove = 1
        
        if(status.add === 0 || status.remove === 0)
        {
            let old_pilot_id = [];
            let new_pilot_id = "{{implode(',', $event_pilot_companies)}}".trim('') != '' ? "{{implode(',', $event_pilot_companies)}}".trim('').split(',') : [];

            document.querySelectorAll('select[name="pilot_companies_id[]"] option').forEach(ob => {
                if(ob.selected) old_pilot_id.push(ob.value);
            })
            if([...old_pilot_id].diff([...new_pilot_id]).length > 0) status.add = 1
            if([...old_pilot_id].filter(x => [...new_pilot_id].includes(x)).length !== new_pilot_id.length) status.remove = 1
        }

        if(status.change === 1) document.forms.event.mailchanges.value = 'true'

        if(status.add === 1 && status.remove === 1 && status.change === 1) emailPara = "Would you like to send emails to new, existing and removed guests?";
        else if(status.change === 1 && status.add === 1) emailPara = "Would you like to send emails to existing and new guests?";
        else if(status.change === 1 && status.remove === 1) emailPara = "Would you like to send emails to existing and removed guests?";
        else if(status.add === 1 && status.remove === 1) emailPara = "Would you like to send emails to new and removed guests?";
        else if(status.add === 1) emailPara = "Would you like to send emails to new guests?";
        else if(status.remove === 1) emailPara = "Would you like to send emails to removed guests?";
        else if(status.change === 1) emailPara = "Would you like to send update emails to existing guests?";
        else
        {
            return 0;
        }
        document.querySelector('p[data-para="mailpara"]').innerHTML = emailPara;
        return 1;
    }

    let confirmFlag = 0;
    const submitForm = event => {
        event.preventDefault();
        if(confirmFlag === 0 && event.target.event_for.value != 'public' && event.target.event_for.value != '')
        {
            if(validateEvent(event.target))
            {
                $('#eventModal').modal('show')
                return;
            }
        }
        event.target.submit.innerHTML = `<div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div> Loading`
        const fd = new FormData(event.target);
        commonAjax({
            page: 'admin/event/edit/{{request()->id}}',
            params: fd
        }).then(response => {
            event.target.submit.innerHTML = "Submit"
            snackbar(response?.message || "Something went wrong");
            if(response?.success)window.location.href="../";
            let errors = response.errors || {};
            for(let [key, name] of Object.entries(errors)) {
                document.querySelector(`small[data-error-event='${key}']`).innerHTML = name;
            }
        })
        .catch(err => {snackbar("Something went wrong"); event.target.submit.innerHTML = "Submit"})
    }
    document.forms.event.addEventListener("submit", submitForm)

    document.forms.event.category.value = '{{$data->category}}'
    document.forms.event.type.value = '{{$data->type}}'
    document.forms.event.event_for.value = '{{$data->event_for}}'
</script>
@endsection