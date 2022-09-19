<?php
use App\Models\Footer;
use App\Models\Common;
use App\Models\Roles;
use App\Models\Module;
use App\Models\Action;
use App\Models\Permission;
use App\Models\Admin;

function getFooterData(){
    $footer = Footer::findOrFail(1);
    $quick_links = Common::where('type', 'footer_quick_links') -> select('id', 'content1', 'content2') ->get();
    return (object)['f' => $footer, 'ql' => $quick_links];
}

function getIndustryList() {
    return [
        'Accounting',
        'Airlines/Aviation',
        'Alternative Dispute Resolution',
        'Alternative Medicine',
        'Animation',
        'Apparel & Fashion',
        'Architecture & Planning',
        'Arts and Crafts',
        'Automotive',
        'Aviation & Aerospace',
        'Banking',
        'Biotechnology',
        'Broadcast Media',
        'Building Materials',
        'Business Supplies and Equipment',
        'Capital Markets',
        'Chemicals',
        'Civic & Social Organization',
        'Civil Engineering',
        'Commercial Real Estate',
        'Computer & Network Security',
        'Computer Games',
        'Computer Hardware',
        'Computer Networking',
        'Computer Software',
        'Construction',
        'Consumer Electronics',
        'Consumer Goods',
        'Consumer Services',
        'Cosmetics',
        'Dairy',
        'Defense & Space',
        'Design',
        'Education Management',
        'E-Learning',
        'Electrical & Electronic Manufacturing',
        'Entertainment',
        'Environmental Services',
        'Events Services',
        'Executive Office',
        'Facilities Services',
        'Farming',
        'Financial Services',
        'Fine Art',
        'Fishery',
        'Food & Beverages',
        'Food Production',
        'Fund-Raising',
        'Furniture',
        'Gambling & Casinos',
        'Glass, Ceramics & Concrete',
        'Government Administration',
        'Government Relations',
        'Graphic Design',
        'Health, Wellness and Fitness',
        'Higher Education',
        'Hospital & Health Care',
        'Hospitality',
        'Human Resources',
        'Import and Export',
        'Individual & Family Services',
        'Industrial Automation',
        'Information Services',
        'Information Technology and Services',
        'Insurance',
        'International Affairs',
        'International Trade and Development',
        'Internet',
        'Investment Banking',
        'Investment Management',
        'Judiciary',
        'Law Enforcement',
        'Law Practice',
        'Legal Services',
        'Legislative Office',
        'Leisure, Travel & Tourism',
        'Libraries',
        'Logistics and Supply Chain',
        'Luxury Goods & Jewelry',
        'Machinery',
        'Management Consulting',
        'Maritime',
        'Market Research',
        'Marketing and Advertising',
        'Mechanical or Industrial Engineering',
        'Media Production',
        'Medical Devices',
        'Medical Practice',
        'Mental Health Care',
        'Military',
        'Mining & Metals',
        'Motion Pictures and Film',
        'Museums and Institutions',
        'Music',
        'Nanotechnology',
        'Newspapers',
        'Non-Profit Organization Management',
        'Oil & Energy',
        'Online Media',
        'Outsourcing/Offshoring',
        'Package/Freight Delivery',
        'Packaging and Containers',
        'Paper & Forest Products',
        'Performing Arts',
        'Pharmaceuticals',
        'Philanthropy',
        'Photography',
        'Plastics',
        'Political Organization',
        'Primary/Secondary Education',
        'Printing',
        'Professional Training & Coaching',
        'Program Development',
        'Public Policy',
        'Public Relations and Communications',
        'Public Safety',
        'Publishing',
        'Railroad Manufacture',
        'Ranching',
        'Real Estate',
        'Recreational Facilities and Services',
        'Religious Institutions',
        'Renewables & Environment',
        'Research',
        'Restaurants',
        'Retail',
        'Security and Investigations',
        'Semiconductors',
        'Shipbuilding',
        'Sporting Goods',
        'Sports',
        'Staffing and Recruiting',
        'Supermarkets',
        'Telecommunications',
        'Textiles',
        'Think Tanks',
        'Tobacco',
        'Translation and Localization',
        'Transportation/Trucking/Railroad',
        'Utilities',
        'Venture Capital & Private Equity',
        'Veterinary',
        'Warehousing',
        'Wholesale',
        'Wine and Spirits',
        'Wireless',
        'Writing and Editing',
    ];
}

function getMenu(){
    $path = env('APP_URL').'/admin/';
    return [
        'Users' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'All User',
                                        'url' => $path.'user/',
                                        'slug' => 'user',
                                        'action' => 'index'
                                    ],
                                    [
                                        'name' => 'Add User',
                                        'url' => $path.'user/add',
                                        'slug' => 'user',
                                        'action' => 'create'
                                    ]]
                    ],
        'Role' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'All Role',
                                        'url' => $path.'role/',
                                        'slug' => 'role',
                                        'action' => 'index'
                                    ],
                                    [
                                        'name' => 'Add Role',
                                        'url' => $path.'role/add',
                                        'slug' => 'role',
                                        'action' => 'create'
                                    ]]
                    ],
        'Contact' => [
                        'position' => 0,
                        'icon' => 'la la-book',
                        'url' => $path.'contact/',
                        'slug' => 'contact',
                        'action' => 'index'
                    ],
        'Pages' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'Home Page',
                                        'url' => $path.'homepage/',
                                        'slug' => 'homepage',
                                        'action' => 'index'
                                    ]]
                    ],
        'Template Part' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'Footer',
                                        'url' => $path.'footer/',
                                        'slug' => 'footer',
                                        'action' => 'index'
                                    ]]
                    ],
        'Startup' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'All Startup',
                                        'url' => $path.'startup/',
                                        'slug' => 'startup',
                                        'action' => 'index'
                                    ]]
                    ],
        'Pilots' => [
        'position' => 1,
        'url' => '',
        'icon' => 'la la-book',
        'Module' => [[
                'name' => 'All Pilots',
                'url' => $path.'pilots/',
                'slug' => 'pilots',
                'action' => 'index'
            ]]
            ],
        'Case Studies' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'All Case Studies',
                                        'url' => $path.'case_studies/',
                                        'slug' => 'case_studies',
                                        'action' => 'index'
                                    ],
                                    [
                                        'name' => 'Add Case Studies',
                                        'url' => $path.'case_studies/add',
                                        'slug' => 'case_studies',
                                        'action' => 'create'
                                    ]]
                    ],
        'Knowledge Sharing' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'All Knowledge Sharing',
                                        'url' => $path.'knowledge_sharing/',
                                        'slug' => 'knowledge_sharing',
                                        'action' => 'index'
                                    ],
                                    [
                                        'name' => 'Add Knowledge Sharing',
                                        'url' => $path.'knowledge_sharing/add',
                                        'slug' => 'knowledge_sharing',
                                        'action' => 'create'
                                    ]]
                    ],
        'Event' => [
                        'position' => 1,
                        'url' => '',
                        'icon' => 'la la-book',
                        'Module' => [[
                                        'name' => 'All Event',
                                        'url' => $path.'event/',
                                        'slug' => 'event',
                                        'action' => 'index'
                                    ],
                                    [
                                        'name' => 'Add Event',
                                        'url' => $path.'event/add',
                                        'slug' => 'event',
                                        'action' => 'create'
                                    ]]
                    ],
        'Season' => [
            'position' => 1,
            'url' => '',
            'icon' => 'la la-book',
            'Module' => [[
                            'name' => 'Season',
                            'url' => $path.'season/',
                            'slug' => 'season',
                            'action' => 'index'
                        ]]
        ]

    ];
}

function getPrivilege($m, $a, $r){
    // return true;
    $permission = Permission::whereHas('modules', function($query) use($m){
        $query -> where('slug', $m);
    })
    -> whereHas('actions', function($query) use($a){
            $query -> where('slug', $a);
        })
    -> where('role_id', $r) -> first();
    return $permission;
}

function getUserRole() {
    $role = Admin::where("id", session('user')->id) -> select('id', 'role_id')
    ->with([
        'roles' => function($query){
            $query -> select('id', 'slug');
        }
    ])
    ->get()->first();
    if($role->roles->slug === 'superadmin') return 'superadmin';
    else if($role -> roles && $role -> roles -> slug) return $role->roles->id;
    else return false;
}

// function startupRegistered(){
//     $stratup_registered = Startup::where('is_active', '1'); 
// }

// function startupApproved(){
//     $stratup_approved = Startup::where([['is_active', '1'], ['request', '1']]);
// }

// function startupRejected(){
//     $stratup_rejected = Startup::where([['is_active', '1'], ['request', '2']]);
// }

// function startupPending(){
//     $stratup_pending = Startup::where([['is_active', '1'], ['request', '0']]);
// }
// function startupRecent(){
//     $today = date("Y-m-d");
//     $stratup_recent = Startup::where('is_active', '1') -> whereDate('created_at', $today) -> select('company_name', 'id', 'state') -> get();   
// }