<?php 
require("templates/header.php");
require("../server/products.php");

require("../server/userManagement.php");

checkSession();

$products = getProducts();

$db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');
$sql = "select 
     c.app_id,
     c.first_name,
     c.last_name,
     c.dob,
     c.postcode,
     c.contact_no,
     a.status as application_status,
     p.placement as selected_product
     from customers c 
     inner join applications a on c.app_id = a.app_id 
     inner join products p on p.id = a.selected_product;";

$stmt = $db->prepare($sql);
$stmt->bindParam(':uid', $_GET['uid'], SQLITE3_TEXT);
$result= $stmt->execute();
$arrayResult = [];

while($row=$result->fetchArray(SQLITE3_NUM)){
    $arrayResult [] = $row;
}

if (isset($_POST['submit'])){

    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');
     $c = 0;

    $db->exec("BEGIN");

     //     Update customer
    $sql = "UPDATE customers SET first_name = :fname, last_name = :lname, dob = :dob, birth_month = :mob, contact_no = :tel, postcode =:pcode WHERE  app_id = :appid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':fname',$_POST['fname'], SQLITE3_TEXT);
    $stmt->bindParam(':lname',$_POST['lname'], SQLITE3_TEXT);
    $stmt->bindParam(':dob',$_POST['dob'], SQLITE3_TEXT);
    $stmt->bindParam(':mob',$_POST['mob'], SQLITE3_TEXT);
    $stmt->bindParam(':pcode',$_POST['pcode'], SQLITE3_TEXT);
    $stmt->bindParam(':tel',$_POST['tel'], SQLITE3_TEXT);
    $stmt->bindParam(':appid',$_POST['appid'], SQLITE3_TEXT);

    $stmt->execute();

    if($stmt){++$c;}


    $prod = intval($_POST['prod']);
     //     Update application
    $sql = "UPDATE applications set status=:status, comments=:comments, last_modified=CURRENT_TIMESTAMP, selected_product=:prod where app_id=:appid"; 
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':status',$_POST['status'], SQLITE3_TEXT);
    $stmt->bindParam(':prod',$prod, SQLITE3_INTEGER);
    $stmt->bindParam(':appid',$_POST['appid'], SQLITE3_TEXT);
    $stmt->bindParam(':comments',$_POST['comments'], SQLITE3_TEXT);
    
    $stmt->execute();
    if($stmt){++$c;}

    echo $c;

    if($c==2){
          $db->exec('COMMIT');
     }else{
          $db->exec('ROLLBACK');
     }

    header('Location: manageRegistrations.php');
}

?>


<div class="container update-app-container">

     <div class="row">
     <?php if (!$arrayResult){
          echo "<p>Invalid selection</p>";
          header('Location: manageRegistrations.php'.$createUser);

     } else{
          $appId = $arrayResult[0][0];
          $history = getApplicationHistory($appId);
          // print_r($arrayResult);   
     ?>


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
                        <h3>Update Application</h3>

                        <!-- <?php print_r($_SERVER);?> -->
     <p><b>ID:</b> <?php echo $_GET['uid'];?></p>
     <div class="col-8">
          <form method="post" class="register-frm row g-8 require-validation" novalidate>
               <input class="form-control" type="text" name="appid" value="<?php echo $_GET['uid']; ?>" hidden>
               <div class="form-group col-lg-4">
                    <label class="control-label labelFont">First Name</label>
                    <input class="form-control" type="text" name="fname" value="<?php echo $arrayResult[0][1]; ?>" required>
               </div>

               <div class="form-group col-lg-4">
                    <label class="control-label labelFont">Last Name</label>
                    <input class="form-control" type="text" name="lname" value="<?php echo $arrayResult[0][2]; ?>" required>
               </div>

               <div class="form-group col-lg-4">
                    <label class="control-label labelFont">DOB</label>
                    <input  id="dob-input" class="form-control" type="date" name="dob" value="<?php echo $arrayResult[0][3]; ?>" required>
               </div>

               <div class="col-lg-4">
                    <label for="mob-input" class="control-label labelFont">Month of Birth</label>
                    <input dob-input="mob" name="mob" type="text" class="form-control" id="mob-input" readonly required>
                    <div class="valid-feedback">
                         Valid
                    </div>
               </div>

               <div class="form-group col-lg-4">
                    <label class="control-label labelFont">Post Code</label>
                    <input id="postcode-input" class="form-control" type="text" name="pcode" value="<?php echo $arrayResult[0][4]; ?>" required>
               </div>

               <div class="form-group col-lg-4">
                    <label class="control-label labelFont">Contact</label>
                    <input class="form-control" type="text" name="tel" value="<?php echo $arrayResult[0][5]; ?>" required>
               </div>
               <div class="form-group col-lg-4">
                    <label class="control-label labelFont">Product</label>

                    
                    <select name="prod" class="form-select" id="validationCustom04" required>
                         <option  disabled value="">Select updated product...</option>
                         
                         
                         <?php 

                         foreach($products as $product){


                              echo 
                                   '<option value="'.$product['id'] . '"'.
                                   ($product['placement'] == $arrayResult[0][7] ? " selected":""). '> Placement '
                                   . $product['placement'].', min tenure: '.$product['min_tenure'].
                                   '</option>';
                         }
                         ?>

                        
                    </select>
               </div>
               <div class="form-group col-lg-4">
                    <label class="control-label labelFont">Application Status</label>
                    <select name="status" class="form-control">
                         <option <?php echo ($arrayResult[0][6]=="New") ? "selected" : ""; ?>>New</option>
                         <option <?php echo ($arrayResult[0][6]=="In-process") ? "selected" : ""; ?>>In-process</option>
                         <option <?php echo ($arrayResult[0][6]=="Complete") ? "selected" : ""; ?>>Complete</option>
                         <option <?php echo ($arrayResult[0][6]=="On-hold") ? "selected" : ""; ?>>On-hold</option>
                         <option <?php echo ($arrayResult[0][6]=="Withdrawn") ? "selected" : ""; ?>>Withdrawn</option>
                    </select>
               </div>
               <div class="form-group col-lg-6">
                    <label for="comments">Comments</label>
                    <textarea name="comments" class="form-control" id="comments" rows="3"></textarea>
               </div>

               <div class="form-group col-lg-12">
                    <input id="submit" type="submit" name="submit" value="Update" class="btn btn-primary">
               </div>
               <div class="form-group col-lg-4"><a href="manageRegistrations.php">Back</a></div>
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


     <?php }?>
</div>
</div>
<script src="../assets/js/scripts.js"></script>

<?php require("templates/footer.php");?>