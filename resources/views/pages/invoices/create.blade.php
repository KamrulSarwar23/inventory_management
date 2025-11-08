@extends("layouts.master")

@section("page")

<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;

$customers = Customer::all();
$products = Product::all();
$invoicesCount = Invoice::count();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<style>
    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100%;
        background: #f4f6f8;
        overflow-x: hidden;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
            Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        color: #1d1d1f;
    }

    .invoice-box {
        background: #fff;
        max-width: 1100px;
        width: 98%;
        min-height: 100vh;
        padding: 50px 60px;
        margin: 40px auto;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        display: flex;
        flex-direction: column;
    }

    .invoice-header {
        background: linear-gradient(135deg, #2c3e50, #4ca1af);
        padding: 20px 30px;
        border-radius: 12px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;

    }

    .invoice-header h4 {
        font-weight: 700;
        font-size: 1.6rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        letter-spacing: 0.05em;
        user-select: none;
    }

    .invoice-header .apple-icon {
        color: #0071e3;
        font-size: 1.6rem;
    }

    .invoice-date {
        font-weight: bold;
        font-size: 1rem;
        color: white;
        user-select: none;
    }

    h1 {
        text-align: center;
        font-weight: 800;
        font-size: 3rem;
        color: #0f2943;
        letter-spacing: 2px;
        margin-bottom: 20px;
    }

    .company-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 45px;
        font-size: 1rem;
        color: #0f2943;
        line-height: 1.6;
    }

    .company-details>div {
        max-width: 48%;
    }

    select#customer {
        padding: 8px 12px;
        font-size: 1rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        width: 100%;
        max-width: 300px;
        margin-top: 6px;
        transition: border-color 0.3s ease;
    }

    select#customer:focus {
        border-color: #0071e3;
        outline: none;
    }

    .invoice-info {
        margin-bottom: 40px;
        font-size: 1rem;
        color: #0f2943;
        letter-spacing: 0.02em;
    }

    .invoice-info p {
        margin: 6px 0;
    }

    table.items {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
        margin-bottom: 40px;
        font-size: 1rem;
    }

    table.items th {
        text-align: left;
        padding: 12px 15px;
        font-weight: 700;
        background: #519787;
        color: #444;
        border-radius: 10px 10px 0 0;
    }

    table.items td {
        background: #fafafa;
        padding: 14px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e0e0e5;
        border-left: 1px solid #e0e0e5;
        border-right: 1px solid #e0e0e5;
    }

    table.items tr:last-child td {
        border-radius: 0 0 10px 10px;
        border-bottom: none;
    }

    table.items tr:hover td {
        background: #e9f0fb;
    }

    input[type="text"],
    select#item {
        width: 100%;
        padding: 8px 10px;
        font-size: 1rem;
        border: 1.5px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    select#item:focus {
        border-color: #0071e3;
        outline: none;
    }

    input[type="button"]#add {
        background-color: rgb(0, 227, 170);
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        padding: 10px 22px;
        font-size: 1rem;
        transition: background-color 0.25s ease;
        box-shadow: 0 3px 7px rgba(0, 113, 227, 0.35);
    }

    input[type="button"]#add:hover {
        background-color: #005bb5;
    }

    .total {
        text-align: right;
        font-size: 1.15rem;
        margin-bottom: 40px;
        color: #222;
    }

    .total p {
        margin: 8px 0;
    }

    .total strong {
        display: inline-block;
        width: 130px;
    }

    .notes {
        font-size: 1rem;
        color: #0f2943;
        border-top: 1px solid #ddd;
        padding-top: 20px;
        margin-top: 30px;
        font-style: italic;
    }

    input#save {
        background-color: rgb(1, 37, 10);
        color: white;
        font-weight: 700;
        padding: 12px 35px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 1.15rem;
        transition: background-color 0.3s ease;
        display: block;
        margin: 0 0 40px auto;
        /* Align right */
        width: 180px;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }

    input#save:hover {
        background-color: #1e7e34;
    }

    @media (max-width: 768px) {
        .company-details {
            flex-direction: column;
            gap: 25px;
        }

        .company-details>div {
            max-width: 100%;
        }

        .invoice-box {
            padding: 30px 20px;
            width: 95%;
            min-height: auto;
        }

        h1 {
            font-size: 2.2rem;
        }

        table.items th,
        table.items td {
            font-size: 0.9rem;
            padding: 10px 12px;
        }
    }
</style>

<div class="invoice-box">
    <div class="invoice-header">
        <h4><i class="fa-brands fa-rebel"></i> Coder Shop</h4>
        <span class="invoice-date">{{ now()->format('d M Y') }}</span>
    </div>

    <h1>INVOICE</h1>

    <div class="company-details">
        <div>
            <strong>From:</strong><br>
            Coder Shop <br>
            1234 Business Ave, Dhaka, Bangladesh<br>
            Email: codershop@gmail.com
        </div>
        <div>
            <strong>To:</strong><br>
            <select id="customer">
                <option value="">-- Select Customer --</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                    data-address="{{ $customer->address }}"
                    data-email="{{ $customer->email }}">
                    {{ $customer->name }}
                </option>
                @endforeach
            </select><br><br>

            <span id="customer-address">[Address will appear here]</span><br>
            Email: <span id="customer-email">[Email will appear here]</span>
        </div>

    </div>

    <div class="invoice-info">
        <p><strong>Invoice #:</strong> INV-{{ str_pad($invoicesCount + 1, 4, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Date:</strong> {{ now()->format('d-M-Y') }}</p>
        <p><strong>Due Date:</strong> {{ now()->addDays(7)->format('d-M-Y') }}</p>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            <tr>
                <th>#</th>
                <th>
                    <select id="item">
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price ?? '' }}">
                            {{ $product->name }}
                        </option>
                        @endforeach
                    </select>
                </th>
                <th><input type="text" id="qty" /></th>
                <th><input type="text" id="price" /></th>
                <th><input type="button" id="add" value="Add" /></th>
            </tr>
        </thead>
        <tbody id="cart"></tbody>
    </table>

    <div class="total">
        <p><strong>Subtotal:</strong> <span id="subtotal">$0.00</span></p>
        <p><strong>Tax (5%):</strong> <span id="tax">$0.00</span></p>
        <p><strong>Total:</strong> <span id="grand-total">$0.00</span></p>
    </div>

    <div>
        <input class="btn btn-primary" type="button" value="Save Invoice" id="save" />
    </div>

    <div class="notes">
        <p><strong>Note:</strong> Thank you for your business. Please make the payment by the due date.</p>
    </div>
</div>

<script>

    // When customer is selected, show their address and email
    document.getElementById('customer').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const address = selected.getAttribute('data-address') || 'N/A';
        const email = selected.getAttribute('data-email') || 'N/A';

        document.getElementById('customer-address').innerText = address;
        document.getElementById('customer-email').innerText = email;
    });


    const base_url ="http://127.0.0.1:8000/api";
    let items = [];

    document.getElementById('add').addEventListener('click', () => {
        const el = document.getElementById('item');
        const product_id = el.value;
        const product_name = el.options[el.selectedIndex].text;
        const qty = document.getElementById('qty').value;
        const price = document.getElementById('price').value;

        if (!product_id) {
            alert("Please select a product.");
            return;
        }

        if (!qty || !price || isNaN(qty) || isNaN(price) || qty <= 0 || price <= 0) {
            alert("Please enter valid quantity and price.");
            return;
        }

        const json = {
            id: Number(product_id),
            name: product_name,
            qty: Number(qty),
            price: Number(price),
            vat: 0,
            discount: 0
        };

        items.push(json);
        printCart();

        document.getElementById('qty').value = '';
        document.getElementById('price').value = '';
    });

    function printCart() {
        const cart = document.getElementById('cart');
        let html = '';
        let invoice_total = 0;

        items.forEach((item, index) => {
            const line_total = item.qty * item.price;
            invoice_total += line_total;
            html += `<tr>
        <td>${index + 1}</td>
        <td>${item.name}</td>
        <td>${item.qty}</td>
        <td>$${item.price.toFixed(2)}</td>
        <td>$${line_total.toFixed(2)}</td>
      </tr>`;
        });

        const tax = invoice_total * 0.05; // 5% tax
        const grandTotal = invoice_total + tax;

        cart.innerHTML = html;
        document.getElementById('subtotal').innerText = `$${invoice_total.toFixed(2)}`;
        document.getElementById('tax').innerText = `$${tax.toFixed(2)}`;
        document.getElementById('grand-total').innerText = `$${grandTotal.toFixed(2)}`;
    }

    document.getElementById('save').addEventListener('click', async () => {
        if (items.length === 0) {
            alert("Add at least one item to save the invoice.");
            return;
        }

        const customer_id = document.getElementById('customer').value;
        if (!customer_id) {
            alert("Please select a customer.");
            return;
        }

        if (!confirm("Are you sure you want to submit this invoice?")) {
            return;
        }

        const subtotalText = document.getElementById('subtotal').innerText.replace('$', '');
        const invoice_total = parseFloat(subtotalText);

        const payload = {
            customer_id: Number(customer_id),
            invoice_total: invoice_total,
            paid_total: invoice_total,
            discount: 0,
            remark: "N/A",
            shipping_address: "N/A",
            items: items
        };

        console.log("Payload being sent:", payload);

        try {
            const response = await fetch(`${base_url}/invoices`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (!response.ok) {
                console.error("Server response error:", data);
                alert("Error saving invoice: " + (data.message || JSON.stringify(data)));
                return;
            }

            console.log("Success response:", data);
            alert("Invoice submitted successfully!");

            // Reset
            items = [];
            printCart();
            document.getElementById('customer').value = "";
        } catch (error) {
            console.error("Error in fetch:", error);
            alert("Failed to save. Error: " + error.message);
        }
    });
</script>

@endsection