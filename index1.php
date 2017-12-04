<?php
session_start();
ob_start();
include('cdb.php');


?>
<?php
$hashedPassword = '';
$flag = true;
$accNotFound = false;
$emailExist = false;
$passNotMatch = false;
$usernameExist = false;
$accountFound = false;
$isMe = false;
$userLevel;






    /* CLEAN UP THE INPUT */

/*********************************logInCLicked***************************************/
if(isset($_POST['login'])) {

    $emailLogin= $_POST['email-logIn'];
    $passLogin= $_POST['pass-logIn'];

    $emailLogin = mysqli_escape_string($connection,$emailLogin);
    $passLogin = mysqli_escape_string($connection,$passLogin);


    $query = "SELECT * FROM `USER_REGISTRATION` WHERE `email` = '".$emailLogin."'";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($result)) {
       $db_email = $row['email'];
       $db_password= $row['password'];
       $db_username= $row['username'];
       $db_userlevel = $row['user_level'];
       if ($db_userlevel == 0) {
         $userLevel = 1;
       }
       else {
         $userLevel = 5;
       }

    }

    if ($emailLogin !== $db_email) {
        $accNotFound = true;
    }
    else if (!password_verify($passLogin, $db_password))
    {
        $accNotFound = true;
    }
    else {

        $query = "SELECT `username` FROM `USER_REGISTRATION` WHERE `email` = '".$emailLogin."'";
        $result = mysqli_query($connection, $query);
        if(!$result){
          echo "fail". mysqli_error($connection);
        }
        $a = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $a['username'];
        if ($userLevel == 1){
          header("Location: profile.php");

        exit();
        }
        else {
          header("Location: adminIndex.php");

          exit();
        }
    }

}
/******************************************************************************************/



/*************************************submitCLicked*****************************************/

if(isset($_POST['submit'])) {


    $username = $_POST['userName'];
    $email = $_POST['email'];
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




        $_SESSION['username'] = $a['username'];

      //  header("Location: profile.php");
      //  exit();


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


if(isset($_POST['isMe'])){
    $isMe = true;
}

?>
































<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>L4Food</title>
  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>


    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/icon/logo.png" width="100" height="100" alt="">
              </a>
        <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

          <form method="post" class="my-form-line ml-auto" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                  <input class="form-control px-3 my-1" name="email-logIn" type="email" placeholder="Email" size="40" required>
                  <input class="form-control px-3 my-1" name="pass-logIn" type="password" placeholder="Password" size="40" required>
                <div>
                <?php if ($accNotFound === true) {
               echo "<span class='error-message'>Either Email or Password is not correct</span>";
          }
          ?>
                </div>
                <div class="text-right">
                  <a  href="#" data-toggle="modal" data-target="#forgotPassModal">forgot password?</a>
                  <button class="btn btn-myOutline-logIn ml-auto my-1 " name="login" type="submit">Log In</button>

                </div>
          </form>
        </div>
      </div>
      </nav>



<!-- Modal -->
<div class="modal fade" id="forgotPassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">


    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Find Your Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <div class="modal-body text-center">

        <p>What's your email?</p>
        <form class="form-group mt-2 text-right" action="" method="post">
            <input id="forgetEmailInput" class="form-control" type="email" name="forgetEmail" required>
            <button id="forgetSearch" type="" name="forgotPassword" class="btn btn-my-search">Search</button>
        </form>

         <div class="forgetPasswordUser-wrapper">

         <div class="forgetPasswordUser" id="1">

        </div>


        </div><!--forgetPasswordUser wrapper -->

    </div><!--modal body-->

    <div class="modal-footer">

    </div><!--modal footer-->
    </div>
  </div>
</div>
<!--End MODAL -->

<!-- Second Modal -->
<div class="modal fade" id="secondModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">


    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Not So Fast!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <div class="modal-body">



        <p id="secuQuestion"></p>
        <form class="form-group mt-2 text-right" action="" method="post">
            <input id="secuAnswer" class="form-control" type="text"  required>
            <button id="validate" type="" name="forgotPassword" class="btn btn-my-search">Validate</button>
        </form>



    </div><!--modal body-->

    <div class="modal-footer">

    </div><!--modal footer-->
    </div>
  </div>
</div>
<!--End second MODAL -->

    <div class="background">
      <div class="darkOverlay">
      <div class="container">
        <div class="row">
          <div class="col-md-7">

          </div>
          <div class="col-md-4 ml-auto">
            <!--FORM-->

              <form action="index1.php" class="myForm p-3" method="post">
                  <h1 class="display-4">Register Now!</h1>
                  <p>Be cool and join today! Meet millions!</p>
                  <fieldset class="form-group">
                    <?php
                        if ($usernameExist) {
                            echo "<span class='error-message'> This username is already exist. </span>";
                        }
                        ?>
                      <input  class="form-control" type="text" name="userName" placeholder= "Username" value="<?php echo isset($_POST['userName']) ? $username : ''; ?>" required>


                  </fieldset>
                  <fieldset class="form-group">
                        <?php
                        if ($emailExist) {
                            echo "<span class='error-message'> This email is already exists. </span>";
                        }
                        ?>
                      <input class="form-control" type="email" name="email" placeholder="Your Email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>"required>
                  </fieldset>
                  <fieldset class="form-group">
                  <?php
                        if ($passNotMatch) {
                            echo "<span class='error-message'> Password doest not match. </span>";
                        }
                        ?>
                      <input class="form-control"type="password" name="password" placeholder="Password" required>
                  </fieldset>
                  <fieldset class="form-group">
                      <input  class="form-control" type="password" name="conPassword" placeholder="Confirm Password" required>
                  </fieldset>


                  <fieldset class="form-group" id="dob">
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
                </fieldset><!--DOB-->
                <fieldset class="form-group" id="secu">
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
                </fieldset>
                <fieldset class="form-check">
                  <label class="form-check-label" for="">
                      <input class="form-check-input" type="radio" name="gender" value="male" required>
                      Male
                  </label>
                  <label class="form-check-label" for="">
                      <input class="form-check-input" type="radio" name="gender" value="female" required>
                      Female
                  </label>

                </fieldset><!--Gender-->

                  <button class="btn btn-myOutline-logIn" name="submit" type="submit">Create Account</button>
            </form>

          </div>
        </div>
       </div>
      </div><!--overlay-->
    </div>


  <footer>
    <div class="text-center myFooter">
      <p>&copy; L4Food 2017</p>
    </div>
  </footer>
<script>
    $(document).ready(function () {

        var secuAnswer = '';
       var id ='';
        $('#forgetSearch').click(function (e) {
            e.preventDefault();
            var search = $('#forgetEmailInput').val().toLowerCase();
            if (search === "") {
                $('#1').html("<p class='alert alert-warning'>Please Enter Your Email Address!</p>");
            } else {
        var secret='';
        var user = '';

        var pictureName='';
        var secuQuestion = '';
        var email = '';
        var response='';
        var gender='';
        var src='';
            $.ajax({
                datatype: 'JSON',
                async: false,
                url: 'forgetPassword.php',
                data: {
                    search: search,
                    secret: search
                    },
                type: 'POST',
                success: function(result) {
                    try {
                        response = JSON.parse(result);
                        user = response.user;
                        email = response.email;
                        pictureName = response.picture;
                        secuQuestion = response.secuQuestion;
                        secuAnswer = response.secuAnswer;
                        id = response.id;

                        if (pictureName == 'boy'){
                           src = " src='images/icon/userProfile/boy.svg'";
                        } else if(pictureName == 'girl'){
                          src = " src='images/icon/userProfile/girl.svg'";
                        } else {
                          src = " src='uploads/"+user+"/userprofile/"+pictureName+"'>";
                        }


                        var message =  "<p class='alert alert-success'>Account Found</p>";
                            message += "<img class='forgetPasswordUserPic'"+src +"<br>";
                            message += "<p class='flex-item '>"+user+"</p>";
                            message +=  "<p class='flex-item'>"+email+"</p>";
                            message +=  "<button class='btn btn-primary text-center' data-toggle='modal' data-target='#secondModal' name='itMe' id='itMe'>It's me!</button>";


                         $('#1').html(message);
                         $("#secuQuestion").html(secuQuestion);
                    }
                    catch(e) {

                            $('#1').html("<p class='alert alert-danger'>Account Not Found!</p>");

                    }//catch
                }//success function
            }); //AJAXy
        }//else
    });//click Event forgetlink

    $('#validate').click(function (e) {
        e.preventDefault();
        var answer = $('#secuAnswer').val().toLowerCase();

        if (answer === secuAnswer) {

            $.post("resetPassword.php", { id: id }, function(data){
                window.location.replace("resetPassword.php?id="+id);
            });

            }

         else {
            alert("Your answer is not correct!");
        }


    });//validate question
});//document ready


</script>
</body>
</html>
