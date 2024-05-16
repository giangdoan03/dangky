<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hotel - Rooms</title>
    <?php require('inc/links.php')?>
    <style>

    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR ROOM</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias architecto asperiores at aut blanditiis cum dolor dolore
        <br> doloremque esse exercitationem ipsum obcaecati perspiciatis quae, quam quibusdam repellat sapiente sit sunt?</p>
</div>
<div class="container">
    <div class="row">

        <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                <div class="container-fluid flex-lg-column align-items-stretch">
                    <h4 class="mt-2" href="#">FILTERS</h4>
                    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="filterDropdown">
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-3" style="font-size: 18px">CHECK AVAILABILITY</h5>
                            <label class="form-label">Check-in</label>
                            <input type="date" class="form-control shadow-none">
                            <label class="form-label">Check-out</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-3" style="font-size: 18px">FACILITIES</h5>
                            <div class="mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="f1">
                                <label class="form-check-label" for="f1">
                                    Facilities one
                                </label>
                            </div>
                            <div class="mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="f2">
                                <label class="form-check-label" for="f2">
                                    Facilities two
                                </label>
                            </div>
                            <div class="mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="f3">
                                <label class="form-check-label" for="f3">
                                    Facilities one
                                </label>
                            </div>
                        </div>
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-3" style="font-size: 18px">GUESTS</h5>
                            <div class="d-flex">
                                <div class="me-3">
                                    <label class="form-label">Adults</label>
                                    <input type="number" class="form-control shadow-none">
                                </div>
                                <div>
                                    <label class="form-label">Children</label>
                                    <input type="number" class="form-control shadow-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="col-lg-9 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow">
                <div class="row g-0 p-3 align-items-center ">
                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                        <img src="images/rooms/1.jpg" class="img-fluid rounded" >
                    </div>
                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                        <h5 class="mb-3">Simple Room Name</h5>
                        <div class="features mb-3">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        2 Rooms
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        1 Bathroom
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        1 Balcony
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        3 Sofa
                        </span>
                        </div>
                        <div class="facilities mb-3">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Wifi
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Television
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        AC
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Room heater
                        </span>
                        </div>
                        <div class="guests">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        5 Adults
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        4 Children
                        </span>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6>200 per night</h6>
                        <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
                        <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">More details</a>
                    </div>
                </div>
            </div>
            <div class="card mb-4 border-0 shadow">
                <div class="row g-0 p-3 align-items-center ">
                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                        <img src="images/rooms/1.jpg" class="img-fluid rounded" >
                    </div>
                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                        <h5 class="mb-3">Simple Room Name</h5>
                        <div class="features mb-3">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        2 Rooms
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        1 Bathroom
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        1 Balcony
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        3 Sofa
                        </span>
                        </div>
                        <div class="facilities mb-3">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Wifi
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Television
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        AC
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Room heater
                        </span>
                        </div>
                        <div class="guests">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        5 Adults
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        4 Children
                        </span>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6>200 per night</h6>
                        <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
                        <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">More details</a>
                    </div>
                </div>
            </div>
            <div class="card mb-4 border-0 shadow">
                <div class="row g-0 p-3 align-items-center ">
                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                        <img src="images/rooms/1.jpg" class="img-fluid rounded" >
                    </div>
                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                        <h5 class="mb-3">Simple Room Name</h5>
                        <div class="features mb-3">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        2 Rooms
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        1 Bathroom
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        1 Balcony
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        3 Sofa
                        </span>
                        </div>
                        <div class="facilities mb-3">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Wifi
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Television
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        AC
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        Room heater
                        </span>
                        </div>
                        <div class="guests">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        5 Adults
                        </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                        4 Children
                        </span>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6>200 per night</h6>
                        <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
                        <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">More details</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require('inc/footer.php'); ?>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".swiper-container", {
        spaceBetween: 30,
        effect: "fade",
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false
        }
    });
    var swiper = new Swiper(".swiper-testimonial", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        slidesPerView: "3",
        loop: true,
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            }
        }
    });
</script>
</body>
</html>