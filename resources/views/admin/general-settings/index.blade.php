@extends('layouts.app')
@section('title', 'Settings')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Settings</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">General Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-12">
        <!-- Tabs -->
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">General Setting</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Mail Configuration</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sendMail" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Send Test Mail</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sms" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Sms & Otp</span></a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tabcontent-border">
                <div class="tab-pane active" id="home" role="tabpanel">
                    <div class="p-20">
                        <div class="card">
                            <div class="card-body">
                    <form action="{{route('general-settings.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                                @php($site_name = \App\Models\GeneralSetting::where('key', 'site_name')->first())
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Site Name</label>
                                        <input type="text" name="site_name" class="form-control" placeholder="Site Name" value="{{$site_name->value??''}}">
                                    </div>
                                    @php($footer_text = \App\Models\GeneralSetting::where('key', 'footer_text')->first())

                                    <div class="form-group col-md-4">
                                        <label>Footer Text</label>
                                        <input type="text" name="footer_text" class="form-control"  placeholder="Footer Text" value="{{$footer_text->value??''}}">
                                    </div>
                                    @php($footer_link = \App\Models\GeneralSetting::where('key', 'footer_link')->first())

                                    <div class="form-group col-md-4">
                                        <label>Footer Link</label>
                                        <input type="text" class="form-control" name="footer_link" placeholder="Footer Link" value="{{$footer_link->value??''}}">
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="d-flex __gap-12px mt-4">
                                        @php($icon = \App\Models\GeneralSetting::where('key', 'icon')->first())
                                        @php($icon = $icon->value ?? '')
                                        <div class="form-group col-md-4">
                                            <label>Fav Icon</label><span class="text--primary">(1:1)</span>
                                            <label class="text-center position-relative">
                                                <img class="img--133 onerror-image image--border" id="iconViewer" data-onerror-image="{{ asset('assets/images/admin/upload-img.png') }}" src="{{ \App\Helpers\Helper::onerror_image_helper($icon, asset('storage/assets/images/admin/'.$icon), asset('assets/images/admin/upload-img.png'), 'assets/images/admin/') }}" alt="Fav icon" />
                                                <div class="icon-file-group">
                                                    <div class="icon-file">
                                                        <input type="file" name="icon" id="favIconUpload" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                        <i class="tio-edit"></i>
                                                    </div>
                                                    <button class="btn action-btn btn-outline-danger">
                                                        <i class="tio-delete-outlined"></i>
                                                    </button>
                                                </div>
                                            </label>
                                        </div>
                                        @php($logo = \App\Models\GeneralSetting::where('key', 'logo')->first())
                                        @php($logo = $logo->value ?? '')
                                        <div class="form-group col-md-4">
                                            <label>Dashboard Logo</label><span class="text--primary">(3:1)</span>
                                            <label class="text-center position-relative">
                                                <img class="img--vertical onerror-image image--border" id="viewer" data-onerror-image="{{ asset('assets/images/admin/upload-img.png') }}" src="{{ \App\Helpers\Helper::onerror_image_helper($logo, asset('storage/assets/images/admin/'.$logo), asset('assets/images/admin/upload-img.png'), 'assets/images/admin/') }}" alt="logo image" />
                                                <div class="icon-file-group">
                                                    <div class="icon-file">
                                                        <input type="file" name="logo" id="customFileEg1" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                        <i class="tio-edit"></i>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-md-4">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
</form>
                    </div>
                </div>
                @php($config = \App\Models\GeneralSetting::where(['key' => 'mail_config'])->first())
                @php($data = $config ? json_decode($config['value'], true) : null)
                <div class="tab-pane  p-20" id="profile" role="tabpanel">
                    <div class="card">

                        <form class="form-horizontal" action="javascript:" method="post" id="mail-config-form" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="status" value="">
                                <div class="disable-on-turn-of {{isset($data) && isset($data['status'])&&$data['status']==1?'':'inactive'}}">
                                    <div class="row g-3">
                                        <div class="col-sm-12">
                                            <div class="form-group mb-2">
                                                <label for="name" class="form-label">Mailer Name</label><br>
                                                <input id="name" type="text" placeholder="Ex: Alex" class="form-control" name="name" value="{{env('APP_MODE') != 'demo' ? $data['name'] ?? '' : ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label for="host" class="form-label">Host</label><br>
                                                <input id="host" type="text" class="form-control" name="host" placeholder="Ex: smtp" value="{{env('APP_MODE') != 'demo' ? $data['host'] ?? '' : ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label for="driver" class="form-label">Driver</label><br>
                                                <input id="driver" type="text" class="form-control" name="driver" placeholder="Ex : smtp" value="{{env('APP_MODE') != 'demo' ? $data['driver'] ?? '' : ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label for="port" class="form-label">Port</label><br>
                                                <input id="port" type="text" class="form-control" name="port" placeholder=".Ex : 587" value="{{ env('APP_MODE') != 'demo' ? $data['port'] ?? '' : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group mb-2">
                                                <label for="username" class="form-label">User Name</label><br>
                                                <input id="username" type="text" placeholder="Ex: ex@yahoo.com" class="form-control" name="username" value="{{env('APP_MODE') != 'demo' ? $data['username'] ?? '' : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label for="email" class="form-label">Email Id</label><br>
                                                <input id="email" type="email" placeholder="Ex: ex@yahoo.com" class="form-control" name="email" value="{{env('APP_MODE') != 'demo' ? $data['email_id'] ?? '' : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label for="encryption" class="form-label">Encryption</label><br>
                                                <input id="encryption" type="text" placeholder="Ex: tls" class="form-control" name="encryption" value="{{env('APP_MODE') != 'demo' ? $data['encryption'] ?? '' : ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label for="password" class="form-label">Password</label><br>
                                                <input id="password" type="text" class="form-control" name="password" placeholder="Ex : 5+ Characters" value="{{env('APP_MODE') != 'demo' ? $data['password'] ?? '' : ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="btn--container justify-content-end">
                                                <button type="reset" class="btn btn-warning">Reset</button>
                                                <button type="{{env('APP_MODE') != 'demo' ? 'submit' : 'button'}}" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane p-20" id="sendMail" role="tabpanel">
                    <form class="form-horizontal" action="javascript:">
                            <div class="card-body">
                                @csrf
                                    <div class="row g-3">
                                        <div class="col-sm-8">
                                            <div class="form-group mb-2">
                                                <label for="name" class="form-label">Email</label><br>
                                                <input type="email" placeholder="Ex: Alex@yahoo.com" class="form-control" id="test-email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="btn---container justify-content-end">
                                                <button type="submit" class="btn btn-primary send-mail">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                </div>
                <div class="tab-pane p-20" id="sms" role="tabpanel">
                    <form class="form-horizontal" action="javascript:">
                            <div class="card-body">
                                For SMs 
                                </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- Card -->
        <div>
            <div>
                
                                             <!-- Mail Sent -->
    <div class="modal fade" id="sent-mail-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center mb-20">
                        <img src="{{asset('assets/images/admin/save-data.png')}}" alt="" class="mb-20">
                        <h5 class="modal-title">Congratulations! Your SMTP mail has been setup successfully!</h5>
                        <p class="txt">Go to test mail to check that its work perfectly or not!</p>
                    </div>
                    <div class="btn-container justify-content-center">
                        <button class="btn btn-primary min-w-120 sendMail">
                            <img src="{{asset('assets/images/admin/paper-plane.png')}}" alt="">Send Test Mail
</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
                @section('scripts')

                <script src="{{asset('assets/libs/quill/dist/quill.min.js')}}"></script>
                <script src="{{asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
                <script src="{{asset('dist/js/pages/mask/mask.init.js')}}"></script>
                <script src="{{asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
                <script src="{{asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
                <script src="{{asset('assets/libs/jquery-asColor/dist/jquery-asColor.min.js')}}"></script>
                <script src="{{asset('assets/libs/jquery-asGradient/dist/jquery-asGradient.js')}}"></script>
                <script src="{{asset('assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js')}}"></script>
                <script src="{{asset('assets/libs/jquery-minicolors/jquery.minicolors.min.js')}}"></script>
                <script src="{{asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
                <script src="{{asset('assets/libs/quill/dist/quill.min.js')}}"></script>
                <script type="text/javascript">
                    function readURL(input, viewer) {
                        if (input.files && input.files[0]) {
                            let reader = new FileReader();
                            reader.onload = function(e) {
                                $('#' + viewer).attr('src', e.target.result);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $("#customFileEg1").change(function() {
                        readURL(this, 'viewer');
                    });
                    $("#favIconUpload").change(function() {
                        readURL(this, 'iconViewer');
                    });

                    const disableMailConf = () => {
        if($('#mail-config-disable').is(':checked')) {
            $('.disable-on-turn-of').removeClass('inactive')
        }else {
            $('.disable-on-turn-of').addClass('inactive')
            }
        }

        $('#mail-config-disable').on('change', function(){
            disableMailConf()
        })
        $('.sendMail').on('click',function(e){
            e.preventDefault();
            $('#sent-mail-modal').modal('hide');
            $('.nav-link').removeClass('active');
            $('.tab-pane').removeClass('active show');
            $('a[data-toggle="tab"][href="#sendMail"]').addClass('active');
            $('#sendMail').addClass('active show');
        });
        $('#mail-config-form').submit(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('general-settings.mail_config') }}",
                method: 'POST',
                data: $('#mail-config-form').serialize(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function() {
                    toastr.success('configuration_updated_successfully');
                    $('#sent-mail-modal').modal('show');
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        });
        function ValidateEmail(inputText) {
            let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return !!inputText.match(mailformat);
        }

        $(document).on('click', '.send-mail', function () {
            @if(env('APP_MODE') =='demo')
            toastr.info('{{ translate('Update option is disabled for demo!') }}', {
                CloseButton: true,
                ProgressBar: true
            });
            @else

            if (ValidateEmail($('#test-email').val())) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "a Test Mail Will Be Sent To Your Email",
                    showCancelButton: true,
                    confirmButtonColor: '#7460ee',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('general-settings.send') }}",
                            method: 'GET',
                            data: {
                                "email": $('#test-email').val()
                            },
                            beforeSend: function() {
                                $('#loading').show();
                            },
                            success: function(data) {
                                if (data.success === 2) {
                                    toastr.error('Email Configuration Error');
                                } else if (data.success === 1) {
                                    toastr.success('Email Configured Perfectly!');
                                } else {
                                    toastr.info('Email Status is Not Active');
                                }
                            },
                            complete: function() {
                                $('#loading').hide();

                            }
                        });
                    }
                })
            } else {
                toastr.error('invali email address');
            }

            @endif

        });

                </script>
                @endsection
 
