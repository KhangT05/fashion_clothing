document.addEventListener('DOMContentLoaded', function () {
    // ========== HÀM LOAD GIỎ HÀNG ==========
    function loadCartSummary() {
        fetch('/gio-hang/summary')
            .then(response => response.json())
            .then(data => {
                // Kiểm tra phản hồi từ server
                const cartData = data.original || data;
                const totalQuantity = cartData.totalQuantity || 0;
                const totalAmount = cartData.totalAmount || 0;

                // Cập nhật badge số lượng
                updateBadge(totalQuantity);

                // Cập nhật tổng tiền
                updateTotalAmount(totalAmount);
            })
            .catch(error => console.error('Error loading cart:', error));
    }

    // ========== HÀM CẬP NHẬT BADGE ==========
    function updateBadge(quantity) {
        // Cập nhật tất cả badge
        const badges = document.querySelectorAll('[data-cart-badge]');
        badges.forEach(badge => {
            badge.textContent = quantity;
            badge.style.display = quantity > 0 ? 'flex' : 'none';
        });

        // Legacy: ID-based (nếu còn sử dụng)
        const legacyBadge = document.getElementById('cart-quantity-badge');
        if (legacyBadge) {
            legacyBadge.textContent = quantity;
            legacyBadge.style.display = quantity > 0 ? 'flex' : 'none';
        }
    }

    // ========== HÀM CẬP NHẬT TỔNG TIỀN ==========
    function updateTotalAmount(amount) {
        const formattedAmount = new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';

        // Cập nhật tất cả phần tử tổng tiền
        const totalElements = document.querySelectorAll('[data-cart-total]');
        totalElements.forEach(el => {
            el.textContent = formattedAmount;
        });

        // Legacy: ID-based (nếu còn sử dụng)
        const legacyTotal = document.getElementById('cart-total-text');
        if (legacyTotal) {
            legacyTotal.textContent = formattedAmount;
        }

        const miniTotal = document.getElementById('mini-cart-total');
        if (miniTotal) {
            miniTotal.textContent = formattedAmount;
        }
    }

    // ========== DROPDOWN HOVER EFFECT ==========
    const cartWidget = document.querySelector('.cart-widget');
    const cartDropdown = document.querySelector('.cart-dropdown');

    if (cartWidget && cartDropdown) {
        cartWidget.addEventListener('mouseenter', function () {
            cartDropdown.classList.remove('hidden');
        });

        cartWidget.addEventListener('mouseleave', function () {
            cartDropdown.classList.add('hidden');
        });
    }

    // ========== LOAD GIỎ HÀNG LẦN ĐẦU ==========
    loadCartSummary();

    // ========== LẮNG NGHE SỰ KIỆN CẬP NHẬT GIỎ ==========
    window.addEventListener('cartUpdated', function () {
        loadCartSummary();
    });

    // ========== HÀM DISPATCH SỰ KIỆN ==========
    window.updateCartDisplay = function () {
        window.dispatchEvent(new Event('cartUpdated'));
    };
});

// ========== HÀM THÊM VÀO GIỎ HÀNG ==========
function addToCart(productId, quantity = 1) {
    fetch('/gio-hang/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.updateCartDisplay();
                showNotification('Đã thêm vào giỏ hàng', 'success');
            } else {
                showNotification(data.message || 'Lỗi khi thêm vào giỏ hàng', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Lỗi khi thêm vào giỏ hàng', 'error');
        });
}

// ========== HÀM XÓA KHỎI GIỎ HÀNG ==========
function removeFromCart(cartId) {
    if (!confirm('Bạn chắc chắn muốn xóa sản phẩm này?')) return;

    fetch(`/gio-hang/remove/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.updateCartDisplay();
                showNotification('Đã xóa khỏi giỏ hàng', 'success');
            } else {
                showNotification(data.message || 'Lỗi khi xóa sản phẩm', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Lỗi khi xóa sản phẩm', 'error');
        });
}

// ========== HÀM HIỂN THỊ THÔNG BÁO ==========
function showNotification(message, type = 'success', duration = 3000) {
    let container = document.getElementById('notification-container');

    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        `;
        document.body.appendChild(container);
    }

    const notification = document.createElement('div');
    notification.style.cssText = `
        padding: 12px 16px;
        margin-bottom: 10px;
        border-radius: 6px;
        color: white;
        font-weight: 500;
        animation: slideIn 0.3s ease-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    `;

    const colors = {
        success: '#10b981',
        error: '#ef4444',
        warning: '#f59e0b',
        info: '#3b82f6'
    };

    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    container.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}