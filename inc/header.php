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
                <a href="https://thcsthanhxuan.edu.vn/homegd14">Trang chủ</a>
            </li>
            <li class="menu-item">
                <a href="#">Thông tin tuyển sinh</a>
            </li>
            <li class="menu-item">
                <a href="#">Đăng ký tuyển sinh</a>
            </li>
            <li class="menu-item">
                <a href="<?php echo base_url(); ?>tra-cuu-diem.php">Tra cứu kết quả</a>
            </li>
            <li class="menu-item">
                <a href="#">Hướng dẫn đăng ký</a>
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

    // Lấy danh sách các phần tử <li> trong menu
    const menuItems = document.querySelectorAll('#menu li');

    // Duyệt qua từng phần tử và gắn sự kiện click
    menuItems.forEach(item => {
        item.addEventListener('click', function () {
            // Xóa class 'active' khỏi tất cả các phần tử <li> trong menu
            menuItems.forEach(menuItem => {
                menuItem.classList.remove('active');
            });

            // Thêm class 'active' cho phần tử <li> hiện tại được click
            item.classList.add('active');
        });
    });
</script>