<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
    <h3 class="mb-0 h-font">ADMIN PANEL</h3>
    <a class="btn btn-light btn-sm" href="logout.php">LOGOUT</a>
</div>
<div class="col-lg-2 bg-warning bg-dark border-top border-3 border-secondary" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <!--                <h4 class="mt-2 text-light" href="#">DASHBOARD</h4>-->
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="adminDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="profile-list.php">Quản lý hồ sơ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="nhap-phieu.php">Nhập phiếu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="xuat-phieu.php">Xuất phiếu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>