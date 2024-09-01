<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\GeneralSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:Users Delete')->only('destroy');
        $this->middleware('permission:Users Edit')->only(['edit','update']);
        $this->middleware('permission:Users View')->only('index');
        $this->middleware('permission:Users Create')->only('store');
    }

    public function index(Request $request)
    {
            return view('admin.general-settings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('general_settings')->updateOrInsert(['key' => 'site_name'], [
            'value' => $request->site_name
        ]);
        $curr_logo = GeneralSetting::where(['key' => 'logo'])->first();
        if ($request->has('logo')) {
            $image_name = Helper::update('assets/images/admin/', $curr_logo['value'], 'png', $request->file('logo'));
        } else {
            $image_name = $curr_logo['value'];
        }
        DB::table('general_settings')->updateOrInsert(['key' => 'logo'], [
            'value' => $image_name
        ]);
        $fav_icon = GeneralSetting::where(['key' => 'icon'])->first();
        if ($request->has('icon')) {
            $image_name =Helper::update('assets/images/admin/', $fav_icon->value, 'png', $request->file('icon'));
        } else {
            $image_name = $fav_icon['value'];
        }
        DB::table('general_settings')->updateOrInsert(['key' => 'icon'], [
            'value' => $image_name
        ]);
        // DB::table('general_settings')->updateOrInsert(['key' => 'email_address'], [
        //     'value' => $request->email
        // ]);
        DB::table('general_settings')->updateOrInsert(['key' => 'footer_link'], [
            'value' => $request->footer_link
        ]);
        DB::table('general_settings')->updateOrInsert(['key' => 'footer_text'], [
            'value' => $request->footer_text
        ]);
        Toastr::success('GeneralSetting updated Successfully', 'Success!!');
        activity()
        ->causedBy(Auth::user())
        ->performedOn(Auth::user())
        ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
        ->log('GeneralSetting updated.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function mail_config(Request $request)
    {
        if (env('APP_MODE') == 'demo') {
            Toastr::info('messages.update_option_is_disable_for_demo');
            return back();
        }
        GeneralSetting::updateOrInsert(
            ['key' => 'mail_config'],
            [
                'value' => json_encode([
                    "status" => $request['status'] ?? 0,
                    "name" => $request['name'],
                    "host" => $request['host'],
                    "driver" => $request['driver'],
                    "port" => $request['port'],
                    "username" => $request['username'],
                    "email_id" => $request['email'],
                    "encryption" => $request['encryption'],
                    "password" => $request['password']
                ]),
                'updated_at' => now()
            ]
        );
        Toastr::success('Mail Config Updated Successfully');
        activity()
        ->causedBy(Auth::user())
        ->performedOn(Auth::user())
        ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
        ->log('Mail Config Updated.');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    //Send Mail
    public function send_mail(Request $request)
    {
        if (env('APP_MODE') == 'demo') {
            Toastr::info('update_option_is_disable_for_demo');
            return back();
        }
        $email=$request->email;
        $response_flag = 0;
        try {
            Mail::to($request->email)->send(new \App\Mail\TestEmailSender());
            $response_flag = 1;
        } catch (\Exception $exception) {
            info($exception->getMessage());
            $response_flag = 2;
        }
        activity()
        ->causedBy(Auth::user())
        ->performedOn(Auth::user())
        ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
        ->log($email.' '.$response_flag==2?'Test mail Send Failed.':'Test mail Send Successfully.');
        return response()->json(['success' => $response_flag]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
