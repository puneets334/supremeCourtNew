<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="msg">
                <?php
                if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
                    echo $_SESSION['MSG'];
                } unset($_SESSION['MSG']);
                ?></div> 
        </div>
    </div>    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">            
            <div class="x_panel">                
                <?php if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN) { ?>
                    <div class="x_title">
                        <h2><i class="fa  fa-newspaper-o"></i> Refile Old eFiling Cases</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                    </div>
                <?php } else { ?> 

                    <h2><i class="fa  fa-newspaper-o"></i> Refile Old eFiling Cases</h2>
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
                    <!--<center><h2>Under Development 123....</h2></center>-->
                    <embed src="/uploaded_docs/user_manual/Independent_Old_Refiling.pdf" type="application/pdf" width="100%" height="800">
                    <!--<iframe src="/uploaded_docs/user_manual/pdf3.pdf" width="800" height="600"></iframe>-->
                    <!--<object width="100%" height="900" data="/uploaded_docs/user_manual/eFM_2.0_Manual.pdf"></object>-->



                </div>
            </div>
        </div>
        <!------------Table--------------------->
    </div>
</div>
</div>
