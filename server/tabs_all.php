<?php if ( ! isset( $DASHBOARD ) ) exit; ?>

<h3>Push Notification To All Devices</h3>

<form method="post" enctype="multipart/form-data">
    
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

if ( isset ( $_POST['title']) && isset( $_POST['body'] ) ) {

    $title = $_POST['title'];
       
    $body = $_POST['body'];
    
    if ( $title != '' && $body != '' ) {
                
        $fcm = new Fcm;
        
        if ( isset ( $_FILES['image'] ) && $_FILES['image']['error'] === 0 && $_FILES['image']['size'] > 0 ) {
        
            $image =  basename( $_FILES['image']['name'] ) ; 
        
            $ext = strtolower( pathinfo ( $image , PATHINFO_EXTENSION)); 

            if ( in_array( $ext, array( 'gif', 'jpg', 'jpeg', 'png' ) ) ) {
            
                $image = time() . '.' . $ext;
            
                move_uploaded_file ( $_FILES['image']['tmp_name'], UPLOAD_PATH . $image ) ;
                
                $fcm->sendDataAll ( $title, $body, $image );
                
            }            
            
        } else {
        
            $fcm->sendNotifAll ( $title, $body );
            
        }
    
    } else {
    
    
    echo '<div class="alert alert-danger" role="alert">Form incomplete.</div>';
        
    }

} 

?>
