@extends('layouts.admin')

@section('title','Buat Transaksi')

@section('content')
<h4 class="mb-4">💳 Buat Transaksi</h4>

@php
$selectedProductIds = !empty($konsultasi?->rekomendasi_products)
    ? array_map('intval', explode(',', $konsultasi->rekomendasi_products))
    : [];

$selectedTreatmentIds = !empty($konsultasi?->rekomendasi_treatments)
    ? array_map('intval', explode(',', $konsultasi->rekomendasi_treatments))
    : [];
@endphp

<form method="POST" action="{{ route('admin.transaksi.store') }}">
@csrf

<input type="hidden" name="customer_id" value="{{ $customer->id }}">
<input type="hidden" name="total" id="totalInput">

<div class="card shadow-sm">
<div class="card-body">

<p><b>Pasien:</b> {{ $customer->nama_lengkap }}</p>
<hr>

{{-- ================= PRODUK ================= --}}
<label class="fw-bold mb-2">🧴 Produk</label>
<div class="border rounded p-3 mb-4" style="max-height:250px;overflow:auto">
@foreach($products as $product)
<div class="form-check mb-2">
    <input class="form-check-input product-check"
           type="checkbox"
           name="products[]"
           value="{{ $product->id }}"
           data-harga="{{ $product->harga }}"
           data-rekomendasi="{{ in_array($product->id, $selectedProductIds) ? 1 : 0 }}"
           {{ in_array($product->id, $selectedProductIds) ? 'checked' : '' }}>
    <label class="form-check-label w-100">
        {{ $product->nama }}
        <span class="float-end">Rp {{ number_format($product->harga,0,',','.') }}</span>
    </label>
</div>
@endforeach
</div>

{{-- ================= TREATMENT ================= --}}
<label class="fw-bold mb-2">💆 Treatment</label>
<div class="border rounded p-3 mb-4" style="max-height:250px;overflow:auto">
@foreach($treatments as $treatment)
<div class="form-check mb-2">
    <input class="form-check-input treatment-check"
           type="checkbox"
           name="treatments[]"
           value="{{ $treatment->id }}"
           data-harga="{{ $treatment->harga }}"
           data-rekomendasi="{{ in_array($treatment->id, $selectedTreatmentIds) ? 1 : 0 }}"
           {{ in_array($treatment->id, $selectedTreatmentIds) ? 'checked' : '' }}>
    <label class="form-check-label w-100">
        {{ $treatment->nama_treatment }}
        <span class="float-end">Rp {{ number_format($treatment->harga,0,',','.') }}</span>
    </label>
</div>
@endforeach
</div>

{{-- ================= PROMO ================= --}}
<label class="fw-bold mb-2">🎁 Promo</label>
<select name="promos_id" id="promoSelect" class="form-select mb-3">
    <option value="">-- Tanpa Promo --</option>
    @foreach($promos as $promo)
        @php
            $pp = $promoProducts[$promo->id] ?? collect();
            $pt = $promoTreatments[$promo->id] ?? collect();
        @endphp
        <option value="{{ $promo->id }}"
            data-diskon="{{ $promo->diskon_persen }}"
            data-products="{{ $pp->pluck('product_id')->implode(',') }}"
            data-treatments="{{ $pt->pluck('treatment_id')->implode(',') }}"
            hidden>
            {{ $promo->nama_promo }} ({{ $promo->diskon_persen }}%)
        </option>
    @endforeach
</select>

{{-- ================= METODE BAYAR ================= --}}
<label class="fw-bold">💰 Metode Pembayaran</label>
<select name="metode_pembayaran" class="form-select mb-4" required>
    <option value="">-- Pilih Metode --</option>
    <option value="cash">Cash</option>
    <option value="transfer">Transfer</option>
    <option value="qris">QRIS</option>
</select>

<hr>

<div class="d-flex justify-content-end">
    <h5>Total: Rp <span id="total">0</span></h5>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-success">💾 Simpan Transaksi</button>
    <a href="{{ route('admin.konsultasi') }}" class="btn btn-secondary">Kembali</a>
</div>

</div>
</div>
</form>


<script>
function selected(selector){
    return [...document.querySelectorAll(selector)].map(el => el.value);
}

function updatePromo(){
    const products = selected('.product-check:checked');
    const treatments = selected('.treatment-check:checked');

    document.querySelectorAll('#promoSelect option').forEach(opt=>{
        if(!opt.value) return;
        const p = opt.dataset.products.split(',').filter(Boolean);
        const t = opt.dataset.treatments.split(',').filter(Boolean);

        opt.hidden = !(p.some(id=>products.includes(id)) || t.some(id=>treatments.includes(id)));
    });

    if(document.querySelector('#promoSelect option:checked')?.hidden){
        document.getElementById('promoSelect').value='';
    }
}

function hitungTotal(){
    let total=0;
    document.querySelectorAll('.product-check:checked,.treatment-check:checked')
        .forEach(el=> total+=parseInt(el.dataset.harga));

    const diskon = parseInt(document.querySelector('#promoSelect option:checked')?.dataset.diskon||0);
    if(diskon) total -= total*diskon/100;

    document.getElementById('total').innerText = total.toLocaleString();
    document.getElementById('totalInput').value = Math.round(total);
}

document.querySelectorAll('.product-check,.treatment-check')
    .forEach(el=>el.addEventListener('change',()=>{updatePromo();hitungTotal();}));

document.getElementById('promoSelect')
    .addEventListener('change',hitungTotal);

updatePromo();
hitungTotal();
</script>
@endsection

