<?php
session_start(); ob_start();
include("adminHeader.php");
include("cdb.php");

$query = "SELECT COUNT(user_id) FROM `USER_REGISTRATION`";
$result = mysqli_query($connection,$query);
$row = mysqli_fetch_array($result);
$userCount = $row['COUNT(user_id)'];



?>

<div id="wrapper">
          <div class="row mt-3 mx-3 justify-content-around">

              <!--LEFT ASIDE CONTENT-->
              <div class="col-md-2 my-aside ">
                    <div class="list-group ">
                            <a href="#" class="list-group-item list-group-item-action active bg-info text-center">
                              Welcome, <?php echo $_SESSION['username']?>
                            </a>
                            <a href="view-user.php" class="list-group-item list-group-item-action"><span><i class="fa fa-user" aria-hidden="true"></i>
                            </span>Users &amp; Privileges</a>
                            <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                            <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                            <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>
                    </div>
              </div><!--LEFT ASIDE CONTENT END-->
              <div class="col-md-9 my-right-content">
                    <div class="list-group ">
                            <a href="#" class="list-group-item list-group-item-action active bg-danger text-center">
                                USERS &amp; PRIIVLEGES
                            </a>

                            <div class="container">
                                    <table class="user-table">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            <th>Active</th>
                                        </tr>

                                        <?php

                                         $query = "SELECT * FROM USER_REGISTRATION ORDER BY username";
                                         $result = mysqli_query($connection,$query);
                                         if(!$result){
                                           echo mysqli_error($connection);
                                         }
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                          echo '<tr>
		                                            <td><a href="user_edit_profile.php?user_id=' . $row['user_id'] . '">'. $row['username'] .'</a></td>
		                                             <td>' . $row['email'] . '</td>
		                                             <td>' . $row['user_level'] . '</td>
                                                 <td>' . $row['active'] . '</td>
	                                                </tr>';
                                                  }
                                        ?>


                                    </table>
                                    <?php
                                    if($_SESSION['usercount'] > $userCount) {
                                      echo "
                                      <div class='alert-danger text-center mt-3'
                                      id = 'user_deleted_msg'>
                                          <p>A user has been deleted!</p>
                                      </div>
                                      ";
                                    }?>

                            </div>
                    </div>
              </div>
          </div>

</div><!--WRAPPER-->


<?php include("adminFooter.php"); ?>
