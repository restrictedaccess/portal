{if $smarty.server.REQUEST_URI == "/"}
    <!-- Google Adwords Code for Remotestaff.com.au - Leads -->
    <meta name="google-site-verification" content="pFwgC_ROSWz4vRknFzyDk4A5Xg1qsttXmYBlvFdQzbc" />
{/if}

{strip}
    <input type="hidden" id="contact_numbers_desktop" value="{$contact_numbers.aus_header_number}">
    <nav id="header_v2" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed mobile-header" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="img-responsive cta_tracker_btn" href="/aboutus.php#corevalues"><img src="/remotestaff_2015/img/rs-fb-header.png" alt="logo" class="img-rounded logo-header"></a>
                <div>
                    <p>
                        Relationships you can rely on from the Philippines
                    </p>
                </div>
            </div>

            <div id="navbar" class="navbar-collapse collapse nav-top">
                <ul class="nav navbar-nav nav-list-menu">
                    <li>
                        <a id="navigation_home_header_button_desktop" href="/" class="header-toggle cta_tracker_btn" aria-haspopup="true" aria-expanded="false">Home<i class="fa fa-caret-down header-caret" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu header-dropdown">
                            <li class="bg-gray"><a id="navigation_home_popular_roles_header_button_desktop" class="cta_tracker_btn" href="/#browse-popular-roles">Popular Roles</a></li>
                            <li><a id="navigation_home_support_structures_ensure_success_header_button_desktop" class="cta_tracker_btn" href="/#range-support">Support Structures To Ensure Your Success</a></li>
                            <li class="bg-gray"><a id="navigation_home_why_partner_with_us_header_button_desktop" class="cta_tracker_btn" href="/#why-partner">Why Partner With Us</a></li>
                            <li><a id="navidation_home_staffing_solutions_header_button_desktop" class="cta_tracker_btn" href="/#staffing-solutions">Staffing Solutions</a></li>
                        </ul>
                    </li>
                    <li>
                        <a id="navigation_candidates_header_button_desktop" href="/asl/candidates/" class="header-toggle cta_tracker_btn" aria-haspopup="true" aria-expanded="false">Candidates<i class="fa fa-caret-down header-caret" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu header-dropdown">
                            <li class="bg-gray"><a id="navigation_candidates_view_candidates_header_button_desktop" class="cta_tracker_btn" href="/asl/candidates/#view-candidates">View Candidates</a></li>
                            <li><a id="navigation_candidates_roles_header_button_desktop" class="cta_tracker_btn" href="/asl/candidates/#asl-roles">Roles</a></li>
                            <li class="bg-gray"><a id="navigation_candidates_advanced_search_button_desktop" class="cta_tracker_btn" href="/asl/candidates/#advanced-search">Advanced Search</a></li>
                            <li><a id="navigation_candidates_tell_us_what_you_need_button_desktop" class="cta_tracker_btn" href="/portal/link_form/job_specification_form.php#">Tell Us What You Need</a></li>
                            <li class="bg-gray"><a id="navigation_candidates_request_skills_assessment_button_desktop" class="cta_tracker_btn" href="/about/skill_assessment.php#skill-assessment-m">Request A Skills Test Assessment</a></li>
                            <li><a id="navigation_candidates_request_trial_candidate_button_desktop" class="cta_tracker_btn" href="#" data-toggle="modal" data-target="#modal-leads-form">Request To Trial A Candidate</a></li>
                            <li class="bg-gray"><a id="navigation_candidates_contact_our_recruiters_button_desktop" class="cta_tracker_btn" href="#" data-toggle="modal" data-target="#modal-leads-form">Contact Our Recruiters</a></li>
                        </ul>
                    </li>

                    <li>
                        <a id="navigation_how_it_works_header_button_desktop" href="/client-services.php" class="header-toggle cta_tracker_btn">How It Works</a>
                        {*<ul class="dropdown-menu header-dropdown">*}
                            {*<li class="bg-gray"><a id="navigation_how_it_works_four_step_process_header_button_desktop" class="cta_tracker_btn" href="/client-services.php#four-step-process">Our 4 Step Process</a></li>*}
                            {*<li><a id="navigation_how_it_works_how_we_recruit_header_button_desktop" class="cta_tracker_btn" href="/client-services.php#how-we-recruit">How We Recruit</a></li>*}
                            {*<li class="bg-gray"><a id="navigation_how_it_works_our_technology_header_button_desktop" class="cta_tracker_btn" href="/client-services.php#our-technology">Our Technology</a></li>*}
                            {*<li><a id="navigation_how_it_works_your_account_manager_header_button_desktop" class="cta_tracker_btn" href="/client-services.php#account-manager">Your Account Manager</a></li>*}
                            {*<li class="bg-gray"><a id="navigation_how_it_works_payroll_header_button_desktop" class="cta_tracker_btn" href="/client-services.php#payroll">Payroll</a></li>*}
                            {*<li><a id="navigation_how_it_works_minimised_risk_header_button_desktop" class="cta_tracker_btn" href="/client-services.php#minimised-risk">Minimised Risk</a></li>*}
                            {*<li class="bg-gray"><a id="navigation_how_it_works_what_to_expect_header_button_desktop" class="cta_tracker_btn" href="/client-services.php#what-to-expect">What to Expect</a></li>*}
                            {*<li class="bg-gray"><a href="/about/skill_assessment.php#skill-assessment-call">Request A Skills Test Assessment</a></li>*}
                        {*</ul>*}
                    </li>
                    <li>
                        <a id="navigation_pricing_header_button_desktop" href="/view-price-range.php" class="header-toggle cta_tracker_btn" aria-haspopup="true" aria-expanded="false">Pricing<i class="fa fa-caret-down header-caret" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu header-dropdown">
                            <li><a id="navigation_pricing_risk_mitigation_header_button_desktop" class="cta_tracker_btn" href="/view-price-range.php#take-on-risk">Risk Mitigation</a></li>
                            <li class="bg-gray"><a id="navigation_pricing_our_pricing_model_header_button_desktop" class="cta_tracker_btn" href="/view-price-range.php#six-things">Our Pricing Model</a></li>
                            <li><a id="navigation_pricing_staff_pricing_header_button_desktop" class="cta_tracker_btn" href="/view-price-range.php#cost-estimation">Staff Pricing</a></li>
                            <li class="bg-gray"><a id="navigation_pricing_billing_header_button_desktop" class="cta_tracker_btn" href="/view-price-range.php#what-you-need">Billing</a></li>
                            <li><a id="navigation_pricing_cost_calculator_header_button_desktop" class="cta_tracker_btn" href="/view-price-range.php#fair-realistic">Fair and Realistic Pricing</a></li>
                        </ul>
                    </li>
                    <li>
                        <a id="navigation_about_us_header_button_desktop" href="/aboutus.php" class="header-toggle cta_tracker_btn" aria-haspopup="true" aria-expanded="false">About Us<i class="fa fa-caret-down header-caret" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu header-dropdown">

                            <li class="bg-gray"><a id="navigation_about_us_our_people_header_button_desktop" class="cta_tracker_btn" href="/aboutus.php#ourpeople">Our People</a></li>
                            <li><a id="navigation_about_us_meet_our_management_team_header_button_desktop" class="cta_tracker_btn" href="/aboutus.php#management">Meet Our Management Team</a></li>
                            <li class="bg-gray"><a id="navigation_about_us_company_vision_mission_header_button_desktop" class="cta_tracker_btn" href="/aboutus.php#missionvission">Company Vision and Mission</a></li>
                            <li><a id="navigation_about_us_remotestaff_story_header_button_desktop" class="cta_tracker_btn" href="/aboutus.php#staffstory">The Remote Staff Story</a></li>
                            <li class="bg-gray"><a id="navigation_about_us_remotestaff_seven_core_header_button_desktop" class="cta_tracker_btn" href="/aboutus.php#corevalues">Remote Staff’s 7 Core Values</a></li>
                            <li style="background-color:#FFF;"><a id="navigation_client_success_remotestaff_button_desktop" class="cta_tracker_btn" href="/client-success.php">Client Success</a></li>

                            <li class="bg-gray"><a id="" class="" href="/view-faq.php">FAQs</a></li>
                            <li class="bg-gray"><a id="" class="" href="/contactus.php">Contact Us</a></li>

                        </ul>

                    </li>
                    <li>
                        <a id="navigation_our_difference_header_button_desktop" href="/remote_staff_difference/" class="header-toggle cta_tracker_btn" aria-haspopup="true" aria-expanded="false">Our Difference<i class="fa fa-caret-down header-caret" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu header-dropdown">
                            <li><a id="navigation_our_difference_five_areas_of_support_header_button_desktop" class="cta_tracker_btn" href="/remote_staff_difference/#five-areas">5 Areas Of Support</a></li>
                            <!--  <li class="bg-gray"><a href="#" class="open-modal-leads-form" type="button" data-form-location="our difference" data-form-section="1">Book A Free Strategy Call</a></li> -->
                        </ul>
                    </li>
                    <li>
                        <a id="navigation_office_solution_header_button_desktop" href="/about/office-solution.php" class="header-toggle cta_tracker_btn" aria-haspopup="true" aria-expanded="false">Office Solution<i class="fa fa-caret-down header-caret" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu header-dropdown">
                            <li class="bg-gray"><a id="navigation_office_solution_eigth_benefits_you_love_header_button_desktop" class="cta_tracker_btn" href="/about/office-solution.php#eight-reason">8 Benefits You'll Love</a></li>
                            <li><a id="navigation_office_solution_home_office_based_header_button_desktop" class="cta_tracker_btn" href="/about/office-solution.php#office-homebased">Office or Home-Based? </a></li>
                            <li class="bg-gray"><a id="navigation_office_solution_all_about_makati_header_button_desktop" class="cta_tracker_btn" href="/about/office-solution.php#why-makati">All About Makati</a></li>
                            <li><a id="navigation_office_solution_office_pricing_header_button_desktop" class="cta_tracker_btn" href="/about/office-solution.php#office-lease">Office Pricing</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{$blog_link}" class="header-toggle">Blog</a>
                    </li>

                    <li>
                        <a id="navigation_login_header_button_desktop" href="/portal/" class="header-toggle cta_tracker_btn">Login</a>
                    </li>
                    <li>
                        <a href="#"> | </a>
                    </li>
                    <li>
                        <a id="navigation_job_seeker_header_button_desktop" href="http://remotestaff.com.ph" class="job-seeker header-toggle cta_tracker_btn">Job Seeker?</a>
                    </li>
                    <li class="contacts-nav">
                        <img id="phone-pic" src="/remotestaff_2015/img/head_phone.png"  />
                        <span class="v2-au-number">
                            <a id="contact_numbers_forcallaus_office_number_header_button_desktop" class="cta_tracker_btn" id="au-number" href="tel:{$contact_numbers_forcall.aus_office_number}">{$contact_numbers.aus_office_number}</a>
                        </span>
                        <span class="v2-intl-number-landing">
                           <a id="contact_numbers_forcall_aus_header_number_header_button_desktop" class="cta_tracker_btn" id="intl-number-landing" href="tel: {$contact_numbers_forcall.aus_header_number}">{$contact_numbers.aus_header_number}</a>
                       </span>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
{/strip}