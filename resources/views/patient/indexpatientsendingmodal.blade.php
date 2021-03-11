<!-- Modal -->
<div class="modal fade" id="patientsendclosejobmodal" role="dialog" style="text-align: center;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="background-color:#ca004e;color:#fff;">

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-12">
                            <img style="height:280px;width380px;" src="{{url('')}}/public/stemi_images/ambulance.png">
                        </div>
                        <div class="col-12 mb-12">
                            <div class="txt-h">การส่งผู้ป่วยสำเร็จ</div>
                        </div>
                        <div class="col-12 mb-12">
                            <div id="sending_patient_name" class="txt text-modal-send">ชื่อ:</div>
                        </div>
                        <div class="col-12 mb-12">
                            <div id="sending_hospital_name" class="txt text-modal-send">ส่งจาก:</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-stemi-closejob-close btn-block" data-dismiss="modal" onclick="onclickClose()">
                            <div class="txt">รับทราบ</div>
                        </button>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>
