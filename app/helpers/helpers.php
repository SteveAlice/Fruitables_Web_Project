<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\GeneralSetting;
use App\Models\SocialNetwork;
use App\Models\Category;
use App\Models\SubCategory;

// SEND MAIL FUNCTION USING PHPMAILER LIBRARY.

if (!function_exists('sendEmail')) {
    function sendEmail($mailConfig)
    {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();                                            //
        $mail->Host       = env('EMAIL_HOST');                      //
        $mail->SMTPAuth   = true;                                   //
        $mail->Username   = env('EMAIL_USERNAME');                   //
        $mail->Password   = env('EMAIL_PASSWORD');                   //
        $mail->SMTPSecure = env('EMAIL_ENCRYPTION');                 //
        $mail->Port       = env('EMAIL_PORT');                       //
        //Recipients
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($mailConfig['mail_recipient_email'], $mailConfig['mail_recipient_name']);
        $mail->isHTML(true);
        $mail->Subject = $mailConfig['mail_subject'];
        $mail->Body = $mailConfig['mail_body'];
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}

/** GET GENERAL SETTINGS **/
if (!function_exists('get_settings')) {
    function get_settings(){
        $results = null;
        $settings = new GeneralSetting();
        $settings_data = $settings->first();

        if ($settings_data) {
            $results = $settings_data;
        } else {
            $settings->insert([
                'site_name' => 'fruitshop',
                'site_email' => 'quanhs0971@gmail.com'
            ]);
            $new_settings_data = $settings->first();
            $results = $new_settings_data;
        }
        return $results;
    }
}

/** GET SOCIAL NETWORK**/
if(!function_exists('get_social_networks')){
    function get_social_networks(){
        $results =null;
        $social_network = new SocialNetwork();
        $social_network_data = $social_network->first();

        if($social_network_data){
            $results =  $social_network_data;
        }else{
            $social_network->insert([
                'facebook_url' => null,
                'twitter_url'=>null,
                'instagram_url'=>null,
                'youtube_url'=>null,
                'github_url' => null,
                'linkedin_url'=>null
            ]);
            $new_social_network_data = $social_network->first();
            $results = $new_social_network_data;
        }
        return  $results;
    }
}

///FRONTEND::
// GET FRONT END CATEGORIES
if (!function_exists("get_categories") ){
    function get_categories() {   //get_categories được thiết kế để lấy tất cả các danh mục cùng với các danh mục con của chúng từ cơ sở dữ liệu.
        $categories = Category::with('subcategories')->orderBy('ordering','asc')->get();
        return !empty($categories) ? $categories : [];
    }
}
