<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email=array(
            array(
            'id' => 1,
            'mail_key' => 'FORGOT_PASSWORD',
            'user_type' => 'all',
            'language_id' => '1',
            'title' => 'FORGOT PASSWORD link for admin user',
            'from_name' => 'CaltechTeam',
            'from_email' => 'info@mypcot.com',
            'to_name' => '',
            'cc_email' => '',
            'subject' => 'Forgot Password Notification - Caltech Team',
            'label' => 'Caltech admin registration',
            'content' => '<p><span [removed]=\\\"font-weight: bold;\\\">Hi $$admin_name$$,</span></p><p><span [removed]=\\\"font-weight: bold;\\\">You have recently requested a forgot password link. We\\\'ve received the request and your password request link has been processed.</span></p><p><span [removed]=\\\"font-weight: bold;\\\">Your reset password link is : <a href=$$url$$ tab=\"_new\">Click Here</a><br></span></p><p><span [removed]=\\\"font-weight: bold;\\\">Kindly click on the above link to reset your password.</span></p><br/><p><span [removed]=\\\"font-weight: bold;\\\">Thanks,</span></p><p><span [removed]=\\\"\\\" bold;\\\"=\\\"\\\">$$from_name$$</span></p>',
            'trigger' => 'batch',
            'status' => '1',
            'created_by' => '0',
            'updated_by' => '0',
            'created_at' => '2022-09-12 20:20:07',
            'updated_at' => '2022-12-15 07:25:20',
            ),

            array(
            'id' => 2,
            'mail_key' => 'SHARE_CERTIFICATE',
            'user_type' => 'all',
            'language_id' => '1',
            'title' => 'Share Certificate Link For Client',
            'from_name' => 'CaltechTeam',
            'from_email' => 'info@mypcot.com',
            'to_name' => '',
            'cc_email' => 'mohammed.s@mypcot.com',
            'subject' => 'Caltech - Certificate $$certificate_id$$',
            'label' => 'Share Certificate',
            'content' => '<p><span [removed]=\\\"font-weight: bold;\\\">Hi $$company_name$$,</span></p><p><span [removed]=\\\"font-weight: bold;\\\">A Certificate Share Has Been Initiated. We\\\'ve received the request and your Certificate Link Has Been Generated.</span></p><p><span [removed]=\\\"font-weight: bold;\\\">Your Certificate Link Is : <a href=$$url$$ tab=\"_new\">Click Here</a><br></span></p><p><span [removed]=\\\"font-weight: bold;\\\">Kindly click on the above link to view your certificate.</span></p><br/><p><span [removed]=\\\"font-weight: bold;\\\">Thanks,</span></p><p><span [removed]=\\\"\\\" bold;\\\"=\\\"\\\">$$from_name$$</span></p>',
            'trigger' => 'batch',
            'status' => '1',
            'created_by' => '0',
            'updated_by' => '0',
            'created_at' => '2022-12-29 13:26:00',
            'updated_at' => '2023-01-03 05:33:10',
            ),

        );

        foreach($email as $notification){
        DB::table('email_notifications')->insert($notification);
        }
    }
}
