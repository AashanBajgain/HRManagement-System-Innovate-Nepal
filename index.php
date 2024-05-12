<?php include('config/constants.php'); ?>
<html>
    <head>
        <title>Login - Inno Tech</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="verification">
            <div class="form-wrap verification-form">
                <h1 class="text-center">Sign in to Innovet Tech</h1>
                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }

                    if(isset($_SESSION['no-login-message']))
                    {
                        echo $_SESSION['no-login-message'];
                        unset($_SESSION['no-login-message']);
                    }
                ?>
                <form action="" method="POST" class="">
                    <div class="form-box">
                        <span class="form-label">Username</span>
                        <input type="text" name="username">
                    </div>
                    <div class="form-box">
                        <span class="form-label">Password</span>
                        <input type="password" name="password">
                    </div>
                    <div class="form-box">
                        <input type="submit" name="submit" value="Login">
                    </div>
                </form>
            </div> 
        </div>
    </body>
</html>
<?php 
    //CHeck whether the Submit Button is Clicked or NOt
    if(isset($_POST['submit']))
    {
        //Process for Login
        //1. Get the Data from Login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        //2. SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        //3. Execute the Query
        $res = mysqli_query($conn, $sql);
        //4. COunt rows to check whether the user exists or not
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            while($row=mysqli_fetch_assoc($res)) {
                if( $row['is_admin']==1){
                    //User AVailable and Login Success
                    $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
                    $_SESSION['user'] = $username; //TO check whether the user is logged in or not and logout will unset it

                    //REdirect to HOme Page/Dashboard
                    header('location:'.SITEURL.'admin/');
                    $_SESSION['user_id'] = $row['id'];
                }else{
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user'] = $username;
                    header('location:'.SITEURL.'user/');
                }
            }
        }
        else
        {
            //User not Available and Login FAil
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            //REdirect to HOme Page/Dashboard
            header('location:'.SITEURL.'admin/login.php');
        }
    }
?>