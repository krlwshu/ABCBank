<?php 
require("../server/products.php");
$products = getProducts();
?>

<form method="post" class="register-frm row g-8 require-validation" novalidate>
    <div class="col-lg-4">
        <label for="fname-input" class="form-label">First name</label>
        <input name="fname" type="text" class="form-control" id="fname-input" value="" placeholder="Karl" required>
        <div class="valid-feedback">
            Valid
        </div>
    </div>
    <div class="col-lg-4">
        <label for="lname-input" class="form-label">Last name</label>
        <input name="lname" type="text" class="form-control" id="lname-input" value="" placeholder="Webster" required>
        <div class="valid-feedback">
            Valid
        </div>
    </div>


    <div class="col-lg-4">
        <label for="dob-input" class="form-label">Date of Birth</label>
        <input name="dob" type="date" class="form-control res-dob" id="dob-input" min="" required>
        <div class="valid-feedback">
            Valid
        </div>
        <div class="invalid-feedback">
            You must be aged 18+
        </div>        
    </div>

    <div class="col-lg-4">
        <label for="mob-input" class="form-label">Month of Birth</label>
        <input name="mob" type="text" class="form-control" id="mob-input" readonly required>
        <div class="valid-feedback">
            Valid
        </div>
    </div>

    <div class="col-lg-4">
        <label for="postcode-input" class="form-label">Postcode</label>
        <input name="pcode" type="text" class="form-control" id="postcode-input" required>
        <div class="invalid-feedback">
            Please enter a valid postcode!
        </div>
    </div>
    <div class="col-lg-4">
        <label for="tel-input" class="form-label">Contact Number</label>
        <input name="tel" type="text" class="form-control" id="tel-input" required>
        <div class="invalid-feedback">
            Please enter a contact number!
        </div>
    </div>
    <div class="col-lg-4">
        <label for="validationCustom04" class="form-label"> Product</label>
        <select name="prod" class="form-select" id="validationCustom04" required>
            <option selected disabled value="">Choose...</option>


            <?php
            foreach($products as $product){


            echo 
                    '<option value="'.$product['id'] . '"'.
                    ($product['placement'] == $arrayResult[0][6] ? " selected":""). '> Placement '
                    . $product['placement'].', min tenure: '.$product['min_tenure'].
                    ' months</option>';
        }
            ?>
        </select>
        <div class="invalid-feedback">
            Please select a valid state.
        </div>
    </div>

    <div style="padding-top:3rem;" class="col-lg-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
            <label class="form-check-label" for="invalidCheck">
                Agree to terms and conditions
            </label>
            <div class="invalid-feedback">
                You must agree before submitting.
            </div>
        </div>
    </div>
    <div style="padding-top:1rem;" class="col-12">
    <input class="btn btn-primary" type="submit" value="Submit" name="submit">
    </div>
</form>

<script src="../assets/js/scripts.js"></script>

