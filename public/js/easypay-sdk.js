/**
 * Easypay Payment Gateway SDK
 * Version: 1.0.0
 *
 * This SDK allows merchants to easily integrate Easypay payment gateway
 * into their websites and applications.
 */

(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.Easypay = factory());
})(this, (function () {
    'use strict';

    // Default configuration
    const DEFAULT_CONFIG = {
        apiUrl: '/api/payment/process',
        currency: 'BDT',
        locale: 'en'
    };

    // Easypay class
    class Easypay {
        constructor(options = {}) {
            this.config = { ...DEFAULT_CONFIG, ...options };
            this.init();
        }

        init() {
            // Initialize the payment gateway
            console.log('Easypay SDK initialized with config:', this.config);
        }

        /**
         * Create a payment request
         * @param {Object} paymentDetails - Payment details
         * @param {number} paymentDetails.amount - Payment amount
         * @param {string} paymentDetails.description - Payment description
         * @param {string} paymentDetails.method - Payment method (bkash, nagad)
         * @returns {Promise} - Promise that resolves with payment data
         */
        async createPayment(paymentDetails) {
            try {
                const response = await fetch(this.config.apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.getCsrfToken()
                    },
                    body: JSON.stringify({
                        amount: paymentDetails.amount,
                        method: paymentDetails.method,
                        order_id: this.generateOrderId(),
                        description: paymentDetails.description
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Payment creation failed:', error);
                throw error;
            }
        }

        /**
         * Render payment button
         * @param {string} containerId - ID of the container element
         * @param {Object} paymentDetails - Payment details
         * @param {Object} options - Button options
         */
        renderPaymentButton(containerId, paymentDetails, options = {}) {
            const container = document.getElementById(containerId);
            if (!container) {
                console.error(`Container with ID '${containerId}' not found`);
                return;
            }

            // Default button options
            const buttonOptions = {
                text: `Pay ${paymentDetails.amount} ${this.config.currency}`,
                className: 'easypay-button',
                style: 'default',
                ...options
            };

            // Create payment button
            const button = document.createElement('button');
            button.className = buttonOptions.className;
            button.textContent = buttonOptions.text;

            // Add click event
            button.onclick = async () => {
                try {
                    // Show loading state
                    const originalText = button.textContent;
                    button.textContent = 'Processing...';
                    button.disabled = true;

                    // Create payment
                    const paymentData = await this.createPayment(paymentDetails);

                    // Redirect to payment gateway
                    if (paymentData.success && paymentData.data.redirect_url) {
                        window.location.href = paymentData.data.redirect_url;
                    } else {
                        throw new Error('Payment initialization failed');
                    }
                } catch (error) {
                    alert('Payment initialization failed. Please try again.');
                    // Reset button
                    button.textContent = originalText;
                    button.disabled = false;
                }
            };

            // Add default styles
            if (buttonOptions.style === 'default') {
                this.addDefaultStyles();
            }

            // Append button to container
            container.appendChild(button);
        }

        /**
         * Add default styles for payment button
         */
        addDefaultStyles() {
            // Check if styles are already added
            if (document.getElementById('easypay-styles')) {
                return;
            }

            const style = document.createElement('style');
            style.id = 'easypay-styles';
            style.textContent = `
                .easypay-button {
                    background-color: #4361ee;
                    color: white;
                    border: none;
                    padding: 12px 24px;
                    font-size: 16px;
                    font-weight: 500;
                    border-radius: 8px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .easypay-button:hover {
                    background-color: #3a56e4;
                    transform: translateY(-2px);
                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                }

                .easypay-button:active {
                    transform: translateY(0);
                }

                .easypay-button:disabled {
                    background-color: #b6c1e2;
                    cursor: not-allowed;
                    transform: none;
                    box-shadow: none;
                }
            `;

            document.head.appendChild(style);
        }

        /**
         * Get CSRF token from meta tag
         */
        getCsrfToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            return token ? token.getAttribute('content') : '';
        }

        /**
         * Generate unique order ID
         */
        generateOrderId() {
            return 'ORD-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        }
    }

    // Export the Easypay class
    return Easypay;
}));
