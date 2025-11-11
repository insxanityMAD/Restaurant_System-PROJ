<?php 


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title></title>
 <style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    background: linear-gradient(to bottom right, #f8e7c1, #f6d6aa);
    font-family: 'Poppins', sans-serif;
    color: #111;
    min-height: 100vh;
  }

  .container {
    width: 100%;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 28px;
    padding: 22px;
    background: rgba(255,255,255,0.85);
    border: 8px solid rgba(0,0,0,0.85);
  }

  .box1 {
    width: 100%;
    display:flex;
    justify-content:center;
    align-items:center;
    padding: 6px 0 2px;
  }

  .logo img { max-height: 100px; width: auto; }

  .box2 {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 25px;
    align-items: start;
    padding: 10px 20px;
  }

  /* --- Card / dish styling: translucent "paper" with blur --- */
.dish {
  background: rgba(255, 250, 245, 0.75); /* soft cream */
  border: 1px solid rgba(20, 20, 20, 0.08);
  backdrop-filter: blur(6px) saturate(1.05);
  -webkit-backdrop-filter: blur(6px);
  padding: 18px;
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 12px;
  border-radius: 14px;
  box-shadow: 0 8px 20px rgba(20, 20, 20, 0.08);
  transition: transform .35s ease, box-shadow .35s ease;
  color: #2b2b2b; /* dark text for contrast */
  font-size: clamp(14px, 2.2vw, 18px); /* reasonable scaling */
}

/* image with contained aspect and rounded corners */
.dish img {
  width: 100%;
  height: auto;
  max-height: 420px; /* prevents enormous image on zoom */
  object-fit: cover;
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.06);
  background: linear-gradient(180deg, rgba(255,255,255,0.6), rgba(240,240,240,0.6));
}

/* subtle hover lift */
.dish:hover {
  transform: translateY(-12px);
  box-shadow: 0 18px 40px rgba(10,10,10,0.12);
}

/* meta row: title left / price right */
.dish .meta {
  display:flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  font-weight: 700;
  font-size: clamp(16px, 2.6vw, 24px);
  color: #1f1f1f;
}

/* price badge — warm accent with subtle shadow */
.dish .price {
  background: linear-gradient(180deg, #ffbf4d, #ff9b00);
  color: #fff;
  padding: 6px 12px;
  border-radius: 999px;
  font-weight: 800;
  box-shadow: 0 6px 12px rgba(255,160,0,0.18);
  white-space: nowrap;
  font-size: clamp(14px, 2.2vw, 18px);
}

/* Quantity controls — smaller, compact, consistent sizing */
.qty-controls {
  display:flex;
  gap: 8px;
  align-items:center;
  justify-content:flex-start;
  margin-top: 8px;
}

.qty-controls button {
  width: 44px;
  height: 44px;
  border-radius: 8px;
  border: 1px solid rgba(0,0,0,0.08);
  background: rgba(255,255,255,0.9);
  cursor: pointer;
  font-size: 22px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform .12s ease, background .12s ease;
}

.qty-controls button:hover { transform: translateY(-2px); background: rgba(255,235,200,0.95); }

.qty-num {
  width: 36px;
  text-align: center;
  font-weight: 700;
  font-size: 18px;
  color: #222;
}

/* totals panel — darker translucent block for contrast */
.box3 {
  width: 100%;
  max-width: 420px;
  background: rgba(18, 18, 18, 0.55); /* dark translucent */
  color: #fff;
  padding: 18px;
  border-radius: 14px;
  display: flex;
  flex-direction: column;
  gap: 12px;
  align-self: flex-end;
  box-shadow: 0 18px 40px rgba(0,0,0,0.4);
  border: 1px solid rgba(255,255,255,0.06);
}

/* totals text */
.totals div { font-size: clamp(14px, 2.2vw, 18px); }
#totalPrice { font-size: clamp(18px, 2.8vw, 22px); font-weight: 900; }

/* checkout buttons: full width stacking on small screens */
.checkout {
  display:flex;
  gap: 10px;
  align-items: center;
  justify-content: space-between;
  margin-top: 6px;
}

.checkout button {
  background: #ffae00;
  color: white;
  border: none;
  padding: 10px 14px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 700;
  box-shadow: 0 6px 14px rgba(255,174,0,0.16);
}

#clearBtn { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,0.14); box-shadow: none; }

/* make layout responsive and avoid huge fonts when zoomed out */
@media (max-width: 900px) {
  .box2 { gap: 14px; flex-direction: column; }
  .dish img { max-height: 260px; }
  .box3 { width: 100%; max-width: none; align-self: stretch; }
}

  
</style>


</head>
<body>
  <div class="container">
    <div class="box1">
      <div class="logo">
        <img src="ChatGPT Image Sep 20, 2025, 02_28_43 AM.png" alt="Logo">
      </div>
    </div>

    <div class="box2" id="menu">
    
      <div class="dish" data-id="1" data-price="180.00">
        <img src="vegan-kare-kare-removebg-preview.png">
        <div>

          <div class="meta">
          Vegan Kare-Kare
            <div class="price">₱180.00</div>
          </div>

          <p>Rich peanut sauce, veggies, plant-based goodness.</p>
        </div>
        <div class="qty-controls" aria-label="Quantity controls for Vegan Kare-Kare">
          <button class="qty-decrease" aria-label="Decrease quantity">−</button>
          <div class="qty-num" role="status" aria-live="polite">0</div>
          <button class="qty-increase" aria-label="Increase quantity">+</button>
        </div>
      </div>

      <div class="dish" data-id="2" data-price="150.00">
        <img src="spicy-minced-meat-made-from-raw-meat.png" alt="Spicy Minced Meat">
        <div>
          <div class="meta">
            SISIG
            <div class="price">₱150.00</div>
          </div>
          <p>Spicy, savory — pairs great with rice.</p>
        </div>
        <div class="qty-controls" aria-label="Quantity controls for Spicy Minced Meat">
          <button class="qty-decrease">−</button>
          <div class="qty-num" role="status" aria-live="polite">0</div>
          <button class="qty-increase">+</button>
        </div>
      </div>

      <div class="dish" data-id="3" data-price="220.50">
        <img src="Bulalo-removebg-preview.png" alt="Bulalo">
        <div>
          <div class="meta">
            Bulalo
            <div class="price">₱220.50</div>
          </div>
          <p>Beefy bone marrow soup — classic comfort.</p>
        </div>
        <div class="qty-controls" aria-label="Quantity controls for Bulalo">
          <button class="qty-decrease">−</button>
          <div class="qty-num" role="status" aria-live="polite">0</div>
          <button class="qty-increase">+</button>
        </div>
      </div>

      <div class="dish" data-id="4" data-price="175.25">
        <img src="FiestaCebuLiempo_512x512.webp" alt="Liempo">
        <div>
          <div class="meta">
            Fiesta Liempo
            <div class="price">₱175.25</div>
          </div>
          <p>Juicy grilled pork belly with herbs.</p>
        </div>
        <div class="qty-controls" aria-label="Quantity controls for Fiesta Liempo">
          <button class="qty-decrease">−</button>
          <div class="qty-num" role="status" aria-live="polite">0</div>
          <button class="qty-increase">+</button>
        </div>
      </div>
     
    </div>

    <div class="box3">
      <div class="totals">
        <div>Total items: <span id="totalQty">0</span></div>
        <div>Total price: <strong id="totalPrice">₱0.00</strong></div>
      </div>

      <div class="checkout">
        <button id="clearBtn" type="button">Clear</button>
        <button id="orderBtn" type="button">Place Order</button>
      </div>
    </div>
  </div>

  <script>
    // Utility helpers
    const formatCurrency = (num) => {
      // ensure number -> string currency with two decimals and php symbol
      return '₱' + Number(num).toFixed(2);
    };

    const menuEl = document.getElementById('menu');
    const totalQtyEl = document.getElementById('totalQty');
    const totalPriceEl = document.getElementById('totalPrice');
    const clearBtn = document.getElementById('clearBtn');
    const orderBtn = document.getElementById('orderBtn');

    // initialize state from DOM (each .dish has data-price)
    const dishes = Array.from(menuEl.querySelectorAll('.dish')).map(dishEl => {
      const id = dishEl.dataset.id;
      const price = parseFloat(dishEl.dataset.price) || 0;
      const qtyEl = dishEl.querySelector('.qty-num');
      return { id, price, el: dishEl, qtyEl, qty: 0 };
    });

    // update totals based on dish states
    function updateTotals() {
      let totalQty = 0;
      let totalPrice = 0;
      dishes.forEach(d => {
        totalQty += d.qty;
        totalPrice += d.qty * d.price;
      });
      totalQtyEl.textContent = totalQty;
      totalPriceEl.textContent = formatCurrency(totalPrice);
    }

    // function to set quantity on a dish with clamps
    function setDishQty(dish, newQty) {
      // ensure integer and non-negative
      const qty = Math.max(0, Math.floor(newQty));
      dish.qty = qty;
      dish.qtyEl.textContent = qty;
      updateTotals();
    }

    // attach event listeners for each dish's +/- buttons
    dishes.forEach(dish => {
      const incBtn = dish.el.querySelector('.qty-increase');
      const decBtn = dish.el.querySelector('.qty-decrease');

      incBtn.addEventListener('click', () => setDishQty(dish, dish.qty + 1));
      decBtn.addEventListener('click', () => setDishQty(dish, dish.qty - 1));
    });

    // Clear button: reset all quantities
    clearBtn.addEventListener('click', () => {
      dishes.forEach(d => setDishQty(d, 0));
    });

    // Place order: simple demo action — show summary alert
    orderBtn.addEventListener('click', () => {
      const itemsOrdered = dishes.filter(d => d.qty > 0);
      if (itemsOrdered.length === 0) {
        alert('Your cart is empty. Please add at least one item.');
        return;
      }
      let summary = 'Order summary:\n\n';
      let grand = 0;
      itemsOrdered.forEach(d => {
        const lineTotal = d.qty * d.price;
        grand += lineTotal;
        summary += `${d.el.querySelector('h3').textContent} — ${d.qty} x ${formatCurrency(d.price)} = ${formatCurrency(lineTotal)}\n`;
      });
      summary += `\nTotal items: ${itemsOrdered.reduce((s, d) => s + d.qty, 0)}`;
      summary += `\nTotal price: ${formatCurrency(grand)}`;
      // In a real app you'd send this to the server — here we just show it
      alert(summary);
    });

    // initialize UI (all qty = 0)
    updateTotals();
  </script>
</body>
</html>