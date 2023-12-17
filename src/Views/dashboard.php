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

<script type="text/javascript" src="src/lib/Functions/CookieUtils.js"></script>
<script type="text/javascript" src="src/lib/Functions/PriceUtils.js"></script>

<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800">
        <div class="flex justify-between">
            <div>
                <p class="text-base font-bold text-white">Jumlah Order</p>
                <h5 class="leading-none text-3xl font-bold text-white pb-2" id="amount-transaction-today">0</h5>
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-2xl font-semibold text-green-500 text-center" id="amount-transaction-today-precentage">

            </div>
        </div>
    </div>
    <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800">
        <div class="flex justify-between">
            <div>
                <p class="text-base font-bold text-white">Jumlah Barang Terbeli</p>
                <h5 class="leading-none text-3xl font-bold text-white pb-2" id="selled-product">0</h5>
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-2xl font-semibold text-red-500 text-red-500 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 fill-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path>
                    <path d="M12 11c-2 0-2-.63-2-1s.7-1 2-1 1.39.64 1.4 1h2A3 3 0 0 0 13 7.12V6h-2v1.09C9 7.42 8 8.71 8 10c0 1.12.52 3 4 3 2 0 2 .68 2 1s-.62 1-2 1c-1.84 0-2-.86-2-1H8c0 .92.66 2.55 3 2.92V18h2v-1.08c2-.34 3-1.63 3-2.92 0-1.12-.52-3-4-3z"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800">
        <div class="flex justify-between">
            <div>
                <p class="text-base font-bold text-white">Jumlah Pendapatan</p>
                <h5 class="leading-none text-3xl font-bold text-white pb-2" id="amount-income">Rp. 0</h5>
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-2xl font-semibold text-center" id="amount-income-precentage">
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 mb-6 transition-all duration-300 ease-in">
    <div class="w-full rounded-lg shadow bg-gray-800 p-4 md:p-6 transition-all duration-300 ease-in">
        <div class="flex justify-between">
            <div>
                <h5 class="leading-none text-3xl font-bold text-white pb-2" id="income-inyear">Rp. 0</h5>
                <!-- <p class="text-base font-normal text-gray-500 ">Sales this week</p> -->
            </div>
            <div class="flex items-center px-2.5 py-0.5 text-xl font-semibold text-green-500 text-center" id="difference-income">

            </div>
        </div>
        <div id="data-series-chart" class="transition-all duration-300 ease-in w-full h-full">
        </div>
    </div>
</div>

<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 transition-all duration-300 ease-in">
    <div class="col-span-1">
        <div class="w-full rounded-lg shadow p-4 md:p-6 bg-gray-800 text-white h-full">
            <h2 class="text-center font-bold mb-2">Best Product of The Month</h2>
            <ol class="list-inside list-decimal transition-all duration-300 ease-in" id="list-best-seller-of-the-month">
            </ol>
        </div>
    </div>
    <div class="col-span-1 md:col-span-2">
        <div class="w-full rounded-lg shadow bg-gray-800 p-4 md:p-6 transition-all duration-300 ease-in">
            <div id="bar-chart" class="transition-all duration-300 ease-in"></div>
        </div>
    </div>
</div>

<script>
    const a = {
        "_id": {
            "$oid": "657a828440ee3d4c1541f13d"
        },
        "creatorName": "administrator",
        "created_at": 1702527603,
        "update": [{
            "status": "pending",
            "productID": {
                "$oid": "656e6ebc0a04f3555c2e4815"
            },
            "old": {
                "name": "Cocacola",
                "price": 5000,
                "category": "drink",
                "available": true,
                "imgUrl": "https://clipart-library.com/images_k/coca-cola-bottle-transparent-background/coca-cola-bottle-transparent-background-17.png",
                "stock": 123
            },
            "new": {
                "name": "Cocacola",
                "price": 5000,
                "category": "drink",
                "available": true,
                "imgUrl": "https://clipart-library.com/images_k/coca-cola-bottle-transparent-background/coca-cola-bottle-transparent-background-17.png",
                "stock": 123
            }
        }],
        "create": [{
            "status": "pending",
            "fields": {
                "name": "Mie Kuah",
                "price": 4000,
                "category": "food",
                "imgUrl": "https://www.nissin.com/en_jp/brands/images/export/japan/instant_noodles/02.jpg",
                "available": false,
                "stock": 123
            }
        }],
        "delete": [{
            "status": "pending",
            "productID": {
                "$oid": "65731686088c66361df900d7"
            },
            "productName": "Mie Goreng"
        }]
    }

    function initPageData() {
        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        fetch('/api/order-lastdays', {
                method: 'GET',
                headers: headersList
            })
            .then(response => response.json())
            .then(result => {
                const transactionAmount = document.getElementById('amount-transaction-today');
                const transactionPrecentage = document.getElementById('amount-transaction-today-precentage');
                let precentageTemplate;

                if ((result.today < result.yesterday)) {

                    precentageTemplate = `
                    <span class="text-[#EF4444]">
                        ${result.yesterday === 0 ? 100 : Math.abs((((result.today - result.yesterday) / result.yesterday)) * 100)}%
                    </span>
                    <svg class="w-6 h-6 ms-1 fill-[#EF4444]" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0.210025 6.44933C0.276364 6.38222 0.355193 6.32897 0.44199 6.29264C0.528786 6.2563 0.621844 6.2376 0.715826 6.2376C0.809808 6.2376 0.902864 6.2563 0.989661 6.29264C1.07646 6.32897 1.15529 6.38222 1.22163 6.44933L4.28559 9.53812V0.719858C4.28559 0.528939 4.36082 0.345841 4.49474 0.210842C4.62865 0.0758419 4.81028 0 4.99966 0C5.18905 0 5.37067 0.0758419 5.50459 0.210842C5.6385 0.345841 5.71373 0.528939 5.71373 0.719858V9.53812L8.77889 6.44933C8.91304 6.31409 9.09498 6.23812 9.28469 6.23812C9.4744 6.23812 9.65634 6.31409 9.79049 6.44933C9.92464 6.58456 10 6.76798 10 6.95923C10 7.15048 9.92464 7.33389 9.79049 7.46913L5.50606 11.7883C5.43972 11.8554 5.36089 11.9086 5.27409 11.945C5.1873 11.9813 5.09424 12 5.00026 12C4.90628 12 4.81322 11.9813 4.72642 11.945C4.63963 11.9086 4.5608 11.8554 4.49446 11.7883L0.210025 7.46913C0.143455 7.40225 0.0906343 7.32278 0.0545931 7.23528C0.0185528 7.14778 0 7.05397 0 6.95923C0 6.86448 0.0185528 6.77067 0.0545931 6.68317C0.0906343 6.59567 0.143455 6.5162 0.210025 6.44933Z" fill="#EF4444" />
</svg>
                    `
                } else {

                    precentageTemplate = `
                    <span>
                        ${result.yesterday === 0 ? 100 : Math.abs((((result.today - result.yesterday) / result.yesterday)) * 100)}%
                    </span>
                    <svg class="w-6 h-6 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                        <path class="" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4" />
                    </svg>
                    `
                }


                transactionAmount.innerHTML = result.today
                transactionPrecentage.innerHTML = precentageTemplate
            })

        fetch('/api/order-best-seller-year', {
                method: 'GET',
                headers: headersList
            })
            .then(response => response.json())
            .then(result => {
                const transactionAmount = document.getElementById('list-best-seller-of-the-month');
                let precentageTemplate;

                let templateList = ''
                let counter = 0;

                result.data.map(value => {
                    value.details.map(item => {
                        if (counter < 5 && new Object(item).hasOwnProperty('productName')) {
                            templateList += `<li>${item.productName}</li>`
                            counter++
                        }
                    })
                })


                transactionAmount.innerHTML = templateList
            })

        fetch('/api/order-clean', {
                method: 'GET',
                headers: headersList
            })
            .then(response => response.json())
            .then(result => {
                let lastMonthIncome = 0;
                let lastYearIncome = 0

                let incomeThisMonth = 0

                let selledProduct = [{
                        idx: 0,
                        value: 0
                    },
                    {
                        idx: 1,
                        value: 0
                    },
                    {
                        idx: 2,
                        value: 0
                    },
                    {
                        idx: 3,
                        value: 0
                    },
                    {
                        idx: 4,
                        value: 0
                    },
                    {
                        idx: 5,
                        value: 0
                    },
                    {
                        idx: 6,
                        value: 0
                    },
                    {
                        idx: 7,
                        value: 0
                    },
                    {
                        idx: 8,
                        value: 0
                    },
                    {
                        idx: 9,
                        value: 0
                    },
                    {
                        idx: 10,
                        value: 0
                    },
                    {
                        idx: 11,
                        value: 0
                    }
                ]

                let optionsLine = {
                    // main datanya disini
                    series: [{
                        name: "Pemasukan",
                        data: [
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0
                        ],
                        color: "#1A56DB",
                    }, ],
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
                        y: {
                            show: false,
                            title: {
                                formatter: function(seriesName) {
                                    return null
                                }
                            },
                            formatter: function(value, {
                                series,
                                seriesIndex,
                                dataPointIndex,
                                w
                            }) {
                                const current = selledProduct.find(value => value.idx === dataPointIndex)

                                return `<div class="grid gap-2 grid-cols-2 grid-rows-2">
                                    <span class="col-span1 flex gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-purple-700" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 11c-2 0-2-.63-2-1s.7-1 2-1 1.39.64 1.4 1h2A3 3 0 0 0 13 7.12V6h-2v1.09C9 7.42 8 8.71 8 10c0 1.12.52 3 4 3 2 0 2 .68 2 1s-.62 1-2 1c-1.84 0-2-.86-2-1H8c0 .92.66 2.55 3 2.92V18h2v-1.08c2-.34 3-1.63 3-2.92 0-1.12-.52-3-4-3z"></path></svg>Income:</span>
                                    <span class="col-span1 text-purple-700 text-end">${formatToIDR(value)}</span>
                                    <span class="col-span1 flex gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-blue-700"><path d="M21.822 7.431A1 1 0 0 0 21 7H7.333L6.179 4.23A1.994 1.994 0 0 0 4.333 3H2v2h2.333l4.744 11.385A1 1 0 0 0 10 17h8c.417 0 .79-.259.937-.648l3-8a1 1 0 0 0-.115-.921zM17.307 15h-6.64l-2.5-6h11.39l-2.25 6z"></path><circle cx="10.5" cy="19.5" r="1.5"></circle><circle cx="17.5" cy="19.5" r="1.5"></circle></svg>Product Sell:</span>
                                    <span class="col-span1 text-blue-700 text-end">${current.value}</span>
                                </div>`
                            },
                        }
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
                        // kolom horizontal bawah
                        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        labels: {
                            show: true,
                            style: {
                                colors: '#fcfffd',
                            }
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                    },
                    yaxis: {
                        show: true,
                        labels: {
                            style: {
                                colors: '#fcfffd',
                                cssClass: 'apexcharts-yaxis-label ml-5 pl-10 text-start w-full',
                            },
                            formatter: function(value, index) {

                                return formatToIDR(value)
                            }
                        }
                    },
                }

                result.data.map(value => {
                    value._id.timestamp.month === 12 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[11] = value.total : 0
                    value._id.timestamp.month === 11 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[10] = value.total : 0
                    value._id.timestamp.month === 10 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[9] = value.total : 0
                    value._id.timestamp.month === 9 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[8] = value.total : 0
                    value._id.timestamp.month === 8 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[7] = value.total : 0
                    value._id.timestamp.month === 7 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[6] = value.total : 0
                    value._id.timestamp.month === 6 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[5] = value.total : 0
                    value._id.timestamp.month === 5 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[4] = value.total : 0
                    value._id.timestamp.month === 4 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[3] = value.total : 0
                    value._id.timestamp.month === 3 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[2] = value.total : 0
                    value._id.timestamp.month === 2 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[1] = value.total : 0
                    value._id.timestamp.month === 1 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? optionsLine.series[0].data[0] = value.total : 0

                    value._id.timestamp.month === 12 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[11] = {
                        idx: 11,
                        value: value.selledProduct
                    } : {
                        idx: 11,
                        value: 0
                    }
                    value._id.timestamp.month === 11 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[10] = {
                        idx: 10,
                        value: value.selledProduct
                    } : {
                        idx: 10,
                        value: 0
                    }
                    value._id.timestamp.month === 10 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[9] = {
                        idx: 9,
                        value: value.selledProduct
                    } : {
                        idx: 9,
                        value: 0
                    }
                    value._id.timestamp.month === 9 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[8] = {
                        idx: 8,
                        value: value.selledProduct
                    } : {
                        idx: 8,
                        value: 0
                    }
                    value._id.timestamp.month === 8 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[7] = {
                        idx: 7,
                        value: value.selledProduct
                    } : {
                        idx: 7,
                        value: 0
                    }
                    value._id.timestamp.month === 7 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[6] = {
                        idx: 6,
                        value: value.selledProduct
                    } : {
                        idx: 6,
                        value: 0
                    }
                    value._id.timestamp.month === 6 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[5] = {
                        idx: 5,
                        value: value.selledProduct
                    } : {
                        idx: 5,
                        value: 0
                    }
                    value._id.timestamp.month === 5 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[4] = {
                        idx: 4,
                        value: value.selledProduct
                    } : {
                        idx: 4,
                        value: 0
                    }
                    value._id.timestamp.month === 4 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[3] = {
                        idx: 3,
                        value: value.selledProduct
                    } : {
                        idx: 3,
                        value: 0
                    }
                    value._id.timestamp.month === 3 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[2] = {
                        idx: 2,
                        value: value.selledProduct
                    } : {
                        idx: 2,
                        value: 0
                    }
                    value._id.timestamp.month === 2 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[1] = {
                        idx: 1,
                        value: value.selledProduct
                    } : {
                        idx: 1,
                        value: 0
                    }
                    value._id.timestamp.month === 1 && value._id.timestamp.year === new Date(Date.now()).getFullYear() ? selledProduct[0] = {
                        idx: 0,
                        value: value.selledProduct
                    } : {
                        idx: 0,
                        value: 0
                    }

                    lastYearIncome += (value._id.timestamp.year - 1) === (new Date(Date.now()).getFullYear() - 1) ? value.total : 0

                    console.log(value)

                    if (value._id.timestamp.month === ((new Date(Date.now()).getMonth()) + 1) && value._id.timestamp.year === new Date(Date.now()).getFullYear()) {
                        incomeThisMonth = value.total

                        var options = {
                            series: [{
                                // main datanya disini
                                data: [{
                                        x: "Food",
                                        y: value.food,
                                        colors: "#1757e6",
                                    },
                                    {
                                        x: "Drink",
                                        y: value.drink,
                                        colors: "#22C55E",
                                    },
                                ],
                            }],
                            chart: {
                                sparkline: {
                                    enabled: false,
                                },
                                type: "bar",
                                width: "100%",
                                height: 150,
                                toolbar: {
                                    show: false,
                                }
                            },
                            fill: {
                                opacity: 1,
                            },
                            colors: ["#1757e6", "#22C55E"],
                            plotOptions: {
                                bar: {
                                    horizontal: true,
                                    columnWidth: "50%",
                                    borderRadiusApplication: "end",
                                    borderRadius: 6,
                                    distributed: true,
                                    dataLabels: {
                                        position: "top",
                                    },
                                },
                            },
                            legend: {
                                enabled: false,
                                show: false,
                                position: "bottom",
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            tooltip: {
                                shared: false,
                                intersect: false,
                                x: {
                                    show: false,
                                },
                                y: {
                                    title: {
                                        formatter: function() {
                                            return '';
                                        }
                                    }
                                },
                                marker: {
                                    show: false,
                                },
                            },
                            xaxis: {
                                labels: {
                                    show: true,
                                    style: {
                                        fontFamily: "Inter, sans-serif",
                                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                                    },
                                },
                                categories: ["Food", "Drink"],
                                axisTicks: {
                                    show: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                            },
                            yaxis: {
                                labels: {
                                    show: true,
                                    style: {
                                        fontFamily: "Inter, sans-serif",
                                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                                    }
                                }
                            },
                            grid: {
                                show: false,
                                padding: {
                                    left: 2,
                                    right: 2,
                                    top: -20
                                },
                            },
                        }

                        if (document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
                            const chart = new ApexCharts(document.getElementById("bar-chart"), options);
                            chart.render();
                        }

                        document.getElementById('selled-product').innerText = value.selledProduct
                        document.getElementById('amount-income').innerText = formatToIDR(value.total)

                    }

                    if (value._id.timestamp.month === ((new Date(Date.now()).getMonth())) && value._id.timestamp.year === new Date(Date.now()).getFullYear()) {
                        lastMonthIncome = value.total
                    }
                })

                let precentageTemplate;

                if ((incomeThisMonth < lastMonthIncome)) {

                    precentageTemplate = `
<span class="text-[#EF4444]">
${Math.floor((((incomeThisMonth-lastMonthIncome) / lastMonthIncome)) * 100)}%
</span>
<svg class="w-6 h-6 ms-1 fill-[#EF4444]" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.210025 6.44933C0.276364 6.38222 0.355193 6.32897 0.44199 6.29264C0.528786 6.2563 0.621844 6.2376 0.715826 6.2376C0.809808 6.2376 0.902864 6.2563 0.989661 6.29264C1.07646 6.32897 1.15529 6.38222 1.22163 6.44933L4.28559 9.53812V0.719858C4.28559 0.528939 4.36082 0.345841 4.49474 0.210842C4.62865 0.0758419 4.81028 0 4.99966 0C5.18905 0 5.37067 0.0758419 5.50459 0.210842C5.6385 0.345841 5.71373 0.528939 5.71373 0.719858V9.53812L8.77889 6.44933C8.91304 6.31409 9.09498 6.23812 9.28469 6.23812C9.4744 6.23812 9.65634 6.31409 9.79049 6.44933C9.92464 6.58456 10 6.76798 10 6.95923C10 7.15048 9.92464 7.33389 9.79049 7.46913L5.50606 11.7883C5.43972 11.8554 5.36089 11.9086 5.27409 11.945C5.1873 11.9813 5.09424 12 5.00026 12C4.90628 12 4.81322 11.9813 4.72642 11.945C4.63963 11.9086 4.5608 11.8554 4.49446 11.7883L0.210025 7.46913C0.143455 7.40225 0.0906343 7.32278 0.0545931 7.23528C0.0185528 7.14778 0 7.05397 0 6.95923C0 6.86448 0.0185528 6.77067 0.0545931 6.68317C0.0906343 6.59567 0.143455 6.5162 0.210025 6.44933Z" fill="#EF4444" />
</svg>
`
                } else {

                    precentageTemplate = `
<span class="text-green-500">
${Math.floor((((incomeThisMonth-lastMonthIncome) / lastMonthIncome)) * 100)}%
</span>
<svg class="w-6 h-6 ms-1 fill-green-500 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                        <path class="" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4" />
                    </svg>
`
                }

                console.log((((incomeThisMonth - lastMonthIncome) / lastMonthIncome)) * 100)

                document.getElementById('amount-income-precentage').innerHTML = precentageTemplate

                let total = 0
                optionsLine.series[0].data.map(value => total += value)
                document.getElementById('income-inyear').innerText = formatToIDR(total)

                document.getElementById('difference-income').innerHTML = `
                <span class>
                    ${(total / lastYearIncome) * 100}%
                </span>
                <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4" />
                </svg>
                `

                if (document.getElementById("data-series-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("data-series-chart"), optionsLine);
                    chart.render();
                }
            })

    }

    initPageData();
</script>