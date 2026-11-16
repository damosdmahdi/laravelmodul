@extends('layouts.belajar')

@section('title', 'Topik 5: Eloquent Accessors, Mutators & Casting - Belajar Laravel SMK')

@push('styles')
<style>
    .code-box-header {
        background: #111827;
        padding: 8px 16px;
        font-size: 0.78rem;
        font-family: 'Fira Code', monospace;
        color: #94a3b8;
        border-bottom: 1px solid #1f2937;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .code-editor-body {
        background: #050811;
        padding: 16px;
        font-family: 'Fira Code', Consolas, monospace;
        font-size: 0.86rem;
        line-height: 1.7;
        color: #cbd5e1;
        overflow-x: auto;
    }
    .code-editor-body .kw { color: #f43f5e; font-weight: 600; }
    .code-editor-body .fn { color: #38bdf8; font-weight: 600; }
    .code-editor-body .str { color: #4ade80; }
    .code-editor-body .cm { color: #64748b; font-style: italic; }
    .code-editor-body .cls { color: #fbbf24; font-weight: 600; }
    .code-editor-body .var { color: #e2e8f0; }

    /* Interactive Code Stepper */
    .stepper-line {
        padding: 2px 6px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    .stepper-line.active-exec {
        background: rgba(56, 189, 248, 0.25);
        border-left: 3px solid #38bdf8;
        color: #ffffff;
    }
    .stepper-line.active-eval {
        background: rgba(16, 185, 129, 0.25);
        border-left: 3px solid #10b981;
        color: #ffffff;
    }

    /* Transformer Chamber Visual */
    .transformer-chamber {
        background: #090d16;
        border: 2px solid #1e293b;
        border-radius: 14px;
        padding: 20px;
        position: relative;
    }
    .gear-box {
        animation: spinGear 8s linear infinite;
        display: inline-block;
    }
    @keyframes spinGear {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-5 py-4">

    <!-- BREADCRUMB & HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('belajar.index') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('belajar.materi.lanjutan') }}" class="text-decoration-none">Materi Lanjutan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Topik 5: Accessors &amp; Mutators</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-danger text-white px-3 py-1">Topik 5 dari 7</span>
            <span class="badge bg-dark border border-secondary text-light">Clean Code Model</span>
        </div>
    </div>

    <!-- TITLE BANNER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #450a0a 0%, #1e1b4b 100%); border-left: 6px solid #ef4444;">
        <div class="card-body p-4 p-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1 text-white">
                        <i class="bi bi-magic text-warning me-2"></i>Eloquent Accessors, Mutators &amp; Attribute Casting
                    </h2>
                    <p class="text-light text-opacity-80 mb-0 small">
                        Penerapan kode nyata untuk memformat nomor WhatsApp menjadi tautan chat API resmi, mengubah angka integer harga menjadi format mata uang Rupiah, serta casting otomatis JSON dan DateTime.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-light btn-sm me-1">
                        <i class="bi bi-grid-fill me-1"></i> Daftar Silabus
                    </a>
                    <a href="{{ route('belajar.materi.lanjutan.6') }}" class="btn btn-danger btn-sm fw-bold">
                        Lanjut ke Topik 6 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 1: PENJELASAN KONSEP & MENGAPA VIEW TIDAK BOLEH DIKOTORI -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="bi bi-shield-x me-2"></i>Masalah Pemula: Menulis String Manipulation di File Blade
                </h5>
                <p class="text-secondary small mb-3">
                    Banyak siswa terbiasa menulis kode pemformatan string secara langsung di dalam file Blade:
                </p>
                <div class="p-3 bg-light rounded-3 border border-danger mb-3 font-monospace small text-danger" style="font-size:0.78rem;">
                    &lt;!-- CONTOH KODE BURUK DI BLADE (ANTI-PATTERN) --&gt;<br>
                    &lt;a href="https://wa.me/@{{ '62' . substr($portfolio->whatsapp, 1) }}?text=@{{ urlencode('Halo ' . $portfolio->nama_usaha) }}"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Hubungi via WhatsApp<br>
                    &lt;/a&gt;<br><br>
                    &lt;span class="harga"&gt;Rp @{{ number_format($product->harga, 0, ',', '.') }}&lt;/span&gt;
                </div>
                <h6 class="fw-bold text-dark mb-2">Mengapa Kode di Atas Melanggar Standar Industri?</h6>
                <ul class="small text-secondary ps-3 mb-0">
                    <li class="mb-2"><strong>Melanggar Separation of Concerns:</strong> File Blade hanya bertugas menyajikan struktur HTML dan CSS tampilan, bukan menjalankan regex pembersih string atau manipulasi logika bisnis.</li>
                    <li class="mb-2"><strong>Duplikasi Kode (Tidak DRY):</strong> Jika tombol WhatsApp atau format harga dipakai di 5 halaman berbeda (Halaman Katalog, Detail Produk, Invoice, Email Pesanan), developer harus copy-paste kode rumit tersebut ke 5 file Blade!</li>
                    <li class="mb-0"><strong>Tidak Tersedia di API JSON:</strong> Jika aplikasi membuat endpoint RESTful API mobile, format WhatsApp dan Rupiah tersebut tidak akan ikut terbawa karena kodenya terkunci di Blade HTML.</li>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-success mb-3">
                    <i class="bi bi-check2-circle me-2"></i>Solusi Bersih: Definisikan di Model Eloquent!
                </h5>
                <p class="text-secondary small mb-3">
                    Dengan membuat <strong>Accessor</strong> di Model, logika format data cukup ditulis <strong>1 kali di Model</strong>, dan dapat dipanggil dengan nama properti virtual yang bersih di mana saja:
                </p>
                <div class="p-3 bg-light rounded-3 border border-success mb-3 font-monospace small text-success" style="font-size:0.82rem;">
                    &lt;!-- KODE ELEGAN DI BLADE VIEW --&gt;<br>
                    &lt;a href="@{{ $portfolio->whatsapp_url }}" target="_blank" class="btn btn-success"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;i class="bi bi-whatsapp me-1"&gt;&lt;/i&gt; Pesan via WhatsApp<br>
                    &lt;/a&gt;<br><br>
                    &lt;span class="harga"&gt;@{{ $product->harga_rupiah }}&lt;/span&gt;
                </div>
                <h6 class="fw-bold text-dark mb-2">Keunggulan Bagi Pengembang:</h6>
                <ul class="small text-secondary ps-3 mb-0">
                    <li class="mb-2"><strong>Otomatis Mengubah Angka HP:</strong> Nomor berawalan <code>0812...</code>, <code>+62812...</code>, atau bahkan yang mengandung spasi <code>0812-3456-7890</code> otomatis dibersihkan menjadi format internasional <code>6281234567890</code>.</li>
                    <li class="mb-2"><strong>Otomatis Menempelkan Pesan Template:</strong> Pesan pembuka otomatis menempel di link chat: <em>"Halo [Nama Usaha], saya ingin memesan..."</em>.</li>
                    <li class="mb-0"><strong>Otomatis di Export JSON:</strong> Cukup tambahkan ke properti <code>protected $appends = ['whatsapp_url'];</code> di model, maka API JSON otomatis memiliki field tersebut!</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- BAGIAN 2: BEDAH STRUKTUR KODE ASLI DI 3 FILE LARAVEL -->
    <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-code-square text-warning me-2"></i>Struktur Kode Asli Aplikasi (File demi File)</h5>
            <span class="badge bg-secondary font-monospace">Production Source Code</span>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3 bg-light border-bottom-0" id="codeFileTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-dark" id="tabModelPortfolioBtn" data-bs-toggle="tab" data-bs-target="#tabModelPortfolio">
                        <i class="bi bi-file-earmark-code text-primary me-1"></i>app/Models/Portfolio.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" id="tabModelProductBtn" data-bs-toggle="tab" data-bs-target="#tabModelProduct">
                        <i class="bi bi-file-earmark-code text-warning me-1"></i>app/Models/PortfolioProduct.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" id="tabViewBladeBtn" data-bs-toggle="tab" data-bs-target="#tabViewBlade">
                        <i class="bi bi-filetype-html text-danger me-1"></i>resources/views/ukk/public/portfolio.blade.php
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="codeFileTabsContent">
                <!-- TAB 1: MODEL PORTFOLIO -->
                <div class="tab-pane fade show active" id="tabModelPortfolio">
                    <div class="code-box-header">
                        <span><i class="bi bi-gear-fill me-1"></i>MODEL PORTOFOLIO DENGAN ACCESSOR WHATSAPP URL &amp; AUTO-SLUG</span>
                        <span class="badge bg-primary">app/Models/Portfolio.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">&lt;?php</span><br><br>
<span class="kw">namespace</span> App\Models;<br><br>
<span class="kw">use</span> Illuminate\Database\Eloquent\Model;<br>
<span class="kw">use</span> Illuminate\Database\Eloquent\Casts\<span class="cls">Attribute</span>;<br>
<span class="kw">use</span> Illuminate\Support\Str;<br><br>
<span class="kw">class</span> <span class="cls">Portfolio</span> <span class="kw">extends</span> <span class="cls">Model</span><br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">protected</span> <span class="var">$fillable</span> = [<span class="str">'nama_usaha'</span>, <span class="str">'tagline'</span>, <span class="str">'slug'</span>, <span class="str">'bio'</span>, <span class="str">'whatsapp'</span>, <span class="str">'status'</span>];<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">/**<br>
&nbsp;&nbsp;&nbsp;&nbsp; * ACCESSOR: Menghasilkan URL WhatsApp API Resmi Beserta Pesan Otomatis<br>
&nbsp;&nbsp;&nbsp;&nbsp; * Dipanggil di Blade dengan: $portfolio->whatsapp_url<br>
&nbsp;&nbsp;&nbsp;&nbsp; */</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">protected function</span> <span class="fn">whatsappUrl</span>(): <span class="cls">Attribute</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="cls">Attribute</span>::<span class="fn">make</span>(<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;get: <span class="kw">function</span> () {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 1. Hilangkan karakter non-angka (spasi, tanda hubung)</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$cleanNumber</span> = <span class="fn">preg_replace</span>(<span class="str">'/[^0-9]/'</span>, <span class="str">''</span>, <span class="var">$this</span>-&gt;whatsapp);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 2. Konversi angka '0' di awal menjadi kode negara '62'</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$internationalNumber</span> = <span class="fn">preg_replace</span>(<span class="str">'/^0/'</span>, <span class="str">'62'</span>, <span class="var">$cleanNumber</span>);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 3. Susun pesan template pesanan</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$pesan</span> = <span class="fn">urlencode</span>(<span class="str">"Halo {$this->nama_usaha}, saya melihat portofolio Anda dan tertarik ingin memesan produk."</span>);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 4. Kembalikan URL lengkap</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="str">"https://wa.me/{$internationalNumber}?text={$pesan}"</span>;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
}
                    </div>
                </div>

                <!-- TAB 2: MODEL PRODUCT -->
                <div class="tab-pane fade" id="tabModelProduct">
                    <div class="code-box-header">
                        <span><i class="bi bi-currency-dollar me-1"></i>MODEL PRODUK DENGAN ACCESSOR FORMAT RUPIAH</span>
                        <span class="badge bg-warning text-dark">app/Models/PortfolioProduct.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">&lt;?php</span><br><br>
<span class="kw">namespace</span> App\Models;<br><br>
<span class="kw">use</span> Illuminate\Database\Eloquent\Model;<br>
<span class="kw">use</span> Illuminate\Database\Eloquent\Casts\<span class="cls">Attribute</span>;<br><br>
<span class="kw">class</span> <span class="cls">PortfolioProduct</span> <span class="kw">extends</span> <span class="cls">Model</span><br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">protected</span> <span class="var">$fillable</span> = [<span class="str">'portfolio_id'</span>, <span class="str">'nama_produk'</span>, <span class="str">'harga'</span>, <span class="str">'deskripsi'</span>, <span class="str">'gambar'</span>];<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">/**<br>
&nbsp;&nbsp;&nbsp;&nbsp; * ACCESSOR: Mengubah angka murni integer database menjadi teks format Rupiah<br>
&nbsp;&nbsp;&nbsp;&nbsp; * Contoh: 25000 -> "Rp 25.000"<br>
&nbsp;&nbsp;&nbsp;&nbsp; * Dipanggil di Blade dengan: $product->harga_rupiah<br>
&nbsp;&nbsp;&nbsp;&nbsp; */</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">protected function</span> <span class="fn">hargaRupiah</span>(): <span class="cls">Attribute</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="cls">Attribute</span>::<span class="fn">make</span>(<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;get: <span class="kw">fn</span> () =&gt; <span class="str">'Rp '</span> . <span class="fn">number_format</span>(<span class="var">$this</span>-&gt;harga, 0, <span class="str">','</span>, <span class="str">'.'</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
}
                    </div>
                </div>

                <!-- TAB 3: BLADE VIEW -->
                <div class="tab-pane fade" id="tabViewBlade">
                    <div class="code-box-header">
                        <span><i class="bi bi-filetype-html me-1"></i>PEMANGGILAN BERSIH DI VIEW BLADE</span>
                        <span class="badge bg-danger">resources/views/ukk/public/portfolio.blade.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="cm">&lt;!-- TOMBOL CTA WHATSAPP DI HERO BANNER --&gt;</span><br>
&lt;<span class="kw">a</span> <span class="fn">href</span>=<span class="str">"@{{ $portfolio->whatsapp_url }}"</span> <span class="fn">target</span>=<span class="str">"_blank"</span> <span class="fn">class</span>=<span class="str">"btn btn-success btn-lg fw-bold px-4"</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&lt;<span class="kw">i</span> <span class="fn">class</span>=<span class="str">"bi bi-whatsapp me-2"</span>&gt;&lt;/<span class="kw">i</span>&gt;Hubungi Kami via WhatsApp<br>
&lt;/<span class="kw">a</span>&gt;<br><br>
<span class="cm">&lt;!-- GRID 4 PRODUK UNGGULAN --&gt;</span><br>
&#64;<span class="kw">foreach</span>(<span class="var">$portfolio</span>-&gt;products <span class="kw">as</span> <span class="var">$item</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;&lt;<span class="kw">div</span> <span class="fn">class</span>=<span class="str">"col-md-6 col-lg-3"</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;<span class="kw">div</span> <span class="fn">class</span>=<span class="str">"card product-card"</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;<span class="kw">div</span> <span class="fn">class</span>=<span class="str">"card-body"</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;<span class="kw">h6</span> <span class="fn">class</span>=<span class="str">"fw-bold"</span>&gt;@{{ $item->nama_produk }}&lt;/<span class="kw">h6</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;<span class="kw">span</span> <span class="fn">class</span>=<span class="str">"badge bg-primary fs-6"</span>&gt;@{{ $item->harga_rupiah }}&lt;/<span class="kw">span</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/<span class="kw">div</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/<span class="kw">div</span>&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&lt;/<span class="kw">div</span>&gt;<br>
&#64;<span class="kw">endforeach</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 3: SIMULATOR INTERAKTIF DENGAN LIVE CODE STEPPER (PENERAPAN ASLI) -->
    <div class="row g-4 mb-5">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background:#090d16; border:1px solid #1e293b;">
                <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="bi bi-play-circle-fill text-danger me-2"></i>Simulator Interaktif: Live Code Execution Stepper</span>
                    <span class="badge bg-danger">Melihat Baris Kode Berjalan</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Left Panel: Live Input -->
                        <div class="col-lg-4">
                            <h6 class="fw-bold text-warning mb-3"><i class="bi bi-input-cursor me-1"></i>1. Ubah Data Kolom Database:</h6>

                            <div class="mb-3">
                                <label class="small text-muted fw-bold mb-1">Nama Usaha ($portfolio->nama_usaha):</label>
                                <input type="text" id="liveShopName" class="form-control form-control-sm bg-black text-white border-secondary font-monospace" value="Kue Enak Bu Sri" oninput="stepTransform()">
                            </div>

                            <div class="mb-3">
                                <label class="small text-muted fw-bold mb-1">Nomor WA Mentah di DB ($portfolio->whatsapp):</label>
                                <input type="text" id="liveRawWa" class="form-control form-control-sm bg-black text-white border-secondary font-monospace" value="0812-3456-7890" oninput="stepTransform()">
                                <span class="text-secondary" style="font-size:0.7rem;">Coba variasikan: 0812..., +62812..., atau beri tanda hubung.</span>
                            </div>

                            <div class="mb-3">
                                <label class="small text-muted fw-bold mb-1">Harga Integer DB ($product->harga):</label>
                                <input type="number" id="liveRawPrice" class="form-control form-control-sm bg-black text-white border-secondary font-monospace" value="35000" oninput="stepTransform()">
                            </div>

                            <div class="p-3 bg-dark rounded-3 border border-secondary text-center mt-4">
                                <span class="small text-muted d-block mb-1">Hasil Rendering Tombol di Blade:</span>
                                <a id="previewWaBtn" href="#" target="_blank" class="btn btn-success btn-sm fw-bold w-100 py-2 shadow-sm text-truncate">
                                    <i class="bi bi-whatsapp me-1"></i> Pesan via WhatsApp
                                </a>
                                <div class="mt-2 text-start">
                                    <span class="small text-muted d-block" style="font-size:0.7rem;">Badge Harga:</span>
                                    <span class="badge bg-primary fs-6" id="previewPriceBadge">Rp 35.000</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Code Execution Trace -->
                        <div class="col-lg-8">
                            <h6 class="fw-bold text-info mb-3"><i class="bi bi-cpu me-1"></i>2. Jalur Eksekusi Kode di Balik Layar:</h6>

                            <div class="bg-black p-3 rounded-3 border border-secondary font-monospace small" style="font-size:0.82rem;">
                                <div class="text-secondary border-bottom border-secondary pb-1 mb-2">
                                    // EKSEKUSI DALAM METHOD whatsappUrl():
                                </div>
                                <div class="stepper-line active-exec mb-1" id="stepLine1">
                                    <span class="text-muted">1.</span> $cleanNumber = preg_replace('/[^0-9]/', '', '<span class="text-warning" id="traceRawWa">0812-3456-7890</span>');<br>
                                    <span class="text-muted ms-3">&rarr; Evaluasi:</span> <strong class="text-info" id="evalCleanWa">"081234567890"</strong>
                                </div>
                                <div class="stepper-line active-exec mb-1" id="stepLine2">
                                    <span class="text-muted">2.</span> $international = preg_replace('/^0/', '62', '<span class="text-info" id="traceCleanWa">081234567890</span>');<br>
                                    <span class="text-muted ms-3">&rarr; Evaluasi:</span> <strong class="text-success" id="evalIntWa">"6281234567890"</strong>
                                </div>
                                <div class="stepper-line active-exec mb-1" id="stepLine3">
                                    <span class="text-muted">3.</span> $pesan = urlencode("Halo <span class="text-warning" id="traceShopName">Kue Enak Bu Sri</span>, saya tertarik memesan...");<br>
                                    <span class="text-muted ms-3">&rarr; Evaluasi:</span> <span class="text-light" style="font-size:0.72rem;" id="evalUrlMsg">Halo+Kue+Enak+Bu+Sri...</span>
                                </div>
                                <div class="stepper-line active-eval mb-3" id="stepLine4">
                                    <span class="text-muted">4.</span> return "https://wa.me/" . $international . "?text=" . $pesan;<br>
                                    <span class="text-muted ms-3">&rarr; Nilai Akhir:</span> <strong class="text-success text-break" style="font-size:0.75rem;" id="evalFinalUrl">https://wa.me/6281234567890...</strong>
                                </div>

                                <div class="text-secondary border-bottom border-secondary pb-1 mb-2">
                                    // EKSEKUSI DALAM METHOD hargaRupiah():
                                </div>
                                <div class="stepper-line active-eval" id="stepLinePrice">
                                    <span class="text-muted">1.</span> return 'Rp ' . number_format(<span class="text-warning" id="traceRawPrice">35000</span>, 0, ',', '.');<br>
                                    <span class="text-muted ms-3">&rarr; Nilai Akhir:</span> <strong class="text-warning" id="evalFinalPrice">"Rp 35.000"</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('belajar.materi.lanjutan.4') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Topik 4: Database Transactions
            </a>
            <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-grid me-1"></i> Menu Silabus 7 Topik
            </a>
            <a href="{{ route('belajar.materi.lanjutan.6') }}" class="btn btn-danger fw-bold">
                Topik 6: Model Observers <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

@push('scripts')
@verbatim
<script>
    function stepTransform() {
        const rawName = document.getElementById('liveShopName').value.trim() || 'Toko Demo';
        const rawWa = document.getElementById('liveRawWa').value.trim() || '08123456789';
        const rawPrice = parseInt(document.getElementById('liveRawPrice').value) || 0;

        // Trace WA Step 1
        const cleanWa = rawWa.replace(/[^0-9]/g, '');
        document.getElementById('traceRawWa').innerText = rawWa;
        document.getElementById('evalCleanWa').innerText = '"' + cleanWa + '"';

        // Trace WA Step 2
        const intWa = cleanWa.replace(/^0/, '62');
        document.getElementById('traceCleanWa').innerText = cleanWa;
        document.getElementById('evalIntWa').innerText = '"' + intWa + '"';

        // Trace WA Step 3
        const msgText = 'Halo ' + rawName + ', saya melihat portofolio Anda dan tertarik ingin memesan produk.';
        const urlEncodedMsg = encodeURIComponent(msgText);
        document.getElementById('traceShopName').innerText = rawName;
        document.getElementById('evalUrlMsg').innerText = urlEncodedMsg.substring(0, 45) + '...';

        // Trace WA Step 4
        const finalUrl = 'https://wa.me/' + intWa + '?text=' + urlEncodedMsg;
        document.getElementById('evalFinalUrl').innerText = finalUrl;
        document.getElementById('previewWaBtn').href = finalUrl;

        // Trace Price
        const formattedPrice = 'Rp ' + rawPrice.toLocaleString('id-ID');
        document.getElementById('traceRawPrice').innerText = rawPrice;
        document.getElementById('evalFinalPrice').innerText = '"' + formattedPrice + '"';
        document.getElementById('previewPriceBadge').innerText = formattedPrice;
    }

    document.addEventListener('DOMContentLoaded', function() {
        stepTransform();
    });
</script>
@endverbatim
@endpush
@endsection
