<div class="mngmntHeader">
    <div class="menu-sec">
        <div class="mngmntLogoSection">
                <!-- Menu - Button Start  -->
            <div class="togglemenuSection">
                <button type="button" class="btn btn-sm togglebtn" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>
            <!-- Menu - Button Start  -->
            <div class="brand-logo-sec">
                <div class="logo"><a href="#"><img src="<?= base_url().'assets/newAdmin/'?>images/logo.png" alt="  " title=" "></a></div>
                <div class="logoSubtitle">
                    <div class="brand-text">
                        <h4>भारत का सर्वोच्च न्यायालय
                            <span> Supreme Court of India </span>
                            <span class="logo-sm-txt">|| यतो धर्मस्ततो जय: ||</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="mngmntUserSection">
            <div class="top-right-nav">
                <ul>
                    <li><a href="javascript:void(0)" class="hide skiptomain">Skip To Main Content</a></li>
                    <li><a class="hide" href="javascript:void(0)">Screen Reader Access</a></li>
                    <li class="text-size">
                    <a href="javascript:void(0)"><img src="<?= base_url().'assets/newAdmin/'?>images/text-ixon.png" alt="" class="txt-icon"></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="toph-icon"><i class="fas fa-sitemap"></i></a>
                    </li>
                    <li class="theme-color">
                        <a href="javascript:void(0)" class="whitebg">A</a>
                        <a href="javascript:void(0)" class="blackbg">A</a>
                    </li>
                    <li>
                        <select name="" id="" class="select-lang">
                            <option value="">English</option>
                            <option value="">Hindi</option>
                        </select>
                    </li>
                </ul>
            </div>
            <?php
                $profile_model = new \App\Models\Profile\ProfileModel();
                $profile = $profile_model->getProfileDetail(getSessionData('login')['userid']);

                $get_valu = help_id_url(uri_string());
                $help_page = explode('.', $get_valu);

                $login_time = $profile_model->userLastLogin(getSessionData('login')['id']);
                $last_login = (!empty($login_time) && $login_time->login_time != '') ? date('d-m-Y h:i:s A', strtotime($login_time->login_time)) : NULL;

                if (getSessionData('photo_path') != '') {
                    $profile_photo = str_replace('/photo/', '/' . 'thumbnail' . '/', getSessionData('login')['photo_path']);
                } else {
                    //$profile_photo = $profile[0]->photo_path;
                    $profile_photo=base_url('assets/images/user.png');
                }
            ?>
            <div class="account-details">
                <div class="userInformation">
                    <!--userDetail-->
                    <div class="userDetail" id="usr-action-btn">
                        <div class="userName"> <?= getSessionData('login')['first_name']; ?> <i class="fas fa-chevron-down"></i>
                            <span class="division"><?= '<strong>Last Login Details</strong>' . "<br>" . "Date : " . (!empty($last_login) ?  htmlentities($last_login, ENT_QUOTES) : '') . "<br>" . "IP : " . (!empty($login_time) ? htmlentities($login_time->ip_address, ENT_QUOTES) : ''); ?></span>
                        </div>
                        <div class="user-action-sec">
                            <ul>
                                <li>
                                    <a href="<?= base_url('profile'); ?>">Profile</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('logout'); ?>">Log Out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--userDetail-->

                    <!--userImg-->
                    <div class="userImgWrap">
                        <div class="userImg">
                            <a href="#"><img src="<?= $profile_photo ?>" alt="Admin" title="admin" width="56" height="56"></a>
                            {{-- <a href="#"><img src="<?= base_url().'assets/newAdmin/'?>images/user.jpg" alt="Admin" title="admin" width="56" height="56"></a> --}}
                        </div>
                    </div>
                    <!--userImg-->
                </div>
                <div class="userInfo">
                    <!-- <a href="#"><span class="fa fa-envelope-o icon-animated-vertical"></span></a> -->
                    <!-- <a href="#"><span class="fa fa-question animated bounceInDown"></span></a>  -->
                    <a href="#"	class="bell"><span class="fa fa-bell ringing"></span><span class="count">5</span></a>
                    <!-- <a	href="login.html" class="signOut"><span class="fa fa-sign-out"></span></a> -->
                </div>
            </div>
        </div>
    </div>			
</div>