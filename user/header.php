<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<?php 
include('../config/constants.php'); 
session_start(); // Start the session
// Check if user ID is set in the session
if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Retrieve user ID from session
}
?>
<div class="top-nav">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="site-logo">
                    <p>Innovate Tech.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="logout-section">
                    <a href="logout.php">logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom-nav">
    <div class="container">
        <div class="row bottom-wrapper">
            <div class="col-lg-6">
                <h1>Welcome back, <span><?php echo $_SESSION['user']; ?></span></h1>
            </div>
            <div class="col-lg-6">
                <div class="user-attendence">
                    <?php 
                        $sqlcheckcalc = "SELECT flag FROM tbl_calc WHERE DATE(date) = CURDATE()";
                        $rescheckcalc = mysqli_query($conn, $sqlcheckcalc);
                        $rowcheckcalc = mysqli_fetch_assoc($rescheckcalc);

                        //Sql Query 
                        $sqluser1 = "SELECT * FROM tbl_admin WHERE id = $userId";
                        //Execute Query
                        $resuser1 = mysqli_query($conn, $sqluser1);
                        //Count Rows
                        $rowuser = mysqli_fetch_assoc($resuser1);
                        if($rowuser['is_admin'] == '0'){ 
                    ?>
                    <div class="starter-btn">
                        <a class="btn btn-secondary" href="index.php">Dashboard</a>
                        <a class="btn btn-secondary" href="askleave.php">Ask a leave</a>
                        <?php if($rowcheckcalc['flag'] == 0){ ?><button id="startBtn" class="btn btn-success">Clock IN</button><?php } ?>
                    </div>
                    <?php if($rowcheckcalc['flag'] == 0){ ?>
                    <div class="recent-time-log">
                        <div id="timer"></div>
                        <form id="timeForm" action="" method="POST" style="display:none;">
                            <input type="hidden" name="time" id="timeInput">
                            <input type="hidden" name="uid" value="<?php echo $userId; ?>">
                            <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
                            <input type="submit" name="submit" class="btn btn-danger" value="stop">
                        </form>
                    </div>
                    <?php 
                        if(isset($_POST['submit']) && ($_POST['submit'] == 'stop')){
                            //1. Get the Data from form
                            $time = $_POST['time'];
                            $uid = $_POST['uid'];
                            $date = $_POST['date'];
                    
                            //2. SQL Query to Save the data into database
                            $sql = "INSERT INTO tbl_time (uid, time, date) VALUES ('$uid', '$time', '$date')";
                    
                            //3. Executing Query and Saving Data into Datbase
                            $res = mysqli_query($conn, $sql);
                    
                            //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
                            if($res==TRUE){
                                //Data Inserted
                                //echo "Data Inserted";
                                //Create a Session Variable to Display Message
                                $_SESSION['add'] = "<div class='success'><div class='container'>Time added successfully.</div></div>";
                                //Redirect Page to Manage Admin
                            }else{
                                //FAiled to Insert DAta
                                //echo "Faile to Insert Data";
                                //Create a Session Variable to Display Message
                                $_SESSION['add'] = "<div class='error'><div class='container'>Failed to Add time.</div></div>";
                                //Redirect Page to Add Admin
                            }
                    
                        } 
                        }
                    }else{
                        if($rowcheckcalc['flag'] == 0){   
                    ?>
                    <div class="dailylog-btn">
                        <form id="calculateEarning" action="" method="POST">
                            <input type="hidden" name="aajakoDate" value="<?php echo date('Y-m-d'); ?>">
                            <input type="submit" name="calearn" value="calculate">
                        </form>
                    </div>
                    <?php 
                        if (isset($_POST['calearn'])) {
                            
                            $sqldailylog = "INSERT INTO tbl_dailylog (uid, date, totaltime, adjusted_salary, salary, todayearning) SELECT t1.uid, t1.date, t1.total_hours, CASE WHEN t1.total_hours < 5 THEN t3.salary - (0.10 * t3.salary) WHEN t1.total_hours > 5 THEN t3.salary + (0.15 * t3.salary) ELSE t3.salary END AS adjusted_salary, t3.salary, t1.total_hours * (CASE WHEN t1.total_hours < 5 THEN t3.salary - (0.10 * t3.salary) WHEN t1.total_hours > 5 THEN t3.salary + (0.15 * t3.salary) ELSE t3.salary END) AS total_earning FROM (SELECT uid, date, COUNT(*) AS num_instances, HOUR(SEC_TO_TIME(SUM(time))) AS total_hours FROM tbl_time WHERE DATE(date) = CURDATE() GROUP BY uid, date) AS t1 JOIN (SELECT uid FROM tbl_time GROUP BY uid) AS tuid ON t1.uid = tuid.uid JOIN tbl_admin AS t2 ON t1.uid = t2.id JOIN tbl_employeetype AS t3 ON t2.employeetype = t3.id";
                            $resdailylog = mysqli_query($conn, $sqldailylog);

                            if($resdailylog==TRUE){
                                $aajakoDate = $_POST['aajakoDate']; 
                                $sqlcalc = "INSERT INTO tbl_calc (date, flag) VALUES ( '2024-04-21', '1')";
                                $rescalc = mysqli_query($conn, $sqlcalc);
                                //Data Inserted
                                //echo "Data Inserted";
                                //Create a Session Variable to Display Message
                                $_SESSION['add'] = "<div class='success'><div class='container'>Today Calculation logged successfully.</div></div>";                                //Redirect Page to Manage Admin
                            }else{
                                //FAiled to Insert DAta
                                //echo "Faile to Insert Data";
                                //Create a Session Variable to Display Message
                                $_SESSION['add'] = "<div class='error'><div class='container'>Failed to dailylog.</div></div>";
                                //Redirect Page to Add Admin
                            }
                    
                        }
                        }
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_SESSION['add'])) //Checking whether the SEssion is Set of Not
{
    echo $_SESSION['add']; //Display the SEssion Message if SEt
    unset($_SESSION['add']); //Remove Session Message
}
?>
<script>
// Function to format time
function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secondsLeft = seconds % 60;
    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secondsLeft.toString().padStart(2, '0')}`;
}


// Update timer function
function updateTimer() {
    const currentTime = Math.floor((Date.now() - startTime) / 1000);
    document.getElementById('timer').textContent = 'Elapsed Time: ' + formatTime(currentTime);
    document.getElementById('timeInput').value = currentTime;
}

// Start button event listener
document.getElementById('startBtn').addEventListener('click', function() {
    // Start the timer
    startTime = Date.now();
    updateTimer(); // Update timer immediately

    // Update the timer every second
    timerInterval = setInterval(updateTimer, 1000);
    var elements = document.querySelectorAll('.starter-btn');
    elements.forEach(function(element) {
        element.style.display = 'none';
    });    
    document.getElementById('timeForm').style.display = 'block';
});

let startTime;
let timerInterval;

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
