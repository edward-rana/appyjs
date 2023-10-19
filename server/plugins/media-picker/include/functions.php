<?php
/**
 * @package include/functions
 * @author Edward Rana
 */
if( !defined("BASE_DIR") ) exit;

ac_ajax('mdp_handle_requests', function(){
    
    $do = @$_POST['do'];
    $res = array('status' => 'error', 'msg' => 'No data');
    if( !$do ){
        die(json_encode($res));
    }

    if( $do == 'get_media' ){
        $db = new DB;

        if( @$_POST['file_types'] ){
            $types = explode(',', $_POST['file_types']);

            foreach( $types as $type ){
                $type = trim($type, ' ');

                $db->or_where('type', '=', $type);
            }
        }

        $files = $db->order_by('sorting', 'DESC')->get('tbl_files');

        $html = '';

        foreach( $files as $file ){
            $html .= '<div class="col-md-2 col-sm-3 col-xs-6 df-gallery-content"><span class="df-gallery-remove-img" onclick="df_remove_img(this, '.$file->ID.')">x</span><img class="df-gallery-content-img img-thumbnail" onclick="df_gallery_content_img(this)" ondblclick="$(\'#btn_media_picker_selected\').trigger(\'click\');" mp-data-id="'.$file->ID.'" src="'.storage_url('/'.$file->path).'" title="'.basename($file->name, ".".$file->type).'"></div>';
        }

        $res = array('status' => 'success', 'msg' => 'Media fetched', 'data' => $html);
    }
    elseif( $do == 'upload_file' ){
        //sleep(2);
        if( @$_FILES['file']['name'] ){
            $res = upload_file('file', array('allowed_types' => 'jpg, png, jpeg', 'dir' => 'media'));

            //print_r($res);

            if( $res['status'] == 'success' ){
                $db = new DB;

                $data = array('name' => $res['filename'], 'path' => $res['filepath'], 'type' => $res['file_type'], 'file_size' => $res['file_size'], 'created_date' => date('Y-m-d H:i:s'));

                if( $last_file = @$db->order_by('sorting', 'DESC')->limit(1)->get('tbl_files')[0] ){
                    $data['sorting'] = ($last_file->sorting + 1);
                }

                if( @$res['sizes'] ){
                    $data['sizes'] = serialize($res['sizes']);
                }

                
                $file_id = $db->insert('tbl_files', $data);

                $html = '<span class="df-gallery-remove-img" onclick="df_remove_img(this, '.$file_id.')">x</span><img class="df-gallery-content-img img-thumbnail" onclick="df_gallery_content_img(this)" mp-data-id="'.$file_id.'" src="'.storage_url('/'.$res['filepath']).'">';

                $res = array('status' => 'success', 'msg' => 'File uploaded', 'html' => $html);
            }
        }
    }

    elseif( $do == 'remove_media' && @$_POST['ids'] ){
        $ids = array_filter( explode(',', $_POST['ids']) );

        foreach( $ids as $id ){
            if(!is_numeric($id)) continue;

            delete_file( $id );
        }

        $res = array('status' => 'success', 'msg' => 'File deleted');
    }

    echo json_encode($res);
    exit;
});

function delete_file( $args ){
    $db = new DB;

    //Delete from Storage..
    if( is_numeric($args) ){
        $db->where('ID', '=', $args);
    }
    elseif( is_array($args) ) {
        foreach( $args as $key => $val ){
            $db->where($key, '=', $val);
        }   
    }

    $files = $db->get('tbl_files');

    foreach( $files as $file ){
        if( $file->sizes ){
            $f_sizes = unserialize( $file->sizes );
            //print_r($f_sizes);

            foreach( $f_sizes as $f_size ){
                unlink(storage_dir('/').$f_size);
            }
        }
        else{
            unlink(storage_dir('/').$file->path);
        }
    }

    //Delete from DB..
    if( is_numeric($args) ){
        $db->where('ID', '=', $args);
    }
    elseif( is_array($args) ) {
        foreach( $args as $key => $val ){
            $db->where($key, '=', $val);
        }   
    }

    return $db->delete('tbl_files');
}