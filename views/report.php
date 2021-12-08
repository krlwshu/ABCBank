<?php 
include("../views/templates/header.php");

// session_start();
if(!isset($_SESSION['logged_in'])){
    header('Location: ../views/login.php');
}

require("../server/userManagement.php");
$users = getApplicationDetails();


?>
<link rel="stylesheet" href="../assets/css/reportUi.css">

<div class="container registration-container">


    <div class="panel panel-default">
        <div class="panel-body">
        <h2>Customer Registration Report</h2>

        <br>
        <br>
        <br>
            <div class="row">
                <div class="col-lg-4">
                    <h5>Application by Status</h5>
                    <div class="chart-container" style="position: relative; ">
                        <canvas height="300px" id="statusPie"></canvas>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="panel panel-info panel-colorful">
                                <div class="panel-body text-center">
                                    <p class="text-uppercase mar-btm text-sm">New Applications </p>
                                    <i class="fa fa-users fa-5x"></i>
                                    <hr>
                                    <p id="new_reg24h" lass="h2 text-thin">0</p>
                                    <small><span class="text-semibold"></span>LAST 24HRS</small>
                                </div>
                            </div>
                            <div class="panel panel-warning panel-colorful">
                                <div class="panel-body text-center">
                                    <p class="text-uppercase mar-btm text-sm">New Applications</p>
                                    <i class="fa fa-users fa-5x"></i>
                                    <hr>
                                    <p id="new_reg7d" class="h2 text-thin">0</p>
                                    <small><span class="text-semibold"></span> LAST 7 DAYS</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-primary panel-colorful">
                                <div class="panel-body text-center">
                                    <p class="text-uppercase mar-btm text-sm">Applications Processed </p>
                                    <i class="fa fa-users fa-5x"></i>
                                    <hr>
                                    <p id="proc_24h" class="h2 text-thin">0</p>
                                    <small><span class="text-semibold"></span>LAST 24HRS</small>
                                </div>
                            </div>
                            <div class="panel panel-dark panel-colorful">
                                <div class="panel-body text-center">
                                    <p class="text-uppercase mar-btm text-sm">Applications Processed</p>
                                    <i class="fa fa-users fa-5x"></i>
                                    <hr>
                                    <p id="proc_7d" class="h2 text-thin">0</p>
                                    <small><span class="text-semibold"></span>LAST 7 DAYS</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="row">
                <br>
                <br>
                <br>
                <h5>Applications</h5>

                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead>
                            <th>Application #</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Post Code</th>
                            <th>Tel</th>
                            <th>Product</th>
                            <th>Status</th>
                        </thead>

                        <tbody>
                            <?php
                foreach ($users as $user){
            ?>
                            <tr>
                                <td><?php echo $user['app_id']?></td>
                                <td><?php echo $user['first_name']?></td>
                                <td><?php echo $user['last_name']?></td>
                                <td><?php echo $user['dob']?></td>
                                <td><?php echo $user['postcode']?></td>
                                <td><?php echo $user['contact_no']?></td>
                                <!-- <td><?php echo $user['application_status']?></td> -->
                                <td><?php echo $user['selected_product']?></td>
                                <td><?php echo $user['application_status']?></td>


                            </tr>
                            <?php }?>
                        </tbody>
                    </table>


                </div>

            </div>

        </div>
    </div>


</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>

<script>

var url = "../server/getReportUiStats.php";

    
let stats;
async function getStats(){
    stats = await fetch(url).then(res => res.json());
    console.log(stats);

    const {counts} = stats;

    const ctx = document.getElementById('statusPie').getContext('2d');
    const statusPie = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: counts.map(i => i.status),
            datasets: [{
                label: 'Status',
                data: counts.map(i => i.count),
                backgroundColor: counts.map(i => i.color_code),
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    document.getElementById('new_reg24h').innerHTML = stats.new_24h[0].new_reg24h;
    document.getElementById('new_reg7d').innerHTML = stats.new_7d[0].new_reg7d;
    document.getElementById('proc_24h').innerHTML = stats.proc_24h[0].proc_24h;
    document.getElementById('proc_7d').innerHTML = stats.proc_7d[0].proc_7d;
}
getStats();      



</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>


<?php require("../views/templates/footer.php");?>
