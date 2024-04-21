<?php include('../user/header.php'); 
if(isset($_SESSION['addemployee'])) //Checking whether the SEssion is Set of Not
{
    echo $_SESSION['addemployee']; //Display the SEssion Message if SEt
    unset($_SESSION['addemployee']); //Remove Session Message
}
?>
<div class="main-content">
    <div class="container">
        <h1>Employee Type</h1>
        <form action="" method="POST">
            <input type="text" name="title" placeholder="Employee designation" required>
            <input type="number" name="salary" placeholder="Salary per hour" required>
            <input type="submit" name="submit" class="btn btn-danger" value="Add">
        </form>
    </div>
</div>
<?php
if(isset($_POST['submit']))
{
//Add the Food in Database
//echo "Clicked";
//1. Get the DAta from Form
$title = $_POST['title'];
$salary = $_POST['salary'];

//Create a SQL Query to Save or Add food
// For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes ''
$sql2 = "INSERT INTO tbl_employeetype SET 
salary = '$salary',
title = '$title'
";

//Execute the Query
$res2 = mysqli_query($conn, $sql2);

//CHeck whether data inserted or not
//4. Redirect with MEssage to Manage Food page
if($res2 == true)
{
//Data inserted Successfullly
$_SESSION['addemployee'] = "<div class='success'><div class='container'>New employee type with salary/hour added.</div></div>";
header("location:".SITEURL.'admin/add-employeetype.php');

}
else
{
//FAiled to Insert Data
$_SESSION['addemployee'] = "<div class='error'><div class='container'>Failed to add new employee type.</div></div>";
}


}

?>