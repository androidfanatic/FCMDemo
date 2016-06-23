<?php

require_once ( 'config.php' );

class FCM {
    
    function curl_request ( $json_post ) {
    
        $ch = curl_init(FCM_SERVER);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode ( $json_post ) );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json', 
            'Authorization:key=' . FCM_SERVER_KEY,
        ));
        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        
        $result = curl_exec($ch);
        
        print_r ( $result );
        
        curl_close($ch);
        
        return $result;
        
    }
        
    function sendData ( $title, $body, $image, $target_token ) {
        
        $json_post = array (
            'to' => $target_token,
            'priority' => 'high',
            'data' => array (
                'title' => $title,
                'body' => $body,
                'image' => BASE_URL . UPLOAD_PATH .  $image
            )
        );
                
        return $this->curl_request ( $json_post ) ;

    }
    
    function sendNotif($title, $body, $target_token) {

        $json_post = array (
            'to' => $target_token,
            'priority' => 'high',
            'notification' => array(
                'title' => $title,
                'body' => $body
            )
        );
        
        return $this->curl_request ( $json_post );

    }    

    function sendDataBulk ( $title, $body, $image, $target_tokens ) {
        
        $json_post = array (
            'registration_ids' => $target_tokens, // array of tokens
            'priority' => 'high',
            'data' => array (
                'title' => $title,
                'body' => $body,
                'image' => BASE_URL . UPLOAD_PATH .  $image
            )
        );
                
        return $this->curl_request ( $json_post ) ;

    }
    
    function sendNotifBulk ( $title, $body, $target_tokens ) {

        $json_post = array (
            'registration_ids' => $target_tokens, // array of tokens
            'priority' => 'high',
            'notification' => array(
                'title' => $title,
                'body' => $body
            )
        );
        
        return $this->curl_request ( $json_post );

    }    

    
    function sendNotifAll ( $title, $body ) {
        
        $this->sendNotif ( $title, $body, '/topics/default' );    
        
    }


    function sendDataAll ( $title, $body, $image ) {
        
        $this->sendData ( $title, $body, $image, '/topics/default' );    
        
    }
    
}
