<!-- Modal -->
<div class="modal fade" id="patienttravelingmodal" role="dialog" style="text-align: center;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="background-color:#ca004e;color:#fff;">

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-12">
                            <img style="height:280px;width380px;" src="{{url('')}}/public/stemi_images/ambulance.png">
                            <input type="hidden" id="patienttravelingid" name="patienttravelingid" value="">
                            <input type="hidden" id="patienttravelingphone" name="patienttravelingphone" value="">
                        </div>
                        <div class="col-12 mb-12">
                            <div class="txt text-modal-send">กำลังส่งตัวผู้ป่วย</div>
                        </div>
                        <div class="col-12 mb-12">
                            <div id="patienttraveling_patient_name" class="txt text-modal-send">ผู้ป่วย:</div>
                        </div>
                        <div class="col-12 mb-12">
                            <div id="patienttraveling_hospital_name" class="txt text-modal-send">ผู้ป่วยจาก:</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-stemi-closejob-save btn-block" data-dismiss="modal" onclick="onclickMapHospital2()">
                            <div class="txt">ดูตำแหน่ง</div>
                        </button>
                        <button type="button" class="btn btn-stemi-closejob-close btn-block" data-dismiss="modal" onclick="onclickClose()">
                            <div class="txt">รับทราบ</div>
                        </button>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>
