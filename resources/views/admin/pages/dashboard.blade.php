@extends("admin.app")
@section("content")
    <!-- index body start -->
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <!-- Nút AI Suggest trên header -->
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <button class="btn btn-info" id="ai-suggest-btn">
                        <i class="ri-robot-2-line"></i> Gợi ý tăng doanh số (AI)
                    </button>
                </div>
                <!-- chart card section start -->
                <div class="col-sm-6 col-xxl-3 col-lg-6">
                    <div class="main-tiles border-5 border-0 card-hover card o-hidden">
                        <div class="custome-1-bg b-r-4 card-body">
                            <div class="media align-items-center static-top-widget">
                                <div class="media-body p-0">
                                    <span class="m-0">Tổng doanh thu</span>
                                    <h4 class="mb-0 counter">{{ number_format($totalRevenue) }}đ
                                        @if($revenueGrowth > 0)
                                            <span class="badge badge-light-primary grow">
                                            <i data-feather="trending-up"></i>{{ number_format($revenueGrowth, 1) }}%
                                        </span>
                                        @elseif($revenueGrowth < 0)
                                            <span class="badge badge-light-danger grow">
                                            <i data-feather="trending-down"></i>{{ number_format(abs($revenueGrowth), 1) }}%
                                        </span>
                                        @endif
                                    </h4>
                                </div>
                                <div class="align-self-center text-center">
                                    <i class="ri-database-2-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xxl-3 col-lg-6">
                    <div class="main-tiles border-5 card-hover border-0 card o-hidden">
                        <div class="custome-2-bg b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="media-body p-0">
                                    <span class="m-0">Tổng đơn hàng</span>
                                    <h4 class="mb-0 counter">{{ $totalOrders }}
                                        <span class="badge badge-light-info grow">
                                        {{ $orderStatus->where('status', 'confirmed')->first()?->count ?? 0 }} đơn đang xử lý
                                    </span>
                                    </h4>
                                </div>
                                <div class="align-self-center text-center">
                                    <i class="ri-shopping-bag-3-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xxl-3 col-lg-6">
                    <div class="main-tiles border-5 card-hover border-0 card o-hidden">
                        <div class="custome-3-bg b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="media-body p-0">
                                    <span class="m-0">Tổng sản phẩm</span>
                                    <h4 class="mb-0 counter">{{ $totalProducts }}
                                        <span class="badge badge-light-secondary grow">
                                        {{ $totalCategories }} danh mục
                                    </span>
                                    </h4>
                                </div>
                                <div class="align-self-center text-center">
                                    <i class="ri-chat-3-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xxl-3 col-lg-6">
                    <div class="main-tiles border-5 card-hover border-0 card o-hidden">
                        <div class="custome-4-bg b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="media-body p-0">
                                    <span class="m-0">Tổng người dùng</span>
                                    <h4 class="mb-0 counter">{{ $totalUsers }}
                                        <span class="badge badge-light-warning grow">
                                        Đánh giá: {{ number_format($averageRating, 1) }}/5
                                    </span>
                                    </h4>
                                </div>
                                <div class="align-self-center text-center">
                                    <i class="ri-user-add-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- chart card section end -->

                <!-- chart section start -->
                <div class="col-xl-6">
                    <div class="card o-hidden card-hover">
                        <div class="card-header border-0 pb-1 d-flex justify-content-between align-items-center">
                            <div class="card-header-title">
                                <h4>Doanh thu theo tháng</h4>
                            </div>
                            <form method="GET" class="mb-0">
                                <select name="months" onchange="this.form.submit()" class="form-select form-select-sm">
                                    <option value="6" {{ request('months', 6) == 6 ? 'selected' : '' }}>6 tháng gần nhất</option>
                                    <option value="12" {{ request('months') == 12 ? 'selected' : '' }}>12 tháng gần nhất</option>
                                </select>
                            </form>
                        </div>
                        <div class="card-body p-0">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- chart section end -->

                <!-- Best Selling Product Start -->
                <div class="col-xl-6 col-md-12">
                    <div class="card o-hidden card-hover">
                        <div class="card-header card-header-top card-header--2 px-0 pt-0">
                            <div class="card-header-title">
                                <h4>Sản phẩm bán chạy</h4>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div>
                                <div class="table-responsive">
                                    <table class="best-selling-table w-image table border-0">
                                        <tbody>
                                        @foreach($topProducts as $product)
                                            <tr>
                                                <td>
                                                    <div class="best-product-box">
                                                        <div class="product-name">
                                                            <h5>{{ $product->name }}</h5>
                                                            <h6>{{ $product->total_quantity }} đơn</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product-detail-box">
                                                        <h6>Doanh thu</h6>
                                                        <h5>{{ number_format($product->revenue) }}đ</h5>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Best Selling Product End -->

                <!-- Recent orders start-->
                <div class="col-xl-6">
                    <div class="card o-hidden card-hover">
                        <div class="card-header card-header-top card-header--2 px-0 pt-0">
                            <div class="card-header-title">
                                <h4>Đơn hàng gần đây</h4>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div>
                                <div class="table-responsive">
                                    <table class="best-selling-table table border-0">
                                        <tbody>
                                        @foreach($recentOrders as $order)
                                            <tr>
                                                <td>
                                                    <div class="best-product-box">
                                                        <div class="product-name">
                                                            <h5>#{{ $order->id }}</h5>
                                                            <h6>{{ $order->created_at->format('d/m/Y') }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product-detail-box">
                                                        <h6>Tổng tiền</h6>
                                                        <h5>{{ number_format($order->total_amount) }}đ</h5>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product-detail-box">
                                                        <h6>Trạng thái</h6>
                                                        <h5>{{ $order->status }}</h5>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent orders end-->

                <!-- Category Revenue chart start-->
                <div class="col-xl-6">
                    <div class="card o-hidden card-hover">
                        <div class="card-header border-0 mb-0 d-flex justify-content-between align-items-center">
                            <div class="card-header-title">
                                <h4>Doanh thu theo danh mục</h4>
                            </div>
                            <form method="GET" class="mb-0">
                                <select name="months_category" onchange="this.form.submit()" class="form-select form-select-sm">
                                    <option value="6" {{ request('months_category', 6) == 6 ? 'selected' : '' }}>6 tháng gần nhất</option>
                                    <option value="12" {{ request('months_category') == 12 ? 'selected' : '' }}>12 tháng gần nhất</option>
                                </select>
                            </form>
                        </div>
                        <div class="card-body p-0">
                            <canvas id="categoryRevenueChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Category Revenue chart end-->

                <!-- Order Status chart start-->
                <div class="col-xxl-4 col-md-6">
                    <div class="card o-hidden card-hover">
                        <div class="card-header border-0">
                            <div class="card-header-title">
                                <h4>Trạng thái đơn hàng</h4>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Order Status chart end-->

                <!-- New Users chart start-->
                <div class="col-xxl-4 col-md-6">
                    <div class="h-100">
                        <div class="card o-hidden card-hover">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                                <div class="card-header-title">
                                    <h4>Người dùng mới</h4>
                                </div>
                                <form method="GET" class="mb-0">
                                    <select name="months_user" onchange="this.form.submit()" class="form-select form-select-sm">
                                        <option value="6" {{ request('months_user', 6) == 6 ? 'selected' : '' }}>6 tháng gần nhất</option>
                                        <option value="12" {{ request('months_user') == 12 ? 'selected' : '' }}>12 tháng gần nhất</option>
                                    </select>
                                </form>
                            </div>
                            <div class="card-body pt-0">
                                <canvas id="newUsersChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- New Users chart end-->

                <!-- Top Rated Products start-->
                <div class="col-xxl-4 col-md-6">
                    <div class="card o-hidden card-hover">
                        <div class="card-header border-0">
                            <div class="card-header-title">
                                <h4>Sản phẩm đánh giá cao</h4>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div>
                                <div class="table-responsive">
                                    <table class="user-table transactions-table table border-0">
                                        <tbody>
                                        @foreach($highRatedProducts as $product)
                                            <tr>
                                                <td>
                                                    <div class="transactions-name">
                                                        <h6>{{ $product->name }}</h6>
                                                        <div class="progress" style="height: 5px;">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                 style="width: {{ ($product->avg_rating/5)*100 }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="success">{{ number_format($product->avg_rating, 1) }}/5</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Top Rated Products end-->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Kiểm tra dữ liệu trước khi vẽ biểu đồ
            console.log('Monthly Revenue:', {!! json_encode($monthlyRevenue) !!});
            console.log('Category Revenue:', {!! json_encode($categoryRevenue) !!});
            console.log('Order Status:', {!! json_encode($orderStatus) !!});
            console.log('New Users:', {!! json_encode($newUsers) !!});

            // Doanh thu theo tháng
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(collect($monthlyRevenue)->pluck('month')->values()) !!},
                    datasets: [{
                        label: 'Doanh thu',
                        data: {!! json_encode(collect($monthlyRevenue)->pluck('revenue')->values()) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return value.toLocaleString('vi-VN') + 'đ';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('vi-VN') + 'đ';
                                }
                            }
                        }
                    }
                }
            });

            // Doanh thu theo danh mục
            const ctx2 = document.getElementById('categoryRevenueChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($categoryLabels) !!},
                    datasets: [{
                        label: 'Doanh thu',
                        data: {!! json_encode($categoryRevenue) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return value.toLocaleString('vi-VN') + 'đ';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('vi-VN') + 'đ';
                                }
                            }
                        }
                    }
                }
            });

            // Trạng thái đơn hàng
            const ctx3 = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(collect($orderStatus)->pluck('status')->values()) !!},
                    datasets: [{
                        label: 'Số lượng',
                        data: {!! json_encode(collect($orderStatus)->pluck('count')->values()) !!},
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Người dùng mới theo tháng
            const ctx4 = document.getElementById('newUsersChart').getContext('2d');
            new Chart(ctx4, {
                type: 'line',
                data: {
                    labels: {!! json_encode(collect($newUsers)->pluck('month')->values()) !!},
                    datasets: [{
                        label: 'Người dùng mới',
                        data: {!! json_encode(collect($newUsers)->pluck('count')->values()) !!},
                        backgroundColor: 'rgba(255, 206, 86, 0.5)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <!-- Modal AI Suggest -->
    <div class="modal fade" id="aiSuggestModal" tabindex="-1" aria-labelledby="aiSuggestModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="aiSuggestModalLabel">Gợi ý tăng doanh số từ AI</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="ai-question" class="form-label">Nhập câu hỏi cho AI:</label>
              <textarea id="ai-question" class="form-control" rows="2" placeholder="Ví dụ: Làm sao tăng doanh số tháng này?"></textarea>
            </div>
            <button class="btn btn-primary mb-3" id="ai-send-btn">Gửi câu hỏi</button>
            <div id="ai-suggest-content">
              <div class="text-center">
                <div class="spinner-border text-info" role="status"></div>
                <div>Đang phân tích dữ liệu, vui lòng chờ...</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('js-custom')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiSuggestBtn = document.getElementById('ai-suggest-btn');
    const aiSuggestModal = document.getElementById('aiSuggestModal');
    const aiSendBtn = document.getElementById('ai-send-btn');
    const aiQuestion = document.getElementById('ai-question');
    const aiSuggestContent = document.getElementById('ai-suggest-content');

    if (aiSuggestBtn && aiSuggestModal) {
        aiSuggestBtn.addEventListener('click', function() {
            aiQuestion.value = '';
            aiSuggestContent.innerHTML = '';
            const modal = new bootstrap.Modal(aiSuggestModal);
            modal.show();
        });
    }
    if (aiSendBtn) {
        aiSendBtn.addEventListener('click', function() {
            const question = aiQuestion.value.trim();
            aiSendBtn.disabled = true;
            aiSuggestContent.innerHTML = `<div class='text-center'><div class='spinner-border text-info' role='status'></div><div>Đang gửi câu hỏi, vui lòng chờ...</div></div>`;
            fetch("{{ route('ai_suggest') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ question })
            })
            .then(res => res.json())
            .then(data => {
                aiSuggestContent.innerHTML = `<pre style='white-space: pre-line;'>${data.suggest}</pre>`;
            })
            .catch(() => {
                aiSuggestContent.innerHTML = '<div class="text-danger">Có lỗi khi lấy gợi ý từ AI!</div>';
            })
            .finally(() => {
                aiSendBtn.disabled = false;
            });
        });
    }
});
</script>
@endsection
