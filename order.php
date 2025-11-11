<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Your Order</title>
  <style>
    /* Minimal page styling so this page looks OK. This does NOT touch your original file. */
    body{font-family: Arial, Helvetica, sans-serif; background: #fafafa; margin: 0; padding: 20px; color:#111}
    .card{max-width:980px;margin:30px auto;background:#fff;padding:18px;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.08)}
    h1{margin:0 0 12px 0}
    .item{display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #eee}
    .item .left{max-width:75%}
    .controls{display:flex;gap:12px;justify-content:flex-end;margin-top:18px}
    button{padding:10px 14px;border-radius:8px;border:0;cursor:pointer}
    .primary{background:#ffae00;color:#fff}
    .muted{background:#ddd}
    .danger{background:#d9534f;color:#fff}
    .empty{padding:28px;text-align:center;color:#666}
    .small{font-size:0.9rem;color:#555}
  </style>
</head>
<body>
  <div class="card">
    <h1>Your Order</h1>
    <div id="orderList"></div>
    <div id="summary" style="margin-top:14px;font-weight:700"></div>

    <div class="controls">
      <button id="backBtn" class="muted">Go back &amp; edit</button>
      <button id="clearOrderBtn" class="danger">Clear order</button>
      <button id="checkoutBtn" class="primary">Checkout</button>
    </div>
    <div style="margin-top:10px" class="small">Note: this is a demo — Checkout will just simulate placing the order and clear the cart.</div>
  </div>

  <script>
    const orderList = document.getElementById('orderList');
    const summaryEl = document.getElementById('summary');
    const backBtn = document.getElementById('backBtn');
    const clearOrderBtn = document.getElementById('clearOrderBtn');
    const checkoutBtn = document.getElementById('checkoutBtn');

    function loadCart() {
      try {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        return Array.isArray(cart) ? cart : [];
      } catch (e) {
        return [];
      }
    }

    function formatCurrency(n){ return '₱' + Number(n || 0).toFixed(2); }

    function render() {
      const items = loadCart();
      orderList.innerHTML = '';
      if (!items.length) {
        orderList.innerHTML = '<div class="empty">Your cart is empty.</div>';
        summaryEl.textContent = '';
        checkoutBtn.disabled = true;
        clearOrderBtn.disabled = true;
        return;
      }
      checkoutBtn.disabled = false;
      clearOrderBtn.disabled = false;

      let totalQty = 0;
      let totalPrice = 0;

      items.forEach(it => {
        const lineTotal = it.qty * it.price;
        totalQty += it.qty;
        totalPrice += lineTotal;

        const row = document.createElement('div');
        row.className = 'item';
        row.innerHTML = `<div class="left">
                           <div style="font-weight:700">${it.name}</div>
                           <div class="small">${it.qty} x ${formatCurrency(it.price)}</div>
                         </div>
                         <div style="text-align:right">${formatCurrency(lineTotal)}</div>`;
        orderList.appendChild(row);
      });

      summaryEl.textContent = `Total items: ${totalQty}   •   Total price: ${formatCurrency(totalPrice)}`;
    }

    backBtn.addEventListener('click', () => {
      
      window.location.href = document.referrer || 'menu.html';
    });

    clearOrderBtn.addEventListener('click', () => {
      if (!confirm('Clear your saved order?')) return;
      localStorage.removeItem('cart');
      render();
    });

    checkoutBtn.addEventListener('click', () => {
      const items = loadCart();
      if (!items.length) { alert('Cart empty'); return; }
     
      alert('Order placed! Thank you.\n\n' + items.map(i => `${i.name} x ${i.qty}`).join('\n'));
      localStorage.removeItem('cart');
      render();
      
    });

    render();
  </script>
</body>
</html>
