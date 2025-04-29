document.addEventListener('DOMContentLoaded', () => {
    const categories = document.querySelectorAll('.category');

    categories.forEach(category => {
        category.addEventListener('click', () => {
            // Remove active class from all categories and sectors
            categories.forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.category-sector').forEach(sector => {
                sector.classList.remove('active');
            });

            // Add active class to clicked category and its corresponding sector
            category.classList.add('active');
            const categoryId = category.dataset.category;
            document.querySelector(`.category-sector[data-category="${categoryId}"]`).classList.add('active');
        });
    });

    // Size indicator and counter functionality
    const sizeIndicators = document.querySelectorAll('.size-indicator');
    
    sizeIndicators.forEach(indicator => {
        indicator.addEventListener('click', () => {
            const menuCard = indicator.closest('.menu-card');
            const size = indicator.textContent.toLowerCase(); // 'l', 'm', or 's'
            
            // Reset all size indicators in this card
            menuCard.querySelectorAll('.size-indicator').forEach(ind => {
                ind.style.backgroundColor = '';
                ind.style.color = 'white';
            });

            // Set the clicked size indicator
            indicator.style.backgroundColor = 'white';
            indicator.style.color = 'green';

            // Hide all item numbers in this card
            menuCard.querySelectorAll('.item-number').forEach(item => {
                item.style.display = 'none';
            });

            // Show the corresponding item number
            const itemNumber = menuCard.querySelector(`.item-number.size-${size}`);
            if (itemNumber) {
                itemNumber.style.display = 'flex';
            }
        });
    });

    // Handle number input changes
    document.addEventListener('change', (e) => {
        if (e.target.classList.contains('quantity-input')) {
            const input = e.target;
            // Ensure the value is not negative
            if (input.value < 0) {
                input.value = 0;
            }
        }
    });

    document.querySelector('.header-button.admin').addEventListener('click', () => {
        window.location.href = 'login_admin.php';
    });

    // Add this new code for total price calculation
    function updateTotalPrice() {
        let total = 0;
        const quantityInputs = document.querySelectorAll('.quantity-input');
        
        quantityInputs.forEach(input => {
            const menuCard = input.closest('.menu-card');
            const quantity = parseInt(input.value) || 0;
            let price = 0;
            
            // Get the price based on the size
            if (input.closest('.item-number').classList.contains('size-l')) {
                price = parseInt(menuCard.querySelector('.size-price:nth-child(1) .price').textContent);
            } else if (input.closest('.item-number').classList.contains('size-m')) {
                price = parseInt(menuCard.querySelector('.size-price:nth-child(3) .price').textContent);
            } else if (input.closest('.item-number').classList.contains('size-s')) {
                price = parseInt(menuCard.querySelector('.size-price:nth-child(5) .price').textContent);
            }
            
            total += quantity * price;
        });

        // Update total display
        document.querySelector('.total-amount').textContent = total + '$';
    }

    // Add event listeners for quantity changes
    document.addEventListener('change', (e) => {
        if (e.target.classList.contains('quantity-input')) {
            const input = e.target;
            // Ensure the value is not negative
            if (input.value < 0) {
                input.value = 0;
            }
            updateTotalPrice();
        }
    });

    // Add event listeners for action buttons
    document.querySelector('.cancel-btn').addEventListener('click', () => {
        // Reset all quantities to 0
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.value = 0;
        });
        updateTotalPrice();
    });

    document.querySelector('.done-btn').addEventListener('click', () => {
        // Handle order completion
        // You can add your order processing logic here
        alert('Order completed! Total: ' + document.querySelector('.total-amount').textContent);
    });
});






















document.querySelector('.done-btn').addEventListener('click', async function() {
    // Collect all selected items
    const orderItems = [];
    let totalPrice = 0;
    
    document.querySelectorAll('.menu-card').forEach(card => {
        const name = card.querySelector('.name-container').textContent.trim();
        const id = card.dataset.itemId; // You should add data-item-id to your menu cards
        
        ['L', 'M', 'S'].forEach(size => {
            const quantityInput = card.querySelector(`.size-${size.toLowerCase()} .quantity-input`);
            const quantity = parseInt(quantityInput.value);
            
            if (quantity > 0) {
                const price = parseFloat(card.querySelector(`.size-${size.toLowerCase()} .price`).textContent.replace('$', ''));
                totalPrice += quantity * price;
                
                orderItems.push({
                    id: id,
                    name: name,
                    size: size,
                    quantity: quantity,
                    l_price: size === 'L' ? price : parseFloat(card.querySelector('.size-l .price').textContent.replace('$', '')),
                    m_price: size === 'M' ? price : parseFloat(card.querySelector('.size-m .price').textContent.replace('$', '')),
                    s_price: size === 'S' ? price : parseFloat(card.querySelector('.size-s .price').textContent.replace('$', ''))
                });
            }
        });
    });
    
    if (orderItems.length === 0) {
        alert('Please select at least one item');
        return;
    }
    
    try {
        const response = await fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'save_order',
                order_data: JSON.stringify({
                    items: orderItems,
                    total: totalPrice
                })
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(`Order #${result.order_num} has been placed successfully!`);
            // Reset the form or redirect as needed
            document.querySelectorAll('.quantity-input').forEach(input => input.value = 0);
            document.querySelector('.total-amount').textContent = '00$';
        } else {
            alert('Error saving order: ' + (result.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to place order. Please try again.');
    }
});


