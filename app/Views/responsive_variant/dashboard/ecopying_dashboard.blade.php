@extends('layout.app')

@section('content')

<style>
.btn-info {
    margin: -13% 15%;
}

.fc-today-button {
    text-transform: capitalize !important;
}

#efiling-details {
    margin-top: 40px !important;
}

.blue-tile {
    height: 100% !important;
}

a .btn-primary {
    color: #fff;
}

li {
    list-style: none;
}

.fc .fc-toolbar-title {
    font-size: 1.6em !important;
}

.uk-modal {
    display: none;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1010;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    padding: 15px 15px;
    background: rgba(0, 0, 0, .6);
    opacity: 0;
    transition: opacity .15s linear
}

@media (min-width:640px) {
    .uk-modal {
        padding: 50px 30px
    }
}

@media (min-width:960px) {
    .uk-modal {
        padding-left: 40px;
        padding-right: 40px
    }
}

.uk-modal.uk-open {
    opacity: 1
}

.uk-modal-page {
    overflow: hidden
}

.uk-modal-dialog {
    position: relative;
    box-sizing: border-box;
    margin: 0 auto;
    width: 600px;
    max-width: calc(100% - .01px) !important;
    background: #fff;
    opacity: 0;
    transform: translateY(-100px);
    transition: .3s linear;
    transition-property: opacity, transform
}

.uk-open>.uk-modal-dialog {
    opacity: 1;
    transform: translateY(0)
}

.uk-modal-container .uk-modal-dialog {
    width: 1200px
}

.uk-modal-full {
    padding: 0;
    background: 0 0
}

.uk-modal-full .uk-modal-dialog {
    margin: 0;
    width: 100%;
    max-width: 100%;
    transform: translateY(0)
}

.uk-modal-body {
    padding: 30px 30px
}

.uk-modal-header {
    padding: 15px 30px;
    background: #fff;
    border-bottom: 1px solid #e5e5e5
}

.uk-modal-footer {
    padding: 15px 30px;
    background: #fff;
    border-top: 1px solid #e5e5e5
}

.uk-modal-body::after,
.uk-modal-body::before,
.uk-modal-footer::after,
.uk-modal-footer::before,
.uk-modal-header::after,
.uk-modal-header::before {
    content: "";
    display: table
}

.uk-modal-body::after,
.uk-modal-footer::after,
.uk-modal-header::after {
    clear: both
}

.uk-modal-body>:last-child,
.uk-modal-footer>:last-child,
.uk-modal-header>:last-child {
    margin-bottom: 0
}

.uk-modal-title {
    font-size: 2rem;
    line-height: 1.3
}

[class*=uk-modal-close-] {
    position: absolute;
    z-index: 1010;
    top: 10px;
    right: 10px;
    padding: 5px
}

[class*=uk-modal-close-]:first-child+* {
    margin-top: 0
}

.uk-modal-close-outside {
    top: 0;
    right: -5px;
    transform: translate(0, -100%);
    color: #fff
}

.uk-modal-close-outside:hover {
    color: #fff
}

@media (min-width:960px) {
    .uk-modal-close-outside {
        right: 0;
        transform: translate(100%, -100%)
    }
}

.uk-modal-close-full {
    top: 0;
    right: 0;
    padding: 20px;
    background: #fff
}

.uk-text-uppercase {
    text-transform: uppercase !important;
}

.uk-text-small {
    font-size: 9px !important;
    line-height: 1.5;
}

.md-bg-grey-700 {
    background-color: #616161 !important;
}

.md-color-grey-50 {
    color: #fafafa !important;
}

.md-bg-red-700 {
    background-color: #d32f2f !important;
}

#calendar {
    cursor: pointer;
}

td {
    line-height: normal !important;
}

.fc-event-main {
    text-align: center;
}

#calendar-cases {
    text-align: center;
}
</style>
<div class="mainPanel ">
    <div class="panelInner">
        <div class="middleContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 sm-12 col-md-12 col-lg-12 middleContent-left">
                        @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
                        <div class="dashboard-section dashboard-tiles-area">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                    <div class="dashbord-tile pink-tile" tabindex="0">
                                        <div >
                                            <h6 class="tile-title" tabindex="0">Recent Documents</h6>
                                            <p class="tile-subtitle" tabindex="0">By Me</p>
                                            <button id="byOthers" class="btn btn-info pull-right" tabindex="0">#By
                                                others</button>
                                            <h4 class="main-count" tabindex="0">
                                                <?php
                                                            echo '00';
                                                        ?>
                                            </h4>
                                            <div class="tiles-comnts">
                                                <div class="tile-comnt" tabindex="0">
                                                    <h6 class="comts-no">
                                                        <?php
                                                                    echo '00';
                                                                ?>
                                                    </h6>
                                                    <p class="comnt-name">Rejoinder</p>
                                                </div>
                                                <div class="tile-comnt" tabindex="0">
                                                    <h6 class="comts-no">
                                                        <?php
                                                                    echo '00';
                                                                ?>
                                                    </h6>
                                                    <p class="comnt-name">Reply</p>
                                                </div>
                                                <div class="tile-comnt" tabindex="0">
                                                    <h6 class="comts-no">
                                                        <?php
                                                                    echo '00';
                                                                ?>
                                                    </h6>
                                                    <p class="comnt-name">IA</p>
                                                </div>
                                                <div class="tile-comnt" tabindex="0">
                                                    <h6 class="comts-no">
                                                        <?php
                                                                    echo '00';
                                                                ?>
                                                    </h6>
                                                    <p class="comnt-name">Other</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End 2nd grid-->
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                    <div class="dashbord-tile purple-tile" tabindex="0">
                                        <h6 class="tile-title" tabindex="0">Incomplete Filings</h6>
                                        <p class="tile-subtitle" tabindex="0">Cases/appl. Filed by you</p>
                                        <h4 class="main-count" tabindex="0">
                                            <?php
                                                        echo '00';
                                                    ?>
                                        </h4>
                                        <div class="tiles-comnts">
                                            <div class="tile-comnt" tabindex="0">
                                                <h6 class="comts-no">
                                                    <?php
                                                                echo '00';
                                                            ?>
                                                </h6>
                                                <p class="comnt-name">Draft</p>
                                            </div>
                                            <div class="tile-comnt" tabindex="0">
                                                <h6 class="comts-no">
                                                    <?php
                                                                echo '00';
                                                            ?>
                                                </h6>
                                                <p class="comnt-name">For Compliance</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                    <div class="dashbord-tile blue-tile" tabindex="0">
                                        <h6 class="tile-title" tabindex="0">Scrutiny Status</h6>
                                        <p class="tile-subtitle" tabindex="0">Cases/appl. Filed by you</p>
                                        <h4 class="main-count">&nbsp;&nbsp;</h4>
                                        <div class="tiles-comnts">
                                            <div class="tile-comnt" tabindex="0">
                                                <h6 class="comts-no">
                                                    <?php
                                                                echo '00';
                                                            ?>
                                                </h6>
                                                <p class="comnt-name">Defect Notified</p>
                                            </div>
                                            <div class="tile-comnt" tabindex="0">
                                                <h6 class="comts-no">
                                                    <?php
                                                                echo '00';
                                                            ?>
                                                </h6>
                                                <p class="comnt-name">Pending Scrutiny</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- -----  -->
                                <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                    <div class="dashbord-tile purple-tile application-tile" tabindex="0">
                                        <h6 class="tile-title" tabindex="0">Application</h6>
                                        <p class="tile-subtitle"></p>
                                        <h4 class="main-count">&nbsp;&nbsp;</h4>
                                        <div class="application-tile-sections">
                                            <div class="applictin-tile-sec">
                                                <div class="appliction-til-nam" tabindex="0">
                                                    <h6>Online</h6>
                                                </div>
                                                <div class="tiles-comnts">
                                                    <div class="tile-comnt" tabindex="0">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            
                                                                    if (isset($online->disposed_appl) && !empty($online->disposed_appl)) {
                                                                        echo $online->disposed_appl;
                                                                    } else {
                                                                        echo '00';
                                                                    }
                                                                    ?>
                                                        </h6>
                                                        <p class="comnt-name">Disposed</p>

                                                    </div>
                                                    <div class="tile-comnt" tabindex="0">
                                                        <h6 class="comts-no">
                                                            <?php
                                                                    if (isset($online->pending_appl) && !empty($online->pending_appl)) {
                                                                        echo $online->pending_appl;
                                                                    } else {
                                                                        echo '00';
                                                                    }
                                                                    ?>
                                                        </h6>
                                                        <p class="comnt-name">Pending</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="applictin-tile-sec">
                                                <div class="appliction-til-nam" tabindex="0">
                                                    <h6>Offline</h6>
                                                </div>
                                                <div class="tiles-comnts">
                                                    <div class="tile-comnt" tabindex="0">
                                                        <h6 class="comts-no">
                                                            <?php
                                                                    if (isset($offline->disposed_appl) && !empty($offline->disposed_appl)) {
                                                                        echo $offline->disposed_appl;
                                                                    } else {
                                                                        echo '00';
                                                                    }
                                                                    ?>
                                                        </h6>
                                                        <p class="comnt-name">Disposed</p>
                                                    </div>
                                                    <div class="tile-comnt" tabindex="0">
                                                        <h6 class="comts-no">
                                                            <?php
                                                                    if (isset($offline->pending_appl) && !empty($offline->pending_appl)) {
                                                                        echo $offline->pending_appl;
                                                                    } else {
                                                                        echo '00';
                                                                    }
                                                                    ?>
                                                        </h6>
                                                        <p class="comnt-name">Pending</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="applictin-tile-sec">
                                                <div class="appliction-til-nam" tabindex="0">
                                                    <h6>Document Requested</h6>
                                                </div>
                                                <div class="tiles-comnts">
                                                    <div class="tile-comnt" tabindex="0">
                                                        <h6 class="comts-no">
                                                            <?php
                                                                    if (isset($request->disposed_request) && !empty($request->disposed_request)) {
                                                                        echo $request->disposed_request;
                                                                    } else {
                                                                        echo '00';
                                                                    }
                                                                    ?>
                                                        </h6>
                                                        <p class="comnt-name">Disposed</p>
                                                    </div>
                                                    <div class="tile-comnt" tabindex="0">
                                                        <h6 class="comts-no">
                                                            <?php
                                                                    if (isset($request->pending_request) && !empty($request->pending_request)) {
                                                                        echo $request->pending_request;
                                                                    } else {
                                                                        echo '00';
                                                                    }
                                                                    ?>
                                                        </h6>
                                                        <p class="comnt-name">Pending</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div id="mail" uk-modal class="common-modal">
        <div class="uk-modal-dialog" id="view_contacts_text" align="center">
            <h4> SMS CASE DETAILS <div id="mail_d"></div>
            </h4>
            <!-- <input type="text" name="<?php // echo $this->security->get_csrf_token_name();?>" value="<?php // echo $this->security->get_csrf_hash();?>" placeholder="csrf token"> -->
            <button class="uk-modal-close-default quick-btn"  type="button" uk-close></button>
            <div class="uk-modal-body">
                To: <input type="text" class="form-control cus-form-ctrl" id="recipient_mobile_no" name="recipient_mobile_no" minlength="10" maxlength="10" placeholder="Recipient's Mobile Number">
                <br>
                Message Text: <div id='caseinfosms'></div>
            </div>
            <div class="uk-modal-footer uk-text-right modal-footer" id="con_footer">
            <div class="center-buttons">
                <button class="quick-btn gray-btn uk-button-default uk-modal-close" type="button">Cancel</button>
                <!-- <input type="button" id="send_sms" value="Send SMS " class="quick-btn"
                    onclick="send_sms()"> -->
                    <button type="button" id="send_sms"  class="quick-btn"
                    onclick="send_sms()">Send SMS</button>
            </div>
            </div>
        </div>
    </div>
    <div id="paper-book-viewer-modal" class="uk-modal-full" uk-modal="bg-close:false;esc-close:false;">
        <div class="uk-modal-dialog" uk-overflow-auto>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <iframe src="" height="100%" width="100%" scrolling frameborder="no" uk-height-viewport></iframe>
        </div>
    </div>
    @endsection
    
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js'></script>
    
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="<?= base_url() ?>assets/newAdmin/js/angular.min.js"></script>
    
    <script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit.min.js')}}"></script>
    <script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit-icons.min.js')}}"></script>
    
    <script>
    function loadPaperBookViewer(obj){
        // alert(obj);
        $('#paper-book-viewer-modal iframe').attr('src', $(obj).data('paper-book-viewer-url'));
        UIkit.modal('#paper-book-viewer-modal').show();
    }
    $(document).ready(function() {
        $('#datatable-responsive-srAdv').DataTable();
        $('#efiled-cases-table').DataTable();
    });
    $(document).ready(function() {
        $('#datatable-responsive-sc_cases').DataTable({
            // "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
            "pageLength": 5,
            // "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
        });

        
    });
    </script>
    
    <script>
    $(document).ready(function() {
        $("#byMe").click(function() {
            $("#showByMe").hide();
            $("#showByOthers").show();
        });
        $("#byOthers").click(function() {
            $("#showByOthers").hide();
            $("#showByMe").show();
        });
    });
    </script>
    
    <script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '<?php echo base_url(); ?>dashboard_alt/getDailyCaseCounts',
                    dataType: 'json',
                    success: function(data) {
                        var events = [];
                        data.forEach(event => {
                            var existingEvent = events.find(e => e.start ===
                                event.start);
                            if (!existingEvent) {
                                events.push({
                                    title: event.count,
                                    start: event.start
                                });
                            }
                        });
                        successCallback(events);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    }
                });
            },
            eventContent: function(arg) {
                let titleEl = document.createElement('div');
                titleEl.innerText = arg.event.title;
                let arrayOfDomNodes = [titleEl];
                return {
                    domNodes: arrayOfDomNodes
                };
            },
            eventClick: function(info) {
                var start = moment(info.event.start).format('YYYY/MM/DD');
                $.ajax({
                    url: '<?php echo base_url(); ?>dashboard_alt/getDayCaseDetails',
                    method: "POST",
                    data: {
                        start: start
                    },
                    // dataType: 'json',
                    beforeSend: function() {
                        $('#loader-wrapper').show();
                        var loaderTimeout = setTimeout(function() {
                            $('#loader-wrapper').fadeOut('slow', function() {
                                $('#content').fadeIn('slow');
                            });
                        }, 1000);
                    },
                    success: function(res) {
                        var Table = document.getElementById("datatable-responsive");
                        Table.innerHTML = "";
                        $('#datatable-responsive').html('');
                        $('#datatable-responsive').html(res);

                    },
                    error: function(xhr, status, error) {
                        var Table = document.getElementById("datatable-responsive");
                        Table.innerHTML = "";
                        $('#datatable-responsive').append('<tr><td colspan="8">No Records Found!</td></tr>');
                    }
                });
            }
        });
        calendar.render();
    });

    function showAllCases(){
        window.location.reload();
    }
    // function showAllCases(){
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>dashboard_alt/getDayCaseDetails',
    //         method: "POST",
    //         data: {
    //             start: ''
    //         },
    //         // dataType: 'json',
    //         beforeSend: function() {
    //             $('#loader-wrapper').show();
    //             var loaderTimeout = setTimeout(function() {
    //                 $('#loader-wrapper').fadeOut('slow', function() {
    //                     $('#content').fadeIn('slow');
    //                 });
    //             }, 1000);
    //         },
    //         success: function(res) {
    //             // $('#datatable-responsive').DataTable();
    //             // var table = $('#datatable-responsive').DataTable().destroy();
    //             $('#datatable-responsive').html('');
    //             $('#datatable-responsive').html(res);
    //             // $('#datatable-responsive').DataTable().reload();

    //         },
    //         error: function(xhr, status, error) {
    //             var Table = document.getElementById("datatable-responsive");
    //             Table.innerHTML = "";
    //             $('#datatable-responsive').append('<tr><td colspan="8">No Records Found!</td></tr>');
    //         }
    //     });
    // }

    function get_message_data(id) {
        UIkit.modal('#mail').toggle();
        var x = id.split("#");
        if (x[2] == '')
            document.getElementById('caseinfosms').innerHTML = "Diary No. " + x[0] + "/" + x[1] + " - " + x[3] +
            " VS " + x[4] + " is to be listed on " + x[7] + " in " + x[6] + " as item " + x[5] +
            " subject to order for the day";
        else
            document.getElementById('caseinfosms').innerHTML = "Case No." + x[2] + " - " + x[3] + " VS " + x[4] +
            " is to be listed on " + x[7] + " in " + x[6] + " as item " + x[5] + " subject to order for the day";

    }

    function send_sms() {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var message = document.getElementById("caseinfosms").innerHTML;
        var mobile_no = $("#recipient_mobile_no").val();
        // Regular expression to allow only numbers and limit to 10 digits
        const regex = /^[0-9]{0,10}$/;
        // Check if the input matches the regex
        if (!regex.test(mobile_no)) {
            // If the input doesn't match, prevent the change
            alert('Mobile Number should be numeric and of maximum 10 digits only.');
            event.preventDefault();
            return false;
        }
        // Attach the validation function to the input field
        const inputField = document.getElementById('recipient_mobile_no');
        // inputField.addEventListener('input', validateInput);
        $.ajax({
            type: "POST",
            data: {
                message: message,
                mobile_no: mobile_no,
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
            },
            url: "<?php echo base_url('mycases/citation_notes/send_sms'); ?>",
            success: function(data) {
                var resArr = data.split('@@@');
                if (resArr[0] == 1)
                    alert(resArr[1]);
                else if (resArr[0] == 2) {
                    alert(resArr[1]);
                    $('#recipient_mobile_no').val('');
                    document.getElementById("caseinfosms").innerHTML = '';
                    UIkit.modal('#mail').toggle();
                }
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function(result) {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    }
    $('body').attr('ng-app', 'dashboardApp').attr('ng-controller', 'dashboardController');
    var mainApp = angular.module("dashboardApp", []);
    mainApp.directive('onFinishRender', function($timeout) {
        return {
            restrict: 'A',
            link: function(scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function() {
                        scope.$emit(attr.onFinishRender);
                    });
                }
            }
        }
    });
    mainApp.directive('ngFocusModel', function($timeout) {
        return {
            link: function(scope, element, attrs) {
                element.bind('click', function() {
                    $timeout(function() {
                        jQuery('[ng-model="' + attrs.ngFocusModel + '"]').focus();
                    });
                })
            }
        }
    });
    mainApp.directive('ngFocus', function($timeout) {
        return {
            link: function(scope, element, attrs) {
                element.bind('click', function() {
                    $timeout(function() {
                        jQuery(attrs.setFocus).focus();
                    });
                })
            }
        }
    });
    mainApp.controller('dashboardController', function($scope, $http, $filter, $interval, $compile) {});
    $(function() {
        ngScope = angular.element($('[ng-app="dashboardApp"]')).scope();
        $('.documents-widget,.my-documents-widget,.applications-widget,.defects-widget [uk-drop]').on('shown',
            function() {
                $('#content > *:not(#widgets-container)').addClass('sci-blur-medium');
            }).on('hidden', function() {
            $('#content > *:not(#widgets-container)').removeClass('sci-blur-medium');
        });

        scutum.require(['datatables', 'datatables-buttons'], function() {
            //    $('#myTable').DataTable();
            /*$('#soon-to-be-listed-cases-table').DataTable({
                "pageLength": 100
            });*/
            $('#efiled-cases-table').DataTable({
                "bSort": false,
                initComplete: function() {
                    this.api().columns().every(function(indexCol, thisCol) {
                        var columnIndex = [];
                        if (userTypeId && userTypeId == 19) {
                            columnIndex[0] = 3;
                        } else {
                            columnIndex[0] = 1;
                            columnIndex[1] = 3;
                        }
                        if ($.inArray(this.selector.cols, columnIndex) !== -1) {
                            var column = this;
                            var select = $(
                                '<select class="uk-select"><option value="">' +
                                this.context[0].aoColumns[this.selector.cols]
                                .sTitle + '</option></select>').appendTo($(
                                column.header()).empty()).on('change',
                            function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(val ? '^' + val + '$' : '',
                                    true, false).draw();
                            });
                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' +
                                    d + '</option>')
                            });
                        }
                    });
                }
            });
        });
    });
    </script>
     