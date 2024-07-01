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
            <li class="menu-item" data-index="0">
                <a href="https://thcsthanhxuan.edu.vn/homegd14">Trang chủ</a>
            </li>
            <li class="menu-item" data-index="1">
                <a href="<?php echo base_url(); ?>thong-tin-tuyen-sinh.php">Thông tin tuyển sinh</a>
            </li>
            <li class="menu-item" data-index="2">
                <a href="<?php echo base_url(); ?>dang-ky-tuyen-sinh.php">Đăng ký tuyển sinh</a>
            </li>
            <li class="menu-item" data-index="3">
                <a href="<?php echo base_url(); ?>tra-cuu-diem.php">Tra cứu kết quả</a>
            </li>
            <li class="menu-item" data-index="4">
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

    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('#menu li');

        // Function to set active item based on stored index
        function setActiveItem(index) {
            menuItems.forEach(item => {
                item.classList.remove('active');
            });
            if (index !== null && index !== undefined) {
                menuItems[index].classList.add('active');
            }
        }

        // Get the stored active index from LocalStorage
        const storedIndex = localStorage.getItem('activeMenuItem');
        if (storedIndex) {
            setActiveItem(parseInt(storedIndex, 10));
        }

        // Add click event to each menu item
        menuItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                menuItems.forEach(menuItem => {
                    menuItem.classList.remove('active');
                });

                // Add active class to the clicked item
                item.classList.add('active');

                // Store the active index in LocalStorage
                localStorage.setItem('activeMenuItem', index);
            });
        });
    });
</script>