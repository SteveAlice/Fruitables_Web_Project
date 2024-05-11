<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Seller;
use App\Models\Shop;
use App\Models\VerificationToken;
use Illuminate\Support\Facades\DB;
use constGuards;
use constDefaults;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\File;
use Mberecall\Kropify\Kropify;

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
                $seller->email_verified_at = Carbon::now();
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
            if (!auth('seller')->user()->verified) {
                auth('seller')->logout();
                return redirect()->route('seller.login')->with('fail', 'Your account is not verified.
                Check in your email and click on the link we had sent in order to verify your email for seller account.');
            } else {
                return redirect()->route('seller.home');
            }
        } else {
            return redirect()->route('seller.login')->withInput()->with('fail', 'Incorrect password.'); // Nếu đăng nhập không thành công, chuyển hướng trở lại trang đăng nhập với thông báo lỗi và giữ nguyên dữ liệu đã nhập
        }
    }
    public function logoutHandler(Request $request)
    {
        Auth::guard('seller')->logout();
        return redirect()->route('seller.login')->with('fail', 'You are logged out!');
    }
    public function forgotPassword(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot Password'
        ];
        return view('back.pages.seller.auth.forgot', $data);
    }
    public function sendPasswordResetLink(Request $request)
    {
        // Validate email input | Kiểm tra tính hợp lệ của địa chỉ email
        $request->validate([
            'email' => 'required|email|exists:sellers,email',
        ], [
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'The :attribute is not exists in our system.'
        ]);

        // Get seller details by email | Lấy thông tin của người bán dựa trên địa chỉ email
        $seller = Seller::where('email', $request->email)->first();

        // Generate a random token | Tạo một token ngẫu nhiên
        $token = base64_encode(Str::random(64));

        // Check if there is an existing token for the seller | Kiểm tra xem đã tồn tại token cho người bán hay chưa
        $oldToken = DB::table('password_reset_tokens')
            ->where(['email' => $seller->email, 'guard' => constGuards::SELLER])
            ->first();

        // Update or insert new reset password token | Cập nhật hoặc thêm mới token để đặt lại mật khẩu
        if ($oldToken) {
            DB::table('password_reset_tokens')
                ->where(['email' => $seller->email, 'guard' => constGuards::SELLER])
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            DB::table('password_reset_tokens')
                ->insert([
                    'email' => $seller->email,
                    'guard' => constGuards::SELLER,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        }

        // Generate the action link for password reset | Tạo liên kết hành động để đặt lại mật khẩu
        $actionLink = route('seller.reset-password', ['token' => $token, 'email' => urldecode($seller->email)]);

        // Prepare data for email template | Chuẩn bị dữ liệu cho mẫu email
        $data['actionLink'] = $actionLink;
        $data['seller'] = $seller;

        // Render email template | Render mẫu email
        $mail_body = view('email-templates.seller-forgot-email-template', $data)->render();

        // Prepare email configuration | Chuẩn bị cấu hình email
        $mailConfig = array(
            'mail_form_email' => env('MAIL_FROM_ADDRESS'),
            'mail_form_name' => env('MAIL_FROM_NAME'),
            'mail_recipient_email' => $seller->email,
            'mail_recipient_name' => $seller->name,
            'mail_subject' => 'Reset password',
            'mail_body' => $mail_body
        );

        // Send email with password reset link | Gửi email với liên kết đặt lại mật khẩu
        if (sendEmail($mailConfig)) {
            return redirect()->route('seller.forgot-password')->with('success', 'We have e-mailed your password reset link.');
        } else {
            return redirect()->route('seller.forgot-password')->with('fail', 'Something went wrong.');
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        //Check if token is not expired  | // Kiểm tra xem token có tồn tại không
        // Tìm token trong cơ sở dữ liệu
        $get_token = DB::table('password_reset_tokens')
            ->where(['token' => $token, 'guard' => constGuards::SELLER])
            ->first();

        // Kiểm tra xem token có tồn tại và hợp lệ không
        if ($get_token) {
            //  Tính thời gian chênh lệch giữa thời điểm tạo token và thời điểm hiện tại
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $get_token->created_at)
                ->diffInMinutes(Carbon::now());

            // Kiểm tra xem token đã hết hạn chưa
            if ($diffMins > constDefaults::tokenExpiredMinutes) {
                // Kiểm tra xem token đã hết hạn chưa
                return redirect()->route('seller.forgot-password', ['token' => $token])
                    ->with('fail', 'Token expired!. Request another reset password link.');
            } else {
                // Nếu token hợp lệ, hiển thị trang đặt lại mật khẩu
                return view('back.pages.seller.auth.reset')->with(['token' => $token]);
            }
        } else {
            // Nếu không tìm thấy token trong cơ sở dữ liệu, chuyển hướng đến trang quên mật khẩu với thông báo lỗi
            return redirect()->route('seller.forgot-password', ['token' => $token])->with('fail', 'Invalid token, request another reset password link.');
        }
    }
    public function resetPasswordHandler(Request $request)
    {
        // Validate form data | Xác minh dữ liệu đầy đủ của biểu mẫu
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:confirm_new_password|same:confirm_new_password',
            'confirm_new_password' => 'required'
        ]);

        $token = DB::table('password_reset_tokens')
            ->where(['token' => $request->token, 'guard' => constGuards::SELLER])
            ->first();

        // Find seller by email | Tìm người bán theo email
        $seller = Seller::where('email', $token->email)->first();

        // Update seller's password | Cập nhật mật khẩu của người bán
        Seller::where('email', $seller->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Delete password reset token | Xóa token đặt lại mật khẩu
        DB::table('password_reset_tokens')->where([
            'email' => $seller->email,
            'token' => $request->token,
            'guard' => constGuards::SELLER
        ])->delete();

        // Prepare data for email template | Chuẩn bị dữ liệu cho mẫu email
        $data['seller'] = $seller;
        $data['new_password'] = $request->new_password;

        // Render email body | Hiển thị nội dung email
        $mail_body = view('email-templates.seller-reset-email-template', $data);

        // Prepare email configuration | Chuẩn bị cấu hình email
        $mailConfig = array(
            'mail_form_email' => env('MAIL_FROM_ADDRESS'),
            'mail_form_name' => env('MAIL_FROM_NAME'),
            'mail_recipient_email' => $seller->email,
            'mail_recipient_name' => $seller->name,
            'mail_subject' => 'Password Changed',
            'mail_body' => $mail_body
        );

        // Send email with password reset confirmation | Gửi email xác nhận việc đặt lại mật khẩu
        sendEmail($mailConfig);

        // Redirect to seller login page with success message | Chuyển hướng đến trang đăng nhập của người bán với thông báo thành công
        return redirect()->route('seller.login')->with('success', 'Done! Your password has been changed. Use the new password to log in to the system.');
    }

    public function profileView(Request $request)
    {
        $data = [
            'pageTitle' => 'Profile'
        ];
        return view('back.pages.seller.profile', $data);
    }
    public function changeProfilePicture(Request $request)
    {
        $seller = Seller::findOrFail(auth('seller')->id()); // Lấy thông tin của người bán hàng đang đăng nhập
        $path = 'images/users/sellers/';    
        $file = $request->file('sellerProfilePictureFile'); // Lấy file ảnh từ request
        $old_picture = $seller->getAttributes()['picture']; // Lấy tên file ảnh cũ
        $filename = 'SELLER_IMG_' . $seller->id . '.jpg'; // Tạo tên file mới dựa trên id của người bán hàng

        // Tiến hành tải lên và xử lý ảnh với Kropify
        $upload = Kropify::getFile($file, $filename)->maxWoH(325)->save($path);
        $infos = $upload->getInfo();

        if ($upload) { // Nếu quá trình tải lên thành công
            // Xóa ảnh cũ nếu có
            if ($old_picture != null && File::exists(public_path($path . $old_picture))) {
                File::delete(public_path($path . $old_picture));
            }

            // Cập nhật tên ảnh mới vào thông tin của người bán hàng
            $seller->update(['picture' => $infos->getName]);

            // Trả về thông báo thành công
            return response()->json(['status' => 1, 'msg' => 'Your profile picture has been succesfully updated.']);
        } else { // Nếu có lỗi xảy ra, trả về thông báo lỗi
            return response()->json(['status' => 0, 'msg' => 'Something went wrong!']);
        }
    }

    public function shopSettings(Request $request){
        $seller =Seller::findOrFail(auth('seller')->id());
        $shop = Shop::where('seller_id',$seller->id)->first();
        $shopInfo = '';

        if(!$shop){

            Shop::create(['seller_id'=>$seller->id]);
            $nshop = Shop::where('seller_id',$seller->id)->first();
            $shopInfo = $nshop;
        }else{
            $shopInfo = $shop;
        }

        $data = [
            'pageTitle' => 'Shop Settings',
            'shopInfo' => $shopInfo
        ];

        return view('back.pages.seller.shop-settings', $data);
    }

    public function shopSetup(Request $request){
        $seller = Seller::findOrFail(auth('seller')->id());
        $shop = Shop::where('seller_id',$seller->id)->first();
        $old_logo_name = $shop->shop_logo;
        $logo_name = '';
        $path = 'images/shop/';

        //Validate
        $request->validate([
            'shop_name' => 'required|unique:shops,shop_name,'.$shop->id,
            'shop_phone' => 'required|numeric',
            'shop_address' => 'required',
            'shop_description' => 'required',
            'shop_logo' => 'nullable|mimes:jpeg,png'
        ]);

        if($request->hasFile('shop_logo')){
            $file = $request->file('shop_logo');
            $filename ='SHOPLOGO_'.$seller->id.uniqid().'.'.$file->getClientOriginalExtension();

            $upload = $file->move(public_path($path), $filename);
            if($upload){
                $logo_name = $filename;
                //Delete
                if($old_logo_name != null && File::exists(public_path($path.$old_logo_name)) ){
                    File::delete(public_path($path.$old_logo_name));
                }
            }
        }

        $data = array(
            'shop_name'=>$request->shop_name,
            'shop_phone'=>$request->shop_phone,
            'shop_address' => $request->shop_address,
            'shop_description' => $request->shop_description,
            'shop_logo' => $logo_name != null ? $logo_name : $old_logo_name
        );
        $update = $shop->update($data);

        if($update){
            return redirect()->route('seller.shop-settings')->with('success','Your shop info have been updated.');
        }else{
            return redirect()->route('seller.shop-settings')->with('fail','Error on updating your shop info.');
        }
    }
}
