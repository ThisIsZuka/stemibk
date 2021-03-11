<!-- Modal -->
<div class="modal fade" id="patientreversestatusclosejobmodal" role="dialog" style="text-align: center;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="background-color:#E67E22;color:#fff;">

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-12">
                            <img style="height:280px;width380px;" src="{{url('')}}/public/stemi_images/ambulance.png">
                        </div>
                        <div class="col-12 mb-12">
                            <div  class="txt text-modal-send">มีการย้อนกลับรายการส่งงาน</div>
                        </div>
                        <div class="col-12 mb-12">
                            <div id="reversestatus_patient_name" class="txt text-modal-send">ชื่อ:</div>
                        </div>
                        <div class="col-12 mb-12">
                            <div id="reversestatus_hospital_name" class="txt text-modal-send">ส่งจาก:</div>
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
