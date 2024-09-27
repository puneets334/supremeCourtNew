@extends('layout.app')

@section('content')
<?php

use Hashids\Hashids;

?>
<div class="container-fluid">


    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-section dashboard-tiles-area">

            </div>

            <div class="dashboard-section">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="dash-card">
                            <div class="title-sec">
                                <h5 class="unerline-title">User List </h5>
                            </div>
                            <div class="table-sec">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table first-th-left" id="datatable-responsive">
                                        <thead>
                                            <tr class="success input-sm" role="row">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Address</th>
                                                <th>Request On</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($advocate_details) > 0){
                                                $k = 1;
                                            foreach($advocate_details as $res){
                                                $state_name = isset($res->first_name) ? ', ' . $res->first_name : '';
                                                $dist_name = isset($res->office_state_name) ? ', ' . $res->office_state_name : '';
                                                $m_pincode = isset($res->m_pincode) ? '- ' . $res->m_pincode : '';
                                                $user_type = isset($res->ref_m_usertype_id) && $res->ref_m_usertype_id == USER_ADVOCATE ? 'Advocate' : '';
                                            ?>
                                            <tr>
                                                <td width="5%"><?=$k; ?></td>
                                                <td width="15%">
                                                    <?php


                                                    $encodedId = integerEncreption($res->id);
                                                    ?>
                                                    <a href="<?= base_url('NewRegister/Advocate/view/' . $encodedId) ?>" style="color: #385198;">
                                                        <?= strtoupper($res->first_name) ?>
                                                    </a>
                                                </td>



                                                <td width="8%">{{ $user_type }}</td>
                                                <td width="10%">{{ $res->m_address1 . ' , ' . $res->m_city . $m_pincode }}</td>
                                                <td width="15%">{{ date("d-m-Y h:i:s A", strtotime($res->created_on)) }}</td>
                                            </tr>
                                            <?php $k++; }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection