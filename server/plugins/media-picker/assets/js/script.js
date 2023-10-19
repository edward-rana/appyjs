var media_picker_multiselect = false;
var media_picker_callback = '';
class compMediaPicker{
	constructor(modal_selector = '#MediaPickerModal'){
		this.modal_selector = modal_selector;
		this.modal = $(modal_selector);
	}

	show(types = '', callback = '', selected_ids = '', multiselect = false){
		// get_media_picker(types, callback, selected_ids, multiselect);

        media_picker_multiselect = multiselect;
        media_picker_callback = callback;
        //console.log( media_picker_multiselect );
        var s_types = types.split(',');
        var str_types = '';
        for(var i in s_types ){
            str_types += '.'+s_types[i].replace(/\s+/g, ' ').trim()+',';
        }

        $("#df-input-files").val('');
        $("#df-input-files").attr("accept", str_types);
        $("#df-gallery").html('');


        var thiss = this;

        $.ajax({url: site_url('/ajax.php'),
            type: "POST",
            data: {action: 'mdp_handle_requests', do: 'get_media', file_types: types},
            success: function(res){
                //console.log( res );
                res = JSON.parse( res );
                if( res.status == 'success' && res.data ){
                    $("#df-gallery").html( res.data );

                    if( selected_ids ){
                        for(var i in selected_ids){
                            if( selected_ids[i] ){
                                $("[mp-data-id="+selected_ids[i]+"]").trigger("click");
                            }    
                        }
                    }
                }

                thiss.modal.modal('show');
            }
        });
	}

	hide(){
		this.modal.modal('toggle');
	}
}

var mediaPicker = new compMediaPicker();

$("#btn_media_picker_selected").click(function(){
    var ids = [];
    $(".df-gallery-content-img").each(function(){
        if( $(this).hasClass("selected") ){
            ids.push({id: $(this).attr("mp-data-id"), name: $(this).attr("title"), src: $(this).attr("src")});
        }
    });

    if( !media_picker_multiselect ){
    	ids = ids[0];
    }

    if( !ids ){
    	//notify("info", "Click on image to select");
    	notify("error", "Please select image");
    	return false;
    }

    if( media_picker_callback ){
        media_picker_callback(ids);
    }

    mediaPicker.hide();

    // if( $("#media_modal").css("display") != "none" )
    // 	$("#btn_media_picker_close").trigger("click");
});

// ************************ Drag and drop ***************** //
var dropArea = document.getElementById("df-drop-area");

$(document).ready(function(){
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false); 
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    dropArea.addEventListener('drop', handleDrop, false);
});

function preventDefaults (e) {
  e.preventDefault()
  e.stopPropagation()
}

function highlight(e) {
  dropArea.classList.add('df-highlight')
}

function unhighlight(e) {
  dropArea.classList.remove('df-highlight')
}

function handleDrop(e) {
  var dt = e.dataTransfer
  var files = dt.files

  handleFiles(files)
}

let uploadProgress = []
//let progressBar = document.getElementById('df-progress-bar')

function initializeProgress(numFiles) {
  //progressBar.value = 0;

  uploadProgress = [];

  for(let i = numFiles; i > 0; i--) {
    uploadProgress.push(0)
  }
}

function updateProgress(fileNumber, percent) {
    //console.log( percent );
  uploadProgress[fileNumber] = percent
  let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length
  console.debug('update', fileNumber, percent, total)
  //progressBar.value = total

  // if( percent == 100 ){
  //       $("#df-progress-bar").hide();
  //   }
  //   else if( $("#df-progress-bar").css("display") == 'none' ){
  //           $("#df-progress-bar").show();
  //   }
}

function handleFiles(files) {
  files = [...files]
  initializeProgress(files.length);
  files.forEach(previewFile);
  //files.forEach(uploadFile);
 
}

var df_upload_processing_count = 0;

function previewFile(file) {
  
  let reader = new FileReader()
  reader.readAsDataURL(file)
  reader.onloadend = function() {
    df_upload_processing_count++;

    uploadFile(file, df_upload_processing_count);

    let img = document.createElement('img');
    $(img).css("opacity", "0.5");
    //let span  = document.createElement('span');

    //span.classList.add("df-gallery-remove-img");
    //span.innerHTML = 'x';

    let span1  = document.createElement('div');
    span1.classList.add("col-md-2", "col-sm-3", "col-xs-6", "df-gallery-content", "df-gallery-content-index-"+df_upload_processing_count);

    //span1.appendChild(span);

    span1.appendChild(img);

    img.classList.add("df-gallery-content-img", "img-thumbnail");

    $(img).attr("onclick", "df_gallery_content_img(this)");

    img.src = reader.result
    $('#df-gallery').prepend(span1);

    //$("#df-gallery").html('<div class="col-md-3">'+span+img+'</div>');

    // if($("#df-gallery").text()){
    //     $("#df-gallery").css("margin-top", "10px");
    // }
  }
}

function uploadFile(file, i) {
   

  $("#df-progress-bar").show();

  var url = site_url('/ajax.php');
  var xhr = new XMLHttpRequest();
  var formData = new FormData();
  xhr.open('POST', url, true);
  xhr.processing_index = i; //df_upload_processing_count;

  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

  // Update progress (can be used to show progress indicator)
  xhr.addEventListener("progress", function(e) {
    //console.log( e.loaded );
    //updateProgress(i, e.loaded / e.total * 100 )
  })

  xhr.addEventListener('readystatechange', function(e) {
    if (xhr.readyState == 4 && xhr.status == 200) {
        //console.log( xhr.response );
        //updateProgress(i, 100) // <- Add this

        res = JSON.parse( xhr.response );

        //console.log( xhr.processing_index );

        if( res.status == 'success' ){
            $(".df-gallery-content-index-"+xhr.processing_index).html( res.html );
        }
        else{
            $(".df-gallery-content-index-"+xhr.processing_index).remove();
        }

        df_upload_processing_count--;

        if( df_upload_processing_count < 1 ){
            $("#df-input-files").val('');
            $("#df-progress-bar").hide();
        }
    }
    else if (xhr.readyState == 4 && xhr.status != 200) {
      // Error. Inform the user
    }
  })

  formData.append('action', 'mdp_handle_requests');
  formData.append('do', 'upload_file')
  formData.append('file', file)
  xhr.send(formData)
}

function df_click_to_upload(){
    $("#df-input-files").trigger("click");
}

function df_gallery_content_img(e){

    if( !media_picker_multiselect ){
        $(".df-gallery-content-img").removeClass("selected");
    }

    if( $(e).hasClass("selected") ){
        $(e).removeClass("selected");
    }
    else{
        $(e).addClass("selected");
    }
}

function df_remove_img(e, id){
    if( !confirm("Are you sure to remove file?") )
        return false;

    $("#df-progress-bar").show();

     $.ajax({url: site_url('/ajax.php'),
        type: "POST",
        data: {action: 'mdp_handle_requests', do: 'remove_media', ids: id},
        success: function(res){
            //console.log( res );
            res = JSON.parse( res );
            if( res.status == 'success'){
                $(e).parent().remove();
            }

            $("#df-progress-bar").hide();
        }
    });
}

