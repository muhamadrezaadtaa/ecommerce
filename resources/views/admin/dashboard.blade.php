@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- ===== STYLE BLIBLI-LIKE (SATU FILE) ===== --}}
<style>
  .card {
    border: 0;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,.04);
  }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }

  .stat-title {
    font-size: 13px;
    color: #6c757d;
  }

  .stat-value {
    font-size: 22px;
    font-weight: 700;
  }

  .table th {
    border-bottom: 1px solid #eee;
    color: #6c757d;
    font-size: 12px;
    text-transform: uppercase;
  }

  .badge {
    font-weight: 500;
  }
  .main-content {
    margin-left: 260px;
    min-height: 100vh;
    width: calc(100% - 260px); /* ⬅️ INI KUNCI NYA */
    background-color: #f8fafc;
}

</style>

<div class="container-fluid">

  {{-- ===== STAT CARDS ===== --}}
  <div class="row g-4 mb-4">

    <div class="col-lg-3 col-md-6">
      <div class="card h-100">
        <div class="card-body d-flex gap-3 align-items-center">
          <div class="stat-icon bg-primary text-white">
            <i class="ti ti-currency-dollar"></i>
          </div>
          <div>
            <div class="stat-value">
              Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
            </div>
            <div class="stat-title">Total Pendapatan</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card h-100">
        <div class="card-body d-flex gap-3 align-items-center">
          <div class="stat-icon bg-info text-white">
            <i class="ti ti-shopping-cart"></i>
          </div>
          <div>
            <div class="stat-value">{{ $stats['total_orders'] ?? 0 }}</div>
            <div class="stat-title">Total Pesanan</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card h-100">
        <div class="card-body d-flex gap-3 align-items-center">
          <div class="stat-icon bg-warning text-dark">
            <i class="ti ti-clock-hour-3"></i>
          </div>
          <div>
            <div class="stat-value">{{ $stats['pending_orders'] ?? 0 }}</div>
            <div class="stat-title">Menunggu Diproses</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card h-100">
        <div class="card-body d-flex gap-3 align-items-center">
          <div class="stat-icon bg-danger text-white">
            <i class="ti ti-alert-triangle"></i>
          </div>
          <div>
            <div class="stat-value">{{ $stats['low_stock'] ?? 0 }}</div>
            <div class="stat-title">Stok Menipis</div>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ===== CHART + QUICK ACTION ===== --}}
  <div class="row g-4 mb-4">

    <div class="col-lg-8">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="fw-bold mb-1">Ringkasan Penjualan</h5>
              <small class="text-muted">Performa penjualan tahun ini</small>
            </div>
            <select class="form-select form-select-sm w-auto">
              <option>2025</option>
              <option>2024</option>
            </select>
          </div>
          <div id="sales-overview" style="height:350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-body">
          <h6 class="fw-bold mb-3">Aksi Cepat</h6>

          <div class="d-grid gap-3">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary py-3 fw-semibold">
              <i class="ti ti-plus me-2"></i> Tambah Produk
            </a>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary py-3 fw-semibold">
              <i class="ti ti-receipt me-2"></i> Pesanan Baru
            </a>

            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary py-3 fw-semibold">
              <i class="ti ti-category me-2"></i> Kelola Kategori
            </a>
          </div>
        </div>
      </div>

      <div class="card bg-primary text-white">
        <div class="card-body text-center">
          <h5 class="fw-bold">Selamat Datang 👋</h5>
          <p class="mb-0">Halo, <strong>{{ auth()->user()->name }}</strong></p>
          <small class="opacity-75">Kelola toko Anda hari ini</small>
        </div>
      </div>
    </div>

  </div>

  {{-- ===== TABLE PESANAN ===== --}}
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Pesanan Terbaru</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary btn-sm">
          Lihat Semua
        </a>
      </div>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Order</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Status</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentOrders as $order)
            <tr>
              <td class="fw-semibold text-primary">
                #{{ $order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
              </td>
              <td>{{ $order->user->name }}</td>
              <td class="fw-semibold">
                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
              </td>
              <td>
                <span class="badge rounded-pill bg-{{ $order->status_color }} bg-opacity-10 text-{{ $order->status_color }}">
                  {{ ucfirst($order->status) }}
                </span>
              </td>
              <td class="text-muted">
                {{ $order->created_at->format('d M Y') }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">
                Belum ada pesanan
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script>
  new ApexCharts(document.querySelector("#sales-overview"), {
    chart: { type: 'area', height: 350 },
    series: [
      { name: 'Bulan Ini', data: [31,40,28,51,42,109,100] },
      { name: 'Bulan Lalu', data: [11,32,45,32,34,52,41] }
    ],
    xaxis: { categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'] },
    colors: ['#0d6efd', '#adb5bd'],
    fill: { opacity: 0.15 }
  }).render();
</script>
@endpush