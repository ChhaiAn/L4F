<?php
session_start(); ob_start();
include("adminHeader.php");
include("cdb.php");
$_GET['user_id'];




$query = "SELECT * FROM USER_REGISTRATION WHERE user_id = '".$_GET['user_id']."'";
$result = mysqli_query($connection,$query);
if (!$result){
  echo mysqli_error($connection);
}
$row = mysqli_fetch_assoc($result);

$pictureDefault = true;
$username = $row['username'];
$email = $row['email'];
$userlevel = $row['user_level'];
$active = $row['active'];
$userid = $row['user_id'];
$usergender= $row['gender'];
$userpicture = $row['profile_image'];

if ($userpicture == ""){
  $pictureDefault = false;
}





//UPDATE THE DATABASE

if(isset($_POST['submit'])) {

  $update_username = $_POST['userName'];
  $update_email = $_POST['userEmail'];
  $update_userlevel = $_POST['userLevel'];
  $update_active = $_POST['userActive'];
  $update_bio = $_POST['userBio'];

  $query = "UPDATE USER_REGISTRATION SET
            username = '$update_username',
            email = '$update_email',
            user_level='$update_userlevel',
            active='$update_active',
            about_me='$update_bio'
            WHERE user_id ='$userid'";

  $result = mysqli_query($connection,$query);
  if(!$result) {
    echo mysqli_error($connection);
  }



  // if ($update_userlevel == 5){
  //   header("Location: user_edit_profile.php?user_id=$userid");
  //   exit();
  // }

  header("Location: user_edit_profile.php?user_id=$userid");

}
// DELETE USER
if(isset($_POST['delete'])) {
   $query = " DELETE FROM USER_REGISTRATION
              WHERE user_id ='$userid'";
  $result = mysqli_query($connection,$query);

  if($result){
    echo "user deleted";
  }
  else {
    echo mysqli_error($connection);
  }

  header('Location: view-user.php');
}









// UPLOAD PIC TO DATABASE
if(isset($_POST['imageUpload'])){

// Desired folder structure
$structure = 'uploads/'.strtolower($username).'/userprofile/';



$tmp_file = $_FILES['the_file']['tmp_name'];
// Make folder
mkdir($structure, 0777, true);

$image = ($_FILES['the_file']['name']);

$image = mysqli_real_escape_string($connection,$image);

//Store image name inside database
if($_FILES['the_file']['size'] == 0) {
  header('Location: '.$_SERVER['REQUEST_URI']);
  }
  else {
$query = "UPDATE `USER_REGISTRATION` SET `profile_image` = '$image' WHERE `user_id` = \"$userid\"";
$result = mysqli_query($connection, $query);

if(!$result) {
  echo mysqli_error($connection);
}
$tmp_file = $_FILES['the_file']['tmp_name'];



     // Try to move the uploaded file:
        if (move_uploaded_file ($tmp_file, $structure.$image)) {


            print '<p class="text-center ">Your file has been uploaded.</p>';

        } else { // Problem!

            print '<p style="color: red;">Your file could not be uploaded because: ';

            // Print a message based upon the error:
            switch ($_FILES['the_file']['error']) {
                case 1:
                    print 'The file exceeds the upload_max_filesize setting in php.ini';
                    break;
                case 2:
                    print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form';
                    break;
                case 3:
                    print 'The file was only partially uploaded';
                    break;
                case 4:
                    print 'No file was uploaded';
                    break;
                case 6:
                    print 'The temporary folder does not exist.';
                    break;
                default:
                    print 'Something unforeseen happened.';
                    break;
            }

            print '.</p>'; // Complete the paragraph.

        } // End of move_uploaded_file() IF.


 header('Location: '.$_SERVER['REQUEST_URI']);


        //header("Location: profile.php");
    } // End of submission IF.
  }


?>
    <!--GRID START-->
    <div id="wrapper">
          <div class="row mt-3 mx-3 justify-content-around">

              <!--LEFT ASIDE CONTENT-->
              <div class="col-sm-2 my-aside">
                    <div class="list-group ">
                            <a href="#" class="list-group-item list-group-item-action active bg-info text-center">
                              Welcome, <?php echo $_SESSION['username'] ?>
                            </a>


                            <a href="view-user.php" class="list-group-item list-group-item-action"><span><i class="fa fa-user" aria-hidden="true"></i>
                            </span>Users &amp; Privileges</a>
                            <a href="create-new-user.php" class="list-group-item list-group-item-action"><span><i class="fa fa-user-plus" aria-hidden="true"></i>
                            </span>Create New User</a>
                            <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                            <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>
                    </div>
              </div><!--LEFT ASIDE CONTENT END-->



              <div class="col-sm-9 my-right-content">

                    <div class="list-group ">
                            <a href="#" class="list-group-item list-group-item-action active bg-danger text-center">
                                USER EDIT
                            </a>

                          <div id="profile-image-wrapper-id" class="container profile-image-wrapper p-5">
                        <img id="default-profile-image" width ="200" height ="200" src="<?php
                    if ($pictureDefault == false) {

                        if ($usergender == "female") {
                            echo 'images/icon/userProfile/girl.svg';
                        } else {
                            echo 'images/icon/userProfile/boy.svg';
                        }

                    }  else {
                        echo "uploads/".strtolower($username).'/userprofile/'.$userpicture;


                    }

                    ?>" alt="" class="profile-image">

                    </div>
                          <div class="container">
                            <form action="user_edit_profile.php?user_id=<?php echo $userid; ?>" method="post" enctype="multipart/form-data">
                              Select image to upload:
                              <input type="file" name="the_file" id="fileToUpload">
                              <input type="submit" value="upload Image" name="imageUpload">
                            </form>
                          </div>
                          <form class="mt-3" action="" method="post">
                            <fieldset class="form-group">
                              <div class="container">
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label for="userFirstName">User Name</label><br>
                                    <input class="form-control" id="userFirstName" type="text" name="userName"
                                    value="<?php echo $username; ?>">
                                  </div>

                                  <div class="col-sm-4">
                                    <label for="userEmail">Email</label><br>
                                    <input class="form-control" id="userEmail" type="email" name="userEmail" value="<?php echo $email; ?>">
                                  </div>

                                  <div class="col-sm-4">
                                    <label for="userLastName">User Level</label><br>
                                    <select class="form-control" id="userLevel" name="userLevel">
                                      <?php
                                        echo "<option selected='selected' value='$userlevel'>".$userlevel."</option>";
                                        if ($userlevel == 5){
                                          echo "<option value='0'>0</option>";
                                        }
                                        else {
                                          echo "<option value='5'>5</option>";
                                        }


                                      ?>

                                    </select>
                                  </div>
                                  <div class="col-sm-4">
                                    <label for="userFirstName">Active</label><br>
                                    <select class="form-control" id="userActive" name="userActive">
                                      <option value="Y">Y</option>
                                      <option value="N">N</option>
                                    </select>
                                  </div>
                                </div><!--ROW-->
                              </div>
                            </fieldset>
                            <div class="container">
                              <fieldset class="mt-3">

                                  <label for="userBio">Biography </label><br>
                                  <textarea class="form-control" name="userBio"></textarea>

                              </fieldset>
                              <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
                              <button type="submit" class="btn btn-danger my-2" id="deleteUser" name="delete">Delete</button>
                            </div>
                          </form>

                    </div>
              </div>
          </div>
        </div><!--WRAPPER-->
   <?php
   include("adminFooter.php");
   ?>
