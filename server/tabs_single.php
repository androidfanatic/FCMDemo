<?php if ( ! isset( $DASHBOARD ) ) exit; ?>

<h3>Push Notification To Individual Devices</h3>

<form method="post" enctype="multipart/form-data">

<?php

$db = new Db;

$users = $db->get_users();

if ( count ( $users ) > 0 ) {

?>    <div class="form-group">
                
        <select name="token" class="form-control">
        
<?php

    foreach ( $users as $user ) {
        
        echo '<option value=" ' .$user['token'] . '">' . $user['name'] . ' => ' . $user['email'] . ' => ' . $user['mobile'] . '</option>';
        
    }
?>
        </select>

    </div>

<?php

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

if ( isset ( $_POST['title']) && isset( $_POST['body'] ) && isset( $_POST['token'] ) ) {

    $title = $_POST['title'];
       
    $body = $_POST['body'];
    
    $token = $_POST['token'];
    
    if ( $title != '' && $body != '' && $token != '') {
        
        $fcm = new Fcm;
        
        if ( isset ( $_FILES['image'] ) && $_FILES['image']['error'] === 0 && $_FILES['image']['size'] > 0 ) {
        
            $image =  basename( $_FILES['image']['name'] ) ; 
        
            $ext = strtolower( pathinfo ( $image , PATHINFO_EXTENSION)); 

            if ( in_array( $ext, array( 'gif', 'jpg', 'jpeg', 'png' ) ) ) {
            
                $image = time() . '.' . $ext;
            
                move_uploaded_file ( $_FILES['image']['tmp_name'], UPLOAD_PATH . $image ) ;
                
                $fcm->sendData ( $title, $body, $image, $token );
                
            }            
            
        } else {
        
            $fcm->sendNotif ( $title, $body, $token );
            
        }
    
    } else {
    
    
    echo '<div class="alert alert-danger" role="alert">Form incomplete.</div>';
        
    }

} 

?>
