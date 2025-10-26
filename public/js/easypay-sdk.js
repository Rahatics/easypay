/**
 * Easypay JavaScript SDK
 *
 * This SDK allows merchants to easily integrate Easypay payment gateway
 * into their websites.
 *
 * Usage:
 * 1. Include this script in your HTML head tag:
 *    <script src="/js/easypay-sdk.js"></script>
 *
 * 2. Initialize the SDK:
 *    const easypay = new Easypay({
 *      apiKey: 'your-api-key',
 *      merchantId: 'your-merchant-id'
 *    });
 *
 * 3. Create a payment:
 *    easypay.createPayment({
 *      amount: 500,
 *      customer_name: 'John Doe',
 *      customer_email: 'john@example.com',
 *      callback_url: 'https://yoursite.com/payment/callback',
 *      description: 'Product Purchase'
 *    }).then(response => {
 *      // Redirect user to payment page
 *      window.location.href = response.redirect_url;
 *    }).catch(error => {
 *      console.error('Payment creation failed:', error);
 *    });
 */

class Easypay {
    constructor(config) {
        this.apiKey = config.apiKey;
        this.merchantId = config.merchantId;
        this.baseUrl = config.baseUrl || '/api/payment/process';
        this.secretKey = config.secretKey || null;
    }

    /**
     * Create a new payment
     * @param {Object} paymentData - Payment information
     * @param {number} paymentData.amount - Payment amount
     * @param {string} paymentData.customer_name - Customer name
     * @param {string} paymentData.customer_email - Customer email
     * @param {string} paymentData.callback_url - Callback URL for payment status updates
     * @param {string} paymentData.description - Payment description
     * @param {string} paymentData.gateway - Payment gateway (optional)
     * @returns {Promise<Object>} Payment response with redirect URL
     */
    async createPayment(paymentData) {
        try {
            const response = await fetch(this.baseUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-API-KEY': this.apiKey,
                    'X-SECRET-KEY': this.secretKey
                },
                body: JSON.stringify(paymentData)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Payment creation failed');
            }

            return data;
        } catch (error) {
            throw new Error(`Payment creation failed: ${error.message}`);
        }
    }

    /**
     * Verify webhook signature
     * @param {Object} payload - Webhook payload
     * @param {string} signature - Signature from X-Easypay-Signature header
     * @param {string} secretKey - Your secret key
     * @returns {boolean} True if signature is valid
     */
    static verifyWebhookSignature(payload, signature, secretKey) {
        // In a browser environment, this would typically be done on the server side
        // This is just for reference - implement properly on your server
        console.warn('Webhook signature verification should be done server-side');
        return true;
    }

    /**
     * Handle payment callback
     * @param {Function} callback - Function to handle payment status updates
     */
    handleCallback(callback) {
        // Listen for messages from the payment iframe (if used)
        window.addEventListener('message', (event) => {
            if (event.data.type === 'easypay_payment_status') {
                callback(event.data);
            }
        });
    }
}

// Make it available globally
window.Easypay = Easypay;

// For Node.js environments (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Easypay;
}
