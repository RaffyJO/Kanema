<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/templates/source.php';
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Dashboard";
    $TPL->bodycontent = __FILE__;
    include __DIR__ . '/layout/layout.php';
    exit;
}
?>

<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800">
        <div class="flex justify-between">
            <div>
                <p class="text-base font-bold text-white">Jumlah Order</p>
                <h5 class="leading-none text-3xl font-bold text-white pb-2">30</h5>
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-2xl font-semibold text-green-500 text-green-500 text-center">
                12%
                <svg class="w-6 h-6 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                    <path class="" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4" />
                </svg>
            </div>
        </div>
    </div>
    <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800">
        <div class="flex justify-between">
            <div>
                <p class="text-base font-bold text-white">Jumlah Barang Terbeli</p>
                <h5 class="leading-none text-3xl font-bold text-white pb-2">35</h5>
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-2xl font-semibold text-red-500 text-red-500 text-center">
                3%
                <svg class="w-6 h-6 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                    <path class="" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v12m0 0 4-4m-4 4L1 9" />
                </svg>
            </div>
        </div>
    </div>
    <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800">
        <div class="flex justify-between">
            <div>
                <p class="text-base font-bold text-white">Jumlah Pendapatan</p>
                <h5 class="leading-none text-3xl font-bold text-white pb-2">Rp. 57.000</h5>
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-2xl font-semibold text-red-500 text-red-500 text-center">
                3%
                <svg class="w-6 h-6 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                    <path class="" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v12m0 0 4-4m-4 4L1 9" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 mb-6">
    <div class="w-full rounded-lg shadow bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between">
            <div>
                <h5 class="leading-none text-3xl font-bold text-white pb-2">Rp. 120000</h5>
                <!-- <p class="text-base font-normal text-gray-500 ">Sales this week</p> -->
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-xl font-semibold text-green-500 text-center">
                23%
                <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4" />
                </svg>
            </div>
        </div>
        <div id="data-series-chart"></div>
    </div>
</div>

<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800 text-white">
        <h2 class="text-center font-bold mb-2">Best Product</h2>
        <ol class="list-inside list-decimal">
            <li>Mie goreng</li>
            <li>Coca-cola</li>
            <li>Sprite</li>
        </ol>
    </div>
</div>

<script>
    // ApexCharts options and config
    window.addEventListener("load", function() {
        let options = {
            series: [{
                    name: "Pengeluaran",
                    data: [1500, 1418, 1456, 1526, 1356, 1256],
                    color: "#1A56DB",
                },
                {
                    name: "Pemasukan",
                    data: [643, 413, 765, 412, 1423, 1731],
                    color: "#7E3BF2",
                },
            ],
            chart: {
                height: "100%",
                maxWidth: "100%",
                type: "area",
                fontFamily: "Inter, sans-serif",
                dropShadow: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
            },
            legend: {
                show: false
            },
            fill: {
                type: "gradient",
                gradient: {
                    opacityFrom: 0.55,
                    opacityTo: 0,
                    shade: "#1C64F2",
                    gradientToColors: ["#1C64F2"],
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 6,
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: 0
                },
            },
            xaxis: {
                categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
                labels: {
                    formatter: function(value) {
                        return 'Rp.' + value;
                    }
                }
            },
        }

        if (document.getElementById("data-series-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("data-series-chart"), options);
            chart.render();
        }
    });
</script>