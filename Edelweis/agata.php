<!-- Section Kegiatan (Grid) -->
<section class="py-5">
    <div class="container py-5">
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
                         data-bs-target='#modalKegiatan" . htmlspecialchars($row['id_kegiatan']) . "'>";
                } else {
                    $mediaTag = "<video controls class='card-img-top' data-bs-toggle='modal' data-bs-target='#modalKegiatan" . htmlspecialchars($row['id_kegiatan']) . "'>
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
                    </div>
                </div>

                <!-- Modal untuk Foto, Nama Kegiatan, dan Sosial Media -->
                <div class='modal fade' id='modalKegiatan" . htmlspecialchars($row['id_kegiatan']) . "' tabindex='-1' aria-labelledby='modalLabel" . htmlspecialchars($row['id_kegiatan']) . "' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='modalLabel" . htmlspecialchars($row['id_kegiatan']) . "'>" . htmlspecialchars($row['nama_kegiatan']) . "</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body text-center'>
                                <img src='assets/media/" . htmlspecialchars($row['media_kegiatan']) . "' class='img-fluid mb-3' alt='" . htmlspecialchars($row['nama_kegiatan']) . "'>
                                <div class='d-flex justify-content-center'>
                                    $socialMediaIcons
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</section>