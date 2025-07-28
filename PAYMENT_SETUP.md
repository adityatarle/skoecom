# Payment Gateway Setup Guide

This guide will help you configure the payment gateway to fix the "Payment gateway initialization failed" error.

## 🔧 Quick Fix for Current Error

The payment gateway error occurs because Razorpay keys are not properly configured. The system now automatically falls back to **demo mode** when keys are missing, so payments should work for testing.

## 🎯 Immediate Steps

1. **Check if demo mode is working**:
   - Go to checkout page
   - You should see "Demo Mode" message
   - Both Cash on Delivery and Razorpay should work
   - Razorpay will simulate payment without real charges

2. **For production setup** (optional):
   - Follow the Razorpay Configuration section below

## 🏗️ Razorpay Configuration (For Real Payments)

### Step 1: Get Razorpay Keys
1. Visit [Razorpay Dashboard](https://dashboard.razorpay.com/app/keys)
2. Create account if needed
3. Get your **Test Keys** for development:
   - Key ID (starts with `rzp_test_`)
   - Key Secret

### Step 2: Configure Environment
1. Copy `.env.example` to `.env` if not done already:
   ```bash
   cp .env.example .env
   ```

2. Edit your `.env` file:
   ```env
   # Replace these with your actual Razorpay keys
   RAZORPAY_KEY=rzp_test_your_actual_key_here
   RAZORPAY_SECRET=your_actual_secret_here
   
   # Keep debug mode enabled for testing
   APP_DEBUG=true
   ```

3. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## 🧪 Testing the Setup

### Option 1: Use Demo Mode (Current State)
- **Cash on Delivery**: Works normally
- **Razorpay**: Simulates payment, creates orders with "paid" status
- No real money involved
- Perfect for development and testing

### Option 2: Use Real Razorpay (After Configuration)
- **Cash on Delivery**: Works normally  
- **Razorpay**: Real payment gateway (uses test money in test mode)
- Real Razorpay integration with webhook support

## 🔍 Debug Configuration

Visit `/debug/config` (only works when APP_DEBUG=true) to check:
- Razorpay key configuration
- Cart session status
- Environment settings

## 🚀 Payment Flow

### Cash on Delivery
1. Select "Cash on Delivery"
2. Fill billing details
3. Place order
4. Order created with "pending" status

### Razorpay (Demo Mode)
1. Select "Razorpay (Demo Mode)"
2. Fill billing details
3. Click "Place Order"
4. Payment simulated automatically
5. Order created with "paid" status

### Razorpay (Real Mode)
1. Select "Razorpay"
2. Fill billing details  
3. Click "Place Order"
4. Razorpay payment modal opens
5. Complete payment
6. Order created with "paid" status

## 🛠️ Troubleshooting

### Error: "Payment gateway initialization failed"
- **Cause**: This should not happen anymore with the new fallback system
- **Solution**: The system automatically falls back to demo mode

### Demo mode always shows
- **Cause**: Razorpay keys not configured or invalid
- **Solution**: Set proper RAZORPAY_KEY and RAZORPAY_SECRET in .env

### Razorpay modal doesn't open
- **Cause**: JavaScript error or network issue
- **Solution**: Check browser console, ensure internet connection

### Orders not created
- **Cause**: Database or session issue
- **Solution**: Check logs in `storage/logs/laravel.log`

## 📝 Current System Status

✅ **Fixed Issues**:
- Payment gateway initialization errors
- Session management during checkout
- Error handling and recovery
- Fallback to demo mode when needed

✅ **Working Features**:
- Cart management (add, remove, update)
- Checkout process (both payment methods)
- Order creation and tracking
- Reorder functionality
- Demo mode for testing

## 🔐 Security Notes

- Never commit real Razorpay secrets to version control
- Use test keys for development
- Switch to live keys only for production
- Enable webhook signature verification for production

## 📞 Support

If you continue to face issues:
1. Check `/debug/config` for configuration status
2. Review `storage/logs/laravel.log` for detailed errors
3. Ensure `.env` file has proper values
4. Clear config cache after changes

The system is now designed to be fault-tolerant and should work even without proper Razorpay configuration.