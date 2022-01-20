<div class="container-fluid">
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir <?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('master/add-guru'); ?>" method="post">
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control <?= form_error('nip') ? 'is-invalid' : ''; ?>" id="nip" name="nip" placeholder="NIP" value="<?= set_value('nip'); ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('nip'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email (Optional)</label>
                            <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
                            <div class="invalid-feedback">
                                <?= form_error('email'); ?>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-group row mt-0">
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    <?= form_error('password'); ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <a href="#" class="btn btn-secondary btn-block" id="btnGenerate">Generate</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>" id="name" name="name" placeholder="Nama" value="<?= set_value('name'); ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('name'); ?>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="telepon">Telepon</label>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">62</span>
                            </div>
                            <input type="text" class="form-control <?= form_error('telepon') ? 'is-invalid' : ''; ?>" id="telepon" name="telepon" placeholder="Telepon" aria-label="Telepon" value="<?= set_value('telepon'); ?>" aria-describedby="basic-addon1">
                            <div class="invalid-feedback">
                                <?= form_error('telepon'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" name="alamat" id="alamat" rows="3"><?= set_value('alamat'); ?></textarea>
                            <div class="invalid-feedback">
                                <?= form_error('alamat'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                            <a href="<?= base_url('master/guru'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>