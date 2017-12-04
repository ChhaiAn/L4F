<?php
include('cdb.php');
include('adminHeader.php');
session_start();
ob_start();

$hashedPassword = '';
$flag = true;
$accNotFound = false;
$emailExist = false;
$passNotMatch = false;
$usernameExist = false;
$accountFound = false;
$isMe = false;
$userLevel;
//CREATE NEW USER
/*************************************submitCLicked*****************************************/

if(isset($_POST['create'])) {


    $username = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = $_POST['password'];
    $conpass = $_POST['conPassword'];
    $birthDate = $_POST['day'];
    $birthMonth = $_POST['month'];
    $birthYear = $_POST['year'];
    $dob = $birthYear."-".$birthMonth."-".$birthDate;
    $time = strtotime($dob);
    $newformat = date('Y-m-d',$time);
    $date_of_birth = $newformat;
    $gender = $_POST['gender'];
    $_SESSION['gender'] = $gender;
   $secuQuestion = $_POST['secu-ques'];
   $secuAnswer = $_POST['secu-answ'];

   $username = mysqli_escape_string($connection,$username);
   $password = mysqli_escape_string($connection,$password);
   $conpass = mysqli_escape_string($connection,$conpass);
   $email = mysqli_escape_string($connection,$email);



    $query = "SELECT `email` FROM `USER_REGISTRATION` WHERE `email` = '".$email."'";
    $result = mysqli_query($connection, $query);

    $b = mysqli_num_rows($result);

    if ($b > 0) {
        $emailExist = true ;
        $flag = false;

    }

    $query = "SELECT `username` FROM `USER_REGISTRATION` WHERE `username` = '".$username."'";
    $result = mysqli_query($connection, $query);

    $b = mysqli_num_rows($result);

    if ($b > 0) {
        $usernameExist = true;

        $flag = false;
    }

    if($password !== $conpass){
        $passNotMatch = true;
        $flag = false;
    }
    else {
        $password = $conpass;
        $hashedPassword = password_hash("$password" , PASSWORD_DEFAULT);

    }

    if ($flag) {

        $query = "INSERT INTO USER_REGISTRATION(`username`,`password`,`email`,`gender`,`secure_question`,`secure_answer`,`date_of_birth`,`user_level`,`active`) VALUES ('$username','$hashedPassword','$email','$gender','$secuQuestion','$secuAnswer','$date_of_birth',0,'Y')";
        $result = mysqli_query($connection, $query);

        if($result) {
            echo "wrote to database";
        }
        else {
            echo "fail to database";
        }
        //********Sending email confirmations
        $body = "Thank you, ".$username." for registering with L4F, we hope we resolve your cravings!";
        $body = $body. "echo <p> Your password is ".$password ;
        mail($email, 'Registration Confirmation',
        $body, 'From: lee.supermonkey@gmail.com');


        $query = "SELECT `username` FROM `USER_REGISTRATION` WHERE `email` = '".$email."'";
        $result = mysqli_query($connection, $query);
        $a = mysqli_fetch_assoc($result);






      header("Location: adminIndex.php");
      exit();


        /*KILL QUERY*/
        if(!$result) {
            die('Query FAILED!');
        }
    }
    else {
        echo "failed";
    }


}
/******************************************************************************************/
/*******************************************************upload pic******************/
if (isset($_POST['upload'])) { // Handle the form.


// Desired folder structure
$structure = 'uploads/'.strtolower($userName).'/userprofile/';

$tmp_file = $_FILES['the_file']['tmp_name'];
// Make folder
mkdir($structure, 0777, true);

$image = ($_FILES['the_file']['name']);

$image = mysqli_real_escape_string($connection,$image);

//Store image name inside database
$query = "UPDATE `USER_REGISTRATION` SET `profile_image` = '$image' WHERE `user_id` = \"$db_id\"";
$result = mysqli_query($connection, $query);
$tmp_file = $_FILES['the_file']['tmp_name'];


if(!$result) {
    echo mysqli_error($connection);
}
     // Try to move the uploaded file:
        if (move_uploaded_file ($tmp_file, $structure.$image)) {

            //email confirmation for profile
            $body = "Thank you, ".$userName." This is a confirmation that we have successfully uploaded your profile picture!!";

            mail($db_email, 'Profile Picture Confirmation',
            $body, 'From: lee.supermonkey@gmail.com');
            print '<p class="profile-conf">Your file has been uploaded.</p>';

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
        header("Location: profile.php");
    } // End of submission IF.

     // End of submission IF.

    // Leave PHP and display the form:




?>
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
                            CREATE NEW USER
                        </a>

                      <div id="profile-image-wrapper-id" class="container profile-image-wrapper p-5">
                    <img id="default-profile-image" width ="200" height ="200" src="images/icon/userProfile/boy.svg"alt="" class="profile-image">

                </div>
                    
                      <form class="mt-3" action="" method="post">
                        <fieldset class="form-group">
                          <div class="container">
                            <div class="row">
                              <div class="col-sm-4">
                                <?php
                                    if ($usernameExist) {
                                        echo "<span class='alert-danger'> This username is already exist. </span>";
                                    }
                                  ?>
                                <label for="userFirstName">User Name</label><br>
                                <input class="form-control" id="userFirstName" type="text" name="userName"
                                value="<?php echo $username; ?>" required>
                              </div>

                              <div class="col-sm-4">
                                <?php
                                if ($emailExist) {
                                    echo "<span class='alert-danger'> This email is already exists. </span>";
                                }
                                ?>
                                <label for="userEmail">Email</label><br>
                                <input class="form-control" id="userEmail" type="email" name="userEmail" value="<?php echo $email; ?>" required>
                              </div>
                              <div class="col-sm-4">
                                <label for="userEmail">Password</label><br>
                                <input class="form-control" id="userEmail" type="password" name="userPass" value="<?php echo $email; ?>" required>
                              </div>
                              <div class="col-sm-4">
                                <label for="userEmail">Confirm Password</label><br>
                                <input class="form-control" id="userEmail" type="password" name="userPass" value="<?php echo $email; ?>" required>
                              </div>
                              <div class="col-sm-4">
                                <label class="text-center" for="dob">Date of Birth</label>
                                <br>
                                  <select class="form-control myDob" name="month" required>
                                      <option value= "" disabled selected>Month</option>
                                      <option value="January">January</option>
                                      <option value="February">February</option>
                                      <option value="March">March</option>
                                      <option value="April">April</option>
                                      <option value="May">May</option>
                                      <option value="June">June</option>
                                      <option value="July">July</option>
                                      <option value="August">August</option>
                                      <option value="September">September</option>
                                      <option value="October">October</option>
                                      <option value="November">November</option>
                                      <option value="December">December</option>
                                  </select>




                              <select class="form-control myDob" name="day" required>
                                                   <option value= "" disabled selected>Day</option>
                                                   <option value="1">1</option>
                                                   <option value="2">2</option>
                                                   <option value="3">3</option>
                                                   <option value="4">4</option>
                                                   <option value="5">5</option>
                                                   <option value="6">6</option>
                                                   <option value="7">7</option>
                                                   <option value="8">8</option>
                                                   <option value="9">9</option>
                                                   <option value="10">10</option>
                                                   <option value="11">11</option>
                                                   <option value="12">12</option>
                                                   <option value="13">13</option>
                                                   <option value="14">14</option>
                                                   <option value="15">15</option>
                                                   <option value="16">16</option>
                                                   <option value="17">17</option>
                                                    <option value="18">18</option>
                                                   <option value="19">19</option>
                                                   <option value="20">20</option>
                                                   <option value="21">21</option>
                                                   <option value="22">22</option>
                                                   <option value="23">23</option>
                                                   <option value="24">24</option>
                                                    <option value="25">25</option>
                                                   <option value="26">26</option>
                                                   <option value="27">27</option>
                                                   <option value="28">28</option>
                                                   <option value="29">29</option>
                                                   <option value="30">30</option>
                                                   <option value="31">31</option>
                               </select>


                              <select  class="form-control myDob" name="year" required>
                                                      <option value= "" disabled selected>Year</option>
                                                      <option value="2010">2010</option>
                                                      <option value="2009">2009</option>
                                                      <option value="2008">2008</option>
                                                      <option value="2007">2007</option>
                                                      <option value="2006">2006</option>
                                                      <option value="2005">2005</option>
                                                      <option value="2004">2004</option>
                                                      <option value="2003">2003</option>
                                                      <option value="2002">2002</option>
                                                      <option value="2001">2001</option>
                                                      <option value="2000">2000</option>
                                                      <option value="1999">1999</option>
                                                      <option value="1998">1998</option>
                                                      <option value="1997">1997</option>
                                                      <option value="1996">1996</option>
                                                      <option value="1995">1995</option>
                                                      <option value="1994">1994</option>
                                                      <option value="1993">1993</option>
                                                      <option value="1992">1992</option>
                                                      <option value="1991">1991</option>
                                                      <option value="1990">1990</option>
                                                      <option value="1989">1989</option>
                                                      <option value="1988">1988</option>
                                                      <option value="1987">1987</option>
                                                      <option value="1986">1986</option>
                                                      <option value="1985">1985</option>
                                                      <option value="1984">1984</option>
                                                      <option value="1983">1983</option>
                                                      <option value="1982">1982</option>
                                                      <option value="1981">1981</option>
                                                      <option value="1980">1980</option>
                                                      <option value="1979">1979</option>
                                                      <option value="1978">1978</option>
                                                      <option value="1977">1977</option>
                                                      <option value="1976">1976</option>
                                                      <option value="1975">1975</option>
                                                      <option value="1974">1974</option>
                                                      <option value="1973">1973</option>
                                                      <option value="1972">1972</option>
                                                      <option value="1971">1971</option>
                                                      <option value="1970">1970</option>
                                                      <option value="1969">1969</option>
                                                      <option value="1968">1968</option>
                                                      <option value="1967">1967</option>
                                                      <option value="1966">1966</option>
                                                      <option value="1965">1965</option>
                                                      <option value="1964">1964</option>
                                                      <option value="1963">1963</option>
                                                      <option value="1962">1962</option>
                                                      <option value="1961">1961</option>
                                                      <option value="1960">1960</option>
                                                      <option value="1959">1959</option>
                                                      <option value="1958">1958</option>
                                                      <option value="1957">1957</option>
                                                      <option value="1956">1956</option>
                                                      <option value="1955">1955</option>
                                                      <option value="1954">1954</option>
                                                      <option value="1953">1953</option>
                                                      <option value="1952">1952</option>
                                                      <option value="1951">1951</option>
                                                      <option value="1950">1950</option>
                                                      <option value="1949">1949</option>
                                                      <option value="1948">1948</option>
                                                      <option value="1947">1947</option>
                                                      <option value="1946">1946</option>
                                                      <option value="1945">1945</option>
                                                      <option value="1944">1944</option>
                                                      <option value="1943">1943</option>
                                                      <option value="1942">1942</option>
                                                      <option value="1941">1941</option>
                                                      <option value="1940">1940</option>
                                                      <option value="1939">1939</option>
                                                      <option value="1938">1938</option>
                                                      <option value="1937">1937</option>
                                                      <option value="1936">1936</option>
                                                      <option value="1935">1935</option>
                                                      <option value="1934">1934</option>
                                                      <option value="1933">1933</option>
                                                      <option value="1932">1932</option>
                                                      <option value="1931">1931</option>
                                                      <option value="1930">1930</option>
                                                      <option value="1929">1929</option>
                                                      <option value="1928">1928</option>
                                                      <option value="1927">1927</option>
                                                      <option value="1926">1926</option>
                                                      <option value="1925">1925</option>
                                                      <option value="1924">1924</option>
                                                      <option value="1923">1923</option>
                                                      <option value="1922">1922</option>
                                                      <option value="1921">1921</option>
                                                      <option value="1920">1920</option>
                                                      <option value="1919">1919</option>
                                                      <option value="1918">1918</option>
                                                      <option value="1917">1917</option>
                                                      <option value="1916">1916</option>
                                                      <option value="1915">1915</option>
                                                      <option value="1914">1914</option>
                                                      <option value="1913">1913</option>
                                                      <option value="1912">1912</option>
                                                      <option value="1911">1911</option>
                                                      <option value="1910">1910</option>
                                                      <option value="1909">1909</option>
                                                      <option value="1908">1908</option>
                                                      <option value="1907">1907</option>
                                                      <option value="1906">1906</option>
                                                      <option value="1905">1905</option>
                                                      <option value="1904">1904</option>
                                                      <option value="1903">1903</option>
                                                      <option value="1902">1902</option>
                                                      <option value="1901">1901</option>
                                                      <option value="1900">1900</option>
                              </select>
                              </div>
                              <div class="col-sm-4">
                                <p>Security Question:</p>
                                <select class="form-control mb-3" name="secu-ques" required>
                                  <option class="text-center" disabled selected>Select One</option>
                                  <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                                  <option value="What is the name of your favorite childhood friend?">What is the name of your favorite childhood friend?</option>
                                  <option value="What primary school did you attend?">What primary school did you attend?</option>
                                  <option value="In what town or city did you meet your spouse/partner?">In what town or city did you meet your spouse/partner?</option>
                                  <option value="What street did you live on in third grade?">What street did you live on in third grade?</option>
                                  <option value="Where were you when you had your first kiss?">Where were you when you had your first kiss?</option>
                                </select>
                                <input class ="form-control" type="text" name="secu-answ" value="" placeholder="Your answer" required>
                              </div>
                              <div class="col-sm-4">
                                <label class="form-check-label" for="">
                                    <input class="form-check-input" type="radio" name="gender" value="male" required>
                                    Male
                                </label>
                                <label class="form-check-label" for="">
                                    <input class="form-check-input" type="radio" name="gender" value="female" required>
                                    Female
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <label for="userLastName">User Level</label><br>
                                <select class="form-control" id="userLevel" name="userLevel">
                                  <option value='0'>0</option>
                                  <option value='5'>5</option>
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
                          <button type="submit" class="btn btn-success my-2" name="create">Create</button>

                        </div>
                      </form>

                </div>
          </div>
      </div>
    </div><!--WRAPPER-->
    <?php
    include("adminFooter.php");
    ?>
