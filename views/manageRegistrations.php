<?php 
include("../views/templates/header.php");

// session_start();
// if(!isset($_SESSION['logged_in'])){
//     header('Location: ../views/login.php');
// }

checkSession();

require("../server/userManagement.php");
$users = getApplicationDetails();

?>
<div class="container registration-container">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">

                <h2>Manage Customer Applications</h2>

                <div class="col-lg-12">
                    <form action="manageRegistrations.php" method="get">
                        <select id="" name="filter_by_status" onchange="this.form.submit()">
                        <?php $selected = (isset($_GET['filter_by_status'])) ? (int) $_GET['filter_by_status']: '';?>
                            <option default <?php echo ($selected == 1)? 'selected ': ''?>value="0">All</option>
                            <option <?php echo ($selected == 1)? 'selected ': ''?>value="1">New</option>
                            <option <?php echo ($selected == 2)? 'selected ': ''?>value="2">In-process</option>
                            <option <?php echo ($selected == 3)? 'selected ': ''?>value="3">On-hold</option>
                            <option <?php echo ($selected == 4)? 'selected ': ''?>value="4">Withdrawn</option>
                            <option <?php echo ($selected == 5)? 'selected ': ''?>value="5">Complete</option>
                        </select>
                    </form>

                </div>                
                <div class="col-lg-12">
                    <table class="table table-striped" data-pagination="true">
                        <thead>
                            <th>Application #</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Post Code</th>
                            <th>Tel</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th><b>Action</b></th>
                        </thead>

                        <tbody>
                            <?php
                foreach ($users as $user){
            ?>
                            <tr id="<?php echo $user['app_id']?>">
                                <td><?php echo $user['app_id']?></td>
                                <td><?php echo $user['first_name']?></td>
                                <td><?php echo $user['last_name']?></td>
                                <td><?php echo $user['dob']?></td>
                                <td><?php echo $user['postcode']?></td>
                                <td><?php echo $user['contact_no']?></td>
                                <!-- <td><?php echo $user['birth_month']?></td> -->
                                <td><?php echo $user['selected_product']?></td>
                                <td><?php echo $user['application_status']?></td>
                                <td>
                                    <div class="action-control-btns">
                                        <a class="btn btn-link btn-link-upd"
                                            href="updateUser.php?uid=<?php echo $user['app_id']; ?>">
                                            <i class="bi bi-pencil-square"></i> Update</a>

                                        <!-- Modal -->

                                        <?php $status = ($user['application_status'] != 'Withdrawn')? 'disabled':''; ?>

                                        <button <?php echo$status?> type="button"
                                            class="btn btn-primary btn-link btn-link-del" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal"
                                            data-bs-uid="<?php echo $user['app_id']; ?>">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>

                            </tr>
                            <?php }?>
                        </tbody>
                    </table>

                    <div>
                        <a href="../server/pdf/report.php" target="_blank">Generate PDF</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<!-- Button  -->


<!-- Modal -->
<div style="top: 20%" class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to delete application <span id="appPlaceholder">{XXX}</span>?

                </p>
                <i class="bi bi-trash text-danger display-4"></i>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn display-2 btn btn-outline-success btn-confirm-cancel"
                    data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill text-success"></i> Cancel</button>
                <button id="confirm-delete" onclick="handleDelete(event)" type="button"
                    class="btn display-2 btn-outline-danger" data-bs-dismiss="modal" data-del-item=""><i
                        class="bi bi-check-circle text-danger"></i> Proceed</button>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


<script>
    var deleteUserModal = document.getElementById('deleteUserModal')
    deleteUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var appId = button.getAttribute('data-bs-uid')

        var deleteItem = document.getElementById("confirm-delete")
        deleteItem.setAttribute("data-del-item", appId)
        var modalBodyInput = deleteUserModal.querySelector('.modal-body input')
        var uidSpan = document.getElementById("appPlaceholder")
        uidSpan.innerText = appId;

    })


    const handleDelete = (e) => {


        var element = document.getElementById(e.target.id);
        var targetAppID = element.getAttribute("data-del-item");
        let data = {
            appId: targetAppID
        };

        var url = "../server/deleteUserApp.php";
        fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(res => res.json())
            .then(res => success(res))
            .catch(error => failure(error));
    }

    const success = (res) => {
        // console.log(res)
        var notyf = new Notyf();
        if (res.status == "DELETED") {
            notyf.success(`${res.appId} successfully deleted`);
            delRow(res.appId); //Delete row from UI
        } else {
            notyf.error(`Deletion failed, response: ${res.status}`);
        }
    }

    // Rather than reload page :-)
    const delRow = (idRow) => {
        var row = document.getElementById(idRow);
        row.parentNode.removeChild(row);
    }

    const failure = (error) => {
        console.log("Error occurred, request not processed")
        console.log(error)
    }
</script>
<?php require("../views/templates/footer.php");?>
