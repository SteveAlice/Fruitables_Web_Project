<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Seller;
use App\Models\VerificationToken;

class SellerController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            'pageTitle' => 'Seller login'
        ];
        return view('back.pages.seller.auth.login');
    }
    public function register(Request $request)
    {
        $data = [
            'pageTitle' => 'Create Seller Account',
        ];
        return view('back.pages.seller.auth.register', $data);
    }
    public function home(Request $request)
    {
        $data = [
            'pageTitle' => 'Seller Dashboard'
        ];
        return view('back.pages.seller.home', $data);
    }
    public function createSeller(Request $request)
    {
        //Validate Seller Registration Form | Kiểm tra hợp lệ thông tin đăng ký người bán
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:sellers',
            'password' => 'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:5'
        ]);
        // Create a new instance of Seller model | Tạo một thể hiện mới của model Seller
        $seller = new Seller();
        // Assign values from request to model attributes | Gán các giá trị từ request vào các thuộc tính của model
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->password = Hash::make($request->password);
        // Save seller data to database | Lưu dữ liệu người bán vào cơ sở dữ liệu
        $saved = $seller->save();

        if ($saved) {
            //Generate Verification Token and Save to the database | Tạo và lưu token xác minh vào cơ sở dữ liệu
            $token = base64_encode(Str::random(64));

            VerificationToken::create([
                'user_type' => 'seller',
                'email' => $request->email,
                'token' => $token
            ]);

            // Generate action link for verification | Tạo liên kết hành động cho việc xác minh
            $actionLink = route('seller.verify', ['token' => $token]);
            // Pass data to email template | Chuyển dữ liệu vào mẫu email
            $data['action_link'] = $actionLink;
            $data['seller_name'] = $request->name;
            $data['seller_email'] = $request->email;

            //Send Activation Link | Gửi liên kết kích hoạt
            $mail_body = view('email-templates.seller-verify-template', $data)->render();

            $mailConfig = array(
                'mail_from_email' => env('MAIL_FROM_ADDRESS'),
                'mail_from_name' => env('MAIL_FROM_NAME'),
                'mail_recipient_email' => $request->email,
                'mail_recipient_name' => $request->name,
                'mail_subject' => 'Verify Seller Account',
                'mail_body' => $mail_body
            );
            // Send email with verification link | Gửi email với liên kết xác minh
            if (sendEmail($mailConfig)) {
                return redirect()->route('seller.register-success');
            } else {
                return redirect()->route('seller.register')->with('fail', 'Some thing went wrong while sending verification link');
            }
        } else {
            return redirect()->route('seller.register')->with('fail', 'Something went wrong!');
        }
    }

    public function verifyAccount(Request $request, $token)
    {
        $verifyToken = VerificationToken::where('token', $token)->first();

        if (!is_null($verifyToken)) {
            $seller = Seller::where('email', $verifyToken->email)->first();

            if (!$seller->verified) {
                $seller->verified = 1;
                $seller->email_verified_at =Carbon::now();
                $seller->save();

                return redirect()->route('seller.login')->with('success', 'Good!, your e-mail is verified. Login with your credentials and complete setup your seller account.');
            } else {
                return redirect()->route('seller.login')->with('info', 'Your e-mail is already verified. You can now login.');
            }
        } else {
            return redirect()->route('seller.register')->with('fail', 'Invalid Token.');
        }
    }

    public function registerSuccess(Request $request)
    {
        return view('back.pages.seller.register-success');
    }

    //Login Seller
    public function loginHandler(Request $request)
    {
        $filedType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($filedType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:sellers,email',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or Username is required',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'Email is not exists in system.',
                'password.required' => 'Password is required'
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:sellers,username',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or Username is required',
                'login_id.exists' => 'Username is not exists in system.',
                'password.required' => 'Password is required'
            ]);
        }

        // Tạo một mảng chứa thông tin đăng nhập
        $creds = array(
            $filedType => $request->login_id, // Tên trường có thể là 'email' hoặc 'username' tùy thuộc vào loại đăng nhập được chọn
            'password' => $request->password // Mật khẩu được nhập từ form
        );

        // Thử đăng nhập bằng Guard 'seller' của Laravel
        if (Auth::guard('seller')->attempt($creds)) { // Thử đăng nhập với thông tin đăng nhập được cung cấp
            // return redirect()->route('seller.home'); // Nếu đăng nhập thành công, chuyển hướng đến trang chính của người bán
            if(!auth('seller')->user()->verified){
                auth('seller')->logout();
                return redirect()->route('seller.login')->with('fail','Your account is not verified.
                Check in your email and click on the link we had sent in order to verify your email for seller account.');
            }else{
                return redirect()->route('seller.home');
            }
        } else {
            return redirect()->route('seller.login')->withInput()->with('fail', 'Incorrect password.'); // Nếu đăng nhập không thành công, chuyển hướng trở lại trang đăng nhập với thông báo lỗi và giữ nguyên dữ liệu đã nhập
        }
    }
    public function logoutHandler(Request $request){
        Auth::guard('seller')->logout();
        return redirect()->route('seller.login')->with('fail','You are logged out!');
    }
}
