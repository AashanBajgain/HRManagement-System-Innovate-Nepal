<?php include('../user/header.php'); 
if(isset($_SESSION['add'])) //Checking whether the SEssion is Set of Not
{
    echo $_SESSION['add']; //Display the SEssion Message if SEt
    unset($_SESSION['add']); //Remove Session Message
}
$id=$_GET['id'];
$sql="SELECT * FROM tbl_leave WHERE id=$id";
//Execute the Query
$res=mysqli_query($conn, $sql);
//Check whether the query is executed or not
if($res==true)
{
    // Check whether the data is available or not
    $count = mysqli_num_rows($res);
    //Check whether we have admin data or not
    if($count==1)
    {
        // Get the Details
        //echo "Admin Available";
        $row=mysqli_fetch_assoc($res);
        $reason = $row['reason'];
        $date = $row['date'];
        $uid = $row['uid'];

        $namesql = "SELECT full_name FROM tbl_admin WHERE id = $uid";
        $nameres = mysqli_query($conn, $namesql);
        //Count Rows
        $rowname = mysqli_fetch_assoc($nameres);
    }
}
?>
<div class="main-content update-leave">
    <div class="container">
        <form action="" method="POST">
            <div class="leave-name"><span class="name"><?php echo $rowname['full_name']; ?></span></div>
            <div class="leave-reason"><span class="desc"><?php echo $reason; ?></span></div>
            <div class="leave-date"><span class="date"><?php echo $date; ?></span></div>
            <input type="hidden" name="uid" value="<?php echo $id; ?>" readonly>
            <div class="aprrove-btn">
                <input type="checkbox" name="approve" value="1"> Yes
                <input type="submit" name="submit" class="btn btn-success" value="Approve">
            </div>
        </form>
    </div>
</div>

<?php 

//CHeck whether the button is clicked or not
if(isset($_POST['submit']))
{
$uid = $_POST['uid'];
$approved = $_POST['approve'];


//3. Insert Into Database

//Create a SQL Query to Save or Add food
// For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes ''
$sql2 = "UPDATE tbl_leave SET
approved = '$approved'
WHERE id='$uid'
";

//Execute the Query
$res2 = mysqli_query($conn, $sql2);

//CHeck whether data inserted or not
//4. Redirect with MEssage to Manage Food page
if($res2 == true)
{
//Data inserted Successfullly
$_SESSION['add'] = "<div class='success'><div class='container'>Request approved.</div></div>";
header('location:'.SITEURL.'admin');
}
else
{
//FAiled to Insert Data
$_SESSION['add'] = "<div class='error'><div class='container'>Failed to send request.</div></div>";
}


}

?>