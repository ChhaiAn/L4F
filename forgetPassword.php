<?php
include("cdb.php");
 $db_question = '';





     if(isset($_POST['search'])){
         $forgetEmail = $_POST['search'];
         $forgetEmail = mysqli_real_escape_string($connection, $forgetEmail);

         $query = "SELECT * FROM USER_REGISTRATION WHERE email = '$forgetEmail'";
         $result = mysqli_query($connection,$query);
         $a = mysqli_fetch_array($result);

         $db['user'] = $a['username'];
         $db['gender'] = $a['gender'];
         $db['email'] = $a['email'];
         $db['picture'] = $a['profile_image'];
         if( $db['picture'] == ""){
            if($db['gender'] == "male"){
              $db['picture'] = 'boy';
            }
            else {
              $db['picture'] = 'girl';
            }
         }
         $db['secuQuestion'] = $a['secure_question'];
         $db['secuAnswer'] = $a['secure_answer'];
         $db['password'] = $a['password'];
         $db['id'] = $a['user_id'];
        if ($db['email'] !== $forgetEmail) {
            echo "Bad Json";
        } else{
            echo json_encode($db);
        }


    }

    if(isset($POST['answer'])) {

        header("Location: resetPassword.php");


        // $body = "Hi, ".$db['user'].". You are recieving this email because you have asked for your account password.";
        // $body = $body. "<p> Your password is ".$db['password']."</p>" ;
        // mail($email, 'Account Password Request',
        // $body, 'From: lee.supermonkey@gmail.com');

    }





?>
