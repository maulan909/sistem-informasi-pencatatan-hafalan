<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#guruModal" id="btnTambahUser">Tambah <?= $title; ?></a>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Role</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($data as $d) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $d->nip; ?></td>
                                        <td><?= $d->name; ?></td>
                                        <td><?= $d->email; ?></td>
                                        <td><?= $d->alamat; ?></td>
                                        <td><?= $d->telepon; ?></td>
                                        <td><?= $d->role; ?></td>
                                        <td>
                                            <?php if ($d->role_id != 1) : ?>
                                                <a href="" class="btn btn-success mt-1 btnEditUser" data-id="<?= $d->id; ?>" data-toggle="modal" data-target="#guruModal"><i class="fas fa-fw fa-edit"></i></a>
                                                <a href="" class="btn btn-danger mt-1 btnHapusUser" data-id="<?= $d->id; ?>" data-toggle="modal" data-target="#userHapusModal"><i class="fas fa-fw fa-trash-alt"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- User Modal -->
<div class="modal fade" id="guruModal" tabindex="-1" role="dialog" aria-labelledby="guruModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guruModalLabel">Tambah Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('master/guru'); ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP" required>
                        <small class="text text-danger" id="alertNip"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email (Optional)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                        <small class="text text-danger" id="alertEmail"></small>
                    </div>
                    <div class="form-group mb-0">
                        <label for="password">Password</label>
                    </div>
                    <div class="form-group row mt-0">
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
                        </div>
                        <div class="col-sm-3">
                            <a href="#" class="btn btn-secondary" id="btnGenerate">Generate</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                        <small class="text text-danger" id="alertName"></small>
                    </div>
                    <input type="hidden" name="role_id" value="2">
                    <div class="form-group mb-0">
                        <label for="telepon">Telepon</label>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">62</span>
                        </div>
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Telepon" aria-label="Telepon" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Hapus Modal -->
<div class="modal fade" id="userHapusModal" tabindex="-1" role="dialog" aria-labelledby="userHapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userHapusModalLabel">Yakin Hapus User?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus user ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>