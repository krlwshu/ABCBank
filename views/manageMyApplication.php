<?php 
require("templates/header.php");

checkSession();

require("../server/products.php");

$products = getProducts();

require("../server/userManagement.php");
$users = getApplicationDetails($_SESSION['app_id'])[0];
$history = getApplicationHistory($_SESSION['app_id']);

?>


<div class="container update-app-container">

    <div class="row">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">My Application</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">History</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Manage My Application</h4>
                        <div class="col-12">
                            <form id="updateMyDetails" method="post" class="register-frm row g-8 require-validation"
                                novalidate>
                                <input id="appid" hidden type="text" name"appId"
                                    value="<?php  echo $users['app_id'];?>" />
                                <input class="form-control" type="text" name="appid"
                                    value="<?php echo $users['app_id']; ?>" hidden>
                                <div class="form-group col-lg-4">
                                    <label class="control-label labelFont">First Name</label>
                                    <input disabled class="form-control" type="text" name="fname"
                                        value="<?php echo $users['first_name']; ?>" required>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label class="control-label labelFont">Last Name</label>
                                    <input disabled class="form-control" type="text" name="lname"
                                        value="<?php echo $users['last_name']; ?>" required>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label class="control-label labelFont">DOB</label>
                                    <input disabled id="dob-input" class="form-control" type="date" name="dob"
                                        value="<?php echo $users['dob']; ?>" required>
                                </div>


                                <div class="form-group col-lg-4">
                                    <label class="control-label labelFont">Post Code</label>
                                    <input disabled id="postcode-input" class="form-control" type="text" name="pcode"
                                        value="<?php echo $users['postcode'];?>" required>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label class="control-label labelFont">Contact</label>
                                    <input disabled class="form-control" type="text" name="tel"
                                        value="<?php echo $users['contact_no']; ?>" required>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label class="control-label labelFont">Application Status</label>
                                    <input disabled class="form-control" type="text" name="tel"
                                        value="<?php echo $users['application_status'] ?>" required>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label class="control-label labelFont">Product</label>


                                    <select id="product" name="prod" class="form-select" id="validationCustom04"
                                        required>
                                        <option disabled value="">Select updated product...</option>


                                        <?php 

                         foreach($products as $product){


                              echo 
                                   '<option value="'.$product['id'] . '"'.
                                   ($product['placement'] == $users['selected_product'] ? " selected":""). '> Placement '
                                   . $product['placement'].', min tenure: '.$product['min_tenure'].
                                   '</option>';
                         }
                         
                         ?>

                                    </select>
                                </div>


                                <div class="col-lg-12">
                                    <br>
                                    <h5>Withdraw application?</h5>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="withdraw" value="0" checked>
                                        <label class="form-check-label" for="inlineRadio1">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="withdraw" class="form-check-input" type="radio" name="withdraw"
                                            value="1">
                                        <label class="form-check-label" for="inlineRadio2">Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">

                                    <button class="btn btn-user-update" type="button" data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal"
                                        data-bs-uid="<?php echo $users['app_id']; ?>">Update
                                    </button>

                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-striped ">
                                <thead>
                                    <th>Application #</th>
                                    <th>Status</th>
                                    <th>Product</th>
                                    <th>Updated</th>
                                    <th>Comments</th>
                                </thead>
                                <tbody>
                                <?php foreach ($history as $hItem){?>
                                    <tr>
                                        <td><?php echo $hItem['app_id'];?></td>
                                        <td><?php echo $hItem['status'];?></td>
                                        <td><?php echo $hItem['selected_product'];?></td>
                                        <td><?php echo $hItem['updated'];?></td>
                                        <td><?php echo $hItem['comments'];?></td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                </div>



    </div>


    <div style="top: 20%" class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Changes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure?

                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn display-2 btn btn-outline-danger btn-confirm-cancel"
                            data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill text-danger"></i> No</button>
                        <button id="confirm-delete" onclick="handleSubmit(event)" type="button"
                            class="btn display-2 btn-outline-success" data-bs-dismiss="modal"><i
                                class="bi bi-check-circle text-success"></i> Yes</button>
                    </div>
                </div>
            </div>
        </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>

var deleteUserModal = document.getElementById('deleteUserModal')
deleteUserModal.addEventListener('show.bs.modal', function (event) {
    var modalBodyInput = deleteUserModal.querySelector('.modal-body input')
    var uidSpan = document.getElementById("appPlaceholder")
})

const handleSubmit = (e) =>{
    
    // Get the variables & build the post data
    var appId = document.getElementById('appid').value;
    var withDrawStatus = document.getElementById('withdraw').checked;
    var newProd = document.getElementById('product').value;

    let data = {app_id: appId, withdraw:withDrawStatus , prod: newProd};


    // Post to server
    var url = "../server/processUserUpdate.php";
    fetch(url, 
        {
            method: 'POST',
            body: JSON.stringify(data),
            headers:{
            'Content-Type': 'application/json'
        }
    }).then(res => res.json())
    .then(res => success(res))
    .catch(error => failure(error));
}

// Endpoint sueccessfully hit, then the response handling of it
const success = (res) => {
    // console.log(res)
    var notyf = new Notyf();
    if (res.status == "UPDATED"){
        notyf.success(`${res.appId} successfully updated`); 
    } else {
        notyf.error(`Update failed, response: ${res.status} , please contact our team`);
    }
}

// Error hitting the endpoint, something's wrong!
const failure = (error) => {
    console.log("Error occurred, request not processed")
    console.log(error)
}

</script>

<?php require("templates/footer.php");?>