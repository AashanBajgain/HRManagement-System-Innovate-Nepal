<?php include('header.php'); 
if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Retrieve user ID from session
}
?>
<div class="user-main-dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="total-log box-class">
                    <h3>Latest Earning</h3>
                    <div class="deatail">
                        <?php 
                            //Sql Query 
                            $sqltotaltime = "SELECT * FROM tbl_dailylog WHERE uid = $userId ORDER BY date DESC LIMIT 1;";
                            //Execute Query
                            $restotaltime = mysqli_query($conn, $sqltotaltime);
                            $rowtotal = mysqli_fetch_assoc($restotaltime);
                        ?>
                        <span class="total-hour">$<?php echo $rowtotal['todayearning']; ?></span>
                        
                    </div>
                    <?php 
                        //Sql Query 
                        $sql = "SELECT * FROM tbl_time WHERE uid = $userId";
                        //Execute Query
                        $res = mysqli_query($conn, $sql);
                        //Count Rows
                        $count = mysqli_num_rows($res);
                    ?>
                    <p class="sub-text">Adj-salary: <?php echo $rowtotal['adjusted_salary']; ?>/hr</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="total-log box-class">
                    <h3>Total Billable hour</h3>
                    <div class="deatail">
                        <?php 
                            //Sql Query 
                            $sqltotaltime = "SELECT SUM(totaltime) AS total_sum FROM tbl_dailylog WHERE uid = $userId;";
                            //Execute Query
                            $restotaltime = mysqli_query($conn, $sqltotaltime);
                            $rowtotal = mysqli_fetch_assoc($restotaltime);
                        ?>
                        <span class="total-hour"><?php echo $rowtotal['total_sum']; ?>hr</span>
                        
                    </div>
                    <?php 
                        //Sql Query 
                        $sql = "SELECT * FROM tbl_dailylog WHERE uid = $userId";
                        //Execute Query
                        $res = mysqli_query($conn, $sql);
                        //Count Rows
                        $count = mysqli_num_rows($res);
                    ?>
                    <p class="sub-text">across <?php echo $count; ?> count</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="salary box-class">
                    <?php 
                        $sqltotalearning = "SELECT SUM(todayearning) AS total_earning FROM tbl_dailylog WHERE uid = $userId;";

                        //Execute Query
                        $restotalearning = mysqli_query($conn, $sqltotalearning);
                        $rowtotalearning = mysqli_fetch_assoc($restotalearning);
                    ?>
                    <h3>Total Earning</h3>
                    <div class="deatail">
                        <span class="total-hour">$<?php echo $rowtotalearning['total_earning'];  ?></span>
                    </div>
                </div>  
            </div>
            <div class="col-lg-3">
                <div class="leave box-class">
                    <?php 
                        //Sql Query 
                        $approvedsql = "SELECT * FROM tbl_leave WHERE uid = $userId AND approved = 1";
                        $leavesql = "SELECT * FROM tbl_leave WHERE uid = $userId";
                        $approvedres = mysqli_query($conn, $approvedsql);
                        $leaveres = mysqli_query($conn, $leavesql);
                        //Count Rows
                        $approvedcount = mysqli_num_rows($approvedres);
                        $leavecount = mysqli_num_rows($leaveres);
                    ?>
                    <h3>Approved Leave</h3>
                    <div class="deatail">
                        <span class="total-hour"><?php echo $approvedcount; ?></span>
                    </div>
                    <p class="sub-text">out of <?php echo $leavecount; ?></p>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php
    $sqldailylog = "SELECT * FROM tbl_dailylog WHERE uid = $userId ORDER BY date DESC LIMIT 16";
    //Execute Query
    $resdailylog = mysqli_query($conn, $sqldailylog);
    if(mysqli_num_rows($resdailylog) > 0) {
?>
<div class="engagement-graph">
    <div class="container">
        <div class="row engagement-wrapper">
            <div class="col-lg-9">
                <div class="graph-wrap box-class">
                    <div class="graph-title">
                        <h3>Activity Log</h3>
                    </div>
                    <table id="labels-example-2" class="charts-css column show-data show-labels">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($rowdailylog = mysqli_fetch_assoc($resdailylog)) { ?>
                            <tr>
                                <th scope="row"> <?php echo explode('-', $rowdailylog['date'])[1].'/'.explode('-', $rowdailylog['date'])[2]; ?> </th>
                                <td style="--size: <?php echo $rowdailylog['totaltime'] * 0.1; ?>;"><span class="data"> <?php echo $rowdailylog['totaltime']; ?>hr </span></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
