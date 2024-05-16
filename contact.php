<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hotel - Contact</title>
    <?php require('inc/links.php')?>
    <style>

    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">CONTACT US</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias architecto asperiores at aut blanditiis cum dolor dolore
        <br> doloremque esse exercitationem ipsum obcaecati perspiciatis quae, quam quibusdam repellat sapiente sit sunt?</p>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4">
                <iframe class="w-100 rounded mb-4" height="320px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.0870263283373!2d105.8479692758878!3d21.029203587762186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab950cfc545d%3A0x9dd5c3345349c008!2zUC4gTmjDoCBUaOG7nSwgSMOgbmcgVHLhu5FuZywgSG_DoG4gS2nhur9tLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1700843239618!5m2!1svi!2s" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <h5>Address</h5>
                <a href="https://maps.app.goo.gl/7Z8yRFZgXeXtm9bL6" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                    <i class="bi bi-geo-alt-fill"></i>Hàng Trống, Hoàn Kiếm, Hà Nội
                </a>
                <h5 class="mt-4">Call us</h5>
                <a href="tel: +84387409300" class="d-inline-block mb-2 text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i>+84387409300
                </a>
                <br>
                <a href="tel: +84387409300" class="d-inline-block mb-2 text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i>+84387409300
                </a>
                <h5 class="mt-4">Email</h5><i class="bi bi-envelope"></i>
                <a href="mailto: doangiang665@gmail.com" class="d-inline-block mb-2 text-decoration-none text-dark">doangiang665@gmail.com</a>

                <h5 class="mt-4">Follow us</h5>
                <a href="tel: +84387409300" class="d-inline-block mb-3 text-dark fs-5 me-2">
                    <i class="bi bi-twitter me-1"></i>
                </a>
                <a href="tel: +84387409300" class="d-inline-block mb-3 text-dark fs-5 me-2">
                    <i class="bi bi-facebook me-1"></i>
                </a>
                <a href="tel: +84387409300" class="d-inline-block text-dark fs-5 me-2">
                    <i class="bi bi-instagram me-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 px-4">
            <div class="bg-white rounded shadow p-4">
                <form action="">
                    <h5>Send a  message</h5>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" style="font-weight: 500" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" style="font-weight: 500" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" style="font-weight: 500" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control shadow-none" rows="5" style="resize: none"></textarea>
                    </div>
                    <button type="button" class="btn text-white custom-bg shadow-none me-lg-3 me-3">
                        Send
                    </button>
                </form>
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