<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
        HomePage
        =============== */
        DB::table('homepage')->insert([
            'banner_title' => 'ACMA Auto & Mobility',
            'banner_caption1' => 'START-UP',
            'banner_caption2' => 'Connect Initiative',
            'banner_subtitle' => 'Driving Innovation in the automotive industry',
            'banner_button' => 'Register Now',
            'banner_button_action' => 'https://startup.acma.in/auth',
            's1_count1' => '10',
            's1_count2' => '15',
            's1_count3' => '20',
            's1_count4' => '8',
            's1_heading1' => 'months of interactive innovation programs',
            's1_heading2' => 'shortlisted startups learn from the Industry’s top companies',
            's1_heading3' => 'hours of knowledge sessions and workshops',
            's1_heading4' => 'startups get shortlisted for the Investment track',
            's2_heading' => 'About the Initiative',
            's2_title' => 'Driving Innovation in the automotive industry',
            's2_description' => 'Description....',
            'event_title' => 'Upcomming Events',
            'event_subtitle' => 'List of Planned Events',
            'case_study_title' => 'Case Study',
            'case_study_subtitle' => 'We Deliver Solutions with the Goal of Trusting Workshops',
            's3_heading' => 'Get in touch',
            's3_title' => "Have any questions? We'd love to hear from you.",
            's3_description' => 'If you have any questions or comments, please use the form below and we will get back to you as soon as possible.',
            's3_email' => 'Test@gmail.com',
            's3_contact_heading' => 'Connect',
            's3_contact_subheading' => "We ‘ll be in touch as soon as possible",
        ]);

        /*
        Footer
        =============== */
        DB::table('footer')->insert([
            'description' => "An ISO 9001:2015 Certified Association, ACMA is an apex body representing the interest of the Indian Auto Component Industry. ACMA membership of over 850 manufacturers contributes to more than 85% of the auto component industry’s turnover in the organised sector.",
            'quick_link_title' => 'Quick Links',
            'copyright_title' => "© 2020 ACMA, India. All Rights Registered. Powered by WeBeeSocial",
            'fb' => 'https://www.facebook.com/india.acma/',
            'twitter' => 'https://twitter.com/acmaindia',
            'linkedin' => 'https://www.linkedin.com/company/13205120/admin/',
            'youtube' => 'https://www.youtube.com/channel/UC5V8yPT716hyH01C1qBXXoQ'
        ]);

        /*
        Pilot companies
        =============== */
        $pilotCompanies = [
            "Webeesocial" => [
                ["name" => 'Anku Pathak', "designation" => 'Tester', 'email' => 'anku.pathak@webeesocial.com', 'password' => 'test'],
                ["name" => 'Dheeraj Pathak', "designation" => 'Tester', 'email' => 'dheeraj@gmail.com', 'password' => 'test']
            ],
            "Acma" => [
                ["name" => 'Acma 1', "designation" => 'Tester', 'email' => 'ankupathak004@gmail.com', 'password' => 'test'],
                ["name" => 'Acma 2', "designation" => 'Tester', 'email' => 'acma2@gmail.com', 'password' => 'test']
            ],
            "ADO" => [
                ["name" => 'ADO 1', "designation" => 'Tester', 'email' => '8882589947anku@gmail.com', 'password' => 'test'],
                ["name" => 'ADO 2', "designation" => 'Tester', 'email' => 'ado2@gmail.com', 'password' => 'test']
            ],
            "SandT" => [
                ["name" => 'ST 1', "designation" => 'Tester', 'email' => 'st1@gmail.com', 'password' => 'test'],
                ["name" => 'ST 2', "designation" => 'Tester', 'email' => 'st2@gmail.com', 'password' => 'test']
            ]
        ];

        foreach($pilotCompanies as $company => $companyMember):
            $pilot_companies_id = DB::table('pilot_companies')->insertGetId([
                'name' => $company,
                'added_by' => '1',
                'updated_by' => "1",
            ]);
            
            foreach($companyMember as $value):
                /*
                Pilot companies Member
                ====================== */
                DB::table('pilot_companies_member')->insert([
                    'pilot_companies_id' => $pilot_companies_id,
                    'name' => $value['name'],
                    'designation' => $value['designation'],
                    'email' => $value['email'],
                    'password' => $value['password']
                ]);
            endforeach;
        endforeach;
    }
}
