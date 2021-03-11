<!-- Modal -->
<div class="modal fade" id="patientclosejob" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ปิดงานส่งตัวผู้ป่วย</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="patientclosejobid" name="patientclosejobid" value="">
                <textarea id="textareacancelmessage" class="form-control" placeholder="กรอกข้อมูลกรณีปิดงานระหว่างทาง" style="height:100px;width:100%;overflow:hidden; resize: none ;"></textarea>
                <div class="container">
                <div class="row">
                    <div class="col-12">
                        <button type="button" onclick="clickUpdateSendPatientAlongWay()"
                            class="btn btn-stemi-closejob-cancel btn-block" style="margin-top:10px">
                            <div class="txt">ปิดงาน ระหว่างทาง</div>
                        </button>
                    </div>
                    <div class="col-12">
                        <button type="button" onclick="clickUpdateSendPatient()"
                            class="btn btn-stemi-closejob-save btn-block" style="margin-top:10px">
                            <div class="txt">ปิดงาน ส่งตัวผู้ป่วย</div>
                        </button>
                    </div>
                    <div class="col-12">
                    <button type="button" class="btn btn-stemi-closejob-close btn-block" data-dismiss="modal" style="margin-top:10px">
                        <div class="txt">ยกเลิก</div>
                    </button>
                    </div>
                </div>
            </div>
            </div>



        </div>

    </div>
</div>
