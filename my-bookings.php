<?php
include './header.php';
require_once ("./src/Database.php");
require_once './src/Session.php';


if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === false) {
    header("Location: ./login.php");
    exit();
  }
  

$user = Session::get('user');

$user_id = $user->id;

$sql = "SELECT c.*, b.* FROM booking b
        JOIN cars c ON b.car = c.id
        WHERE b.customer = '$user_id'";

        //echo $sql;die;
$res = $db->query($sql);

$cars = [];
while ($row = $res->fetch_object()) {
    $cars[] = $row;
}
//print_r($cars);die;


/*if (count($bookings) > 0) {
    // If booking details exist, fetch car details using the car_id from the booking details
    $car_id = $booking_details->car;
    $sql = "SELECT * FROM cars WHERE id = '$car_id'";
    $res = $db->query($sql);
    $car_details = $res->fetch_object();
    $fileName1 = explode('/', $car_details->image1)[4];
    //print_r($fileName1);die;

}*/






?>
<main id="main">
    <section class="section-bg">
        <div class="container">
            <div class="row" style="padding-top: 120px; padding-bottom:100px">
                <div class="col-lg-12 mx-auto">

                    <h3>My Bookings </h3>

                  <?php if(count($cars) > 0): ?>  
                    <?php foreach($cars as $car): ?>
                    <div class="container d-flex ">
                     
                        <div class="card mb-3">
                            <div class="row g-1">
                          
                              <div class="col-md-4">
                                    <img src="./admin/uploaded-files/cars/<?php 
                                    $fileName1 = explode('/', $car->image1)[4];
                                    echo $fileName1 ?>"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                    <a href="./view-my-booking.php?id=<?php echo $car->id ?>"><h5 class="card-title">
                                     <?php echo $car->car_name; ?>
                                        </h5></a>
                                 
                                        <span class="card-text">
                                        Booking Id : <?php echo $car->booking_id; ?>
                                        
                                        </span><br>
                                        <span class="card-text">
                                           Start Date : <?php echo $car->start_date; ?>
                                        
                                        </span><br>
                                        <span class="card-text">
                                          
                                           End Date : <?php echo $car->end_date; ?>
                                        </span>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Status:
                                            </small>
                                            <span class="badge badge-pill badge-success"><?php echo $car->booking_status; ?></span>
                                        </p>
                                    </div>
                                </div>
                               
                              
                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <h5 class="text-center">No Booking Yet</h5>
                    <?php endif ?>
                </div>
            </div>
    </section><!-- #intro -->
</main>
<?php include './footer.php' ?>