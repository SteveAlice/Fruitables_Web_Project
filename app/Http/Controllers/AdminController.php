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
use Illuminate\Support\Facades\File;
use App\Models\GeneralSetting;

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

        //xử lý quá trình cập nhật hoặc thêm mới token đặt lại mật khẩu trong cơ sở dữ liệu.
        //đoạn mã này kiểm tra xem có token đặt lại mật khẩu hiện tại cho người dùng đã tồn tại hay chưa.
        $oldToken = DB::table('password_reset_tokens')
            ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
            ->first();

        if ($oldToken) {  //Nếu đã tồn tại, nó sẽ cập nhật token đó với một token mới và thời gian tạo mới nhất.
            //Update token
            DB::table('password_reset_tokens')
                ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else { //Nếu không tồn tại, nó sẽ thêm một bản ghi mới vào bảng để lưu trữ token đặt lại mật khẩu mới cho người dùng.
            //Add new token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }
        //Mã này được sử dụng để chuẩn bị nội dung email để gửi liên kết đặt lại mật khẩu cho người dùng.
        $actionLink = route('admin.reset-password', ['token' => $token, 'email' => $request->email]);  //Tạo liên kết đặt lại mật khẩu

        $data = array(  //Chuẩn bị dữ liệu cho email
            'actionLink' => $actionLink,
            'admin' => $admin
        );

        $mail_body = view('email-templates.admin-forget-email-template', $data)->render(); //Template này sẽ được sử dụng để hiển thị nội dung email, trong đó sẽ chứa liên kết đặt lại mật khẩu và thông tin người dùng.


        $mailConfig = array(
            'mail_from_email' => env('MAIL_FROM_ADDRESS'), // Địa chỉ email người gửi.
            'mail_from_name' => env('MAIL_FROM_NAME'), //Tên người gửi.
            'mail_recipient_email' => $admin->email, //Địa chỉ email người nhận.
            'mail_recipient_name' => $admin->name,   // Tên người nhận.
            'mail_subject' => 'Reset your password',  //Chủ đề của email
            'mail_body' => $mail_body  //Nội dung của email, được render từ một template,  sử dụng hàm view() và truyền vào dữ liệu $data
        );
        // sử dụng session flash để hiển thị thông báo thành công hoặc thất bại cho người dùng sau khi thực hiện hành động gửi email.
        if (sendEmail($mailConfig)) {
            session()->flash('success', 'We have e-mailed your password reset link.');
            return redirect()->route('admin.forgot-password');
        } else {
            session()->flash('fail', 'Something went wrong! Please try again later');
            return redirect()->route('admin.forgot-password');
        }
    }

    public function resetPassword(Request $request, $token = null)
    {
        //tìm kiếm token trong bảng password_reset_tokens theo token và guard (constGuards::ADMIN là hằng số đại diện cho guard của admin).
        // biến $check_token sẽ chứa thông tin về token tương ứng.
        $check_token = DB::table('password_reset_tokens')
            ->where(['token' => $token, 'guard' => constGuards::ADMIN])
            ->first();

        if ($check_token) {
            //Check if token is not expired ||  Kiểm tra nếu token không hết hạn
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)
                ->diffInMinutes(Carbon::now());

            if ($diffMins > constDefaults::tokenExpiredMinutes) {
                //If token is expired ||    Nếu token đã hết hạn
                session()->flash('fail', 'Token expired , request another reset password link.');
                return redirect()->route('admin.forgot-password', ['token' => $token]);
            } else {
                // Nếu token còn hợp lệ, chuyển đến view reset password và truyền token
                return view('back.pages.admin.auth.reset-password')->with(['token' => $token]);
            }
        } else {
            // Nếu không tìm thấy token,  hàm sẽ thông báo lỗi và chuyển hướng người dùng đến trang yêu cầu gửi lại đường liên kết đặt lại mật khẩu.
            session()->flash('fail', 'Invalid token!, request another reset password link!');
            return  redirect()->route('admin.forgot-password', ['token' => $token]);
        }
    }
    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'
        ]);

        //Hàm này tìm kiếm token trong bảng password_reset_token dựa trên token và guard
        $token = DB::table('password_reset_tokens')
            ->where(['token' => $request->token, 'guard' => constGuards::ADMIN])
            ->first();

        //Get admin details  | Dùng email từ token để tìm thông tin admin tương ứng trong bảng admins
        $admin = Admin::where('email', $token->email)->first();

        //Update the new password for this user  |
        Admin::where('email', $admin->email)->update([
            'password' => Hash::make($request->new_password) //Dùng Hash::make để mã hóa mật khẩu mới trước khi lưu vào CSDL
        ]);

        //Delete the token from database to prevent |   Xóa token đã sử dụng để đặt lại mật khẩu
        //khi đã cập nhật mật khẩu thành công, token đã được sử dụng sẽ được xóa khỏi CSDL để đảm bảo không thể sử dụng lại.
        DB::table('password_reset_tokens')->where([
            'email' => $admin->email,
            'token' => $request->token,
            'guard' => constGuards::ADMIN
        ])->delete();

        //Send email to notify admin
        $data = array(
            'admin' => $admin,
            'new_password' => $request->new_password
        );

        $mail_body = view('email-templates.admin-reset-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name'  => env('MAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject'   => 'Password Changed ',
            'mail_body'     => $mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('admin.login')->with('success', 'Done!, Your password has been changed successfully.Use new password to login into system.');

    }
    public function profileView(Request $request){
        $admin =null;
        if(Auth::guard('admin')->check()){
            $admin =Admin::findOrFail(auth()->id());
        }
        return view('back.pages.admin.profile', compact('admin'));
    }
    public function changeProfilePicture(Request $request){
        $admin =Admin::findOrFail(auth('admin')->id());
        $path = 'images/users/admins/';
        $file = $request->file('adminProfilePictureFile');
        $old_picture = $admin->getAttributes()['picture'];
        $file_path = $path.$old_picture;
        $filename = 'ADMIN_IMG_'.rand(2,1000).$admin->id.time().uniqid().'.jpg';

        $upload = $file->move(public_path($path), $filename);

        if($upload){
            if($old_picture != null && File::exists(public_path($path.$old_picture)) ){
                File::delete(public_path($path.$old_picture));
            }
            $admin->update(['picture'=>$filename]);
            return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
        }
    }

    public function changeLogo(Request $request){
        $path = 'images/site/';
        $file = $request->file('site_logo');
        $settings =new GeneralSetting();
        $old_logo = $settings->first()->site_logo;
        $file_path = $path.$old_logo;
        $filename = 'LOGO_'.uniqid().'.'.$file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);
        if($upload){
            if( $old_logo != null && File::exists(public_path($path.$old_logo))) {
                File::delete(public_path($path.$old_logo));
            }
            $settings = $settings->first();
            $settings->site_logo =$filename;
            $update = $settings->save();

            return response()->json(['status' => 1,'msg'=>'Site logo has been updated successfully!']);

        }else{
            return response()->json(['status' => 0,'msg' => 'Something went wrong!']);
        }
    }
}
