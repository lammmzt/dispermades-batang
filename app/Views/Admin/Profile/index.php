<?= $this->extend('Template/index'); ?>
<?= $this->section('content'); ?>
<!--begin::Row-->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Selamat!</strong> <?= session()->getFlashdata('success'); ?>.
                </div>

                <?php endif; ?>
                <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> <?= session()->getFlashdata('errors'); ?>.
                </div>
                <?php endif; ?>
                <form action="<?= base_url('Users/ChangePass') ?>" method="post" enctype="multipart/form-data"
                    class="form-horizontal">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
                    <h5 class="mt-3">Profil Pengguna</h5>
                    <div class="form-group row mt-3">
                        <label for="nama_user" class="col-sm-2">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_user" name="nama_user" required
                                placeholder="Nama Pengguna" value="<?= $user['nama_user']; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="role" class="col-sm-2">Role</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="role" name="role" value="<?= $user['role']; ?>"
                                required placeholder="Role Pengguna" disabled>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-3">Ubah Password</h5>
                    <div class="form-group row mt-3">
                        <label for="password_lama" class="col-sm-2">Password Lama</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password_lama" name="password_lama"
                                placeholder="Masukkan Password Lama" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="password" class="col-sm-2">Password Baru</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan Password Baru" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="password_confirm" class="col-sm-2">Konfirmasi Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                                placeholder="Konfirmasi Password Baru" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?= base_url('/'); ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>