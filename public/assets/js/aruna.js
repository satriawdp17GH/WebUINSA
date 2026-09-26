/* ARUNA — public/assets/js/aruna.js
 * Dimuat dengan `defer` SEBELUM Alpine. Isi: store Alpine (keranjang, favorit, toast)
 * + efek scroll (reveal, count-up) + parallax kolase hero. */

(function () {
  var CART_KEY = 'aruna_cart_v1';
  var FAV_KEY = 'aruna_fav_v1';

  function read(key, fallback) {
    try { var v = JSON.parse(localStorage.getItem(key)); return v == null ? fallback : v; }
    catch (e) { return fallback; }
  }
  function write(key, value) {
    try { localStorage.setItem(key, JSON.stringify(value)); } catch (e) { /* mode privat / penuh */ }
  }

  document.addEventListener('alpine:init', function () {
    /* ---------- Toast ---------- */
    Alpine.store('toast', {
      on: false, msg: '', _t: null,
      show: function (msg) {
        var s = this;
        s.msg = msg; s.on = true;
        clearTimeout(s._t);
        s._t = setTimeout(function () { s.on = false; }, 2200);
      }
    });

    /* ---------- Keranjang ----------
     * Sekarang disimpan di localStorage. Saat API siap, ganti isi add/inc/dec/remove/clear
     * dengan fetch() ke /api/v1/cart (sertakan header CSRF dari <meta name="csrf-token">)
     * dan isi `items` dari GET /api/v1/cart. Aturan: 1 keranjang = 1 UMKM. */
    Alpine.store('cart', {
      items: read(CART_KEY, []),
      open: false,
      conflict: null,

      get count() { return this.items.reduce(function (a, i) { return a + i.qty; }, 0); },
      get total() { return this.items.reduce(function (a, i) { return a + i.qty * i.price; }, 0); },
      get merchant() { return this.items.length ? this.items[0].merchant : ''; },

      rp: function (n) { return 'Rp' + Number(n).toLocaleString('id-ID'); },
      save: function () { write(CART_KEY, this.items); },

      add: function (p) {
        if (this.items.length && this.items[0].merchantId !== p.merchantId) {
          this.conflict = p; this.open = true; return;
        }
        var found = this.items.find(function (i) { return i.id === p.id; });
        if (found) { found.qty++; } else { this.items.push(Object.assign({}, p, { qty: 1 })); }
        this.save();
        Alpine.store('toast').show(p.name + ' masuk keranjang');
      },
      replaceWith: function () {
        var p = this.conflict;
        this.items = [Object.assign({}, p, { qty: 1 })];
        this.conflict = null; this.save();
        Alpine.store('toast').show(p.name + ' masuk keranjang');
      },
      keep: function () { this.conflict = null; },
      inc: function (id) {
        var it = this.items.find(function (i) { return i.id === id; });
        if (it && it.qty < 99) { it.qty++; this.save(); }
      },
      dec: function (id) {
        var it = this.items.find(function (i) { return i.id === id; });
        if (!it) return;
        if (it.qty > 1) { it.qty--; } else { this.remove(id); return; }
        this.save();
      },
      remove: function (id) {
        this.items = this.items.filter(function (i) { return i.id !== id; });
        this.save();
      },
      clear: function () { this.items = []; this.conflict = null; this.save(); }
    });

    /* ---------- Favorit (id UMKM) ----------
     * Untuk pengguna login, sinkronkan ke POST /api/v1/favorites/{id}. */
    Alpine.store('fav', {
      ids: read(FAV_KEY, []),
      get count() { return this.ids.length; },
      has: function (id) { return this.ids.indexOf(id) !== -1; },
      toggle: function (id) {
        if (this.has(id)) {
          this.ids = this.ids.filter(function (x) { return x !== id; });
          Alpine.store('toast').show('Dihapus dari favorit');
        } else {
          this.ids.push(id);
          Alpine.store('toast').show('Disimpan ke favorit');
        }
        write(FAV_KEY, this.ids);
      }
    });

    // Sinkron antar tab
    window.addEventListener('storage', function (e) {
      if (e.key === CART_KEY) Alpine.store('cart').items = read(CART_KEY, []);
      if (e.key === FAV_KEY) Alpine.store('fav').ids = read(FAV_KEY, []);
    });
  });

  /* ---------- Efek scroll & hero ---------- */
  var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;

  function ready(fn) {
    if (document.readyState !== 'loading') fn(); else document.addEventListener('DOMContentLoaded', fn);
  }

  function countUp(el) {
    var target = parseFloat(el.dataset.count);
    var prefix = el.dataset.prefix || '';
    if (reduce || isNaN(target)) return;
    var start = null, dur = 1300;
    function frame(ts) {
      if (start === null) start = ts;
      var p = Math.min((ts - start) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = prefix + Math.round(target * eased).toLocaleString('id-ID');
      if (p < 1) requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
  }

  ready(function () {
    var els = [].slice.call(document.querySelectorAll('[data-reveal],[data-in]'));

    if (!('IntersectionObserver' in window) || reduce) {
      els.forEach(function (el) { el.classList.add('in'); });
    } else {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (!en.isIntersecting) return;
          en.target.classList.add('in');
          [].forEach.call(en.target.querySelectorAll('[data-count]'), countUp);
          io.unobserve(en.target);
        });
      }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
      els.forEach(function (el) { io.observe(el); });
    }

    // Parallax ringan pada kolase hero (hanya perangkat dengan mouse)
    var hero = document.getElementById('hero');
    var col = document.getElementById('collage');
    if (hero && col && !reduce && matchMedia('(hover: hover)').matches) {
      var raf = null;
      hero.addEventListener('pointermove', function (e) {
        if (raf) return;
        raf = requestAnimationFrame(function () {
          var r = hero.getBoundingClientRect();
          col.style.setProperty('--mx', ((e.clientX - r.left) / r.width - 0.5) * 2);
          col.style.setProperty('--my', ((e.clientY - r.top) / r.height - 0.5) * 2);
          raf = null;
        });
      });
      hero.addEventListener('pointerleave', function () {
        col.style.setProperty('--mx', 0); col.style.setProperty('--my', 0);
      });
    }
  });
})();
