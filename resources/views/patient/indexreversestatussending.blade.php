<!-- Modal -->
<div class="modal fade" id="patientreversestatussendingclosejobmodal" role="dialog" style="text-align: center;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" >

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-12">
                            <input type="hidden" id="patientreversestatussendingid" name="patientreversestatussendingid" value="">
                            <div class="txt-h" style="font-size:30px !important">คุณต้องการย้อนสถานะกลับหรือไม่</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-stemi-closejob-close btn-block"  onclick="clickReverStatus()">
                            <div class="txt">ตกลง</div>
                        </button>
                    </div>
                </div>
                <div class="col-12 mb-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-stemi-closejob-close btn-block" data-dismiss="modal" onclick="onclickClose()">
                            <div class="txt">ปิด</div>
                        </button>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>
