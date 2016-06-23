<?php if ( ! isset( $DASHBOARD ) ) exit; ?>

<h3>Push Notification To Individual Devices</h3>

<form method="post" enctype="multipart/form-data">

<?php

$db = new Db;

$users = $db->get_users();


if ( count ( $users ) > 0 ) {

shuffle ( $users );

    if ( count ( $users ) > 10 ) {
    
        $users = array_slice ( $users, 0, NUM_RANDOM_USERS ) ;
    
    }
                        
    foreach ( $users as $user ) {
    
        echo '<div class="checkbox">';
        
        echo '<label>';
        
        echo '<input checked="checked" name="tokens[]" type="checkbox" value=" ' .$user['token'] . '" />';
        
        echo  $user['name'] . ' => ' . $user['email'] . ' => ' . $user['mobile'] . '</label>';
        
        echo '</div>';
        
    }

}

?>    
    <div class="form-group">
                
        <input type="text" name="title" class="form-control" placeholder="Message title" />
        
    </div>

    <div class="form-group">
        
        <textarea name="body" class="form-control" placeholder="Message body"></textarea>
        
    </div>

    <div class="form-group">
        
        <input type="file" name="image" class="form-control" />
        
    </div>
    
    <div class="form-group text-right">
        
        <button type="submit" class="btn btn-default">Send Notification</button>
        
    </div>
    
</form>

<?php

if ( isset ( $_POST['title']) && isset( $_POST['body'] ) && isset( $_POST['tokens'] ) ) {

    $title = $_POST['title'];
       
    $body = $_POST['body'];
    
    $tokens = $_POST['tokens'];
    
    if ( $title != '' && $body != '' && count( $tokens ) > 0 ) {
                
        $fcm = new Fcm;
        
        if ( isset ( $_FILES['image'] ) && $_FILES['image']['error'] === 0 && $_FILES['image']['size'] > 0 ) {
        
            $image =  basename( $_FILES['image']['name'] ) ; 
        
            $ext = strtolower( pathinfo ( $image , PATHINFO_EXTENSION)); 

            if ( in_array( $ext, array( 'gif', 'jpg', 'jpeg', 'png' ) ) ) {
            
                $image = time() . '.' . $ext;
            
                move_uploaded_file ( $_FILES['image']['tmp_name'], UPLOAD_PATH . $image ) ;
                
                $fcm->sendDataBulk ( $title, $body, $image, $tokens );
                
            }            
            
        } else {
        
            $fcm->sendNotifBulk ( $title, $body, $tokens );
            
        }
    
    } else {
    
    
    echo '<div class="alert alert-danger" role="alert">Form incomplete.</div>';
        
    }

} 

?>
