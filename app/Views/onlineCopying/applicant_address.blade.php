@extends('layout.app')
@section('content')

<style>
      .order-card {
    color: #fff;
}
.applicant_dashboard{
    cursor: pointer;
}
.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}


.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 5px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-block {
    padding: 20px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}
  </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="dash-card dashboard-section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class=" dashboard-bradcrumb">
                                <div class="left-dash-breadcrumb">
                                    <div class="page-title">
                                        <h5><i class="fa fa-file"></i> Online Certified Copy : Address</h5>
                                    </div>
                                    <div class="form-response" id="msg" role="alert" data-auto-dismiss="5000"></div>
                                </div>
                                <div class="ryt-dash-breadcrumb">
                                    <div class="btns-sec">

                                        <a href="javascript:void(0)" class="quick-btn gray-btn" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                               
                </div>
                <div class="dash-card dashboard-section">
                    <div class="row">
                        <div class="panel panel-default">
                            <?php
                            $attribute = array('class' => 'form-horizontal', 'id' => 'search_case_details', 'name' => 'search_case_details', 'autocomplete' => 'off', 'novalidate' => 'novalidate');
                            echo form_open('#', $attribute);
                            ?>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div style="text-align: left;">
                                <?php
                                if (!empty(getSessionData('MSG'))) {
                                    echo getSessionData('MSG');
                                }
                                if (!empty(getSessionData('msg'))) {
                                    echo getSessionData('msg');
                                }
                                ?>
                                <br>
                            </div>
                            <br>
                            <div id="">
                                <div class="row">
                                <body class="bg03" oncontextmenu="return false;">
    <div class="container">
      
       


        <div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">

                </div>
            </div>
        </div>
            <!-- Footer -->
           
        </div>
</body>
                            </div>
                            <?php echo form_close(); ?>

                            <br>
                            <div id="result"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    $(document).on('keyup','#pincode',function(){
        var pincode = $(this).val();
        if(pincode.length == 6){
            $.ajax({
                url:'get_pincode_details.php',
                cache: false,
                async: true,
                data: {pincode:pincode},
                type: 'POST',
                dataType: "json",
                success: function(data, status) {
                    if(data.status == 'success'){
                        $('#applicant_city').val(data.taluk_name);
                        $('#applicant_district').val(data.district_name);
                        $('#applicant_state').val(data.state_name);
                    }
                    else{
                        $('#applicant_city, #applicant_district, #applicant_state').val("");

                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                }

            });
        }
    });
    $(document).on('keyup','#modal_pincode',function(){
        var pincode = $(this).val();
        if(pincode.length == 6)
        {
            $.ajax({
                url:'get_pincode_details.php',
                cache: false,
                async: true,
                data: {pincode:pincode},                            
                type: 'POST',
                dataType: "json",
                success: function(data, status) {                                
                    if(data.status == 'success'){
                        $('#modal_applicant_city').val(data.taluk_name);
                        $('#modal_applicant_district').val(data.district_name);
                        $('#modal_applicant_state').val(data.state_name);
                    }
                    else{
                        $('#modal_applicant_city, #modal_applicant_district, #modal_applicant_state').val("");
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                }
            });   
        }
    });
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).on('click','#btn_save',function(){
        url = 'user_address_save.php';

        var address_type = '';
        if ($("#home_address_type").is(':checked')) {
            address_type = 'Home';
        }
        else if ($("#work_address_type").is(':checked')) {
            address_type = 'Work';
        }
        else{
            address_type = 'Other';
        }
        $(".validation").remove();
        var first_name = $("#applicant_first_name").val();
        var second_name = $("#applicant_second_name").val();
        var postal_add = $("#postal_add").val();
        var city = $("#applicant_city").val();
        var district = $("#applicant_district").val();
        var state = $("#applicant_state").val();
        var country = $("#applicant_country").val();
        var pincode = $("#pincode").val();
        // Initializing Variables With Regular Expressions
        var name_regex = /^[a-zA-Z ]+$/;
        var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; // /^[w-.+]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/;
        var add_regex = /^[a-zA-Z0-9\s,.:'-/]{3,}$/;   //   /^[0-9a-zA-Z ]+$/;
        var zip_regex = /^[0-9]{6,}$/;
        
        if (!($("#home_address_type").is(':checked') || $("#work_address_type").is(':checked') || $("#other_address_type").is(':checked'))) {
            $("#other_address_type").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Address Type Required*</strong></div>');            
            return false;                                                        
        }
        else if (first_name.match(name_regex) == null || first_name.length == 0) {
            $("#applicant_first_name").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>First Name Required. Use alphabets only*</strong></div>');            
            $("#applicant_first_name").focus(); return false;                                                        
        } else if (second_name.match(name_regex) == null || second_name.length == 0) {
                $("#applicant_second_name").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Second Name Required. Use alphabets only.*</strong></div>');            
                $("#applicant_second_name").focus(); return false;                                           
        } else if (pincode.match(zip_regex) == null || pincode.length != 6) {
                $("#pincode").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Valid Pincode Required*</strong></div>');
                $("#pincode").focus(); return false;
        } else if (postal_add.match(add_regex) == null || postal_add.length == 0) {
                $("#postal_add").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Address Required. Do not use Special Symbols</strong></div>');            
                $("#postal_add").focus(); return false;                                               
        } else if (city.match(name_regex) == null || city.length == 0) {
                $("#applicant_city").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>City Name Required*</strong></div>');            
                $("#applicant_city").focus(); return false;                                                        
        } else if (district.match(name_regex) == null || district.length == 0) {
                $("#applicant_district").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>District Name Required*</strong></div>');            
                $("#applicant_district").focus(); return false;                                                                             
        } else if (state.match(name_regex) == null || state.length == 0) {
                $("#applicant_state").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>State Name Required*</strong></div>');            
                $("#applicant_state").focus(); return false;                                                
        } else if (country.match(name_regex) == null || country.length == 0) {
                $("#applicant_country").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Country Name Required*</strong></div>');            
                $("#applicant_country").focus(); return false;                                                
        } 
        else{
            $.ajax
                ({
                    type: 'POST',
                    url: url,
                    dataType: "json",
                    cache: false,
                    beforeSend: function () {
                        $('.show_msg').html('<table widht="100%" align="center"><tr><td>Loading...</td></tr></table>');
                    },
                    data:{first_name: first_name, second_name: second_name, address_type:address_type, postal_add: postal_add, city: city, district: district, state: state, country: country, pincode: pincode},                              
                    success: function(data)
                    {
                        $('.show_msg').html('');
                        if(data.status == 'success'){
                            swal({
                                title: "SUCCESS!",
                                text: "Successfully Saved",
                                icon: "success",
                                button: "Next",
                            }).then(function () {
                                window.location.href = 'user_address.php';
                            }
                            );
                        }
                        else{
                            $('.show_msg').html('<div class="alert alert-danger alert-dismissible"><strong>'+data.status+'</strong></div>');
                        }
                    }
            });
        }
    });


    $(document).on('click','#btn_address_edit_action',function(){

            url = 'user_address_edit_action.php';

        var address_type = '';
        if ($("#modal_home_address_type").is(':checked')) {
            address_type = 'Home';
        }
        else if ($("#modal_work_address_type").is(':checked')) {
            address_type = 'Work';
        }
        else{
            address_type = 'Other';
        }
        $(".validation").remove();
        var address_id = $(this).data("address_table_id");
        var first_name = $("#modal_applicant_first_name").val();
        var second_name = $("#modal_applicant_second_name").val();
        var postal_add = $("#modal_postal_add").val();
        var city = $("#modal_applicant_city").val();
        var district = $("#modal_applicant_district").val();
        var state = $("#modal_applicant_state").val();
        var country = $("#modal_applicant_country").val();
        var pincode = $("#modal_pincode").val();
        // Initializing Variables With Regular Expressions
        var name_regex = /^[a-zA-Z ]+$/;
        var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; // /^[w-.+]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/;
        var add_regex = /^[a-zA-Z0-9\s,.:'-/]{3,}$/;   //   /^[0-9a-zA-Z ]+$/;
        var zip_regex = /^[0-9]{6,}$/;

        if (!($("#modal_home_address_type").is(':checked') || $("#modal_work_address_type").is(':checked') || $("#modal_other_address_type").is(':checked'))) {
            $("#modal_other_address_type").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Address Type Required*</strong></div>');
            return false;
        }
        else if (first_name.match(name_regex) == null || first_name.length == 0) {
            $("#modal_applicant_first_name").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>First Name Required. Use alphabets only*</strong></div>');
            $("#modal_applicant_first_name").focus(); return false;
        } else if (second_name.match(name_regex) == null || second_name.length == 0) {
            $("#modal_applicant_second_name").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Second Name Required. Use alphabets only.*</strong></div>');
            $("#modal_applicant_second_name").focus(); return false;
        } else if (pincode.match(zip_regex) == null || pincode.length != 6) {
            $("#modal_pincode").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Valid Pincode Required*</strong></div>');
            $("#modal_pincode").focus(); return false;
        } else if (postal_add.match(add_regex) == null || postal_add.length == 0) {
            $("#modal_postal_add").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Address Required. Do not use Special Symbols</strong></div>');
            $("#modal_postal_add").focus(); return false;
        } else if (city.match(name_regex) == null || city.length == 0) {
            $("#modal_applicant_city").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>City Name Required*</strong></div>');
            $("#modal_applicant_city").focus(); return false;
        } else if (district.match(name_regex) == null || district.length == 0) {
            $("#modal_applicant_district").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>District Name Required*</strong></div>');
            $("#modal_applicant_district").focus(); return false;
        } else if (state.match(name_regex) == null || state.length == 0) {
            $("#modal_applicant_state").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>State Name Required*</strong></div>');
            $("#modal_applicant_state").focus(); return false;
        } else if (country.match(name_regex) == null || country.length == 0) {
            $("#modal_applicant_country").parent().after('<div class="validation alert alert-danger alert-dismissible p-1 m-1"><strong>Country Name Required*</strong></div>');
            $("#modal_applicant_country").focus(); return false;
        }
        else{
            $.ajax
            ({
                type: 'POST',
                url: url,
                dataType: "json",
                cache: false,
                beforeSend: function () {
                    $('.show_msg_modal').html('<table widht="100%" align="center"><tr><td>Loading...</td></tr></table>');
                },
                data:{address_id:address_id,first_name: first_name, second_name: second_name, address_type:address_type, postal_add: postal_add, city: city, district: district, state: state, country: country, pincode: pincode},
                success: function(data)
                {
                    $('.show_msg_modal').html('');
                    if(data.status == 'success'){
                        swal({
                            title: "SUCCESS!",
                            text: "Successfully Edited",
                            icon: "success",
                            button: "Next",
                        }).then(function () {
                            window.location.href = 'user_address.php';
                            }
                        );
                    }
                    else{
                        $('.show_msg_modal').html('<div class="alert alert-danger alert-dismissible"><strong>'+data.status+'</strong></div>');
                    }
                }
            });
        }
    });

        $(document).on('click','.btn_remove_address',function(){
            var address_id = $(this).data("address-id");
            $.ajax
            ({
                type: 'POST',
                url: "user_address_remove.php",
                dataType: "json",
                cache: false,
                data:{address_id: address_id},
                beforeSend: function () {
                    $('.show_msg').html('<table widht="100%" align="center"><tr><td>Loading...</td></tr></table>');
                },
                success: function(data)
                {
                    $('.show_msg').html('');
                    if(data.status == 'success'){
                        swal({
                            title: "SUCCESS!",
                            text: "Successfully Removed",
                            icon: "success",
                            button: "Next",
                        }).then(function () {
                            window.location.href = 'user_address.php';
                            }
                        );
                    }
                    else{
                        $('.show_msg').html('<div class="alert alert-danger alert-dismissible"><strong>'+data.status+'</strong></div>');
                    }
                }
            });
        });

        $(document).on('click','.btn_edit_address',function(){
            $("#myModal").modal({backdrop: false});
            var address_id = $(this).data("address-id");
            var first_name = $(this).data("first_name");
            var second_name = $(this).data("second_name");
            var address = $(this).data("address");
            var city = $(this).data("city");
            var district = $(this).data("district");
            var state = $(this).data("state");
            var pincode = $(this).data("pincode");
            var country = $(this).data("country");
            var address_type = $(this).data("address_type");
            $.ajax
            ({
                type: 'POST',
                url: "user_address_edit.php",
                cache: false,
                data:{address_id: address_id,address_type:address_type,first_name:first_name,second_name:second_name,address:address,city:city,district:district,state:state,pincode:pincode,country:country},
                beforeSend: function () {
                    $('.modal-content').html('<table widht="100%" align="center"><tr><td>Loading...</td></tr></table>');
                },
                success: function(data)
                {
                    $(".modal-content").html(data);
                }
            });
        });
  </script>
        @endpush