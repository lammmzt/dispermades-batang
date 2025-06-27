<?= $this->extend('Template/index'); ?>
<?= $this->section('content'); ?>
<?php 
if(session()->get('role') == 'Kadin'  || session()->get('role') == 'Admin') :
?>

<!--begin::Row-->
<div class="row">
    <!--begin::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 1-->
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3><?= $total_users; ?></h3>
                <p>Jumlah Penguna</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path
                    d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z" />
            </svg>

        </div>
        <!--end::Small Box Widget 1-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 2-->
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3><?= $total_jenis_surat; ?></h3>
                <p>Jumlah Jenis Surat</p>
            </div>
            <svg fill="currentColor" class="small-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path
                    d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
            </svg>
            <!-- <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a> -->
        </div>
        <!--end::Small Box Widget 2-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 3-->
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3><?= $total_surat_masuk; ?></h3>
                <p>Jumlah Surat Masuk</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path
                    d="M215.4 96L144 96l-36.2 0L96 96l0 8.8L96 144l0 40.4 0 89L.2 202.5c1.6-18.1 10.9-34.9 25.7-45.8L48 140.3 48 96c0-26.5 21.5-48 48-48l76.6 0 49.9-36.9C232.2 3.9 243.9 0 256 0s23.8 3.9 33.5 11L339.4 48 416 48c26.5 0 48 21.5 48 48l0 44.3 22.1 16.4c14.8 10.9 24.1 27.7 25.7 45.8L416 273.4l0-89 0-40.4 0-39.2 0-8.8-11.8 0L368 96l-71.4 0-81.3 0zM0 448L0 242.1 217.6 403.3c11.1 8.2 24.6 12.7 38.4 12.7s27.3-4.4 38.4-12.7L512 242.1 512 448s0 0 0 0c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64c0 0 0 0 0 0zM176 160l160 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-160 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64l160 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-160 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
            </svg>

            <!-- <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a> -->
        </div>
        <!--end::Small Box Widget 3-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 4-->
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3><?= $total_surat_keluar; ?></h3>
                <p>Jumlah Surat Keluar</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path
                    d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
            </svg>

            <!-- <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a> -->
        </div>
        <!--end::Small Box Widget 4-->
    </div>
    <!--end::Col-->
</div>
<div class="row">
    <!-- Start col -->
    <div class="col-lg-12 connectedSortable">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-11 col-sm-10 col-md-10">
                        <h5 class="card-title">Grafik Surat Masuk dan Surat Keluar</h5>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-md-2 text-end">
                        <form id="formTahunSurat" method="post" action="<?= base_url('/'); ?>">
                            <select class="form-select form-select-sm select2" id="tahun" name="tahun"
                                aria-label="Default select example" OnChange="this.form.submit()">
                                <option value="">Pilih Tahun</option>
                                <?php for ($i = date('Y'); $i >= 2025; $i--) : ?>
                                <option value="<?= $i; ?>" <?= ($tahun == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    </div>
                </div>

            </div>

            <div class="card-body">
                <div id="revenue-chart"></div>
            </div>
        </div>
    </div>
</div>
<?php
else :
?>
<div class="row">
    <div class="col-lg-12">
        <div class="" role="alert" style="background-color:rgb(233, 239, 238); padding: 20px; border-radius: 5px;">
            <h4 class="alert-heading">Selamat Datang di Aplikasi Dispermades Kabupaten Batang</h4>
            <p>Anda login sebagai <?= session()->get('role'); ?>.</p>
            <hr>
            <p class="mb-0">Silahkan pilih menu yang tersedia di sidebar untuk mengelola data.</p>
        </div>
    </div>
</div>
<?php
    endif;
?>
<!--end::Row-->
<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<!-- apexcharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
<!-- ChartJS -->
<script>
// NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
// IT'S ALL JUST JUNK FOR DEMO
// ++++++++++++++++++++++++++++++++++++++++++

const sales_chart_options = {
    series: [{
        name: 'Surat Masuk',
        data: <?= json_encode(array_map(function ($item) {
                return (int)$item['surat_masuk'];
            }, $data_surat)); ?>
    }, {
        name: 'Surat Keluar',
        data: <?= json_encode(array_map(function ($item) {
                return (int)$item['surat_keluar'];
            }, $data_surat)); ?>
    }],
    chart: {
        height: 300,
        type: 'area',
        toolbar: {
            show: false,
        },
    },
    legend: {
        show: false,
    },
    colors: ['#0d6efd', '#20c997'],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth',
    },
    yaxis: {
        show: true,
        labels: {
            show: true,
            minWidth: 19,
            style: {
                colors: "#8A92A6",
            },
            offsetX: -5,
        },
        title: {
            text: 'Jumlah Surat',
            style: {
                color: "#8A92A6",
                fontSize: '12px',
            }
        },
        min: 0,
        max: <?= max(array_merge(array_column($data_surat, 'surat_masuk'), array_column($data_surat, 'surat_keluar'))) + 5; ?>,
        tickAmount: 5,
    },
    xaxis: {
        categories: <?= json_encode(array_map(function ($item) {
                return DateTime::createFromFormat('!m', $item['bulan'])->format('M');
            }, $data_surat)); ?>
    },
    tooltip: {
        enabled: true,
    },
};

const sales_chart = new ApexCharts(
    document.querySelector('#revenue-chart'),
    sales_chart_options,
);
sales_chart.render();
</script>
<?= $this->endSection('script'); ?>