<?php 
if(isset($_SESSION['login'])){
    $ex = 'layout.advocateApp';
}else{
    $ex = 'layout.frontApp';
}
?>
@extends($ex)
@section('content')
    <style>
        #accordion {
            font-size: 17px;
        }
        #accordion h3 {
            font-weight: bolder;
            background: lightgoldenrodyellow;
        }
        #accordion div div h3 {
            color: #0d47a1;
            background: whitesmoke;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="dashboard-section dashboard-tiles-area"></div>
                <div class="dashboard-section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="dash-card">
                                {{-- Page Title Start --}}
                                <div class="title-sec">
                                    <h5 class="unerline-title">Resources</h5>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a href="{{base_url('resources/hand_book')}}" aria-current="page" class="nav-link {{(current_url() == base_url('support') || current_url() == base_url('resources/hand_book')) ? 'active' : ''}}">Hand Book</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{base_url('resources/video_tutorial/view')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/video_tutorial/view') ? 'active' : ''}}">Video Tutorial</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{base_url('resources/FAQ')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/FAQ') ? 'active' : ''}}">FAQ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{base_url('resources/hand_book_old_efiling')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/hand_book_old_efiling') ? 'active' : ''}}">Refile Old Efiling Cases</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{base_url('resources/Three_PDF_user_manual')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/Three_PDF_user_manual') ? 'active' : ''}}">3PDF User Manual</a>
                                    </li>
                                </ul>
                                {{-- Page Title End --}}
                                {{-- Main Start --}}
                                <div class="right_col" role="main">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div id="msg">
                                                <?php echo getSessionData('MSG'); ?>
                                            </div> 
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">            
                                            <div class="x_panel">                
                                                <?php if (getSessionData('login') != '' && getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN) { ?>
                                                    <div class="x_title">
                                                        <h2><i class="fa  fa-newspaper-o"></i> Resources FAQ</h2>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content"></div>
                                                <?php } else { ?> 
                                                    <h2><i class="fa  fa-newspaper-o"></i> Resources FAQ</h2>
                                                    <div class="clearfix"></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>        
                                    <!------------Table--------------------->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="x_panel">
                                                <div class="x_content">
                                                    <center><h2>FREQUENTLY ASKED QUESTIONS</h2></center>
                                                    <div id="accordion">
                                                        <h3>REGISTRATION<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion1">
                                                                <h3>01. I am an Advocate on Record. how should I register myself?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>If the details of the AOR are already available with the Registry then such AOR is only required to create a new password in the new efiling Portal by taking the following steps:
                                                                        <ol>
                                                                            <li>On the login page, click on forgot password option;</li>
                                                                            <li>Enter your registered mobile number, enter captcha and then click on send OTP button.</li>
                                                                            <li>OTP will be sent on your registered mobile number;</li>
                                                                            <li>Enter the OTP and click ‘verify’ button</li>
                                                                            <li>Create new password</li>
                                                                        </ol>
                                                                        Once new password is set, the AOR can login by using his AOR code or registered mobile number or registered email id along with the new password.
                                                                    </p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/1.png'); ?>" alt="Registration" align="center"></div>
                                                                    <p>Please note: The password must be at least 8 characters long. It must also contain at least 1 Uppercase character, 1 lowercase character, 1 number, 1 special character each.</p>
                                                                </div>
                                                                <h3>02. I am an AOR and the portal is not accepting my mobile number for registration, what should I do?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>
                                                                        If your mobile number is not updated in records, it is requested to update your record by placing Specimen signature form available on www.sci.gov.in visit the ‘Record Room’ and get your mobile number updated in Records. Further, in case if your mobile number is already registered with a firm having another AOR code, it is requested to use a different mobile number to register yourself.
                                                                    </p>
                                                                </div>
                                                                <h3>03. I have completed registration and completed the profile; still I am not able to access the services. Why?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>
                                                                        Post registration, an AOR can directly access the e-Filing portal to file petition, documents, Caveat etc… However in the case of Advocate their profile needs to be approved and activated.
                                                                    </p>
                                                                    <p>In case of registration as an Advocate, their profile needs to be approved by an AOR by going on the three lines menu and then clicking on the ‘Add Advocate’ image shown in the below screen. </p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/3.png'); ?>" alt="Registration" align="center"></div>
                                                                    <p>The concerned AOR will receive a notification with an OTP/ Code inside their eFiling profile. If the concerned AOR approves the profile of the concerned Advocate, login will be activated.</p>
                                                                    <p>In the case of registration as Petitioner-in-Person (PIP), the account is automatically approved and activated.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>DASHBOARD<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion2">
                                                                <h3>04. What does the dashboard display in SC-EFM ?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Dashboard gives at-a-glance status of your cases which are soon to be listed under ‘My Cases’ head and your e-Filed Cases under the ‘eFiled Cases’ head. Further, you can view ‘Recent documents’ e-filed by you, ‘Incomplete filings’ and ‘Scrutiny Status’ of your cases i.e. whether at Defective Stage or Pending for Scrutiny. Screenshot attached as below:</p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/4.png'); ?>" alt="Registration" align="center"></div>
                                                                </div>
                                                                <h3>05. Does the dashboard provide the list of my cases which are listed in near future?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Dashboard provides details of cases which are to be listed cases in near future under the head “Soon to be listed cases" </p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/5.png'); ?>" alt="Registration" align="center"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>PROFILE UPDATION<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion3">
                                                                <h3>06.  How can I view and update my profile?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>The profile can be viewed by clicking the user icon at the top right corner of the screen.The details of an AOR can be updated through Record Room Section of Supreme Court of India</p>
                                                                </div>
                                                                <h3>07. Can I update my registered mobile number and registered email id?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>The details of an AOR can be updated through Record Room Section of Supreme Court of India</p>
                                                                </div>
                                                                <h3>08. How can I change my password?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>You can change the password by clicking on “Change Password” after logging in below the user profile photo.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>NEW CASE FILING / FINAL CASE SUBMISSION<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion4">
                                                                <h3>09. I have filed a case, but I am not able to do any editing in the case?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Any filed case is available for editing only before final submission. Once submitted, the case will not be available for editing. Please check whether you have already submitted the case.</p>
                                                                </div>
                                                                <h3>10.  For new case filing, do I need to complete all the 7 steps in one go?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>No, you can fill in the details or complete the 7 steps according to your convenience. Also the details can be edited multiple times. The draft case gets saved in your cases list which can be further processed later. Please ensure that all the details are correct before final submission. After Final Submission, the case details cannot be modified.</p>
                                                                </div>
                                                                <h3>11. I am an advocate; can I refile the matter of my AOR?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>No. Advocates login provides facility to only view the case details or the cases of his AOR. The case can be filed or refiled only through the login of the AOR.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>UPLOAD PETITION<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion5">
                                                                <h3>12. Which file formats are allowed for uploading a petition? What is the maximum limit of the file size which can be uploaded?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Only .pdf file format is allowed for uploading a petition through e-Filing Portal. The maximum file size that can be uploaded is 50 MB. If pdf file size is more than 50MB, file may split into parts for meeting the requirement.</p>
                                                                </div>
                                                                <h3>13. If an already signed physical document is scanned for uploading, do we need to re-authenticate it digitally?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>As of now it is not mandatory to sign the petition digitally.</p>
                                                                </div>
                                                                <h3>14. Are there any templates for petitions?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>It is requested to refer to the Supreme Court Rules, 2013 for the same which are available on the website under the bottom panel of the home page of Supreme Court website.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>SUBMISSION OF PETITION<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion6">

                                                                <h3>15. I have completed all the formalities such as entering case details, uploading document(s) and court fee payment etc. How to submit the case to the court?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>To finally submit a case to the court, click on the ‘Submit’ button. History of all the activities that have been completed through the e-filing system for all the cases will be displayed under the ‘e-Filing History’ tab. The facility to view the uploaded petitions, court fee payment, in respect of the respective case is available under the e-Filed Cases report. Advocate can verify that all the details, court fee if any is in order under the view tab.
                                                                    </p>
                                                                    <P>If everything is in order and completed, the case can be finally submitted.
                                                                        Once a case is submitted, the diary number is automatically generated and the case gets transferred to the Registry for further action required.</P>
                                                                </div>
                                                                <h3>16. Is there any facility to review case status after the case is submitted to the court?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>After submission, the court may take some time to verify the case. You can view the status by clicking on ‘Scrutiny status’ button in the dashboard. If the Scrutiny process is complete, your case will be shown under the defects notified button and you may cure your defects in the case using the ‘Cure defects’ option. You can also view the name of the Dealing Assistant to whom your matter has been marked for scrutiny.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>e-PAYMENT / COURT FEE SUBMISSION<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion7">
                                                                <h3>17. Which types of payments can be done through the payment facility?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Provision is made to make online payment towards Court Fees and allied charges through Stock Holding Corporation. The facility to pay the Court fees by debit card, credit card or UPI or Net Banking etc. has been incorporated.
                                                                    </p>
                                                                </div>
                                                                <h3>18. I paid the court fees more than what was required to. How can I get it refunded in my account?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Court fees once submitted successfully gets automatically locked and is transferred to the Consolidated fund of India. Hence, the amount once paid successfully cannot be refunded.
                                                                    </p>
                                                                </div>
                                                                <h3>19. Can I use the court fee deposited by mistake in a matter for another case to be e-filed?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>No. Court fees gets locked automatically once submitted and cannot be used for another matter.
                                                                    </p>
                                                                </div>
                                                                <h3>20. There was some problem during the online payment transaction of court fee. How can I check whether the payment was successful?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>If the transaction was done through the ‘payment’ menu, click on ‘Fee Paid’ tab, details of all the transactions will be provided here.  If there was some issue during the payment, you will see the payment status will be ‘pending’. You need to wait for atleat 30 minutes before making another attempt of payment. If the status is still pending after 30 minutes, you need to repeat the payment in such cases after confirming from your bank that the amount so was not deducted from your account. If the payment was successful, ‘Success’ status  is displayed.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>INTERLOCUTORY APPLICATION FILING<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion8">
                                                                <h3>21. Can I modify an application after I click on Submit?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Any submitted application can be modified before final submission. Once the application is submitted, it cannot be modified.
                                                                    </p>
                                                                </div>
                                                                <h3>22. Can I file IAs for the cases which are not filed through e-Filing services?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Yes, the AOR can file an IA for any case. The prerequisite is that the case must be pending in the account of the cases of that AOR.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>PORTFOLIO MANAGEMENT<span class="panel-icon" style="float: right">+</span></h3>
                                                        <div>
                                                            <div id="accordion9">
                                                                <h3>23. Can I add my existing cases in the portfolio of eFiling services?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>No, existing cases can not be added in the account of SCeFM but advocates can file Miscellaneous documents/ Interlocutory applications in physically filed cases through SCeFM.
                                                                    </p>
                                                                </div>
                                                                <h3>24. I have already created a portfolio in my mobile app. Can I import those cases in the eFiling Services portfolio?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>No, cases in the portfolios of mobile apps cannot be imported in SCeFM.
                                                                    </p>
                                                                </div>
                                                                <h3>25. How can case related updates be reflected in my account?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Defects notified in the matters or defects cured in ICMIS are reflected automatically in every 15 minutes through CRON service in SCeFM.
                                                                    </p>
                                                                </div>
                                                                <h3>26. How can I search my cases?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>You can view your cases under ‘My Cases’ head and your eFiled Cases under the ‘eFiled Cases’ head. Multiple filter options are provided for searching cases. You may search the case using Case number, eFiling number, Cause title, filing stage of the case or other options under ‘Search’ box. All the cases matching the search criteria will be displayed. You may click on the efiling case number to view further details of the case.
                                                                    </p>
                                                                    <div style="text-align: center">
                                                                        <img src="<?php echo base_url('/uploaded_docs/faq_images/26.png'); ?>" alt="Registration" align="center">
                                                                    </div>
                                                                </div>
                                                                <h3>27. How can I remove a case from ‘My Cases’?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Cases cannot be removed from the ‘My Cases’ list.
                                                                    </p>
                                                                </div>
                                                                <h3>28. Which other facilities are provided in the eFiling Services for managing the portfolio?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <ol type="i">
                                                                        <li> Change Password</li>
                                                                        <li>My Cases: Cases can be searched by using different filters like Pending matters, Disposed matters, Registered Matters, Unregistered Matters
                                                                            <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/29.png'); ?>" alt="Registration" align="center"></div>
                                                                        </li>
                                                                        <li>To add and approve an advocate to view the cases filed on behalf of the AOR
                                                                            <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/29-2.png'); ?>" alt="Registration" align="center"></div>
                                                                        </li>
                                                                    </ol>
                                                                </div>
                                                                <h3>29. How do I file Interlocutory Application or Misc. Document?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>The initial process for filing IA and filing Misc. documents is exactly same. Therefore, user can follow exact steps for both. The user needs to enter the Diary number in which the IA or document is to be efiled as in the screenshot below:
                                                                    </p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/30.png'); ?>" alt="Registration" align="center"></div>
                                                                    <p>The portal then checks the status of the matter whether pending or disposed. If disposed, the portal will not allow the user to upload documents in the matter. If the matter is pending, then under the index tab, select the particular document type and then upload the relevant document required to be uploaded. The Index tab  is also to be filled in so that all the documents contained in the pdf so uploaded are updated in the Index. After submission of the Court fees, the IA or the Misc. Document will reach the Miscellaneous Dak Counter for further processing the same. </p>
                                                                </div>
                                                                <h3>30. How do I file Caveat Application?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>By default ‘Caveator is - an Individual’ is kept selected. A user is required to fill the requisite details about the caveator whether it is an Individual, Central Government, State Government or other organization.  The field marked with red asterisk (*) are mandatory.
                                                                    </p>
                                                                    <p>There are six steps which are to be completed for efiling a Caveat as per the screenshot below:</p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/31.png'); ?>" alt="Registration" align="center"></div>
                                                                    <p>After completing the steps, click on the Submit button at the top and your Caveat will be submitted. In case of any defect raised by the Registry, you can view the status of the same under the ‘For Compliance’ menu. The defects are then to be removed and then to be resubmitted by uploading the defect free Caveat in the Upload Documents/ Index tab and then click on ‘Final Submit’ button.</p>
                                                                </div>
                                                                <h3>31. I am an Intervenor, am I allowed to file an application using the SC-eFM?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>Yes, an Intervenor is allowed to file an application of intervention using the ‘IA’ option. The name of the Intervenor is to be entered and then may upload the relevant documents along with the court fee payment. The application then gets submitted and sent to the Miscellaneous Dak Counter for further processing.
                                                                    </p>
                                                                </div>
                                                                <h3>32. How to cure defect of deficit court fees?<span class="panel-icon" style="float: right">+</span></h3>
                                                                <div>
                                                                    <p>For the payment of deficit Court fees in unregistered matters, the AOR/PIP can enter the amount under ‘WANT TO PAY MORE COURT FEE’ option and submit deficit Court fees.
                                                                    </p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/33-1.png'); ?>" alt="Registration" align="center"></div>
                                                                    <p>Further, for registered matters, the user should select ‘Misc. Doc’ option under NEW tab to pay deficit Court fees. Then the following steps have to be followed:-</p>
                                                                    <p><u>Step 1:</u>  Enter Diary Number / Year after Selecting ‘New’ option. Thereafter, relevant information have to be provided in appropriate fields on the page. After filling up the information, submit the page.</p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/33.png'); ?>" alt="Registration" align="center"></div>
                                                                    <p><u>Step 2:</u> Select the party name by clicking on the checkbox.</p>
                                                                    <p><u>Step 3:</u>  Now, upload the document by mentioning details of deficit Court fees to be paid and select ‘Court Fee’ in the ‘Index Item’ drop down. Now click on ‘Add’, then click ‘Next’ as per image below.</p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/33-2.png'); ?>" alt="Registration" align="center"></div>
                                                                    <p><u>Step 4:</u>  Enter the deficit Court fee amount in the box besides ‘want to pay more court fee’ option and submit </p>
                                                                    <div style="text-align: center"><img src="<?php echo base_url('/uploaded_docs/faq_images/33-3.png'); ?>" alt="Registration" align="center"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!------------Table--------------------->
                                    </div>
                                </div>
                                </div>
                                {{-- Main End --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $( function() {
            $( "#accordion" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion1" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion2" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion3" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion4" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion5" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion6" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion7" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion8" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
            $( "#accordion9" ).accordion({heightStyle: "content",collapsible: true}).on("click", "h3.ui-accordion-header", function(e) {
                $("h3.ui-accordion-header").each(function(i, el) {
                    $(this).find(".panel-icon").text($(el).is(".ui-state-active") ? "-" : "+")
                })
            });
        });
    });
</script>
@endpush