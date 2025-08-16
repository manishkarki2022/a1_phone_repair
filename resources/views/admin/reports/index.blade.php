@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Booking Reports</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Filter Card -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter Options</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="from">From Date</label>
                                <input type="date" name="from" id="from" value="{{ $from }}"
                                       class="form-control" max="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="to">To Date</label>
                                <input type="date" name="to" id="to" value="{{ $to }}"
                                       class="form-control" max="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Booking Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ $status=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $status=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $status=='completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $status=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-group w-100">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-filter mr-2"></i> Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Boxes -->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ $summary['total'] }}</h3>
                        <p>Total Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="small-box-footer">
                        {{ \Carbon\Carbon::parse($from)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($to)->format('M d, Y') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ $summary['pending'] }}</h3>
                        <p>Pending</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="small-box-footer">
                        View Pending <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ $summary['confirmed'] }}</h3>
                        <p>Confirmed</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}" class="small-box-footer">
                        View Confirmed <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>{{ $summary['completed'] }}</h3>
                        <p>Completed</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" class="small-box-footer">
                        View Completed <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Chart and Data Section -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Booking Analytics</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="bookingChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-percentage mr-2"></i>Status Distribution</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="statusPieChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="card card-primary card-outline">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-table mr-2"></i>Booking Details</h3>
                <div class="btn-group">
                    <button class="btn btn-success btn-sm" id="exportExcel">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                    <button class="btn btn-primary btn-sm" id="exportCSV">
                        <i class="fas fa-file-csv mr-1"></i> CSV
                    </button>
                    <button class="btn btn-danger btn-sm" id="exportPDF">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="bookingTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr class="bg-lightblue">
                            <th>#</th>
                            <th>Booking #</th>
                            <th>Customer</th>
                            <th>Device</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $booking->booking_number }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->device_brand }} {{ $booking->device_model }}</td>
                            <td>{{ $booking->repairService->name ?? '-' }}</td>
                            <td>
                                <span class="badge
                                    @if($booking->status == 'pending') bg-warning
                                    @elseif($booking->status == 'confirmed') bg-primary
                                    @elseif($booking->status == 'completed') bg-success
                                    @elseif($booking->status == 'cancelled') bg-danger
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('customer-bookings.show', $booking->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="View Details"
                                   data-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                No bookings found for selected filters
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bookings->hasPages())
            <div class="card-footer clearfix">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Bar Chart
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
            datasets: [{
                label: 'Bookings Count',
                data: [
                    {{ $summary['pending'] }},
                    {{ $summary['confirmed'] }},
                    {{ $summary['completed'] }},
                    {{ $summary['cancelled'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 193, 7, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(23, 162, 184, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Bookings by Status ({{ \Carbon\Carbon::parse($from)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($to)->format('M d, Y') }})',
                    font: { size: 16 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('statusPieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $summary['pending'] }},
                    {{ $summary['confirmed'] }},
                    {{ $summary['completed'] }},
                    {{ $summary['cancelled'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Status Distribution',
                    font: { size: 16 }
                },
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const percentage = Math.round((value / total) * 100);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Export Functions
    function exportTable(type) {
        const table = document.getElementById('bookingTable');
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Bookings");

        const fileName = `Bookings_Report_${new Date().toISOString().slice(0,10)}`;

        if (type === 'excel') {
            XLSX.writeFile(wb, `${fileName}.xlsx`);
        } else if (type === 'csv') {
            XLSX.writeFile(wb, `${fileName}.csv`);
        }
    }

    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Title
        doc.setFontSize(18);
        doc.text('Booking Report', 14, 20);

        // Subtitle with date range
        doc.setFontSize(12);
        doc.text(`Date Range: ${new Date('{{ $from }}').toLocaleDateString()} - ${new Date('{{ $to }}').toLocaleDateString()}`, 14, 30);

        // Filters applied
        doc.text(`Status: {{ $status ? ucfirst($status) : 'All Statuses' }}`, 14, 40);

        // Add table
        doc.autoTable({
            html: '#bookingTable',
            startY: 50,
            styles: {
                fontSize: 10,
                cellPadding: 2,
                valign: 'middle'
            },
            headStyles: {
                fillColor: [41, 128, 185],
                textColor: 255,
                fontStyle: 'bold'
            },
            alternateRowStyles: {
                fillColor: [240, 240, 240]
            },
            columnStyles: {
                0: { cellWidth: 10 },
                1: { cellWidth: 25 },
                2: { cellWidth: 30 },
                3: { cellWidth: 30 },
                4: { cellWidth: 30 },
                5: { cellWidth: 20 },
                6: { cellWidth: 20 },
                7: { cellWidth: 15 }
            }
        });

        // Save the PDF
        doc.save(`Bookings_Report_${new Date().toISOString().slice(0,10)}.pdf`);
    }

    // Event Listeners
    document.getElementById('exportExcel').addEventListener('click', () => exportTable('excel'));
    document.getElementById('exportCSV').addEventListener('click', () => exportTable('csv'));
    document.getElementById('exportPDF').addEventListener('click', exportToPDF);
});
</script>
@endpush

@push('styles')
<style>
    .small-box {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .small-box:hover {
        transform: translateY(-5px);
    }
    .small-box .icon {
        font-size: 70px;
        opacity: 0.3;
        transition: all 0.3s ease;
    }
    .small-box:hover .icon {
        opacity: 0.5;
    }
    .bg-lightblue {
        background-color: #e8f4fc;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }
    .card-outline {
        border-top: 3px solid #007bff;
    }
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endpush
