<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <div class="row justify-content-between text-right text-lg-left">
        <div class="col-lg-6 mb-2">
            <a href="<?= base_url('master/add-siswa'); ?>" class="btn btn-primary btn-sm">Tambah <?= $title; ?></a>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#importSiswaModal">Import Data Siswa</button>
        </div>
    </div>
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
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($data as $d) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $d->nis; ?></td>
                                        <td><?= $d->name; ?></td>
                                        <td><?= $d->email; ?></td>
                                        <td class="text-center">
                                            <?php if ($d->role_id != 1) : ?>
                                                <a href="" class="btn btn-sm btn-info mt-1 btnDetailSiswa" data-id="<?= $d->id; ?>" data-toggle="modal" data-target="#siswaDetailModal"><i class="fas fa-fw fa-info-circle"></i></a>
                                                <a href="<?= base_url('master/edit-siswa/' . $d->id); ?>" class="btn btn-sm btn-success mt-1 btnEditSiswa"><i class="fas fa-fw fa-edit"></i></a>
                                                <a href="" class="btn btn-sm btn-danger mt-1 btnHapusSiswa" data-id="<?= $d->id; ?>" data-toggle="modal" data-target="#siswaHapusModal"><i class="fas fa-fw fa-trash-alt"></i></a>
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

<!-- Siswa Detail Modal -->
<div class="modal fade" id="siswaDetailModal" tabindex="-1" aria-labelledby="siswaDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siswaDetailModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Import Modal -->
<div class="modal fade" id="importSiswaModal" tabindex="-1" aria-labelledby="importSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importSiswaModalLabel">Import Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/import-siswa'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="importFile">Pilih Data</label>
                        <input type="file" class="form-control-file" id="importFile" name="importFile" accept=".xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Hapus Modal -->
<div class="modal fade" id="siswaHapusModal" tabindex="-1" role="dialog" aria-labelledby="siswaHapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siswaHapusModalLabel">Yakin Hapus User?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus data siswa ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>