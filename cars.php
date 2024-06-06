<?php include './header.php';


require_once './src/Database.php';

//$db = Database::getInstance();

//fetch brands
$sql = "SELECT * FROM brands ORDER BY id DESC";
$res = $db->query($sql);
$brands = [];
while ($row = $res->fetch_object()) {
    $brands[] = $row;
}

//print_r($brands);die;


$sql = "SELECT c.* FROM cars c LEFT JOIN booking b ON c.id = b.car 
WHERE b.car IS NULL OR (NOW() < b.start_date OR NOW() > b.end_date) ";
//echo $sql;die;
$result = $db->query($sql);

$cars = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
} else {
    echo "0 results";
}

foreach ($cars as $car) {

    $fileName1 = explode('/', $car['image1'])[4];
    //print_r($fileName1);die;
}

//print_r($cars);die();

?>

<main id="main">

    <section class="section-bg">
        <div class="container-fluid" style="padding-top: 80px; ">

            <!-- You can remove the h3 and p tags if you don't need them -->
            </header>
        </div>
        <div class="container" style="padding-top: 50px; padding-bottom:80px">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group" style="color: white;">
                        <label for="start">Pickup Date:</label>
                        <div class="input-group date" id="startPicker" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" id="start" data-target="#startPicker" placeholder="Select start date and time" />
                            <div class="input-group-append" data-target="#startPicker" data-toggle="datetimepicker" style="background-color: white;">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="color: white;">
                        <label for=" end">Drop Date:</label>
                        <div class="input-group date" id="endPicker" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" id="end" data-target="#endPicker" placeholder="Select end date and time" />
                            <div class="input-group-append" data-target="#endPicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <button id="calculateDuration" class="btn btn-primary">Get Car</button>
                </div>
            </div>
            <div class="form-inline mb-1">
                <span class="mr-md-auto"> </span>
                <select class="mr-2 form-control">
                    <option>Latest</option>
                    <option>Low to High</option>
                </select>
                <div class="btn-group">
                    <a href="#" class="btn btn-outline-secondary" data-toggle="tooltip" title="" data-original-title="List view">
                        <i class="fa fa-bars"></i></a>
                    <a href="#" class="btn  btn-outline-secondary active" data-toggle="tooltip" title="" data-original-title="Grid view">
                        <i class="fa fa-th"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span id="durationMessage" class="text-danger"></span>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-md-12">
                    <button id="calculateDuration" class="btn btn-primary">Calculate Duration</button>
                </div>
            </div>-->

            <div class="row">
                <aside class="col-md-3">

                    <div class="card">

                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true" class="">
                                    <i class="icon-control fa fa-chevron-down"></i>
                                    <h6 class="title">Brands </h6>
                                </a>
                            </header>
                            <div class="filter-content collapse show" id="collapse_2" style="">
                                <div class="card-body">
                                    <?php foreach ($brands as $brand) : ?>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input brand-checkbox" data-brand="<?php echo $brand->id; ?>">
                                            <div class="custom-control-label"><?php echo $brand->brand_name; ?>
                                                <b class="badge badge-pill badge-light float-right"><?php echo $count; ?></b>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div> <!-- card-body.// -->
                            </div>

                        </article> <!-- filter-group .// -->
                    </div> <!-- card.// -->

                </aside>
                <main class="col-md-9">


                    <div class="row" id="carsContainer">

                    </div>
                    <nav class="mt-4" aria-label="Page navigation sample">
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>

                </main>
            </div>
        </div>
    </section>
</main>
<?php include './footer.php'; ?>
<script>
    $(document).ready(function() {
        $('#startPicker, #endPicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            minDate: new Date(),
            useCurrent: false,
            timeZone: 'local', // Set the timezone to 'local'
        });

        // Event listener for brand checkboxes
        $('.brand-checkbox').change(function() {
            if ($(this).is(':checked')) {
                var brand = $(this).data('brand');

                fetchCarsByBrand(brand);
            }
        });

        // Function to fetch cars by brand
        function fetchCarsByBrand(brand) {
            $.ajax({
                url: './fetch-cars.php',
                method: 'POST',
                data: {
                    brand: brand
                },
                success: function(response) {
                    console.log(response)
                    if (response.length > 0) {
                        renderCars(response, moment().toISOString(), moment().add(1, 'day').toISOString()); // Set default start and end dates
                    } else {
                        $('#carsContainer').html('<p>No cars available for this brand.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }


        // Function to fetch and display cars based on selected start and end dates
        function fetchCars(start, end) {
            $.ajax({
                url: './check-data.php',
                method: 'POST',
                data: {
                    start: start,
                    end: end
                },
                success: function(response) {

                    // Display fetched cars
                    // Assuming you have a function to render cars, you can call it here
                    renderCars(response, start, end);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Function to render cars on the page
        function renderCars(cars, start, end) {
            console.log('cars' + cars)
            $('#carsContainer').empty(); // Clear existing cars

            cars.forEach(function(car) {
                console.log('car' + car)
                var fullPath = car.image1;
                var extractedPath = fullPath.substring(fullPath.indexOf('/'));

                var html = '<div class="col-md-4">';
                html += '<div class="container">';
                html += '<div class="row">';
                html += '<div class="card">';
                html += '<div class="bg-image hover-overlay">';
                html += '<img src="http://localhost/car-rentals' + extractedPath + '"  class="img-fluid" alt="' + car.car_name + '" />';
                html += '</div>';
                html += '<hr class="my-0" />';
                html += '<div class=" p-1">';
                html += '<a href="#!" class="text-dark font-weight-bold ml-2">' + car.car_name + '</a>';
                html += '</div>';
                html += '<div class="d-flex justify-content-between m-2">';
                html += '<span><i class="fa fa-cog"></i> ' + car.transmission + '</span>';
                html += '<span><i class="fa fa-users"></i> ' + car.seating_capacity + ' persons</span>';
                html += '</div>';
                html += '<div class="d-flex justify-content-between align-items-center p-2 mb-1">';
                html += '<a href="#!" class="text-dark font-weight-bold">Php.' + car.price_per_day + '/day</a>';
                html += '<a href="./car-details.php?id=' + car.id + '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) + '" class="btn btn-outline-primary">View Car</a>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#carsContainer').append(html);
            });
        }

        // Fetch and display default cars when the page loads
        fetchCars(null, null);

        $('#calculateDuration').click(function() {
            var start = moment($('#start').val(), 'YYYY-MM-DD HH:mm').utcOffset(0, true).toISOString();
            var end = moment($('#end').val(), 'YYYY-MM-DD HH:mm').utcOffset(0, true).toISOString();


            fetchCars(start, end); // Fetch and display cars based on selected dates
        });

        // Fetch and display cars when start and end dates are not initially selected
        if ($('#start').val() === '' || $('#end').val() === '') {
            fetchCars(moment().toISOString(), moment().add(1, 'day').toISOString()); // Set default start and end dates
        }
    });
</script>