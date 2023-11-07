<div class="content-wrapper">
    <div class="overlay dark" v-if="appLoading">
        <div class="loader"></div>
    </div>
    <router-view></router-view>

    <div class="modal fade" id="__mopi_alert" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title subject"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="message"></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary agree func">はい</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
