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
                        <div class="panel panel-default">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card mt-0">
                                    <div class="card-header bg-primary text-white font-weight-bolder mt-0 mb-0">
                                        Contact Us
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-3 contact-widget-section2 wow animated fadeInLeft"
                                                data-wow-delay=".2s">

                                                <div class="find-widget">
                                                    Office : <a style="color: #0554DB;" href="<?php echo SCI_GOV_IN; ?>">Supreme Court of India</a>
                                                </div>
                                                <div class="find-widget">
                                                    Address: <a style="color: #0554DB;" href="#">Tilak Marg, New Delhi-110001</a>
                                                </div>
                                                <div class="find-widget">
                                                    Phone: <a style="color: #0554DB;" href="#">011-23112081 (Copying Section)</a>
                                                </div>
                                                <div class="find-widget">
                                                    Email: <a style="color: #0554DB;" href="#">supremecourt[at]nic[dot]in</a>
                                                </div>

                                                <div class="find-widget">
                                                    Website: <a style="color: #0554DB;" href="<?php echo MAIN_SCI_GOV_IN; ?>">http://sci.gov.in</a>
                                                </div>

                                            </div>


                                        </div>
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
