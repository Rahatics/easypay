/**
 * Easypay Payment Gateway Integration SDK
 * Version: 1.0.0
 *
 * This script allows website owners to integrate Easypay payment gateways
 * into their websites for processing payments.
 */

(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.Easypay = factory());
})(this, (function () {
    'use strict';

    // Default configuration
    const DEFAULT_CONFIG = {
        apiUrl: 'https://easypay.example.com/api',
        gateway: 'bkash',
        currency: 'BDT',
        theme: 'default'
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
         * @param {string} paymentDetails.redirectUrl - URL to redirect after payment
         * @returns {Promise} - Promise that resolves with payment URL
         */
        async createPayment(paymentDetails) {
            try {
                const response = await fetch(`${this.config.apiUrl}/payments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: paymentDetails.amount,
                        currency: this.config.currency,
                        description: paymentDetails.description,
                        gateway: this.config.gateway,
                        redirectUrl: paymentDetails.redirectUrl
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                return data.paymentUrl;
            } catch (error) {
                console.error('Payment creation failed:', error);
                throw error;
            }
        }

        /**
         * Render payment button
         * @param {string} containerId - ID of the container element
         * @param {Object} paymentDetails - Payment details
         */
        renderPaymentButton(containerId, paymentDetails) {
            const container = document.getElementById(containerId);
            if (!container) {
                console.error(`Container with ID '${containerId}' not found`);
                return;
            }

            // Create payment button
            const button = document.createElement('button');
            button.className = 'easypay-button';
            button.textContent = `Pay ${paymentDetails.amount} ${this.config.currency} with ${this.config.gateway}`;
            button.onclick = async () => {
                try {
                    const paymentUrl = await this.createPayment(paymentDetails);
                    window.location.href = paymentUrl;
                } catch (error) {
                    alert('Payment initialization failed. Please try again.');
                }
            };

            // Add default styles
            this.addDefaultStyles();

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
            `;

            document.head.appendChild(style);
        }

        /**
         * Set gateway
         * @param {string} gateway - Gateway name (e.g., 'bkash', 'nagad')
         */
        setGateway(gateway) {
            this.config.gateway = gateway;
        }

        /**
         * Set currency
         * @param {string} currency - Currency code (e.g., 'BDT', 'USD')
         */
        setCurrency(currency) {
            this.config.currency = currency;
        }
    }

    // Export the Easypay class
    return Easypay;
}));
