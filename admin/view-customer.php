<?php
include './header.php';

if (!isset($_GET['id']) || strlen($_GET['id']) < 1 || !ctype_digit($_GET['id'])) {
    header('Location:./index.php');
    exit();
}
require_once '../src/Database.php';


$id = filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $db->real_escape_string($id);

$query = "SELECT * FROM customers
       WHERE id = '$id'";

$result = $db->query($query);
$customer_details = $result->fetch_object();

$front_image = explode('/', $customer_details->driving_license_image1)[5];
$back_image = explode('/', $customer_details->driving_license_image2)[5];
$address_proof_image = explode('/', $customer_details->address_proof_image)[5];




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    if (isset($_POST['status'])) {

        $customer_id = $_POST["customer_id"];
        $status = ($_POST['status'] == 'Verified') ? 'Verified' : 'Pending';

        // Example: $status = ($_POST['status'] == 'on') ? 'verified' : 'not_verified'; // Save $status to the backend or database
        $sql = " UPDATE customers SET is_verified = '$status' WHERE id = '$id'";
        //echo $sql;die;
        if ($db->query($sql) === true) {
            echo "<script>alert('User verified successfully'); window.location.href = './customers.php';</script>";
        } else {
            echo '<script>alert("Unable to verify user");</script>';

        }

    }
}


?>


<div class="container-fluid">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><a href="">Dashboard</a> / View Adhar Booking</li>
    </ol>
    <div class="card">
        <div class="table-responsive" style="height: 600px; overflow-y:auto">
            <div class="col-lg-12">

                <table cellspacing="0" width="100%" class="my-5" style="margin-top:60px">

                    <tr>
                        <td colspan="2" style="padding: 10px">
                            <table width="100%">
                                <tr>
                                    <td width="110px"><strong>Status:</strong></td>
                                    <?php $customer_details->is_verified == 'Pending' ? $labelColor = 'danger' : $labelColor = 'success' ?>
                                    <td><span
                                            class="badge badge-<?php echo $labelColor ?>"><?php echo $customer_details->is_verified ?></span>
                                    </td>

                                    <td width="110px"><strong>Name:</strong></td>
                                    <td><?php echo $customer_details->name ?></td>
                                    <td width="130px"><strong>Email:</strong></td>
                                    <td><?php echo $customer_details->email ?></td>
                                    <td width="130px"><strong>Phone No:</strong></td>
                                    <td><?php echo $customer_details->email ?></td>
                                </tr>
                                <tr>
                                    <td width="110px" style="padding-top:80px"><strong>Address:</strong></td>
                                    <td width="110px" style="padding-top:80px"><?php echo $customer_details->address ?>
                                    </td>


                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="padding-top:70px">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td width="180px"><strong>DL Number:</strong></td>
                                        <td><input type="text" class="form-control"
                                                value="<?php echo $customer_details->driving_license_no ?>" readonly />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td style="padding-top:10px"><strong>DL Images :</strong></td>
                                        <td class="image-box">
                                            <img src="./uploaded-files/customer-doc/DL/<?php echo $front_image ?>"
                                                alt="Image 1" class="image">
                                            <img src="./uploaded-files/customer-doc/DL/<?php echo $front_image ?>"
                                                alt="Image 2" class="image">
                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="190px" style="padding-top:40px"><strong>Address Proof No: </strong>
                                        </td>
                                        <td style="padding-top:40px"><?php echo $customer_details->address_proof_no ?>
                                        </td>

                                    </tr>
                                    <td style="padding-top:10px"><strong>Address Proof Image :</strong></td>
                                    <td class="image-box mt-5">
                                        <img src="./uploaded-files/customer-doc/address-proof/<?php echo $address_proof_image ?>"
                                            alt="Image 1" class="image">

                                    </td>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>

                <form method="POST" action="">
                    <input type="hidden" name="customer_id" value="<?php echo $id ?>">
                    <label>
                        <input type="checkbox" name="status" class="form-control" value="Verified" <?php echo ($customer_details->is_verified === 'Verified') ? 'checked' : ''; ?>>
                        Is Verified
                    </label>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </form>
                <div class="page-break" style="position:relative; height:75px"></div>

            </div>
        </div>
    </div>

    <?php
    include './footer.php';
    ?>