<footer id="footer">
         <p>&copy; 2017 L4Food Admin Dashboard</p>
     </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){

        //user_edit_profile.php delete user function/////
        $('#deleteUser').click (function (e){
          var con = confirm("Are you sure you want to delete this user?");
          if (con == false) {
                e.preventDefault();
          }



        });
        ///////////////////////////////////////////////
        var hide = function () {
            $('#user_deleted_msg').hide();
        };
        setTimeout(hide, 2000 );
      });


    </script>
  </body>
</html>
