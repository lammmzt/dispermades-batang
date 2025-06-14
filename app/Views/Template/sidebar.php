<?php 
    use App\Models\dataInstansiModel;
    use App\Models\suratKeluarModel;
    use App\Models\suratMasukModel;
    use App\Models\detailSuratKeluarModel;
    use App\Models\pegawaiModel;
    use App\Models\disposisiModel;
    $instansi = new dataInstansiModel();
    $suratKeluarModel = new suratKeluarModel();
    $suratMasukModel = new suratMasukModel();
    $pegawaiModel = new pegawaiModel();
    $disposisiModel = new disposisiModel();
    $detailSuratKeluarModel = new detailSuratKeluarModel();
    $data_pegawai = $pegawaiModel->getPegwaiByIdUser(session()->get('id_user')); // mengambil data pegawai berdasarkan id user
    if($data_pegawai != null) { // jika data pegawai tidak kosong
        $id_pegawai = $data_pegawai['id_pegawai']; // set id pegawai
    } else {
        $id_pegawai = 0; // set id pegawai 0
    }
    $jml_disposisi = $disposisiModel->getDisposisiByIdPegawai($id_pegawai)->where('disposisi.status_disposisi', '0')->countAllResults(); // menghitung jumlah disposisi
    $jumlah_surat_masuk = 0; // inisialisasi jumlah surat masuk
    $data_instansi = $instansi->first();
    if(session()->get('role') == 'Admin' ) {
        $jml_surat_keluar = $suratKeluarModel->getSuratkeluar()->where('surat_keluar.status_surat_keluar !=', '3')->countAllResults(); // menghitung jumlah surat keluar
    } elseif(session()->get('role') == 'Kadin' ) {
        $jumlah_surat_masuk = $suratMasukModel->where('surat_masuk.status_surat_masuk !=', '1')->countAllResults(); // menghitung jumlah surat masuk
        $jml_surat_keluar = $suratKeluarModel->getSuratkeluar()->where('surat_keluar.status_surat_keluar =', '2')->countAllResults(); // menghitung jumlah surat keluar
    } else{
        $jml_surat_keluar = $detailSuratKeluarModel->getSuratKeluarByUser(session()->get('id_user'))->where('detail_surat_keluar.status_detail_surat_keluar', '0')->countAllResults();
    }
    $jml_surat_keluar =(isset($jml_surat_keluar)) ? $jml_surat_keluar : 0;
?>
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="<?= base_url('/'); ?>" class="brand-link">
            <!--begin::Brand Image-->
            <img src="<?= base_url('Assets/img/data_instansi/').$data_instansi['logo_instansi']; ?>" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">
                <?= $data_instansi['nama_alias_insansi']; ?> </span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Home</li>
                <li class="nav-item">
                    <a href="<?= base_url('/'); ?>" class="nav-link <?= $active == 'Dashboard' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Master Data</li>
                <li class="nav-item ">
                    <a href="<?= base_url('Data_instansi'); ?>"
                        class="nav-link  <?= $active == 'Data_instansi' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-building-gear"></i>
                        <p>Profile Instansi</p>
                    </a>
                </li>
                <li
                    class="nav-item  <?= $active == 'referensi_jenis_surat' || $active == 'Jenis_surat' ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?= $active == 'referensi_jenis_surat' || $active == 'Jenis_surat' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-envelope-fill"></i>
                        <p>
                            Format Surat
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('Referensi'); ?>"
                                class="nav-link <?= $active == 'referensi_jenis_surat' ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Referensi Surat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('jenis_surat'); ?>"
                                class="nav-link <?= $active == 'Jenis_surat' ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Jenis Surat</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a href="<?= base_url('Pegawai'); ?>"
                        class="nav-link  <?= $active == 'Pegawai' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-person-workspace"></i>
                        <p>Data Pegawai</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="<?= base_url('External'); ?>"
                        class="nav-link  <?= $active == 'External' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-buildings"></i>
                        <p>Data External</p>
                    </a>
                </li>

                <li class="nav-header">Persuratan</li>
                <li class="nav-item  <?= $active == 'Surat_masuk' || $active == 'Surat_keluar' ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?= $active == 'Surat_masuk' || $active == 'Surat_keluar' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-envelope-paper-fill"></i>
                        <p>
                            Surat
                            <span class="nav-badge badge text-bg-secondary me-3">6</span>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('Surat_masuk'); ?>"
                                class="nav-link <?= $active == 'Surat_masuk' ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Surat Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('Surat_keluar'); ?>"
                                class="nav-link <?= $active == 'Surat_keluar' ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Surat Keluar</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Pelaporan</li>
                <li
                    class="nav-item  <?= $active == 'Laporan_surat_masuk' || $active == 'Laporan_surat_keluar' ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?= $active == 'Laporan_surat_masuk' || $active == 'Laporan_surat_keluar' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-bar-chart-line-fill"></i>
                        <p>
                            Surat
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('Laporan/Surat_masuk'); ?>"
                                class="nav-link <?= $active == 'Laporan_surat_masuk' ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Surat Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('Laporan/Surat_keluar'); ?>"
                                class="nav-link <?= $active == 'Laporan_surat_keluar' ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Surat Keluar</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>