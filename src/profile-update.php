<?php
require_once './Database.php';

//$db = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo 'Method not allowed';
    return;
}

$isError = false;
$errors = [
    "name" => "",
    "email" => "",
    "phone" => "",
    "address" => "",
    "driving_license_no" => "",
    "driving_license_image1" => "",
    "driving_license_image2" => "",
    "address_proof_no" => "",
    "address_proof_image" => "",
];

$id = $_POST['id'];

if (empty($_POST['name'])) {
    $isError = true;
    $errors['name'] = 'Please enter name';
}

if (empty($_POST['email'])) {
    $isError = true;
    $errors['email'] = 'Please enter email';
}

if (empty($_POST['phone'])) {
    $isError = true;
    $errors['phone'] = 'Please enter phone';
}

if (!ctype_digit($_POST['phone']) && strlen($_POST['phone']) == 10) {
    $isError = true;
    $errors['phone'] = 'Please enter valid phone';
}

if (empty($_POST['address'])) {
    $isError = true;
    $errors['address'] = 'Please enter address';
}

if (empty($_POST['driving-license-no'])) {
    $isError = true;
    $errors['driving_license_no'] = 'Please enter driving license no';
}

if (empty($_POST['address-proof-no'])) {
    $isError = true;
    $errors['address_proof_no'] = 'Please enter address_proof_no';
}


# File validation
$allowedExts = ['png', 'jpeg', 'jpg'];
$maxAllowedSize = 1024 * 300; #300KB

if ($_FILES['driving-license-image1']['error'] == 4) {
    $isError = true;
    $errors['driving_license_image1'] = 'Please select driving license front image';
} else {
    if (
        !in_array(
            strtolower(pathinfo($_FILES['driving-license-image1']['name'], PATHINFO_EXTENSION)),
            $allowedExts
        )
    ) {
        $isError = true;
        $errors['driving_license_image1'] = 'Invalid file format for DL front image (jpg, jpeg, png only)';
    }

    if ($_FILES['driving-license-image1']['size'] > $maxAllowedSize) {
        $isError = true;
        $errors['driving_license_image1'] = 'DL Front image size is too large (MAX 100KB)';
    }
}
//second image
if ($_FILES['driving-license-image2']['error'] == 4) {
    $isError = true;
    $errors['driving_license_image2'] = 'Please select driving license front image';
} else {
    if (
        !in_array(
            strtolower(pathinfo($_FILES['driving-license-image2']['name'], PATHINFO_EXTENSION)),
            $allowedExts
        )
    ) {
        $isError = true;
        $errors['driving_license_image2'] = 'Invalid file format for DL back image (jpg, jpeg, png only)';
    }

    if ($_FILES['driving-license-image2']['size'] > $maxAllowedSize) {
        $isError = true;
        $errors['driving_license_image2'] = 'DL Back image size is too large (MAX 100KB)';
    }
}

//address proof image
if ($_FILES['address-proof-image']['error'] == 4) {
    $isError = true;
    $errors['address_proof_image'] = 'Please select address proof image';
} else {
    if (
        !in_array(
            strtolower(pathinfo($_FILES['address-proof-image']['name'], PATHINFO_EXTENSION)),
            $allowedExts
        )
    ) {
        $isError = true;
        $errors['address_proof_image'] = 'Invalid file format address proof image (jpg, jpeg, png only)';
    }

    if ($_FILES['address-proof-image']['size'] > $maxAllowedSize) {
        $isError = true;
        $errors['address_proof_image'] = 'address proof image size is too large (MAX 100KB)';
    }
}

if ($isError) {
    http_response_code(400);
    $payload = json_encode(['msg' => 'Correct the following fields', 'errors' => $errors]);
    echo $payload;
    return;
}

$name = $db->real_escape_string($_POST['name']);
$email = $db->real_escape_string($_POST['email']);
$phone = $db->real_escape_string($_POST['phone']);
$address = $db->real_escape_string($_POST['address']);
$driving_license_no = $db->real_escape_string($_POST['driving-license-no']);
$address_proof_no = $db->real_escape_string($_POST['address-proof-no']);


# File path and extension
$drivingLicenseImage1Ext = pathinfo($_FILES['driving-license-image1']['name'], PATHINFO_EXTENSION);
$drivingLicenseImage2Ext = pathinfo($_FILES['driving-license-image2']['name'], PATHINFO_EXTENSION);
$addressProofImageExt = pathinfo($_FILES['address-proof-image']['name'], PATHINFO_EXTENSION);
$drivingLicenseImage1Path = '../admin/uploaded-files/customer-doc/DL/' . md5(time()) . '.' . $drivingLicenseImage1Ext;
$drivingLicenseImage2Path = '../admin/uploaded-files/customer-doc/DL/' . md5(time() + 100000) . '.' . $drivingLicenseImage2Ext;
$addressProofImagePath = '../admin/uploaded-files/customer-doc/address-proof/' . md5(time() + 100000) . '.' . $addressProofImageExt;

try {


    $sql = "UPDATE customers SET address = '$address', 
    driving_license_no = '$driving_license_no',
    driving_license_image1 = '$drivingLicenseImage1Path',
    driving_license_image2 = '$drivingLicenseImage2Path',
    address_proof_no = '$address_proof_no',
    address_proof_image = '$addressProofImagePath'
     WHERE id = '$id'";
    //echo $sql;die;
    $db->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    if ($db->query($sql) === false) {
        throw new Exception('Failed to save data');
    }


    if (!move_uploaded_file($_FILES['driving-license-image1']['tmp_name'], $drivingLicenseImage1Path)) {
        throw new Exception('Failed move driving license front image file');
    }

    if (!move_uploaded_file($_FILES['driving-license-image2']['tmp_name'], $drivingLicenseImage2Path)) {
        throw new Exception('Failed move driving license back image file');
    }

    if (!move_uploaded_file($_FILES['address-proof-image']['tmp_name'], $addressProofImagePath)) {
        throw new Exception('Failed move address proof image file');
    }

    $db->commit();
    http_response_code(200);
    echo json_encode(['msg' => "Your profile updation is successful"]);

    //echo json_encode(['msg' => "Your appointment for adhar enrollment is successful, please visit Kudrat Computer Care with downloaded receipt", 'url' => "./src/receipt.php?id=" . $bookingId]);
} catch (Exception $e) {
    $db->rollback();

    if (file_exists($drivingLicenseImage1Path)) {
        unlink($drivingLicenseImage1Path);
    }

    if (file_exists($drivingLicenseImage2Path)) {
        unlink($drivingLicenseImage2Path);
    }

    if (file_exists($addressProofImagePath)) {
        unlink($addressProofImagePath);
    }


    $db->rollback();
    $db->commit();

    http_response_code(500);
    echo json_encode(['msg' => 'Can not update profile now, please try again later']);
}