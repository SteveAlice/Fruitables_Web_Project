<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use constGuards;
use constDefaults;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:admins,email',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or Username is required! Please enter your email or username.',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => "Email is not exists in system! ",
                'password.required' => 'Password is required! Please enter your password.'
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:admins,username',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or Username is required. ',
                'login_id.exists' => "Username is not exists in system.",
                'password.required' => 'Password is required! '
            ]);
        }
        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );

        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('admin.home');
        } else {
            session()->flash('fail', 'Incorrect credentials please try again');
            return redirect()->route('admin.login');
        }
    }
    public function logoutHandler(Request $request)
    {
        Auth::guard('admin')->logout();
        session()->flash('fail', 'You are logged out!');
        return redirect()->route('admin.login');
    }
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ], [
            'email.required' => 'The :attribute is required!',
            'email.email' => 'This is a invalid Email Address!',
            'email.exists' => 'The :attribute is not exits in system'
        ]);


        //Get admin details  | Lấy chi tiết của admin từ email      //first() trả về bản ghi đầu tiên tìm thấy hoặc null nếu không tìm thấy bản ghi nào.
        $admin = Admin::where('email', $request->email)->first();   //sử dụng để tìm kiếm thông tin của admin dựa trên địa chỉ email ,tìm kiếm bản ghi trong bảng Admin mà có trường email khớp với giá trị được cung cấp.

        //Generate token | Tạo token ngẫu nhiên dưới dạng chuỗi base64
        $token = base64_encode(Str::random(64));

        //
        $oldToken = DB::table('password_reset_tokens')
            ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
            ->first();

        if($oldToken){
            //Update token
            DB::table('password_reset_tokens')
            ->where(['email'=> $request->email,'guard'=>constGuards::ADMIN])
            ->update([
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }else{
            //Add new token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        $actionLink = route('admin.reset-password',['token' =>$token,'email' =>$request->email]);

        $data = array(
            'actionLink' => $actionLink,
            'admin' => $admin
        );

        $mail_body = view('email-templates.admin-forget-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mail_recipient_email' =>$admin->email,
            'mail_recipient_name' =>$admin->name,
            'mail_subject' => 'Reset your password',
            'mail_body' => $mail_body
        );

        if( sendEmail($mailConfig)){
            session()->flash('success', 'We have e-mailed your password reset link.');
            return redirect()->route('admin.forgot-password');
        }else{
            session()->flash('fail','Something went wrong! Please try again later');
            return redirect()->route('admin.forgot-password');
        }
    }
}
