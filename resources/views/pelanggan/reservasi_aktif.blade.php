@extends('layouts.pelanggan')

@section('title', 'Reservasi Aktif')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Pemberitahuan
                    </h4>
                </div>

                <div class="card-body p-4 text-center">
                    <p class="mb-4">
                        Maaf, Anda masih memiliki reservasi yang sedang aktif. <br>
                        Silakan selesaikan reservasi sebelumnya sebelum membuat reservasi baru.
                    </p>

                   
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
