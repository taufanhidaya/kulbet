<nav id="mainNavbar" class="p-3 mb-3 border-bottom sticky-top" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <img src="assets/img/Edelweis logo.png" width="50"><span class="font-edelweis">Edelweis</span>
            </a>

            <ul class="nav nav-pills col-12 col-lg-auto me-lg-auto mx-auto mb-2 justify-content-center mb-md-0"
                style="font-family: 'Courgette', cursive; font-weight: 400; font-style: normal;">
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo ($page == 'home') ? 'active link-light' : 'link-dark'; ?>"
                        href="index.php?x=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo ($page == 'kegiatan') ? 'active link-light' : 'link-dark'; ?>"
                        href="index.php?x=kegiatan">Kegiatan</a>
                </li>

                <!-- Dropdown Pengurus -->
                <li class="nav-item dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <a class="nav-link ps-2 dropdown-toggle <?php echo $isPengurusActive ? 'active link-light' : 'link-dark'; ?>"
                        href="#" id="pengurusDropdown" role="button">
                        Pengurus
                    </a>
                    <ul class="dropdown-menu mt-3" aria-labelledby="pengurusDropdown">
                        <li><a class="dropdown-item <?php echo ($page == 'daftar_pengurus') ? 'active' : ''; ?>"
                                href="index.php?x=daftar_pengurus">Daftar Pengurus</a></li>
                        <li><a class="dropdown-item <?php echo ($page == 'struktur') ? 'active' : ''; ?>"
                                href="index.php?x=struktur">Struktur Pengurus</a></li>
                        <li><a class="dropdown-item <?php echo ($page == 'upload') ? 'active' : ''; ?>"
                                href="index.php?x=upload">Upload Data</a></li>
                    </ul>
                </li>
                <!-- End dropdown Pengurus -->

                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo ($page == 'anggota') ? 'active link-light' : 'link-dark'; ?>"
                        href="index.php?x=anggota">Anggota</a>
                </li>

                <!-- Dropdown Divisi -->
                <li class="nav-item dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <a class="nav-link ps-2 dropdown-toggle <?php echo $isDivisiActive ? 'active link-light' : 'link-dark'; ?>"
                        href="#" id="divisiDropdown" role="button">
                        Divisi
                    </a>
                    <ul class="dropdown-menu mt-3" aria-labelledby="divisiDropdown">
                        <li><a class="dropdown-item <?php echo ($page == 'montain') ? 'active' : ''; ?>"
                                href="index.php?x=montain">Gunung Hutan</a></li>
                        <li><a class="dropdown-item <?php echo ($page == 'climbing') ? 'active' : ''; ?>"
                                href="index.php?x=climbing">Panjat Tebing</a></li>
                        <li><a class="dropdown-item <?php echo ($page == 'rafting') ? 'active' : ''; ?>"
                                href="index.php?x=rafting">Arung Jeram</a></li>
                        <li><a class="dropdown-item <?php echo ($page == 'ksda') ? 'active' : ''; ?>"
                                href="index.php?x=ksda">Konservasi Sumber Daya Alam</a></li>
                    </ul>
                </li>
                <!-- End dropdown Divisi -->
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" action="proses/search_proses.php"
                method="get">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search" name="keyword">
            </form>

            <!-- Profil Dropdown -->
            <div class="dropdown text-end" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                    aria-expanded="false">
                    <img src="assets/img/Edelweis logo.png" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small mt-4"
                    style="font-family: 'Courgette', cursive; font-weight: 400; font-style: normal;">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i
                                class="bi bi-box-arrow-in-right"></i> Log In</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left"></i> Log Out</a></li>
                </ul>
            </div>
            <!-- End Profil Dropdown -->
        </div>
    </div>
</nav>
