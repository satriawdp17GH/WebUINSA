<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>ARUNA — Gerakkan Usahamu, Tumbuh Bersama</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#16294d;--navy2:#1f3a6e;--or:#f28a2e;--orsoft:#fff0e0;--bg:#f7f6f3;--card:#fff;--tx:#1b2333;--mut:#667085;--line:#e8e6e0;--ok:#1f9d55;--sh:0 6px 24px rgba(22,41,77,.08);
box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#0e1626;--card:#16223a;--tx:#eef1f7;--mut:#9aa6bd;--line:#26334d;--orsoft:#3a2a18;--navy:#8fb0ff;--sh:0 6px 24px rgba(0,0,0,.35)}}
:root[data-theme="dark"]{--bg:#0e1626;--card:#16223a;--tx:#eef1f7;--mut:#9aa6bd;--line:#26334d;--orsoft:#3a2a18;--navy:#8fb0ff;--sh:0 6px 24px rgba(0,0,0,.35)}
html{scroll-padding-top:env(safe-area-inset-top,0px);scroll-behavior:smooth}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--tx);font-family:'Plus Jakarta Sans',system-ui,-apple-system,'Segoe UI',sans-serif;line-height:1.55}
a{color:inherit;text-decoration:none}
button{font:inherit;cursor:pointer}
:focus-visible{outline:3px solid var(--or);outline-offset:2px}
.w{max-width:1160px;margin:0 auto;padding:0 20px}
h1,h2,h3{line-height:1.15;margin:0;letter-spacing:-.02em}
h2{font-size:clamp(1.5rem,3vw,2rem);font-weight:800;color:var(--navy)}
.sub{color:var(--mut);margin:.4rem 0 1.4rem;max-width:56ch}
section{padding:44px 0}
.btn{display:inline-flex;align-items:center;gap:8px;border:0;border-radius:14px;padding:12px 20px;font-weight:700;background:var(--or);color:#2a1600}
.btn.navy{background:var(--navy2);color:#fff}
.btn.ghost{background:transparent;border:1.5px solid var(--line);color:var(--tx)}
.btn.sm{padding:8px 14px;font-size:.88rem;border-radius:12px}
/* nav */
header{position:sticky;top:env(safe-area-inset-top,0px);z-index:20;background:color-mix(in srgb,var(--bg) 92%,transparent);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)}
.nav{display:flex;align-items:center;gap:22px;height:66px}
.logo{display:flex;align-items:center;gap:8px;font-weight:800;font-size:1.3rem;letter-spacing:.04em;color:var(--navy)}
.menu{display:flex;gap:4px;margin-left:8px}
.menu a{padding:8px 12px;border-radius:10px;font-weight:600;color:var(--mut)}
.menu a:hover,.menu a.on{color:var(--navy);background:var(--card)}
.act{margin-left:auto;display:flex;align-items:center;gap:8px}
.ib{position:relative;width:40px;height:40px;border-radius:12px;border:0;background:transparent;font-size:1.1rem}
.ib:hover{background:var(--card)}
.badge{position:absolute;top:2px;right:2px;background:var(--or);color:#2a1600;border-radius:99px;font-size:.68rem;font-weight:800;min-width:18px;height:18px;display:grid;place-items:center}
/* hero */
.hero{padding:40px 0 24px}
.hg{display:grid;grid-template-columns:1.05fr 1fr;gap:40px;align-items:center}
.hero h1{font-size:clamp(2.2rem,5.2vw,3.6rem);font-weight:800;color:var(--navy)}
.hero p{font-size:1.1rem;color:var(--mut);max-width:48ch;margin:16px 0 24px}
.sb{display:flex;gap:8px;background:var(--card);border:1.5px solid var(--line);border-radius:20px;padding:8px;box-shadow:var(--sh)}
.sb input{flex:1;min-width:0;border:0;background:transparent;font:inherit;color:var(--tx);padding:10px 12px}
.sb input:focus{outline:none}
.loc{display:inline-flex;gap:6px;margin-top:14px;font-size:.9rem;color:var(--mut);font-weight:600}
.loc i{width:8px;height:8px;border-radius:50%;background:var(--ok);align-self:center;font-style:normal}
.col{display:grid;grid-template-columns:repeat(6,1fr);grid-template-rows:repeat(6,58px);gap:12px}
.tile{border-radius:22px;display:grid;place-items:center;font-size:3rem;position:relative;overflow:hidden;box-shadow:var(--sh)}
.tile small{position:absolute;left:10px;bottom:8px;font-size:.72rem;font-weight:700;background:rgba(255,255,255,.88);color:#1b2333;border-radius:99px;padding:2px 9px}
.t1{grid-column:1/4;grid-row:1/4;background:#ffd9b0}.t2{grid-column:4/7;grid-row:1/3;background:#cfe1ff}
.t3{grid-column:4/7;grid-row:3/5;background:#ffe9a8}.t4{grid-column:1/3;grid-row:4/7;background:#d6f0dc}
.t5{grid-column:3/4;grid-row:4/7;background:#f5d2d2}.t6{grid-column:4/7;grid-row:5/7;background:var(--navy2);color:#fff;font-size:1rem;font-weight:700;padding:0 14px;text-align:center}
/* categories */
.cats{display:flex;gap:12px;overflow-x:auto;padding:4px 2px 12px;scrollbar-width:none}
.cats::-webkit-scrollbar{display:none}
.cat{flex:1 0 96px;background:var(--card);border:1px solid var(--line);border-radius:20px;padding:14px 8px;text-align:center;font-weight:700;font-size:.9rem;box-shadow:var(--sh)}
.cat:hover{border-color:var(--or)}
.cat span{display:block;font-size:1.8rem;margin-bottom:4px}
/* cards */
.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.card{background:var(--card);border:1px solid var(--line);border-radius:22px;overflow:hidden;box-shadow:var(--sh);display:flex;flex-direction:column}
.ph{aspect-ratio:4/3;display:grid;place-items:center;font-size:3.4rem;position:relative}
.cb{padding:14px 16px 16px;display:flex;flex-direction:column;gap:6px;flex:1}
.cb h3{font-size:1.02rem;color:var(--tx)}
.meta{color:var(--mut);font-size:.86rem}
.row{display:flex;justify-content:space-between;align-items:center;gap:8px;margin-top:auto;padding-top:8px}
.st{position:absolute;top:10px;left:10px;font-size:.75rem;font-weight:800;background:#fff;color:#1b2333;border-radius:99px;padding:3px 10px;display:flex;gap:6px;align-items:center}
.st b{width:8px;height:8px;border-radius:50%;background:var(--ok)}
.st.off b{background:#c0392b}
.tag{position:absolute;top:10px;right:10px;font-size:.72rem;font-weight:800;background:var(--navy2);color:#fff;border-radius:99px;padding:3px 10px}
.rt{font-weight:700;font-size:.9rem}
.price{font-weight:800;color:var(--navy);font-size:1.05rem}
.add{width:40px;height:40px;border-radius:12px;border:0;background:var(--or);color:#2a1600;font-size:1.4rem;font-weight:800}
.add:active{transform:scale(.92)}
/* gerobak */
.gero{background:var(--orsoft);border-radius:32px;padding:32px 24px;margin:0 -8px}
.gero .grid{grid-template-columns:repeat(3,1fr)}
.live{font-weight:800;color:var(--or);font-size:.86rem;display:flex;gap:6px;align-items:center}
.live i{width:9px;height:9px;border-radius:50%;background:var(--or);animation:p 1.6s infinite}
@keyframes p{50%{opacity:.3}}
@media (prefers-reduced-motion:reduce){.live i{animation:none}html{scroll-behavior:auto}}
/* pilihan */
.hs{display:flex;gap:16px;overflow-x:auto;padding:4px 2px 14px;scroll-snap-type:x mandatory}
.hc{flex:0 0 min(360px,84%);scroll-snap-align:start;display:flex;gap:14px;background:var(--card);border:1px solid var(--line);border-radius:22px;padding:12px;box-shadow:var(--sh);align-items:center}
.hc .ph{width:96px;aspect-ratio:1;border-radius:16px;font-size:2.4rem;flex:none}
/* steps */
.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;position:relative}
.stp{background:var(--card);border:1px solid var(--line);border-radius:22px;padding:22px;box-shadow:var(--sh)}
.stp .n{font-weight:800;color:var(--or);font-size:.95rem}
.stp .ic{width:52px;height:52px;border-radius:16px;background:var(--orsoft);display:grid;place-items:center;font-size:1.6rem;margin:10px 0 12px}
.stp h3{color:var(--navy);margin-bottom:4px}
.stp p{margin:0;color:var(--mut);font-size:.94rem}
/* cta */
.cta{display:grid;grid-template-columns:1fr 1fr;gap:28px;align-items:center;background:var(--navy2);color:#fff;border-radius:32px;padding:40px}
.cta h2{color:#fff}
.cta p{color:#cdd8f0;margin:12px 0 22px;max-width:46ch}
.dash{background:#fff;color:#1b2333;border-radius:22px;padding:18px;box-shadow:0 12px 32px rgba(0,0,0,.25)}
.kp{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.kp div{background:#f3f5fa;border-radius:14px;padding:12px}
.kp small{color:#667085;font-size:.76rem;display:block}
.kp b{font-size:1.2rem;color:#16294d}
.bars{display:flex;align-items:flex-end;gap:8px;height:70px;margin-top:12px}
.bars i{flex:1;background:#f28a2e;border-radius:6px 6px 0 0;opacity:.85}
.cta.alt{background:var(--card);color:var(--tx);border:1px solid var(--line);box-shadow:var(--sh)}
.cta.alt h2{color:var(--navy)}.cta.alt p{color:var(--mut)}
.pin{background:var(--orsoft);border-radius:22px;padding:22px;display:grid;gap:12px}
.pin .r{display:flex;gap:12px;align-items:center;background:var(--card);border-radius:14px;padding:10px 14px;font-weight:600;font-size:.92rem}
.pin .r small{margin-left:auto;color:var(--mut);font-weight:500}
/* footer */
footer{background:var(--navy2);color:#dbe4f7;margin-top:44px;padding:44px 0 28px}
[data-theme="dark"] footer,footer{--x:1}
.fg{display:grid;grid-template-columns:1.4fr repeat(4,1fr);gap:24px}
footer h4{margin:0 0 10px;color:#fff;font-size:.95rem}
footer a{display:block;padding:3px 0;color:#c2cfe9;font-size:.92rem}
footer a:hover{color:#fff}
.fb{margin-top:28px;padding-top:18px;border-top:1px solid rgba(255,255,255,.15);display:flex;flex-wrap:wrap;gap:16px;font-size:.86rem}
.fb span{margin-left:auto}
.bn{display:none}
/* responsive */
@media (max-width:980px){.grid{grid-template-columns:repeat(2,1fr)}.hg,.cta{grid-template-columns:1fr}.steps{grid-template-columns:repeat(2,1fr)}.fg{grid-template-columns:repeat(2,1fr)}.gero .grid{grid-template-columns:repeat(2,1fr)}.menu{display:none}}
@media (max-width:640px){
.w{padding:0 16px}section{padding:30px 0}.nav{height:58px;gap:8px}.nav .txt{display:none}
.col{grid-template-rows:repeat(6,46px);gap:8px}.tile{font-size:2.2rem;border-radius:16px}
.grid,.gero .grid{gap:12px}.gero .grid{grid-template-columns:1fr}.gero{padding:22px 14px;margin:0 -4px;border-radius:24px}
.steps{grid-template-columns:1fr}.cta{padding:26px 20px;border-radius:24px}.sb .btn{padding:10px 14px}
.cb{padding:10px 12px 12px}.ph{font-size:2.6rem}
.bn{display:grid;grid-template-columns:repeat(5,1fr);position:fixed;left:0;right:0;bottom:0;z-index:30;background:var(--card);border-top:1px solid var(--line);padding:6px 6px calc(6px + env(safe-area-inset-bottom,0px))}
.bn a{text-align:center;font-size:.7rem;font-weight:700;color:var(--mut);padding:4px 0}
.bn a span{display:block;font-size:1.25rem}
.bn a.on{color:var(--or)}
footer{padding-bottom:90px}.fb span{margin-left:0}
}
</style>
</head>
<body>
<header><div class="w nav">
 <a class="logo" href="#"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M5 27 16 5l11 22" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 21c4-5 7-1 9-3s3-3 5-4" stroke="#f28a2e" stroke-width="3.4" stroke-linecap="round"/></svg>ARUNA</a>
 <nav class="menu" aria-label="Menu utama"><a class="on" href="#">Beranda</a><a href="#sekitar">Jelajahi UMKM</a><a href="#populer">Produk</a><a href="#gerobak">Gerobak</a><a href="#cara">Pesanan</a></nav>
 <div class="act">
  <button class="ib" aria-label="Cari" onclick="document.getElementById('q').focus()">🔍</button>
  <button class="ib" aria-label="Favorit">♡</button>
  <button class="ib" aria-label="Keranjang">🛒<span class="badge" id="cnt">0</span></button>
  <a class="btn ghost sm txt" href="#">Masuk</a><a class="btn sm txt" href="#">Daftar</a>
 </div>
</div></header>

<main>
<section class="hero"><div class="w hg">
 <div>
  <h1>Temukan UMKM Lokal di Sekitarmu</h1>
  <p>Belanja produk lokal, pesan dari UMKM favorit, atau temukan gerobak yang sedang jualan di dekatmu.</p>
  <div class="sb" role="search"><input id="q" placeholder="Cari produk, UMKM, atau makanan..." aria-label="Cari produk, UMKM, atau makanan"><button class="btn">Cari Sekarang</button></div>
  <div class="loc"><i></i>📍 Menampilkan UMKM di sekitar kamu</div>
 </div>
 <div class="col" aria-hidden="true">
  <div class="tile t1">🏪<small>Warung Bu Sari</small></div>
  <div class="tile t2">🍜<small>Bakso Pak Darto</small></div>
  <div class="tile t3">🛵<small>Kurir mengantar</small></div>
  <div class="tile t4">🧺<small>Produk UMKM</small></div>
  <div class="tile t5">🥤</div>
  <div class="tile t6">Ganti dengan foto UMKM asli</div>
 </div>
</div></section>

<section style="padding-top:8px"><div class="w"><div class="cats" id="cats"></div></div></section>

<section id="sekitar"><div class="w">
 <h2>UMKM di Sekitarmu</h2><p class="sub">Temukan usaha lokal yang sedang buka dan siap melayani pesananmu.</p>
 <div class="grid" id="umkm"></div>
</div></section>

<section id="gerobak"><div class="w"><div class="gero">
 <div class="live"><i></i>Fitur khas ARUNA</div>
 <h2 style="margin-top:6px">Gerobak yang Sedang Jualan</h2><p class="sub">Cari pedagang gerobak yang sedang berjualan di sekitar lokasimu.</p>
 <div class="grid" id="gero"></div>
</div></div></section>

<section id="populer"><div class="w">
 <h2>Paling Banyak Dipesan</h2><p class="sub">Menu favorit pembeli di sekitarmu.</p>
 <div class="grid" id="prod"></div>
</div></section>

<section><div class="w">
 <h2>UMKM Pilihan ARUNA</h2><p class="sub">Usaha lokal yang sedang banyak dikunjungi pembeli.</p>
 <div class="hs" id="pil"></div>
</div></section>

<section id="cara"><div class="w">
 <h2>Cara Kerja</h2><p class="sub">Empat langkah dari mencari sampai pesanan sampai.</p>
 <div class="steps">
  <div class="stp"><span class="n">01</span><div class="ic">🔍</div><h3>Cari</h3><p>Temukan produk atau UMKM di sekitar kamu.</p></div>
  <div class="stp"><span class="n">02</span><div class="ic">🛍️</div><h3>Pesan</h3><p>Pilih produk dan lakukan pemesanan.</p></div>
  <div class="stp"><span class="n">03</span><div class="ic">💳</div><h3>Bayar</h3><p>Bayar secara digital dengan aman.</p></div>
  <div class="stp"><span class="n">04</span><div class="ic">🛵</div><h3>Terima</h3><p>Pesanan disiapkan UMKM dan diantar kurir.</p></div>
 </div>
</div></section>

<section><div class="w"><div class="cta">
 <div><h2>Usahamu Bisa Tumbuh Lebih Jauh Bersama ARUNA</h2><p>Kelola produk, pesanan, pembayaran, dan penjualan dalam satu platform.</p><a class="btn" href="#">Gabung Sebagai UMKM</a></div>
 <div class="dash" aria-label="Contoh dashboard penjual">
  <div class="kp"><div><small>Penjualan hari ini</small><b>Rp1.250.000</b></div><div><small>Pesanan baru</small><b>18</b></div><div><small>Produk terlaris</small><b>Nasi Ayam</b></div><div><small>Pendapatan bulan ini</small><b>Rp24,8 jt</b></div></div>
  <div class="bars"><i style="height:35%"></i><i style="height:52%"></i><i style="height:44%"></i><i style="height:70%"></i><i style="height:60%"></i><i style="height:88%"></i><i style="height:100%"></i></div>
 </div>
</div></div></section>

<section style="padding-top:0"><div class="w"><div class="cta alt">
 <div><h2>Jualan di Mana Saja, Tetap Ditemukan Pelanggan</h2><p>Perbarui lokasi jualanmu dan biarkan pelanggan menemukanmu saat kamu sedang berjualan.</p><a class="btn navy" href="#">Daftar sebagai UMKM Gerobak</a></div>
 <div class="pin"><div class="r">📍 Jl. Raya Darmo<small>Diperbarui 2 menit lalu</small></div><div class="r">🛑 Pindah ke Taman Bungkul<small>Perbarui lokasi</small></div><div class="r"><span class="live" style="margin:0"><i></i>Sedang Jualan</span><small>Terlihat oleh pembeli</small></div></div>
</div></div></section>
</main>

<footer><div class="w">
 <div class="fg">
  <div><div class="logo" style="color:#fff"><svg width="28" height="28" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M5 27 16 5l11 22" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 21c4-5 7-1 9-3s3-3 5-4" stroke="#f28a2e" stroke-width="3.4" stroke-linecap="round"/></svg>ARUNA</div><p style="margin:10px 0 0;font-size:.92rem">Gerakkan Usahamu, Tumbuh Bersama.</p></div>
  <div><h4>Jelajahi</h4><a href="#">UMKM Sekitar</a><a href="#">Gerobak</a><a href="#">Produk</a></div>
  <div><h4>Untuk UMKM</h4><a href="#">Gabung UMKM</a><a href="#">Daftar Gerobak</a><a href="#">Masuk Dashboard</a></div>
  <div><h4>Bantuan</h4><a href="#">FAQ</a><a href="#">Hubungi Kami</a><a href="#">Cara Pesan</a></div>
  <div><h4>Tentang ARUNA</h4><a href="#">Kisah Kami</a><a href="#">Kebijakan Privasi</a><a href="#">Syarat &amp; Ketentuan</a></div>
 </div>
 <div class="fb"><a href="#">Kebijakan Privasi</a><a href="#">Syarat &amp; Ketentuan</a><a href="#">FAQ</a><a href="#">Hubungi Kami</a><span>© 2026 ARUNA</span></div>
</div></footer>

<nav class="bn" aria-label="Navigasi bawah"><a class="on" href="#"><span>🏠</span>Beranda</a><a href="#sekitar"><span>🧭</span>Jelajahi</a><a href="#gerobak"><span>🛺</span>Gerobak</a><a href="#cara"><span>🧾</span>Pesanan</a><a href="#"><span>👤</span>Akun</a></nav>

<script>
var $=function(i){return document.getElementById(i)};
$('cats').innerHTML=[['🍜','Makanan'],['🥤','Minuman'],['🛒','Sembako'],['👕','Fashion'],['🎨','Kerajinan'],['💻','Jasa'],['➜','Lainnya']].map(function(c){return '<a class="cat" href="#"><span>'+c[0]+'</span>'+c[1]+'</a>'}).join('');
var U=[['Warung Bu Sari','Makanan','1,2 km','4,8','15 mnt','🍚','#ffd9b0',1],['Kopi Kelana','Minuman','0,8 km','4,7','10 mnt','☕','#d8e6ff',1],['Toko Sembako Makmur','Sembako','2,1 km','4,6','20 mnt','🛒','#d6f0dc',1],['Batik Ningrum','Fashion','3,4 km','4,9','—','👘','#f5d2d2',0]];
$('umkm').innerHTML=U.map(function(u){return '<article class="card"><div class="ph" style="background:'+u[6]+'">'+u[5]+'<span class="st'+(u[7]?'':' off')+'"><b></b>'+(u[7]?'Buka':'Tutup')+'</span></div><div class="cb"><h3>'+u[0]+'</h3><div class="meta">'+u[1]+' • '+u[2]+' • '+u[4]+'</div><div class="row"><span class="rt">⭐ '+u[3]+'</span><a class="btn sm navy" href="#">Lihat Toko</a></div></div></article>'}).join('');
var G=[['Bakso Pak Darto','Bakso & mie ayam','Jl. Raya Darmo','1,4 km','2 menit lalu','🍲','#ffe9a8'],['Es Dawet Mbak Rini','Minuman tradisional','Taman Bungkul','2,0 km','6 menit lalu','🥤','#d8e6ff'],['Martabak Bang Ucok','Martabak manis & telur','Jl. Ngagel','2,6 km','11 menit lalu','🥞','#f5d2d2']];
$('gero').innerHTML=G.map(function(g){return '<article class="card"><div class="ph" style="background:'+g[6]+'">'+g[5]+'<span class="tag">Gerobak</span></div><div class="cb"><span class="live"><i></i>Sedang Jualan</span><h3>'+g[0]+'</h3><div class="meta">'+g[1]+'</div><div class="meta">📍 '+g[2]+' • '+g[3]+'</div><div class="meta">Lokasi diperbarui '+g[4]+'</div><div class="row"><span></span><a class="btn sm" href="#">Lihat Lokasi</a></div></div></article>'}).join('');
var P=[['Nasi Ayam','Warung Bu Sari','Rp15.000','4,9','🍗','#ffd9b0'],['Es Kopi Susu','Kopi Kelana','Rp18.000','4,8','🧋','#d8e6ff'],['Tempe Mendoan (5)','Dapur Ibu Wati','Rp10.000','4,7','🥟','#d6f0dc'],['Sambal Bawang 200g','Sambal Nusantara','Rp22.000','4,9','🌶️','#f5d2d2']];
$('prod').innerHTML=P.map(function(p){return '<article class="card"><div class="ph" style="background:'+p[5]+'">'+p[4]+'</div><div class="cb"><h3>'+p[0]+'</h3><div class="meta">'+p[1]+'</div><div class="row"><div><div class="price">'+p[2]+'</div><span class="rt">⭐ '+p[3]+'</span></div><button class="add" aria-label="Tambah '+p[0]+' ke keranjang">+</button></div></div></article>'}).join('');
var H=[['Dapur Ibu Wati','Makanan','4,9','Sidoarjo','🥘','#ffe9a8'],['Kerajinan Anyam Lestari','Kerajinan','4,8','Surabaya Timur','🧺','#d6f0dc'],['Jahit Cepat Pak Yanto','Jasa','4,8','Wonokromo','🧵','#d8e6ff'],['Sambal Nusantara','Makanan','4,9','Gubeng','🌶️','#f5d2d2']];
$('pil').innerHTML=H.map(function(h){return '<a class="hc" href="#"><div class="ph" style="background:'+h[5]+'">'+h[4]+'</div><div><h3>'+h[0]+'</h3><div class="meta">'+h[1]+' • '+h[3]+'</div><span class="rt">⭐ '+h[2]+'</span></div></a>'}).join('');
var n=0;document.addEventListener('click',function(e){if(e.target.classList.contains('add')){n++;$('cnt').textContent=n}});
</script>
</body>
</html>
