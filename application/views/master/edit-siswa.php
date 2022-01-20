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
                    <form action="<?= base_url('master/edit-siswa/' . $siswa->id); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $siswa->id; ?>">
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" class="form-control <?= form_error('nis') ? 'is-invalid' : ''; ?>" id="nis" name="nis" placeholder="NIS" value="<?= form_error('nis') ? set_value('nis') : $siswa->nis; ?>" required readonly>
                            <div class="invalid-feedback">
                                <?= form_error('nis'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email Address" value="<?= form_error('email') ? set_value('email') : $siswa->email; ?>" readonly>
                            <div class="invalid-feedback">
                                <?= form_error('email'); ?>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="password">Password <small class="text-danger">(Kosongkan jika tidak ingin ganti password)</small></label>
                        </div>
                        <div class="form-group row mt-0">
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password" autocomplete="off">
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
                            <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>" id="name" name="name" placeholder="Nama" value="<?= form_error('name') ? set_value('name') : $siswa->name; ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('name'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-control" name="kelas_id" id="kelas_id">
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k->id; ?>" <?= $siswa->kelas_id == $k->id ? 'selected' : ''; ?>><?= $k->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?= set_value('kelas_id'); ?>
                        <div class="form-group mb-0">
                            <label for="telepon">Telepon</label>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">62</span>
                            </div>
                            <input type="text" class="form-control <?= form_error('telepon') ? 'is-invalid' : ''; ?>" id="telepon" name="telepon" placeholder="Telepon" aria-label="Telepon" value="<?= form_error('telepon') ? set_value('telepon') : substr($siswa->telepon, 2); ?>" aria-describedby="basic-addon1">
                            <div class="invalid-feedback">
                                <?= form_error('telepon'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" name="alamat" id="alamat" rows="3"><?= form_error('alamat') ? set_value('alamat') : $siswa->alamat; ?></textarea>
                            <div class="invalid-feedback">
                                <?= form_error('alamat'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                            <a href="<?= base_url('master/siswa'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>