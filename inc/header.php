<div class="bl_header">
    <div class="container">
        <div class="header">
            <div class="banner">
                <div class="logo">
                    <img src="./images/common/logo_thcs_thanh_xuan.png" alt="">
                </div>
                <div class="text">
                    <h1>TRƯỜNG THCS THANH XUÂN</h1>
                    <p>NHÂN CÁCH - TRI THỨC - KỸ NĂNG</p>
                </div>
            </div>
            <div class="bg_truong">
                <img src="./images/common/anh_2.png" alt="">
            </div>
        </div>
        <ul class="menu_top desktop-menu" id="menu">
            <li class="menu-item">
                <a class="nav-link" href="https://thcsthanhxuan.edu.vn/homegd14">Trang chủ</a>
            </li>
            <li class="menu-item">
                <a class="nav-link" href="thong-tin-tuyen-sinh.php">Thông tin tuyển sinh</a>
            </li>
            <li class="menu-item">
                <a class="nav-link" href="dang-ky-tuyen-sinh.php">Đăng ký tuyển sinh</a>
            </li>
            <li class="menu-item">
                <a class="nav-link" href="tra-cuu-diem.php">Tra cứu kết quả</a>
            </li>
            <li class="menu-item">
                <a class="nav-link" href="huong-dan-dang-ky.php">Hướng dẫn đăng ký</a>
            </li>
        </ul>
        <!-- Icon cho mobile -->
        <div class="mobile-icon" onclick="toggleMobileMenu()">☰</div>
    </div>
</div>
<script type="text/javascript">
    function toggleMobileMenu() {
        var menu = document.querySelector('.menu_top');
        menu.classList.toggle('show-mobile-menu');
    }

    // Get the current URL of the page
    var currentUrl = window.location.href;

    // Get all menu items
    var menuItems = document.querySelectorAll('#menu .menu-item .nav-link');

    // Loop through each menu item
    menuItems.forEach(function(menuItem) {
        // Check if the menu item's href matches the current URL
        if (menuItem.href === currentUrl) {
            // Add the 'active' class to the matching menu item
            menuItem.classList.add('active');
        }
    });

</script>