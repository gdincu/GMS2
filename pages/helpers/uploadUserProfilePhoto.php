<?php 
/**
 * Store Image File in Database
 */ 
// If file upload form is submitted 
if (!isLoggedIn()) {
    echo "Permission error";
} else if(isset($_POST["saveChanges"])){ 
    if(!empty($_FILES["image"]["name"])) { 
        $status = 'error'; 
        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $statusMsg = "Sorry, your file is too large.";
        } else {
            // Get file info 
            $fileName = strtolower(basename($_FILES["image"]["name"])); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
            
                // Update image content into database
                $user = getLoggedInUser(); 
                $insert = $connection->query("UPDATE user SET image = '$imgContent' WHERE username='$user'"); 
                
                if($insert){ 
                    $status = 'success'; 
                    $statusMsg = "File uploaded successfully."; 
                }else{ 
                    $statusMsg = "File upload failed, please try again."; 
                }  
            }else{ 
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
            }
        }
        
        
        if ($status != 'success') {
            // Display status message
            $_SESSION["photo_size"] = 1; 
            echo $statusMsg; 
        }
    }
}

?>