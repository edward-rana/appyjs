<!-- MediaPicker Modal -->
<div class="modal fade" id="MediaPickerModal" style="z-index: 9999">
  <div class="modal-dialog modal-xl modal-simple modal-pricing">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
        <div class="card mb-4">
          <h5 class="card-header">Media Picker</h5>
          <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div id="df-drop-area" class="">
                            <div style="padding: 10px; cursor: pointer; border: dotted 2px #eaeaea; border-radius: 4px;" onclick="df_click_to_upload();">Drop your files here or click here to upload files</div>
                            <input type="file" id="df-input-files" multiple accept="image/*" onchange="handleFiles(this.files)" class="form-control" style="display: none;">                       
                        </div>
                        
                    </div>
                    <div class="col-xs-12">
                        <div id="df-progress-bar" style="display: none;"></div>
                        <div id="df-gallery" class="row sortable"></div>
                    </div>
                </div>
          </div>
          <div class="card-footer text-center">
                <button id="btn_media_picker_close" type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close">Close</button>

                <button type="button" id="btn_media_picker_selected" class="btn btn-success">
                    <i class="fa fa-image"></i>
                    <span>Okay</span>
                </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ MediaPicker Modal -->