<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link menu-bar" href="<?= base_url('dashboard'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed menu-bar" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Kegiatan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link menu-bar" href="<?= base_url('daftar-kegiatan'); ?>">Daftar Kegiatan</a>
                    </nav>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link menu-bar" href="<?= base_url('input-target'); ?>">Input Target Realisasi</a>
                    </nav>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link menu-bar" href="<?= base_url('input-progress'); ?>">Input Progress</a>
                    </nav>
                </div>
                <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Authentication
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="login.html">Login</a>
                                <a class="nav-link" href="register.html">Register</a>
                                <a class="nav-link" href="password.html">Forgot Password</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseError" aria-expanded="false"
                            aria-controls="pagesCollapseError">
                            Error
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                                <a class="nav-link" href="404.html">404 Page</a>
                                <a class="nav-link" href="500.html">500 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a> -->
                <?php if (in_groups('Admin')) : ?>
                    <a class="nav-link menu-bar" href="<?= base_url('kecamatan') ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-atlas"></i></div>
                        Daftar Kecamatan
                    </a>
                    <a class="nav-link menu-bar" href="<?= base_url('kelurahan') ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-map-marked-alt"></i></div>
                        Daftar Kelurahan/Desa
                    </a>
                    <a class="nav-link menu-bar" href="<?= base_url('mitra') ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                        Daftar Mitra
                    </a>
                    <a class="nav-link menu-bar" href="<?= base_url('akun') ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Daftar Akun Pengguna
                    </a>
                <?php endif; ?>
                <a class="nav-link menu-bar" href="<?= base_url('logout') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <!-- <div class="sb-sidenav-footer">
            <div class="small">Masuk Sebagai:</div>
            
        </div> -->
    </nav>
</div>