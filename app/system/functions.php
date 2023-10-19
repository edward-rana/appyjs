<?php
function aj_page_title_metas(){
    /**
     * Secret code
     *
     * Verify secret code on server api code to make sure curl request
     * sent from this app system.
     *
     * @method GET
     */
    $secret_key = '406dcddf-78db-1c59-b448-5e8499030c26';

    $url = 'http://localhost:81/webapp/server?provider=appyjs&secret_key='.$secret_key.'&query=';

    $query = '';
    if( isset( $_SERVER['QUERY_STRING'] ) && strpos($_SERVER['QUERY_STRING'], 'path=') !== false ){
        $query_string = rtrim( str_replace('path=', '', $_SERVER['QUERY_STRING']), '/\\');
    }

    $query = rtrim($query, '/\\');
    $url .= urlencode( $query );

    $cookies = [];
    if( $_COOKIE ){
        foreach( $_COOKIE as $key => $val ){
            $cookies[] = $key.'='.$val;
        }
    }
    
    $cookies = implode(';', $cookies);

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

    $headers = [
        'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        'Cookie: '.$cookies
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    /**
     * Return JSON data from server api.
     * 
     * An example of the response:
     * {"status": "success", "title": "Page title", "metas": [{"name": "Content"}]}
     * @var $res
     * @return JSON string
     */
    $res = curl_exec( $ch );

    $html = '';
    try{
        $data = json_decode( $res, true );
        if( ! isset( $data['status'] ) || $data['status'] != 'success' ){
            $data = false;
        }

        $data = [
            'title' => 'HII'
        ];

        if( isset( $data['title'] ) ){
            $html .= '<title>'.$data['title'].'</title>'.PHP_EOL;
        }

        if( isset( $data['metas'] ) && is_array( $data['metas'] ) ){
            foreach( $data['metas'] as $name => $content ){
                $html .= '<meta name="'.$name.'" content="'.$content.'">'.PHP_EOL;
            }
        }
    }
    catch(Exception $e) {
        $data = false;
    }
    
    if( $data ){
        return $html;
    }
    return '';
}