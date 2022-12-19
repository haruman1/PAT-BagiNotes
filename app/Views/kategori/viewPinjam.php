<!-- ============================================-->
<!-- <section> begin ============================-->

<div class="container">
    <?php

    $id_buku = $request->getGet('id_buku');
    $sql =  $db->table('trendingbook')->where('id_buku', $id_buku)->get();
    $data = $sql->getResultArray();
    foreach ($data as $data) {
    ?>
        <div class="overflow-hidden mb-4" data-zanim-timeline="{}" data-zanim-trigger="scroll">
            <div data-zanim-xs='{"delay":0}'>
                <h3 data-zanim-xs='{"delay":0.1}'><?= $data['judulbuku'] ?></h3>
                <p data-zanim-xs='{"delay":0.1}'>By <?= $data['author'] ?></p>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-6"> <img class="card-img-top" src="<?php echo base_url('/') ?>/asset/img/buku/<?= $data['cover_buku'] ?>" alt="<?= $data['judulbuku'] ?>" />
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card-body">
                        <h4 class="mb-4">Availability</h4>
                        <h5>Stock</h5>

                        <p><?= $data['stok'] ?></p>
                        <h5>Status</h5>
                        <p>
                        <?php
                    }
                    if ($data['stok'] == 0) {
                        echo "Out of Stock";
                    } else {
                        echo "In Stock";
                    }
                        ?>
                        </p>
                        <h4 class="mb-4">Book Description</h4>
                        <p class="dropcap"><?= $data['textbuku'] ?></p>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Pinjam Buku
                        </button>

                        <!-- Modal -->

                        <?php
                        if (!isset($_SESSION['nama'])) {
                        ?>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Pinjam Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="overflow-hidden" data-zanim-timeline="{}" data-zanim-trigger="scroll">
                                                <div class="form-group text-center">
                                                    <h5>Mau Baca Buku?</h5>
                                                    <p>Silahkan Masuk</p>
                                                </div>
                                                <div class="row mx-7 my-2">
                                                    <div class="col-lg-auto mx-2 align-item-center">
                                                        <a href="<?php echo base_url()  ?>/login" class="btn btn-info btn-block">Masuk</a>
                                                        <a href="<?php echo base_url()  ?>/register" class="btn btn-primary btn-block">Daftar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                    </div>
                </div>
            </div>
        <?php
                        } else {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form class="modal-dialog" method="post" action="pinjam">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pinjam Buku</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="overflow-hidden" data-zanim-timeline="{}" data-zanim-trigger="scroll">
                                <div class="form-group text-center">
                                    <img class="card-center" style="width: 16rem;" data-zanim-xs='{"delay":0}' src="<?php echo base_url('/') ?>/asset/img/buku/<?= $data['cover_buku'] ?>" alt="Judul" />
                                </div>
                                <div class="form-group hidden">
                                    <h5>ID Buku</h5>
                                    <input type="text" class="form-control mb-3" id="id_buku" name="id_buku" value="<?= $data['id_buku'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <h5>Judul Buku</h5>
                                    <input type="text" class="form-control mb-3" id="judulbuku" name="judulbuku" value="<?= $data['judulbuku'] ?>" required>
                                </div>
                                <div class="form-group hidden">
                                    <h5>File Buku</h5>
                                    <input type="text" class="form-control mb-3" id="file_buku" name="file_buku" value="<?= $data['file_buku'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <h5>Author</h5>
                                    <p class="form-control mb-3" id="author" name="author" data-zanim-xs='{"delay":0.5}'><?= $data['author'] ?></p>
                                </div>
                                <div class="form-group">
                                    <h5>Stock</h5>
                                    <p class="form-control mb-3" id="stok" name="stok" data-zanim-xs='{"delay":0.5}'><?= $data['stok'] ?></p>
                                </div>
                                <div class="form-group">
                                    <h5>Status</h5>
                                    <p class="form-control mb-3" id="status" name="status" data-zanim-xs='{"delay":0.5}'><?php
                                                                                                                            if ($data['stok'] == 0) {
                                                                                                                                echo "Out of Stock";
                                                                                                                            } else {
                                                                                                                                echo "In Stock";
                                                                                                                            }
                                                                                                                            ?></p>
                                </div>
                                <div class="form-group">
                                    <h5>Borrow Date</h5>
                                    <input type="date" class="form-control mb-3" id="tanggal_peminjaman" name="tanggal_peminjaman" required>
                                </div>
                                <div class="form-group">
                                    <h5>Return Date</h5>
                                    <input type="date" class="form-control mb-3" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
<?php
                        } ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <h5>Genre</h5>
                    <ul class="nav tags mt-3 fs--1">

                        <?php
                        $sql = $db->query("SELECT * FROM hlmnbuku where kategoribuku = '$id_buku'");
                        $data =     $sql->getResultArray();
                        var_dump($data);
                        foreach ($data as $data) :

                        ?>
                            <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/#NB"><?=
                                                                                                                                    $data['kategoribuku'] ?></a></li>
                            <!-- <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/#F">Fiction</a></li>
                        <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/#H">Historical</a></li>
                        <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/#SI">Self Improvement</a></li>
                        <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/">Business</a></li>
                        <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/">Horror</a></li>
                        <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/">Crime</a></li>
                        <li><a class="btn btn-sm btn-outline-primary m-1 p-2" href="<?php echo base_url('/') ?>/category/">Science Fiction</a></li> -->
                    </ul>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mb-6">
    <h3 class="fs-2 fs-md-3">Related Books</h3>
    <hr class="short" data-zanim-xs='{"from":{"opacity":0,"width":0},"to":{"opacity":1,"width":"4.20873rem"},"duration":0.8}' data-zanim-trigger="scroll" />
</div>
<div class="row g-4">
    <?php
    $sql = $db->query("SELECT * FROM hlmnbuku WHERE kategoribuku LIKE '%$data[kategoribuku]%' ORDER BY id_buku DESC LIMIT 3");
    foreach ($sql->getResultArray() as $data) {
    ?>
        <div class="col-md-5 col-lg-3 center">
            <div class="card"><a href="<?php echo base_url('/') ?>/category/borrow?id_buku=<?= $data['id_buku'] ?>"><img class="card-img-top" src="<?php echo base_url('/') ?>/asset/img/buku/<?= $data['cover_buku'] ?>" alt="<?= $data['judulbuku'] ?>" /></a>
                <div class="card-body" data-zanim-timeline="{}" data-zanim-trigger="scroll">
                    <div class="overflow-hidden"><a href="<?php echo base_url('/') ?>/category/borrow?id_buku=<?= $data['id_buku'] ?>">
                            <h5 data-zanim-xs='{"delay":0}'><?= $data['judulbuku'] ?></h5>
                        </a></div>
                    <div class="overflow-hidden">
                        <p class="text-500" data-zanim-xs='{"delay":0.1}'>By <?= $data['author'] ?></p>
                    </div>
                    <div class="overflow-hidden">
                        <div class="d-inline-block" data-zanim-xs='{"delay":0.3}'><a class="d-flex align-items-center" href="<?php echo base_url('/') ?>/category/borrow?id_buku=<?= $data['id_buku'] ?>">Book Now!<div class="overflow-hidden ms-2" data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.8}'><span class="d-inline-block fw-medium">&xrarr;</span></div></a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
</div>
</div><!-- end of .container-->
</section><!-- <section> close ============================-->
<!-- ============================================-->

</main><!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->