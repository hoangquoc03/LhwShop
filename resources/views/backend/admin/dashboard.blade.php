@extends('backend/master')
@section('title')
    Dashboard
@endsection
@section('main-content')
    <main class="dashboard  dark:bg-gray-800 dark:border-gray-700">
        <div class="dashboard-grid">

            <!-- Cột trái: 2 card + biểu đồ tuần -->
            <div class="dashboard-left">

                <!-- Tổng quan 3 card mini chart -->
                <div class="card-grid">
                    <div class="card revenue-card">
                        <h3>Tổng doanh thu tuần</h3>
                        <p class="value">{{ number_format($totalWeek, 0, ',', '.') }}₫</p>
                        <canvas id="miniRevenueChart"></canvas>
                    </div>

                    <div class="card orders-card">
                        <h3>Tổng đơn hàng tuần</h3>
                        <p class="value">{{ $totalOrders }}</p>
                        <canvas id="miniOrdersChart"></canvas>
                    </div>

                    <div class="card customers-card">
                        <h3>Khách hàng tuần</h3>
                        <p class="value">{{ $totalCustomers }}</p>
                        <canvas id="miniCustomersChart"></canvas>
                    </div>
                </div>

                <!-- Biểu đồ doanh số tuần -->
                <div class="main-chart card">
                    <h2>Doanh số tuần này</h2>
                    <canvas id="weeklySalesChart"></canvas>
                </div>

            </div>

            <!-- Cột phải: Top sản phẩm tuần -->
            <div class="dashboard-right">
                <div class="card top-products">
                    <h2>Top sản phẩm tuần này</h2>
                    <ul>
                        @foreach ($topProducts as $product)
                            <li class="flex justify-between items-center py-3">
                                <div class="product-info flex items-center space-x-3">
                                    <!-- Ảnh sản phẩm -->
                                    <img src="{{ $product->image }}" alt="{{ $product->product_name }}"
                                        class="w-10 h-10 object-cover rounded" />


                                    <!-- Tên sản phẩm + trend -->
                                    <span
                                        class="font-medium text-gray-700 dark:text-gray-800">{{ $product->product_name }}</span>

                                    @if ($product->trend > 0)
                                        <span class="trend up">↑ {{ $product->trend }}%</span>
                                    @elseif($product->trend < 0)
                                        <span class="trend down">↓ {{ abs($product->trend) }}%</span>
                                    @else
                                        <span class="trend neutral">→ 0%</span>
                                    @endif
                                </div>

                                <!-- Mini sparkline chart + số lượng -->
                                <div class="product-stats flex items-center space-x-3">
                                    <span class="quantity">{{ $product->total_quantity }}</span>
                                    <canvas class="sparkline h-6 w-24"
                                        data-product-id="{{ $product->product_id }}"></canvas>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </main>

    <style>
        /* Layout chính */
        .dashboard-grid {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .dashboard-left {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .dashboard-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Grid card mini chart */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        /* Card chung */
        .card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            color: #111827;
        }

        /* Dark mode */
        body.dark-mode .card {
            background-color: #1f2937;
            border-color: #374151;
            color: #f3f4f6;
        }

        .card h3,
        .card h2 {
            margin-bottom: 8px;
            font-weight: 600;
        }

        .card .value {
            font-size: 1.75rem;
            font-weight: bold;
        }

        .main-chart canvas,
        .card canvas {
            width: 100% !important;
            height: 60px;
        }

        /* Top sản phẩm */
        .top-products ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .top-products li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        body.dark-mode .top-products li {
            border-bottom-color: #374151;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trend {
            padding: 2px 6px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .trend.up {
            background-color: #d1fae5;
            color: #065f46;
        }

        .trend.down {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .trend.neutral {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        body.dark-mode .trend.up {
            background-color: #065f46;
            color: #d1fae5;
        }

        body.dark-mode .trend.down {
            background-color: #991b1b;
            color: #fee2e2;
        }

        body.dark-mode .trend.neutral {
            background-color: #374151;
            color: #f3f4f6;
        }

        .product-stats {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quantity {
            background-color: #d1fae5;
            color: #065f46;
            padding: 4px 8px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        body.dark-mode .quantity {
            background-color: #065f46;
            color: #d1fae5;
        }
    </style>




    <script>
        // Mini charts cho tổng quan
        const miniRevenueChart = new Chart(document.getElementById('miniRevenueChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'date')) !!},
                datasets: [{
                    data: {!! json_encode(array_column($chartData, 'total')) !!},
                    borderColor: 'rgba(34,197,94,0.7)',
                    backgroundColor: 'rgba(34,197,94,0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const miniOrdersChart = new Chart(document.getElementById('miniOrdersChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'date')) !!},
                datasets: [{
                    data: {!! json_encode(array_map(fn($d) => $d['orders'] ?? 0, $chartData)) !!},
                    borderColor: 'rgba(59,130,246,0.7)',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const miniCustomersChart = new Chart(document.getElementById('miniCustomersChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'date')) !!},
                datasets: [{
                    data: {!! json_encode(array_map(fn($d) => $d['customers'] ?? 0, $chartData)) !!},
                    borderColor: 'rgba(139,92,246,0.7)',
                    backgroundColor: 'rgba(139,92,246,0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Sparkline cho mỗi sản phẩm
        document.querySelectorAll('.sparkline').forEach(canvas => {
            const productId = canvas.dataset.productId;
            // Bạn có thể fetch data thực tế từ server nếu muốn, ví dụ:
            const data = [5, 8, 6, 9, 7, 10, 12]; // demo dữ liệu ngẫu nhiên
            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: data.map((_, i) => i + 1),
                    datasets: [{
                        data: data,
                        borderColor: 'rgba(34,197,94,0.7)',
                        backgroundColor: 'rgba(34,197,94,0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 0
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>




    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#16a34a",
                close: true
            }).showToast();
        </script>
    @endif
@endsection
@section('custom.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('weeklySalesChart').getContext('2d');

        const data = {
            labels: {!! json_encode(array_column($chartData, 'date')) !!},
            datasets: [{
                label: 'Doanh số (₫)',
                data: {!! json_encode(array_column($chartData, 'total')) !!},
                backgroundColor: 'rgba(34,197,94,0.2)',
                borderColor: 'rgba(34,197,94,1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'rgba(34,197,94,1)',
                pointRadius: 5
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('vi-VN').format(context.raw) + '₫';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + '₫';
                            }
                        }
                    }
                }
            }
        };

        new Chart(ctx, config);
    </script>
    <script>
        const ctx = document.getElementById('weeklySalesChart').getContext('2d');

        const data = {
            labels: {!! json_encode(array_column($chartData, 'date')) !!},
            datasets: [{
                label: 'Doanh số (₫)',
                data: {!! json_encode(array_column($chartData, 'total')) !!},
                backgroundColor: 'rgba(34,197,94,0.2)',
                borderColor: 'rgba(34,197,94,1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'rgba(34,197,94,1)',
                pointBorderColor: '#fff',
                pointHoverRadius: 6,
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true
            }
        });
    </script>
@endsection
