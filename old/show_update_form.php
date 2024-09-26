<?php
session_start();
require 'apiconfig.php';
$stmt = $pdo->query("select * from vendor where vendor_id='".$_POST['vendorid']."'");
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$stmt1=$pdo->query("select * from user where user_id='".$row['vendor_name']."'");
$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
if($row['type']==0){$temp='<option value="0" selected>Individual</option>
    <option value="1">Company</option>';}
if($row['type']==1){$temp='<option value="0">Individual</option>
    <option value="1" selected>Company</option>';}
if($row['kyc_verified']==0){$temp1='<option value="0" selected>No</option>
    <option value="1">Yes</option>';}
if($row['kyc_verified']==1){$temp1='<option value="0">No</option>
    <option value="1" selected>Yes</option>';}
$stmt2 = $pdo->query("select * from role order by role_value");
echo '
<div class="row" style="width: 100%;">
<form style="width: 100%;" name="updateVendorForm" onsubmit="return updateVendor()">
<div class="row">
        <div class="col-md-6">
            <label for="vendorName">First Name<span style="color: red;font-weight:bold;">*</span> :</label>
            <input onkeyup="return updateVendorValidation(\'firstName\');" type="text" class="form-control" id="uvendorFirstName" aria-describedby="vendorFNameFeedback" value="'.$row['first_name'].'" required>
            <div id="vendorFNameFeedback" class="invalid-feedback">
                Invalid Username
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">Last Name<span style="color: red;font-weight:bold;">*</span> :</label>
            <input onkeyup="return updateVendorValidation(\'lastName\');" type="text" class="form-control" id="uvendorLastName" aria-describedby="vendorLNameFeedback" value="'.$row['last_name'].'" required>
            <div id="vendorLNameFeedback" class="invalid-feedback">
                Invalid Username
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Vendor User Name<span style="color: red;font-weight:bold;">*</span> :</label>
            <input type="text" class="form-control" id="uvendorName" aria-describedby="vendorNameFeedback"  value="'.$row['vendor_name'].'" required>
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorNameFeedback" class="invalid-feedback">
                Invalid Username
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">Vendor Type :</label>
            <select name="vendorType" id="uvendorType" class="form-control">
                '.$temp.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Vendor Email<span style="color: red;font-weight:bold;">*</span> :</label>
            <input onkeyup="return updateVendorValidation(\'email\');"   value="'.$row1['email'].'" type="email" class="form-control" id="uvendorEmail" aria-describedby="vendorEmailFeedback" required>
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorEmailFeedback" class="invalid-feedback">
                Invalid Email Address.
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">Vendor Role :</label>
            <select name="vendorType" id="uvendorRole" class="form-control">';
                
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    if($row['role_id']!=$row2['role_id']){
                    echo '<option value="' . $row2['role_id'] . '">' . $row2['role_value'] . '</option>';
                    }
                    else{
                        echo '<option value="' . $row2['role_id'] . '" selected>' . $row2['role_value'] . '</option>';
                    }
                }
                echo '
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="Pan">Pan Number :</label>
            <input onkeyup="return updateVendorValidation(\'pan\');"  value="'.$row['pan'].'" type="text" class="form-control" id="uvendorPan" aria-describedby="vendorPanFeedback">
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorPanFeedback" class="invalid-feedback">
                Invalid PAN Number
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">gst Number :</label>
            <input onkeyup="return updateVendorValidation(\'gst\');"  value="'.$row['gst'].'" type="text" class="form-control" id="uvendorGst" aria-describedby="vendorGstFeedback">
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorGstFeedback" class="invalid-feedback">
                Invalid Gst Number
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Aadhar Number :</label>
            <input onkeyup="return updateVendorValidation(\'aadhar\');" value="'.$row['aadhar_number'].'" type="number" class="form-control" id="uaadharNumber" aria-describedby="vendorAadharFeedback">
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorAadharFeedback" class="invalid-feedback">
                Invalid Aadhar Number
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">KYC Verified :</label>
            <select name="kycVerified" id="ukycVerified" class="form-control">
               '.$temp1.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Mobile Number<span style="color: red;font-weight:bold;">*</span> :</label>
            <input onkeyup="return updateVendorValidation(\'mobile\');" type="number" value="'.$row['mobile_number'].'"  class="form-control" id="umobileNumber" aria-describedby="vendorMobileFeedback" required>
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorMobileFeedback" class="invalid-feedback">
                Invalid Mobile Number
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">Other contact Number :</label>
            <input onkeyup="return updateVendorValidation(\'mobile2\');" type="number" value="'.$row['mobile_number_other'].'" class="form-control" id="umobileNumber2" aria-describedby="vendorMobile2Feedback">
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorMobile2Feedback" class="invalid-feedback">
                Invalid Mobile Number
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">State :</label>
            <input type="text" class="form-control" value="'.$row['state'].'" id="ustate">
        </div>
        <div class="col-md-6">
            <label for="vendorName">Country :</label>
            <input type="text" class="form-control" value="'.$row['country'].'" id="ucountry">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">IFSC Code :</label>
            <input onkeyup="return updateVendorValidation(\'ifsc\');" type="text" class="form-control" value="'.$row['ifsc'].'" id="uifscCode" aria-describedby="vendorIfscFeedback">
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorIfscFeedback" class="invalid-feedback">
                Invalid IFSC Number
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">Account Number :</label>
            <input onkeyup="return updateVendorValidation(\'account\');" type="number" value="'.$row['account_number'].'" class="form-control" id="uaccountNumber" aria-describedby="vendorAccountFeedback">
            <div class="valid-feedback">
                Looks Good!
            </div>
            <div id="vendorAccountFeedback" class="invalid-feedback">
                Invalid Account Number
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Contract Type :</label>
            <input type="text" class="form-control" id="ucontractType" value="'.$row['contract_type'].'" aria-describedby="vendorTypeFeedback" >
            <div id="vendorTypeFeedback" class="invalid-feedback">
                Invalid!
            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">Contract Signed :</label>
            <select name="contractSigned" id="ucontractSigned" value="'.$row['contract_signed'].'" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Estimated Budget :</label>
            <input type="number" class="form-control" onkeyup="return ushowEstimatedWords()" value="'.$row['estimated_budget'].'" aria-describedby="uestimatedBudgetFeedback" id="uestimatedBudget">
            <div class="valid-feedback" id="uestimatedBudgetFeedback">
                                                Looks Good!
                                            </div>
        </div>
        <div class="col-md-6">
            <label for="vendorName">Finalised Budget :</label>
            <input type="number" onkeyup="return ushowFinalesdWords()" class="form-control" value="'.$row['final_budget'].'"aria-describedby="ufinalisedBudgetFeedback" id="ufinalisedBudget">
            <div class="valid-feedback" id="ufinalisedBudgetFeedback">
            Looks Good!
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Boarding Date :</label>
            <input type="date" class="form-control" value="'.$row['boarding_date'].'" id="uboardingDate">
        </div>
        <div class="col-md-6">
            <label for="vendorName">Work Rating :</label>
            <input type="text" class="form-control" value="'.$row['work_rating'].'" id="uworkRating">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="vendorName">Planned Days :</label>
            <input type="number" class="form-control" value="'.$row['planned_days'].'" id="uplannedDays">
        </div>
        <div class="col-md-6">
            <label for="vendorName">Days Utilised :</label>
            <input type="number" class="form-control" value="'.$row['utilised_days'].'" id="udaysutilised">
        </div>
    </div>
    <button style="margin: 8px;" class="btn btn-primary" type="submit">Register Vendor</button>
    
</form>
</div>
';
?>
