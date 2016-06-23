<?php

/* 
API endpoint: /reg.php
Schema:
    In:
        Method: POST
        Params:
            name: username
            email: valid email address
            mobile: ten digit mobile number
            token: firebase access token
            
    Out:
        Type: application/json
        Params:
            {
                error : error message if any errors are encountered
                success : success message if everything goes as usual
            }       

*/

require_once( 'db_class.php' );

class RegApi{

    private $response = [];

    function get_var( $param ) {

        if ( isset ( $_POST[ $param ] ) && $_POST[ $param ] != '' ) {
    
            return $_POST[ $param ] ;

        } else {
        
            $this->fatal_error( $param . ' was null.' ) ;
        
        }
    }
    
    function error ( $error_msg ) {
        
        $this->response[ 'error' ] = $error_msg;

    }

    function success ( $success_msg ) {
        
        $this->response[ 'success' ] = $success_msg;

    }
    
    function fatal_error ( $error_msg ) {
        
        $this->response[ 'error' ] = $error_msg;
        
        $this->send_response();
        
    }

    function send_response() {
    
        print json_encode($this->response, JSON_PRETTY_PRINT);
    
        exit;
    }

    function serve() {

        $name = $this->get_var('name');

        $email = $this->get_var('email');

        $mobile = $this->get_var('mobile');

        $firebase_token = $this->get_var('token');
        
        if ( filter_var($email, FILTER_VALIDATE_EMAIL) == false ) {
            
            $this->fatal_error( 'Invalid email address.' );
            
        }
        
        if ( preg_match( '/^\d{10}$/', $mobile ) == false ) {
            
            $this->fatal_error( 'Invalid mobile number.' );    
            
        }
        
        $db = new Db;
        
        $success = $db->save_user ( 
            $name,
            $email,
            $mobile,
            $firebase_token
        );
        
        if ( $success ) {
            
            $this->success ( 'User created.' );
            
        } else {
            
            $this->error( 'Unable to create user.' );
        
        }
                
        $this->send_response();

    }
    
}

$regApi = new RegApi;

$regApi->serve();
