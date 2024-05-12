
<?php include('../user/header.php'); 
    if(isset($_SESSION['addnotice'])) //Checking whether the SEssion is Set of Not
    {
        echo $_SESSION['addnotice']; //Display the SEssion Message if SEt
        unset($_SESSION['addnotice']); //Remove Session Message
    }
?>
<div class="main-content admin-dashboard">
    <div class="wrapper">
        <?php include('sidebar.php'); ?>
        <form action="" method="POST">
            <input type="text" name="notice_title" placeholder="Enter Title">
            <textarea name="notice_body" cols="30" rows="5" placeholder="Enter Notice."></textarea>
            <input type="hidden" name="today_date" value="<?php echo date('Y-m-d')?>">
            <input type="submit" name="submit" value="Add notice" class="btn-secondary">
        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php 
    //Process the Value from Form and Save it in Database

    //Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked
        //echo "Button Clicked";

        //1. Get the Data from form
        $notice_title = $_POST['notice_title'];
        $notice_body = $_POST['notice_body'];
        $today_date = $_POST['today_date'];

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO tbl_notice SET 
            title='$notice_title',
            description='$notice_body',
            date='$today_date'
        ";
 
        //3. Executing Query and Saving Data into Datbase
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['addnotice'] = "<div class='success'>Notice Added Successfully.</div>";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-notice.php');
        }
        else
        {
            //FAiled to Insert DAta
            //echo "Faile to Insert Data";
            //Create a Session Variable to Display Message
            $_SESSION['addnotice'] = "<div class='error'>Failed to Add Notice.</div>";
            //Redirect Page to Add Admin
            header("location:".SITEURL.'admin/add-notice.php');
        }

    }
    
?>