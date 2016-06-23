<?php

require_once ( 'config.php' );

class Db {

    private $db = null;
    
    function __construct() {
    
        $this->db = new mysqli ( 
            MYSQL_HOST, 
            MYSQL_USER, 
            MYSQL_PASS, 
            MYSQL_DBNAME
        );
        
        if ( $this->db->connect_errno ) {
            
            exit( 'DB connection error.' );    
            
        }

    }
    
    function save_user ( $name, $email, $mobile, $token ) {
        
        
        if ( ! $this->db ) return -1;
        
        
        $stmt = $this->db->stmt_init();
        
        $stmt->prepare ( 
            'INSERT INTO users (name, email, mobile, token) VALUES (?,?,?,?)' 
        );
        
        if ( ! $stmt ) return -1;
        
        $stmt->bind_param( 
            'ssss', 
            $name, 
            $email, 
            $mobile, 
            $token
        );
        
        $result = $stmt->execute();
        
        return $result;
                
    }
    
    function get_users ( ) {
    
            $users = array();
            
            $query = $this->db->query ( 'SELECT * FROM users' ) ;
            
            if ( $query ) {
            
                while ( $row = $query->fetch_array(MYSQLI_ASSOC) ) {
                    
                    $users[] = $row;
                    
                    
                }
                
                $query->free();
            
            }
            
            return $users;
        
    }

}


