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
                    <h4>Startup</h4>
                </div>
            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Startup</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Edit Startup</a></li>
                </ol>
            </div>
        </div>
            <!-- Form -->
            <form class="bg-white p-4" name="startup" method="POST" action="/admin/startup/add" enctype="multipart/form-data">
                @csrf()
                <h4 class="mb-3"><b>Company Info</b></h4>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Company Image *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" />
                                <label class="custom-file-label">Choose file</label>
                                <small class="d-block badge text-secondary text-left">Aspect ratio 1:1, 300x 300px recommended. JPGs, JPEGs and PNGs supported only</small>
                            </div>
                        </div>
                        <div class="shadow-sm text-center p-3" data-append="image">
                            <img src="{{ asset('storage/uploads/startup/Startup'.request()->id.'.jpg') }}" class="img-fluid">
                        </div>
                        <small class="text-danger d-block" data-error-startup="image"></small>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Company Name *</label>

                            <input type="text" class="form-control" name="company_name" required value="{{$data->company_name}}"/>
                            <small class="text-danger d-block" data-error-startup="company_name"></small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Company Overview *</label>

                            <textarea type="text" class="form-control" name="description" required id="description" rows="12">{{$data->description}}</textarea>
                            <small class="text-danger d-block" data-error-startup="description"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Country *</label>

                            <select class="form-control" name="country" required></select>
                            <small class="text-danger d-block" data-error-startup="country"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">State *</label>

                            <select class="form-control" name="state" required></select>
                            <small class="text-danger d-block" data-error-startup="state"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">City *</label>

                            <select class="form-control" name="city" required></select>
                            <small class="text-danger d-block" data-error-startup="city"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Pincode *</label>

                            <input type="text" class="form-control" name="pincode" value="{{$data->pincode}}" required/>
                            <small class="text-danger d-block" data-error-startup="pincode"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $Zone = ["North", "South", "East", "West"];
                            @endphp
                            <label class="form-label">Zone *</label>
                            <select class="form-control" name="zone" required>
                                <option value="" selected disabled>Select Zone</option>
                                @foreach($Zone as $z)
                                    <option value="{{$z}}">{{$z}}</option>
                                @endforeach
                            </select>
                            <small class="text-danger d-block" data-error-startup="zone"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Address *</label>

                            <input type="text" class="form-control" name="address" required value="{{$data->address}}"/>
                            <small class="text-danger d-block" data-error-startup="address"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Founded On</label>

                            <input type="text" class="form-control" name="founded_on" value="{{$data->founded_on}}" />
                            <small class="text-danger d-block" data-error-startup="founded_on"></small>
                        </div>
                    </div>
                    @php $companyType = ["Private Limited Company", "Public Limited Company", "Partnership", "Sole Proprietorship", "Government Agency", "Non Profit", "Self-employed"] @endphp
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Company Type *</label>
                            <select class="form-control" name="company_type" required>
                                <option value="" selected disabled>Select Company Type</option>
                                @foreach($companyType as $ct)
                                    <option value="{{$ct}}">{{$ct}}</option>
                                @endforeach
                            </select>
                            <small class="text-danger d-block" data-error-startup="company_type"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Industry</label>
                            <select class="form-control" name="industry">
                                <option value="" selected disabled>Select Industry</option>
                                @foreach(getIndustryList() as $industry)
                                    <option value="{{$industry}}" {{!empty($data) && $data->industry == $industry ? 'selected' : ''}}>{{$industry}}</option>
                                @endforeach
                            </select>
                            <small class="text-danger d-block" data-error-startup="industry"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Specialities</label>

                            <input type="text" class="form-control" name="specialities" value="{{$data->specialities}}" />
                            <small class="text-danger d-block" data-error-startup="specialities"></small>
                        </div>
                    </div>

                    <div class="col-md-4"></div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Employees</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <select class="form-control" name="company_size" required>
                                    <option value="" selected disabled>Select Company Size</option>
                                    @php $employees = ["Self-employed", "1-10 employee", "11-50 employees", "51-200 employees", "201-500 employees", "501-1000 employees", "1001-5000 employees", "5001-10,000 employees", "10,001+ employees"]; @endphp
                                    @foreach($employees as $e)
                                        <option value="{{$e}}">{{$e}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger d-block" data-error-startup="company_size"></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Revenue (₹ Cr.)</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <select class="form-control" name="revenue">
                                    <option value="" selected disabled>Select Revenue</option>
                                    @php $Revenue = ["1-50", "51-100", "101-250", "251-500", "501-1000", "1001-2500", "2501-5000", "5000&Above"]; @endphp
                                    @foreach($Revenue as $r)
                                        <option value="{{$r}}">{{$r}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger d-block" data-error-startup="revenue"></small>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3"><b>Digital Presence</b></h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Acma Certified</label>
                            <select class="form-control" name="certified">
                                <option value="" selected>Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <small class="text-danger d-block" data-error-startup="certified"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tag</label>
                            <input type="text" name="title" class="form-control" value="{{$data->title}}" />
                            <small class="text-danger d-block" data-error-startup="title"></small>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3"><b>Digital Assets</b></h4>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Website</label>

                            <input type="text" class="form-control" name="website" value="{{$data->website}}" />
                            <small class="text-danger d-block" data-error-startup="website"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Facebook</label>

                            <input type="text" class="form-control" name="facebook" value="{{$data->facebook}}" />
                            <small class="text-danger d-block" data-error-startup="facebook"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Twitter</label>

                            <input type="text" class="form-control" name="twitter" value="{{$data->twitter}}" />
                            <small class="text-danger d-block" data-error-startup="twitter"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Linkedin</label>

                            <input type="text" class="form-control" name="linkedin" value="{{$data->linkedin}}" />
                            <small class="text-danger d-block" data-error-startup="linkedin"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Instagram</label>

                            <input type="text" class="form-control" name="instagram" value="{{$data->instagram}}" />
                            <small class="text-danger d-block" data-error-startup="instagram"></small>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3"><b>Point of Contact</b></h4>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Name *</label>

                            <input type="text" class="form-control" name="name" required value="{{$data_login->fullname}}" />
                            <small class="text-danger d-block" data-error-startup="name"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Designation *</label>

                            <input type="text" class="form-control" name="designation" required value="{{$data->designation}}" />
                            <small class="text-danger d-block" data-error-startup="designation"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>

                            <input type="text" class="form-control" name="email" required value="{{$data_login->email}}" />
                            <small class="text-danger d-block" data-error-startup="email"></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Phone Number *</label>

                            <input type="text" class="form-control" name="phone" required value="{{$data_login->mobile}}" />
                            <small class="text-danger d-block" data-error-startup="phone"></small>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3"><b>Marketing Collaterals</b></h4>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" data-sh="collateral" multiple>
                            <label class="custom-file-label" >Choose file</label>
                        </div>
                        <div data-sh="collateral-data"></div>
                    </div>
                </div>
                <!-- |Collateral| -->
                <div class="row">
                    <div class="col-12 my-3">
                        @php
                            $collateral = explode(",", $data->collateral);
                        @endphp
                        @if(count($collateral) > 0)
                            <div class="row">
                                @foreach($collateral as $c)
                                @if($c != '')
                                    <div class="col-md-3">
                                        <div class="shadow-sm">
                                            <a href="{{ asset('storage/uploads/startup/'.$c) }}" target="_blank">
                                                <div class="d-flex align-items-center justify-content-center" style="height: 100px">
                                                    <i class="fa fa-file-o fa-2x"></i>
                                                </div>
                                                <hr class="mb-0">
                                                <div class="text-center"><i class="fa fa-file-o mr-2"></i><small>{{$c}}</small></div>
                                            </a>
                                        </div>
                                        <input type="hidden" name="uploadedcollateral[]" value="{{$c}}" >
                                        <button type="button" class="btn btn-sm btn-danger form-control text-white" onclick="this.parentElement.remove()">Delete</button>
                                    </div>
                                @endif
                                @endforeach
                            </div>
                        @endif
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
<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js" defer="true"></script>
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/src/lang/en.js" defer="true"></script>
<script src="{{ asset('/assets/admin/js/textEditor.js') }}"></script>
<script>
    document.forms.startup.zone.value = "{{$data->zone}}";
    document.forms.startup.company_type.value = "{{$data->company_type}}";
    document.forms.startup.company_size.value = "{{$data->company_size}}";
    document.forms.startup.revenue.value = "{{$data->revenue}}";
    document.forms.startup.certified.value = "{{$data->certified}}";

    const reSetToken = (n) => {
        const myHeaders = new Headers();
        myHeaders.append("api-token", "kP6UVhJHppu8hjoPirrViYUkS7HsYdAWgDXTpnxYcQChRbP5kWT7hmHMUkU_MlrzNjg");
        myHeaders.append("Accept", "application/json")
        myHeaders.append('user-email', 'gejahom937@sejkt.com')
        commonAjax({
            page: '/api/getaccesstoken',
            header: myHeaders,
            addonUrl: 'https://www.universal-tutorial.com',
            type: 'GET'
        })
        .then(response => {
            localStorage.setItem("access-token", response.auth_token);
            getCollection(n)
        })
        .catch(err => localStorage.removeItem("access-token"))
    }
    let flag = 0;
    const getCollection = (n) => {
        if(!localStorage.getItem("access-token")){
            reSetToken(n);
            return;
        } else
        {
            let url = '';
            if(n === 'country') url = 'countries/'
            else if(n === 'state') url = `states/${document.forms.startup.country.value}`
            else if(n === 'city') url = `cities/${document.forms.startup.state.value}`

            if(url === '') return;

            const myHeaders = new Headers();
            myHeaders.append("Authorization", `Bearer ${localStorage.getItem("access-token")}`);
            myHeaders.append("Accept", "application/json")
            commonAjax({
                page: url,
                header: myHeaders,
                addonUrl: 'https://www.universal-tutorial.com/api/',
                type: 'GET'
            })
            .then(response => {
                if(response?.error) {
                    reSetToken();
                    return false;
                }
                let collection = "";
                if(n === 'country')
                {
                    collection = "<option selected disabled>Select Country</option>";
                    for(let i = 0; i < response.length; i++) collection += `<option value="${response[i].country_name}">${response[i].country_name}</option>`;
                    document.forms.startup.country.innerHTML = collection;
                    if(flag == 0){
                        document.forms.startup.country.value="{{$data->country}}";
                        flag++;
                        getCollection('state');
                    }
                } else if(n === 'state')
                {
                    collection = "<option selected disabled>Select State</option>";
                    for(let i = 0; i < response.length; i++) collection += `<option value="${response[i].state_name}">${response[i].state_name}</option>`;
                    document.forms.startup.state.innerHTML = collection;
                    if(flag == 1){
                        document.forms.startup.state.value="{{$data->state}}";
                        flag++;
                        getCollection('city');
                    }
                }
                else if(n === 'city')
                {
                    collection = "<option selected disabled>Select City</option>";
                    for(let i = 0; i < response.length; i++) collection += `<option value="${response[i].city_name}">${response[i].city_name}</option>`;
                    document.forms.startup.city.innerHTML = collection;
                    if(flag == 2){
                        document.forms.startup.city.value="{{$data->city}}";
                        flag++;
                    }
                }

            })
            .catch(err => reSetToken(n))
        }
    }

    document.forms.startup.country.addEventListener("change", event => getCollection('state'))
    document.forms.startup.state.addEventListener("change", event => getCollection('city'))

    getCollection('country')

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
    |Functionality
    -------------- */
    const renderImage = event => {
        if(event.target.files.length > 0)
        {
            fileUpload(event.target.files[0]).then(response => {
                document.querySelector(`div[data-append='${event.target.name}']`).innerHTML
                = `<img src="${response}" class="img-fluid" style="max-height: 300px">`;
            })
        }
    }
    document.forms.startup.image.addEventListener("change", renderImage)

    let editor;
    window.onload = () => {
        editor = initializeEditor('description');
        editor.onChange = function (contents, isChanged) {
            document.forms.startup.description.value = contents;
        }
    }

    const submitForm = event => {
        event.preventDefault();
        const fd = new FormData(event.target);
        commonAjax({
            page: 'admin/startup/edit/{{request()->id}}',
            params: fd
        }).then(response => {
            snackbar(response?.message || "Something went wrong");
            if(response?.success)window.location.href="../";
            let errors = response.errors || {};
            for(let [key, name] of Object.entries(errors)) {
                document.querySelector(`small[data-error-startup='${key}']`).innerHTML = name;
            }
        })
        .catch(err => snackbar("Something went wrong"))
    }
    document.forms.startup.addEventListener("submit", submitForm)
</script>
@endsection