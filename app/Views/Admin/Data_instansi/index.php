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
                <form action="<?= base_url('Data_instansi/save') ?>" method="post" enctype="multipart/form-data"
                    class="form-horizontal">
                    <!-- logo ditengah" bisa diubah -->
                    <div class="text-center mb-4">
                        <img src="<?= ($data_instansi != null) ? base_url('Assets/img/data_instansi/' . $data_instansi['logo_instansi']) : base_url('Assets/hope-ui-html-2.0/html/assets/images/avatars/01.png') ?>"
                            alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill"
                            id="view_logo_instansi">
                        <input type="file" class="form-control" id="logo_instansi" name="logo_instansi"
                            value="<?= old('logo_instansi') ?>">
                        <style>
                        /* sesuaikan input di  */
                        #logo_instansi {
                            display: none;
                        }

                        .theme-color-default-img {
                            cursor: pointer;
                        }

                        .theme-color-default-img:hover {
                            opacity: 0.7;
                        }

                        #view_logo_instansi {
                            width: 150px;
                            height: 150px;
                            object-fit: cover;
                            border-radius: 50%;
                        }
                        </style>

                        <script type="text/javascript">
                        //    when click image, trigger input file to choose file
                        document.getElementById('view_logo_instansi').addEventListener('click', function() {
                            document.getElementById('logo_instansi').click();
                        });

                        //    when file is selected, show image
                        document.getElementById('logo_instansi').addEventListener('change', function() {
                            const file = this.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function() {
                                    document.getElementById('view_logo_instansi').setAttribute('src', reader
                                        .result);
                                }
                                reader.readAsDataURL(file);
                            }
                        });
                        </script>
                    </div>
                    <!-- end logo -->
                    <hr>
                    <?= csrf_field(); ?>
                    <div class="form-group row mt-2">
                        <label for="nama_instansi" class="col-sm-2">Nama Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi"
                                value="<?= ($data_instansi) ? $data_instansi['nama_instansi'] : old('nama_instansi') ?>"
                                required placeholder="Nama Instansi">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="nama_alias_insansi" class="col-sm-2">Alias Nama Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_alias_insansi" name="nama_alias_insansi"
                                value="<?= ($data_instansi) ? $data_instansi['nama_alias_insansi'] : old('nama_alias_insansi') ?>"
                                required placeholder="Nama Alias Instansi">
                        </div>
                    </div>
                    <div class="form-group row mt-2 ">
                        <label for="alamat_instansi" class="col-sm-2    ">Alamat Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat_instansi" name="alamat_instansi"
                                value="<?= ($data_instansi) ? $data_instansi['alamat_instansi'] : old('alamat_instansi') ?>"
                                required placeholder="Alamat Instansi">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="no_tlp_instansi" class="col-sm-2">No. Telp Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_tlp_instansi" name="no_tlp_instansi"
                                value="<?= ($data_instansi) ? $data_instansi['no_tlp_instansi'] : old('no_tlp_instansi') ?>"
                                required placeholder="No. Telp Instansi">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="email_instansi" class="col-sm-2">Email Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email_instansi" name="email_instansi"
                                value="<?= ($data_instansi) ? $data_instansi['email_instansi'] : old('email_instansi') ?>"
                                required placeholder="Email Instansi">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="nama_kepala_instansi" class="col-sm-2">Nama Kepala Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_kepala_instansi"
                                name="nama_kepala_instansi"
                                value="<?= ($data_instansi) ? $data_instansi['nama_kepala_instansi'] : old('nama_kepala_instansi') ?>"
                                required placeholder="Nama Kepala Instansi">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="nip_kepala_instansi" class="col-sm-2">NIP Kepala Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nip_kepala_instansi" name="nip_kepala_instansi"
                                value="<?= ($data_instansi) ? $data_instansi['nip_kepala_instansi'] : old('nip_kepala_instansi') ?>"
                                required placeholder="NIP Kepala Instansi">
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>