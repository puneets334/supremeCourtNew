
<?php 
$video_details = array(
    array("videoURL"=>"uploaded_docs/video_tutorial/Accessing-e-Filing-Portal.mp4","videoTitle"=>"How to access e-Filing Module/Portal","posterURL"=>"uploaded_docs/video_tutorial/poster.jpg"),
    array("videoURL"=>"uploaded_docs/video_tutorial/Registration-of-Advocate-on-Record.mp4","videoTitle"=>"Registration of AoR" ,"posterURL"=>"uploaded_docs/video_tutorial/poster.jpg"),
    array("videoURL"=>"uploaded_docs/video_tutorial/Registration-of-PIP.mp4" ,"videoTitle"=>"Registration of Party-in-Person" ,"posterURL"=>"uploaded_docs/video_tutorial/poster.jpg"),
    array("videoURL"=>"uploaded_docs/video_tutorial/New-Case-Filing.mp4","videoTitle"=>"How to e-File a New Case","posterURL"=>"uploaded_docs/video_tutorial/poster.jpg"),
    array("videoURL"=>"uploaded_docs/video_tutorial/IA.mp4","videoTitle"=>"How to e-File an I.A.","posterURL"=>"uploaded_docs/video_tutorial/poster.jpg"),
    array("videoURL"=>"uploaded_docs/video_tutorial/Filing-Misc-Docs.mp4","videoTitle"=>"How to e-file a Miscellaneous Document","posterURL"=>"uploaded_docs/video_tutorial/poster.jpg"),
    array("videoURL"=>"uploaded_docs/video_tutorial/Filing-Caveat.mp4","videoTitle"=>"How to e-File Caveat","posterURL"=>"uploaded_docs/video_tutorial/poster.jpg"),
    array("videoURL"=>"uploaded_docs/video_tutorial/Check-defects-marked-and-refile.mp4","videoTitle"=>"How to Check Defects and Re-File","posterURL"=>"uploaded_docs/video_tutorial/poster.jpg") );

//echo '<pre>';print_r($video_details);

?>

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
                        <h2><i class="fa  fa-newspaper-o"></i> Resources Video Tutorial</h2>
                        <div class="clearfix"></div>
                    </div>
                   
                <?php } else { ?>

                    <h2><i class="fa  fa-newspaper-o"></i> Resources Video Tutorial</h2>
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
  
    <div class="row">
        <?php foreach($video_details as $key=>$value){    ?>  

      <div class="col-lg-3 col-md-12 mb-3 mb-lg-0">
        
        <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light" >
       
        <a href="#" onclick="playVideo('<?=base_url();?><?=$value['videoURL'];?>','<?=$value['videoTitle'];?>')">
        <img class="m-1 p-1 w-100" src="<?=base_url();?><?=$value['posterURL'];?>" alt="Introduction to eFiling" style="width:350px;height:350px;border: 1px dotted;">
       
          <h2 class="mt-4 text-primary"><?=$value['videoTitle'];?></h2>
        </a>
        </div>
      </div>
         
  <?php }?>

        </div>     
            </div>
        </div>
       
    </div>
</div>

</div>


<!-- start modal -->
 <div class="modal" id="vd_screen">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document" id="vd_dialog">
      <div class="modal-content  ">
      <div class="modal-header">
    <h5 class="modal-title" id="vd_title">Resources Video Tutorial</h5>
          
      </div>
        <div class="modal-body text-center" id="vd_body"></div>
<div class="modal-footer">
        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
        
      </div>
      </div>
    </div>
</div>
<!-- end modal -->
<script>
  
function playVideo(path,videoTitle)
{
  $('#vd_body').html('');
   $('#vd_title').html('');
	//var str="<object data="+path +"></object>";
//alert('path='+path+'flag='+flag);
	var str='<div class="videoWrapper"><iframe width="100%" height="450" src="'+path+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen sandbox="allow-scripts allow-same-origin" ></iframe></div>';
	//var str='<video autoplay="" controls="" style="width:100%"> <source src='+path+' type="video/mp4"></video>';
	
	 $('#vd_screen').modal('show');
	 $('#vd_body').html(str);
   $('#vd_title').html(videoTitle);
	 $('#vd_dialog').removeClass('modal-md');
	 $('#vd_dialog').addClass('modal-lg');
	 $('#vd_dialog').addClass('modal-dialog-scrollable');
	
	
}
$('#vd_screen .close').click(function(){
		//alert('aaa')
		$('#vd_body').html('');
    $('#vd_screen').modal('hide');
	});
</script>
