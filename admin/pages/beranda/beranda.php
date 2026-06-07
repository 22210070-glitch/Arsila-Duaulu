<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Statistik Upload Peta</h5>
                        </div>
                    </div>
                    <div id="salesChart"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3 fw-semibold">Upload Tahun Ini</h5>
                            <h4 class="fw-semibold mb-3" id="totalYearly">...</h4>
                            <div class="d-flex align-items-center mb-3">
                                <span
                                    class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-arrow-up-left text-success" id="iconYearly"></i>
                                </span>
                                <p class="text-dark me-1 fs-3 mb-0" id="growthYearly">...</p>
                                <p class="fs-3 mb-0" id="compareYearly">dibanding tahun lalu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3 fw-semibold">Upload Bulan Ini</h5>
                            <h4 class="fw-semibold mb-3" id="totalMonthly">...</h4>
                            <div class="d-flex align-items-center pb-1">
                                <span
                                    class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center"
                                    id="monthlyBadge">
                                    <i class="ti ti-arrow-down-right text-danger" id="iconMonthly"></i>
                                </span>
                                <p class="text-dark me-1 fs-3 mb-0" id="growthMonthly">...</p>
                                <p class="fs-3 mb-0" id="compareMonthly">dibanding bulan lalu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3 fw-semibold">Total Semua Upload</h5>
                            <h4 class="fw-semibold mb-0" id="totalAllUploads">...</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('get_user_chart_data.php')
        .then(response => response.json())
        .then(data => {
            const categories = data.map(item => item.bulan);
            const seriesData = data.map(item => item.jumlah);

            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: 'Jumlah Upload',
                    data: seriesData
                }],
                xaxis: {
                    categories: categories
                },
                title: {
                    text: 'Jumlah Upload SHP per Bulan',
                    align: 'left'
                },
                dataLabels: {
                    enabled: true
                },
                colors: ['#1E90FF']
            };

            var chart = new ApexCharts(document.querySelector("#salesChart"), options);
            chart.render();
        });
});
</script>

<script>
fetch("get_user_stats.php")
    .then(res => res.json())
    .then(data => {
        // Yearly
        document.querySelector("#totalYearly").textContent = data.tahun_ini + " Upload";
        document.querySelector("#growthYearly").textContent = "+" + data.growth_tahunan + "%";
        document.querySelector("#compareYearly").textContent = "dibanding tahun lalu";

        // Monthly
        document.querySelector("#totalMonthly").textContent = data.bulan_ini + " Upload";
        document.querySelector("#growthMonthly").textContent = "+" + data.growth_bulanan + "%";
        document.querySelector("#compareMonthly").textContent = "dibanding bulan lalu";
    });
</script>