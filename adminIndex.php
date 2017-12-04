<?php
session_start(); ob_start();
include("adminHeader.php");
require_once("cdb.php");
$userName = $_SESSION['username'];

$query = "SELECT COUNT(user_id) FROM `USER_REGISTRATION`";
$result = mysqli_query($connection,$query);
$row = mysqli_fetch_array($result);
$userCount = $row['COUNT(user_id)'];
$_SESSION['usercount'] = $userCount;
if(!$result) {
  echo mysqli_error($connection);
}


?>
    <!--GRID START-->
    <div id="wrapper">
          <div class="row mt-3 mx-3 justify-content-around">

              <!--LEFT ASIDE CONTENT-->
              <div class="col-sm-2 my-aside">
                    <div class="list-group ">
                            <a href="#" class="list-group-item list-group-item-action active bg-info text-center">
                              Welcome, <span><?php echo $userName; ?></span>
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
                                Web Statistic
                            </a>

                           <div class="row justify-content-around ">

                             <div class="col-md-3 text-center mt-3">
                                <div class="user-counter-wrapper">
                                  <h3>Users</h3>
                                  <h4><?php echo $userCount; ?></h4>
                                </div>

                             </div>
                             <div class="col-md-3 text-center mt-3">
                                <div class="user-counter-wrapper">
                                      <h3>Users</h3>
                                </div>
                             </div>
                             <div class="col-md-3 text-center mt-3">
                                <div class="user-counter-wrapper">
                                      <h3>Users</h3>
                                </div>
                             </div>
                           </div>

                    </div>
              </div>
          </div>
        </div><!--WRAPPER-->
   <?php
   include("adminFooter.php");
   ?>
