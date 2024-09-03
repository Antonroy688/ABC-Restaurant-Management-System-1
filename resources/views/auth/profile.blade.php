@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="midde_cont">
    <div class="container-fluid">
        <!-- row -->
        <div class="row column1">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Profile Information</h2>
                        </div>
                    </div>
                    <div class="full price_table padding_infor_info">
                        <div class="row justify-content-center">
                            <?php  
                                $logoHeader = App\Models\GeneralSetting::where(['key' => 'logo'])->first();
                                $fav_icon = App\Models\GeneralSetting::where(['key' => 'icon'])->first();
                                $logoHeader = $logoHeader->value ?? '';
                                $fav_icon = $fav_icon->value ?? '';
                            ?>
                            <div class="col-lg-12 d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 d-flex justify-content-center mb-3">
                                        <div class="profile_img">
                                            <img width="180" class="rounded-circle" src="{{ \App\Helpers\Helper::onerror_image_helper($logoHeader, asset('storage/assets/images/admin/'.$logoHeader), asset('assets/images/admin/upload-img.png'), 'assets/images/admin/') }}" alt="#" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8 d-flex flex-column justify-content-center">
                                        <div class="profile_contant">
                                            <div class="contact_inner text-center text-md-left">
                                                <h3>{{$user->name}}</h3>
                                                <p><strong>Role: </strong>{{$user->roles->first()->name}}</p>
                                                <ul class="list-unstyled">
                                                    <li><i class="mdi mdi-email"></i> : {{$user->email}}</li>
                                                    <li><i class="mdi mdi-cellphone"></i> : {{--$user->phone--}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <!-- footer -->
    </div>
</div>
@endsection
