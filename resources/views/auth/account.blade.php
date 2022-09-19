@extends('layout.index')

@section('title') Home @endsection

@section('body')




<!-- For Startups -->
<section class="sec-space">
    <div class="container">
        <!-- Form -->
        <form class="bg-white p-4" name="startup" method="POST" action="/admin/startup/add" enctype="multipart/form-data">
                @csrf()
                <!--|Application Status|-->
                <div class="row">
                    <div class="col-md-12 text-end">
                        @if($data)
                            <small class="mx-2">{{ !empty($data) && $data -> screening_count > 3 ? "Screening: Interested" : '' }}</small>
                            <small class="mx-2">{{ !empty($data) && $data -> meeting1_count > 3 ? "Meeting 1: Interested" : '' }}</small>
                            <small class="mx-2">{{ !empty($data) && $data -> meeting2_count > 3 ? "Meeting 2: Interested" : '' }}</small>
                            <small class="mx-2">{{ !empty($data) && $data -> finalcall_count > 3 ? "Final Call: Interested" : '' }}</small>
                        @endif
                    </div>
                </div>
                
                <h4 class="mb-3 bg-primary p-2 text-light"><b>Company Info</b></h4>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Company Image *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input form-control" name="image" />
                                <small class="d-block badge text-secondary text-start">Aspect ratio 1:1, 300x 300px recommended. JPGs, JPEGs and PNGs supported only</small>
                            </div>
                        </div>
                        <div class="p-2" data-append="image" style="height: 100px;">
                            @if(!empty($data))
                                <img src="{{ asset('storage/uploads/startup/Startup'.$data->id.'.jpg') }}" class="img-fluid" style="height: 100%;">
                            @endif
                        </div>
                        <small class="text-danger d-block" data-error-startup="image"></small>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Company Name *</label>

                            <input type="text" class="form-control" name="company_name" required value="{{!empty($data) ? $data->company_name : ''}}"/>
                            <small class="text-danger d-block" data-error-startup="company_name"></small>
                        </div>
                    </div>

                    <div class="col-md-12  mb-3">
                        <div class="form-group">
                            <label class="form-label">Company Overview *</label>

                            <textarea type="text" class="form-control" name="description" required id="description" rows="20">{{!empty($data) ?  $data->description : ''}}</textarea>
                            <small class="text-danger d-block" data-error-startup="description"></small>
                        </div>
                    </div>

                    <div class="col-md-4  mb-3">
                        <div class="form-group">
                            <label class="form-label">Country *</label>

                            <select class="form-control" name="country" required></select>
                            <small class="text-danger d-block" data-error-startup="country"></small>
                        </div>
                    </div>

                    <div class="col-md-4  mb-3">
                        <div class="form-group">
                            <label class="form-label">State *</label>

                            <select class="form-control" name="state" required></select>
                            <small class="text-danger d-block" data-error-startup="state"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">City *</label>

                            <select class="form-control" name="city" required></select>
                            <small class="text-danger d-block" data-error-startup="city"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Pincode *</label>

                            <input type="text" class="form-control" name="pincode" value="{{!empty($data) ?  $data->pincode : ''}}" required/>
                            <small class="text-danger d-block" data-error-startup="pincode"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
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

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Address *</label>

                            <input type="text" class="form-control" name="address" required value="{{!empty($data) ? $data->address : ''}}"/>
                            <small class="text-danger d-block" data-error-startup="address"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Founded On</label>

                            <input type="text" class="form-control" name="founded_on" value="{{!empty($data) ? $data->founded_on : ''}}" />
                            <small class="text-danger d-block" data-error-startup="founded_on"></small>
                        </div>
                    </div>
                    @php $companyType = ["Private Limited Company", "Public Limited Company", "Partnership", "Sole Proprietorship", "Government Agency", "Non Profit", "Self-employed"] @endphp
                    <div class="col-md-4 mb-3">
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

                    <div class="col-md-4 mb-3">
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

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Specialities</label>

                            <input type="text" class="form-control" name="specialities" value="{{!empty($data) ? $data->specialities : ''}}" />
                            <small class="text-danger d-block" data-error-startup="specialities"></small>
                        </div>
                    </div>

                    <div class="col-md-4"></div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Company Size</label>
                        <select class="form-control" name="company_size" required>
                            <option value="" selected disabled>Select Company size</option>
                            @php $employees = ["Self-employed", "1-10 employee", "11-50 employees", "51-200 employees", "201-500 employees", "501-1000 employees", "1001-5000 employees", "5001-10,000 employees", "10,001+ employees"]; @endphp
                            @foreach($employees as $e)
                                <option value="{{$e}}">{{$e}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger d-block" data-error-startup="company_size"></small>
                    </div>

                    <div class="col-md-4 mb-3">
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

                <h4 class="mb-3 bg-primary p-2 text-light"><b>Digital Assets</b></h4>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Website</label>

                            <input type="text" class="form-control" name="website" value="{{!empty($data) ? $data->website : ''}}" />
                            <small class="text-danger d-block" data-error-startup="website"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Facebook</label>

                            <input type="text" class="form-control" name="facebook" value="{{!empty($data) ? $data->facebook : ''}}" />
                            <small class="text-danger d-block" data-error-startup="facebook"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Twitter</label>

                            <input type="text" class="form-control" name="twitter" value="{{!empty($data) ? $data->twitter : ''}}" />
                            <small class="text-danger d-block" data-error-startup="twitter"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Linkedin</label>

                            <input type="text" class="form-control" name="linkedin" value="{{!empty($data) ? $data->linkedin : ''}}" />
                            <small class="text-danger d-block" data-error-startup="linkedin"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Instagram</label>

                            <input type="text" class="form-control" name="instagram" value="{{!empty($data) ? $data->instagram : ''}}" />
                            <small class="text-danger d-block" data-error-startup="instagram"></small>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 bg-primary p-2 text-light"><b>Point of Contact</b></h4>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Name *</label>

                            <input type="text" class="form-control" name="name" required value="{{!empty($data_poc) ? $data_poc->fullname : ''}}" />
                            <small class="text-danger d-block" data-error-startup="name"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Designation *</label>

                            <input type="text" class="form-control" name="designation" required value="{{!empty($data) ? $data->designation : ''}}" />
                            <small class="text-danger d-block" data-error-startup="designation"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>

                            <input type="text" class="form-control" name="email" required value="{{!empty($data_poc) ? $data_poc->email : ''}}" />
                            <small class="text-danger d-block" data-error-startup="email"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Phone Number *</label>

                            <input type="text" class="form-control" name="phone" required value="{{!empty($data_poc) ? $data_poc->mobile : ''}}" />
                            <small class="text-danger d-block" data-error-startup="phone"></small>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 bg-primary p-2 text-light"><b>Marketing Collaterals</b></h4>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="custom-file">
                            <input type="file" required="" class="custom-file-input form-control" data-sh="collateral" multiple>
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
                            <a href="{{ asset('storage/uploads/startup/'.$c) }}" target="_blank">
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
                    <button type="submit" class="btn btn-primary mt-4" id="btnForUpdate">Update</button>
                </div>
            </div>
        </form>
        <!--Result-->
@if(!empty($data) && $data->startup_approval != '' && count($data->startup_approval) > 0)
<div class="container my-4">
    <div class="">
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
            <div class="col-md-6">
                <h3 class="mb-0">Project Committee Member Votes</h3>
                <small class="mb-3 d-block">{{$data->company_name}}</small>
            </div>
            <div class="col-md-6 text-md-end">
                <button onclick="exportData()" class="btn btn-outline-success">Download</button>
            </div>
        </div>    
        <table id="dataTable" class="table table-light table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th class="border-0">SNO</th>
                    <th class="border-0">COMPANY NAME</th>
                    <th class="border-0">Vote</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-center text-primary" colspan="3">Screening</th>
                </tr>
                @foreach($data -> screening as $key => $screen)
                <tr>
                    <th>{{$key+1}}</th>
                    <th>{{$screen -> pilot_companies -> name ?? 'PILOT COMPANY'}}</th>
                    <th>
                        @if($screen -> approved === 1)
                            <span class="text-success">+ 1</span>
                        @endif
                         @if($screen -> approved === 2)
                            <span class="text-danger">- 1</span>
                        @endif
                    </th>
                </tr>
                @endforeach
                <tr>
                    <th class="text-center text-primary" colspan="3">Meeting 1</th>
                </tr>
                @foreach($data -> meeting1 as $key => $meet1)
                <tr>
                    <th>{{$key+1}}</th>
                    <th>{{$meet1 -> pilot_companies -> name ?? 'PILOT COMPANY'}}</th>
                    <th>
                        @if($meet1 -> approved === 1)
                            <span class="text-success">+ 1</span>
                        @endif
                        @if($meet1 -> approved === 2)
                            <span class="text-danger">- 1</span>
                        @endif
                      
                    </th>
                </tr>
                @endforeach
                <tr>
                    <th class="text-center text-primary" colspan="3">Meeting 2</th>
                </tr>
                @foreach($data -> meeting2 as $key => $meet2)
                <tr>
                    <th>{{$key+1}}</th>
                    <th>{{$meet2 -> pilot_companies -> name ?? 'PILOT COMPANY'}}</th>
                    <th>
                        @if($meet2 -> approved === 1)
                            <span class="text-success">+ 1</span>
                        @endif
                        @if($meet2 -> approved === 2)
                            <span class="text-danger">- 1</span>
                        @endif
                    </th>
                </tr>
                @endforeach
                <tr>
                    <th class="text-center text-primary" colspan="3">Final Call</th>
                </tr>
                @foreach($data -> finalcall as $key => $final)
                <tr>
                    <th>{{$key+1}}</th>
                    <th>{{$final -> pilot_companies -> name ?? 'PILOT COMPANY'}}</th>
                    <th>
                        @if($final -> approved === 1)
                            <span class="text-success">+ 1</span>
                        @endif
                        @if($final -> approved === 2)
                            <span class="text-danger">- 1</span>
                        @endif
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
<!--end of result-->
    </div>
</section>



@endsection
@section('script')
<!-- <link href="{{ asset('assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="//cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script src="{{asset('/assets/admin/js/textEditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js" integrity="sha512-DaMQrMxgirR5T0Zu+d7EABoP1uD7e2Sv6OBjifMM8RADf1orW42COfJgwZ8xsLRV6NhgR/erzCfodeqJmA3NtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function exportData(){
        let dataTable = document.getElementById('dataTable');
        let fptr = XLSX.utils.table_to_book(dataTable, {sheet: '{{!empty($data)?$data->company_name:''}}'});
        XLSX.write(fptr, {
            bookType: 'xlsx',
            type: 'base64',
        }),
        XLSX.writeFile(fptr, `{{!empty($data)?$data->company_name:''}} (voting info).xlsx`);
    }
    
</script>


<script>
    @if(!empty($data))
    document.forms.startup.zone.value = "{{$data->zone}}";
    document.forms.startup.company_type.value = "{{$data->company_type}}";
    document.forms.startup.company_size.value = "{{$data->company_size}}";
    document.forms.startup.revenue.value = "{{$data->revenue}}";
    @endif

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
    let flag = {{!empty($data) ? 0 : 10}};
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
                    reSetToken(n);
                    return false;
                }
                let collection = "";
                if(n === 'country')
                {
                    collection = "<option selected disabled>Select Country</option>";
                    for(let i = 0; i < response.length; i++) collection += `<option value="${response[i].country_name}">${response[i].country_name}</option>`;
                    document.forms.startup.country.innerHTML = collection;
                    if(flag == 0){
                        document.forms.startup.country.value="{{!empty($data) ? $data->country : ''}}";
                        flag++;
                        getCollection('state');
                    }
                } else if(n === 'state')
                {
                    collection = "<option selected disabled>Select State</option>";
                    for(let i = 0; i < response.length; i++) collection += `<option value="${response[i].state_name}">${response[i].state_name}</option>`;
                    document.forms.startup.state.innerHTML = collection;
                    if(flag == 1){
                        document.forms.startup.state.value="{{!empty($data) ? $data->state : ''}}";
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
                        document.forms.startup.city.value="{{!empty($data) ? $data->city : ''}}";
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
                = `<img src="${response}" class="img-fluid" style="height: 100%">`;
            })
        }
    }
    document.forms.startup.image.addEventListener("change", renderImage)

    let editor;
    window.onload = () => {
        // editor = initializeEditor('description');
        // editor.onChange = function (contents, isChanged) {
        //     document.forms.startup.description.value = contents;
        // }
        editor = initializeCkEditor('#description');
    }

   const submitForm = event => {
        var btn = document.getElementById("btnForUpdate")
        btn.innerHTML = `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...`;
        event.preventDefault();
        for(var instanceName in CKEDITOR.instances) CKEDITOR.instances[instanceName].updateElement();
        const fd = new FormData(event.target);
        commonAjax({
            page: "myaccount/update",
            params: fd
        }).then(response => {
            btn.innerHTML = 'Update'
            snackbar(response?.message || "Something went wrong");
            if(response?.success)window.location.reload();
            let errors = response.errors || {};
            for(let [key, name] of Object.entries(errors)) {
                document.querySelector(`small[data-error-startup='${key}']`).innerHTML = name;
            }
        })
        .catch(err => 
        snackbar("Something went wrong")
        // btn.innerHTML = 'Update'
        )
    }
    document.forms.startup.addEventListener("submit", submitForm)
</script>
@endsection