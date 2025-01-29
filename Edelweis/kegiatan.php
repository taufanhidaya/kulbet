<?php
// Koneksi ke database
include 'proses/koneksi.php';

// Query untuk mengambil 5 foto terbaru untuk carousel
$sqlCarousel = "
    SELECT 
        id_kegiatan, 
        nama_kegiatan, 
        tanggal_kegiatan, 
        divisi, 
        media_kegiatan
    FROM kegiatan
    WHERE LOWER(SUBSTRING_INDEX(media_kegiatan, '.', -1)) IN ('jpg', 'jpeg', 'png', 'gif') 
    ORDER BY tanggal_kegiatan DESC
    LIMIT 5
";
$resultCarousel = mysqli_query($conn, $sqlCarousel);

// Query untuk mengambil semua kegiatan (untuk grid)
$sqlGrid = "
    SELECT 
        kegiatan.id_kegiatan, 
        kegiatan.nama_kegiatan, 
        kegiatan.tanggal_kegiatan, 
        kegiatan.divisi, 
        kegiatan.media_kegiatan,
        kegiatan.deskripsi_kegiatan,
        kegiatan.instagram_url,
        kegiatan.tiktok_url,
        kegiatan.youtube_url,
        kegiatan.facebook_url,
        kegiatan.twitter_url,
        pengurus.nm_pengurus AS nama_pengurus
    FROM kegiatan
    LEFT JOIN pengurus ON kegiatan.no_anggota = pengurus.no_anggota
    ORDER BY kegiatan.tanggal_kegiatan DESC
";
$resultGrid = mysqli_query($conn, $sqlGrid);
?>

<div class="container-fluid kegiatan-container">
    <div class="row">
        <!-- Kolom untuk Button -->
        <div class="col-1 d-flex align-items-start">
            <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-upload"></i>
            </button>
        </div>

        <!-- Kolom untuk Konten Kegiatan -->
        <div class="col-10">
            <!-- Carousel -->
            <div id="kegiatanCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $activeSet = false;
                    while ($row = mysqli_fetch_assoc($resultCarousel)) {
                        $activeClass = !$activeSet ? 'active' : '';
                        $activeSet = true;
                        ?>
                            <div class='carousel-item <?= $activeClass ?>'>
                                <img src='assets/media/<?= htmlspecialchars($row['media_kegiatan']) ?>' class='d-block w-100 carousel-img' alt='<?= htmlspecialchars($row['nama_kegiatan']) ?>' style='object-fit: cover;'>
                                <div class='carousel-caption d-none d-md-block'>
                                    <h5><?= htmlspecialchars($row['nama_kegiatan']) ?></h5>
                                    <p>Divisi: <?= htmlspecialchars($row['divisi']) ?> | Tanggal: <?= htmlspecialchars($row['tanggal_kegiatan']) ?></p>
                                </div>
                            </div>
                        <?php
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#kegiatanCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#kegiatanCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Section Kegiatan (Grid) -->
            <section class="py-3">
                <div class="container py-3 mt-1">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php
                        while ($row = mysqli_fetch_assoc($resultGrid)) {
                            $fileType = strtolower(pathinfo($row['media_kegiatan'], PATHINFO_EXTENSION));

                            // Tentukan apakah media adalah gambar atau video
                            if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $mediaTag = "
                                    <img src='assets/media/" . htmlspecialchars($row['media_kegiatan']) . "' 
                                         class='card-img-top' 
                                         alt='" . htmlspecialchars($row['nama_kegiatan']) . "' 
                                         data-bs-toggle='modal' 
                                         data-bs-target='#modalKegiatan" . htmlspecialchars($row['id_kegiatan']) . "' 
                                         style='height: 200px; object-fit: cover;'>";
                            } else {
                                $mediaTag = "<video controls 
                                             class='card-img-top' 
                                             data-bs-toggle='modal' 
                                             data-bs-target='#modalKegiatan" . htmlspecialchars($row['id_kegiatan']) . "' 
                                             style='height: 200px; object-fit: cover;'>
                                    <source src='assets/media/" . htmlspecialchars($row['media_kegiatan']) . "' type='video/$fileType'>
                                    Your browser does not support the video tag.
                                </video>";
                            }

                            // Sosial media icons
                            $socialMediaIcons = '';
                            if (!empty($row['instagram_url'])) {
                                $socialMediaIcons .= "<a href='" . htmlspecialchars($row['instagram_url']) . "' target='_blank'><i class='bi bi-instagram me-2'></i></a>";
                            }
                            if (!empty($row['tiktok_url'])) {
                                $socialMediaIcons .= "<a href='" . htmlspecialchars($row['tiktok_url']) . "' target='_blank'><i class='bi bi-tiktok me-2'></i></a>";
                            }
                            if (!empty($row['youtube_url'])) {
                                $socialMediaIcons .= "<a href='" . htmlspecialchars($row['youtube_url']) . "' target='_blank'><i class='bi bi-youtube me-2'></i></a>";
                            }
                            if (!empty($row['facebook_url'])) {
                                $socialMediaIcons .= "<a href='" . htmlspecialchars($row['facebook_url']) . "' target='_blank'><i class='bi bi-facebook me-2'></i></a>";
                            }
                            if (!empty($row['twitter_url'])) {
                                $socialMediaIcons .= "<a href='" . htmlspecialchars($row['twitter_url']) . "' target='_blank'><i class='bi bi-twitter me-2'></i></a>";
                            }

                            // Grid item and modal
                            echo "
                                <div class='col'>
                                    <div class='card h-100'>
                                        $mediaTag
                                        <div class='card-body'>
                                            <h5 class='card-title text-center'>" . htmlspecialchars($row['nama_kegiatan']) . "</h5>
                                            <p class='card-text'>Divisi: " . htmlspecialchars($row['divisi']) . "</p>
                                            <p class='card-text'>Pengurus: " . htmlspecialchars($row['nama_pengurus']) . "</p>
                                            <p class='card-text text-muted'>Tanggal: " . htmlspecialchars($row['tanggal_kegiatan']) . "</p>
                                        </div>
                                        <div class='card-footer d-flex justify-content-between align-items-center'>
                                            <!-- Ikon Media Sosial -->
                                            <div>
                                                $socialMediaIcons
                                            </div>
                                            <!-- Tombol Delete -->
                                            <form action='proses/hapus_kegiatan.php' method='POST' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus kegiatan ini?\");' style='display: inline-block;'>
                                                <input type='hidden' name='id_kegiatan' value='" . htmlspecialchars($row['id_kegiatan']) . "'>
                                                <button type='submit' class='btn btn-sm btn-danger'>
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>";
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Modal Form Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="formUploadKegiatan" action="proses/tambah_kegiatan.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="uploadModalLabel">Upload Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating text-dark">
                                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="Nama Kegiatan">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating text-dark">
                                    <input type="text" class="form-control" id="no_anggota" name="no_anggota" placeholder="No Anggota">
                                    <label for="no_anggota">No Anggota</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="divisi" name="divisi">
                                        <option value="" disabled selected>Pilih divisi</option>
                                        <option value="KSDA">KSDA</option>
                                        <option value="RAFTING">Rafting</option>
                                        <option value="CLIMBING">Climbing</option>
                                        <option value="MONTAIN">Mountain</option>
                                    </select>
                                    <label for="divisi">Divisi</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" placeholder="Tanggal Kegiatan">
                                    <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating text-dark mb-3">
                            <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" placeholder="Deskripsi kegiatan" style="height: 150px;"></textarea>
                            <label for="deskripsi_kegiatan">Deskripsi Kegiatan</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="media_kegiatan" name="media_kegiatan" accept="image/*,video/*">
                            <label for="media_kegiatan">Media Kegiatan (Foto/Video)</label>
                        </div>

                        <!-- Cropper Preview -->
                        <div id="cropContainer" style="display: none; text-align: center;">
                            <img id="cropPreview" style="max-width: 100%; max-height: 300px;" />
                            <button type="button" id="cropButton" class="btn btn-primary mt-2">Crop Gambar</button>
                        </div>

                        <!-- Medsos URL -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating text-dark">
                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" placeholder="https://instagram.com/...">
                                    <label for="instagram_url">Instagram URL</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating text-dark">
                                    <input type="url" class="form-control" id="tiktok_url" name="tiktok_url" placeholder="https://tiktok.com/...">
                                    <label for="tiktok_url">Tiktok URL</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating text-dark">
                                    <input type="url" class="form-control" id="youtube_url" name="youtube_url" placeholder="https://youtube.com/...">
                                    <label for="youtube_url">Youtube URL</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating text-dark">
                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" placeholder="https://facebook.com/...">
                                    <label for="facebook_url">Facebook URL</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating text-dark">
                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" placeholder="https://twitter.com/...">
                                    <label for="twitter_url">Twitter URL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
