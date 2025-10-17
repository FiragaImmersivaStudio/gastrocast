@extends('layouts.app')

@section('title', 'Dataset Details')

@section('content')
<div class="mb-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1>Dataset Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('datasets.index') }}">Datasets</a></li>
                    <li class="breadcrumb-item active">{{ $dataset->filename }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('datasets.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Dataset Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="40%">Type:</th>
                                <td>
                                    @switch($dataset->type)
                                        @case('sales')
                                            <i class="fas fa-receipt text-primary me-1"></i>Sales Transactions
                                            @break
                                        @case('customers')
                                            <i class="fas fa-users text-info me-1"></i>Customer Data
                                            @break
                                        @case('menu')
                                            <i class="fas fa-utensils text-success me-1"></i>Menu Items
                                            @break
                                        @case('inventory')
                                            <i class="fas fa-boxes text-warning me-1"></i>Inventory
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th>Filename:</th>
                                <td>{{ $dataset->filename }}</td>
                            </tr>
                            <tr>
                                <th>Total Records:</th>
                                <td>{{ number_format($dataset->total_records) }}</td>
                            </tr>
                            <tr>
                                <th>Date Range:</th>
                                <td>
                                    @if($dataset->data_start_date && $dataset->data_end_date)
                                        {{ $dataset->data_start_date->format('Y-m-d') }} to {{ $dataset->data_end_date->format('Y-m-d') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @switch($dataset->status)
                                        @case('uploaded')
                                            <span class="badge bg-info">Uploaded</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-warning">Processing...</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                        @case('failed')
                                            <span class="badge bg-danger">Failed</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th>Uploaded By:</th>
                                <td>{{ $dataset->uploadedBy->name ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th>Upload Date:</th>
                                <td>{{ $dataset->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @if($dataset->processed_at)
                            <tr>
                                <th>Processed At:</th>
                                <td>{{ $dataset->processed_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @endif
                            @if($dataset->processing_notes)
                            <tr>
                                <th>Notes:</th>
                                <td>{{ $dataset->processing_notes }}</td>
                            </tr>
                            @endif
                            @if($dataset->validation_errors)
                            <tr>
                                <th>Errors:</th>
                                <td class="text-danger">{{ $dataset->validation_errors }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Restaurant Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="40%">Restaurant:</th>
                                <td>{{ $dataset->restaurant->name }}</td>
                            </tr>
                            <tr>
                                <th>Category:</th>
                                <td>{{ $dataset->restaurant->category }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $dataset->restaurant->address }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $dataset->restaurant->phone }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($dataset->status === 'completed')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Data Preview</h5>
            <small class="text-muted">Showing first 10 rows</small>
        </div>
        <div class="card-body">
            @if(isset($preview['error']))
                <div class="alert alert-danger">
                    {{ $preview['error'] }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead class="table-dark">
                            <tr>
                                @foreach($preview['headers'] as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preview['rows'] as $row)
                                <tr>
                                    @foreach($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
