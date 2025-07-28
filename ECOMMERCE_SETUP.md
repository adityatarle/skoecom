# E-commerce Setup Guide

## Overview
This Laravel-based e-commerce project has been redesigned with improved cart, wishlist, and checkout functionality. The system supports both guest and authenticated users with Razorpay payment integration.

## Key Features

### 1. Shopping Cart
- **Session-based**: Works for both guests and logged-in users
- **AJAX-powered**: Real-time updates without page refreshes
- **Quantity management**: Increase/decrease quantities dynamically
- **Responsive design**: Works on all devices
- **Cart persistence**: Maintains cart across sessions

### 2. Wishlist
- **User-specific**: Database storage for logged-in users, session for guests
- **Easy management**: Add/remove items with visual feedback
- **Cross-device sync**: For authenticated users
- **Quick add to cart**: Convert wishlist items to cart items

### 3. Checkout Process
- **Guest checkout**: Allowed with billing information collection
- **Multiple payment methods**: Cash on Delivery and Razorpay
- **Order tracking**: Complete order history for users
- **Responsive design**: Mobile-friendly checkout flow

### 4. Payment Integration
- **Razorpay Integration**: Secure online payments
- **Payment verification**: Server-side signature verification
- **Order management**: Automatic status updates
- **Error handling**: Graceful error management

## Setup Instructions

### 1. Environment Configuration

Add the following to your `.env` file:

```env
# Razorpay Configuration (Replace with your actual keys)
RAZORPAY_KEY=rzp_test_your_key_here
RAZORPAY_SECRET=your_secret_here

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# App Configuration
APP_NAME="Your Store Name"
APP_ENV=local
APP_KEY=base64:your_app_key
APP_DEBUG=true
APP_URL=http://localhost

# Session Configuration
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

### 2. Database Setup

Run the migrations:
```bash
php artisan migrate
```

The following tables are created:
- `orders` - Stores order information
- `wishlists` - Stores user wishlist items
- `products` - Product catalog
- `users` - User accounts

### 3. Required Dependencies

Ensure these packages are installed:
```bash
composer install
npm install
npm run build
```

### 4. Razorpay Setup

1. **Create Razorpay Account**: Sign up at https://razorpay.com
2. **Get API Keys**: 
   - Go to Settings > API Keys
   - Generate Test/Live keys
   - Update `.env` file with your keys

3. **Test Integration**:
   - Use test keys for development
   - Use test card numbers for testing payments

## Usage Guide

### For Customers

#### Shopping Cart
1. **Add to Cart**: Click "Add to Cart" on any product
2. **View Cart**: Click cart icon in header or visit `/cart`
3. **Update Quantities**: Use +/- buttons or edit directly
4. **Remove Items**: Click × button to remove items
5. **Proceed to Checkout**: Click "Proceed to Checkout" button

#### Wishlist
1. **Add to Wishlist**: Click heart icon on products
2. **View Wishlist**: Click wishlist icon in header or visit `/wishlist`
3. **Move to Cart**: Click "Add to Cart" from wishlist
4. **Remove from Wishlist**: Click × button

#### Checkout Process
1. **Guest Checkout**: Enter billing details directly
2. **User Checkout**: Pre-filled information for logged-in users
3. **Payment Selection**: Choose between COD or Razorpay
4. **Order Confirmation**: Receive order details and tracking

#### Order Management
1. **View Orders**: Go to "My Orders" (requires login)
2. **Order Details**: Click "View Details" for complete information
3. **Reorder**: Click "Reorder" to add all items to cart again
4. **Track Status**: Monitor order status updates

### For Administrators

#### Order Management
- View all orders in admin panel
- Update order status
- Export order data
- Manage customer information

#### Product Management
- Add/edit/delete products
- Manage categories
- Handle product images
- Set pricing information

## API Endpoints

### Cart Operations
```
POST /cart/add - Add item to cart
GET /cart - View cart page
GET /cart/remove/{id} - Remove item from cart
GET /cart/increase/{id} - Increase quantity
GET /cart/decrease/{id} - Decrease quantity
GET /cart/count - Get cart count (AJAX)
```

### Wishlist Operations
```
POST /wishlist/add - Add item to wishlist
GET /wishlist - View wishlist page
DELETE /wishlist/remove/{id} - Remove from wishlist
GET /wishlist/count - Get wishlist count (AJAX)
```

### Checkout Operations
```
GET /checkout - Display checkout page
POST /checkout/place-order - Process order
POST /apply-coupon - Apply coupon code
```

### Order Operations
```
GET /orders - View order history (auth required)
GET /orders/{id} - View specific order (auth required)
```

## JavaScript Features

### Real-time Updates
- Cart count updates automatically
- Wishlist count updates automatically
- Toast notifications for user feedback
- Button state changes (loading, success)

### Enhanced UX
- Loading states for buttons
- Visual feedback for actions
- Error handling with user-friendly messages
- Responsive notifications

## Security Features

### CSRF Protection
- All forms include CSRF tokens
- AJAX requests include CSRF headers
- Protection against cross-site request forgery

### Payment Security
- Server-side signature verification
- Secure payment processing
- Input validation and sanitization
- SQL injection prevention

### Session Security
- Secure session handling
- Cart data validation
- User authentication checks

## Troubleshooting

### Common Issues

1. **Cart not updating**
   - Check browser console for JavaScript errors
   - Verify CSRF token is included
   - Ensure jQuery is loaded

2. **Razorpay not working**
   - Verify API keys in `.env`
   - Check if test mode is enabled
   - Ensure HTTPS in production

3. **Orders not saving**
   - Check database connection
   - Verify table structure
   - Check server logs for errors

4. **Wishlist not working**
   - Ensure user authentication
   - Check database permissions
   - Verify session configuration

### Debug Mode

Enable debug mode in `.env`:
```env
APP_DEBUG=true
```

Check logs in `storage/logs/laravel.log`

## Production Deployment

### Pre-deployment Checklist
1. Set `APP_ENV=production`
2. Set `APP_DEBUG=false`
3. Update Razorpay to live keys
4. Configure proper SSL/HTTPS
5. Set up proper caching
6. Configure queue workers for better performance

### Performance Optimization
1. Enable Laravel caching
2. Use CDN for assets
3. Optimize database queries
4. Enable Gzip compression
5. Set up proper session storage

## Support

For issues and questions:
1. Check the troubleshooting section
2. Review Laravel documentation
3. Check Razorpay documentation
4. Review server logs for errors

## Version History

### v2.0 (Current)
- Redesigned cart functionality
- Improved wishlist system
- Enhanced checkout process
- Better error handling
- Mobile-responsive design
- Real-time updates
- Guest checkout support

### v1.0 (Previous)
- Basic cart functionality
- Simple wishlist
- Basic checkout
- Limited error handling