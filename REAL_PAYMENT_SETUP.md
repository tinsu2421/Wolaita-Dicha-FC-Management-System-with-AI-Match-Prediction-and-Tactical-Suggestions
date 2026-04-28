# Real Payment Gateway Setup Guide

This guide explains how to set up real Chapa and Telebirr payment gateways for the Wolaita Dicha FC fan registration system.

## 🔧 Updated Files

The following files have been updated to support real payment processing:

- `process_payment.php` - Now integrates with real payment APIs
- `payment_success_real.php` - Handles real payment verification
- `payment_callback.php` - Processes webhook notifications
- `Configuration/payment_config.php` - Updated with proper endpoints
- `Payment/PaymentHandler.php` - Contains API integration logic

## 🏦 Chapa Payment Gateway Setup

### 1. Create Chapa Account
1. Visit [https://chapa.co](https://chapa.co)
2. Sign up for a business account
3. Complete KYC verification
4. Get your API keys from the dashboard

### 2. Get API Keys
- **Test Secret Key**: `CHASECK_TEST-xxxxxxxxxx`
- **Test Public Key**: `CHAPUBK_TEST-xxxxxxxxxx`
- **Live Secret Key**: `CHASECK-xxxxxxxxxx`
- **Live Public Key**: `CHAPUBK-xxxxxxxxxx`

### 3. Update Configuration
Edit `Configuration/payment_config.php`:

```php
// Replace with your actual Chapa keys
define('CHAPA_SECRET_KEY', 'CHASECK_TEST-your-actual-secret-key');
define('CHAPA_PUBLIC_KEY', 'CHAPUBK_TEST-your-actual-public-key');
```

### 4. Webhook Configuration
In your Chapa dashboard, set the webhook URL to:
```
http://yourdomain.com/payment_callback.php
```

## 📱 Telebirr Payment Gateway Setup

### 1. Contact Ethio Telecom
1. Contact Ethio Telecom business services
2. Apply for Telebirr merchant account
3. Complete business verification
4. Get your merchant credentials

### 2. Get Merchant Credentials
- **App ID**: Your unique application identifier
- **App Key**: Your application secret key
- **Short Code**: Your business short code
- **Public Key**: Telebirr's public key for signature verification

### 3. Update Configuration
Edit `Configuration/payment_config.php`:

```php
// Replace with your actual Telebirr credentials
define('TELEBIRR_APP_ID', 'your-actual-app-id');
define('TELEBIRR_APP_KEY', 'your-actual-app-key');
define('TELEBIRR_SHORT_CODE', 'your-actual-short-code');
```

## 🔄 Payment Flow

### 1. Registration Process
1. User selects paid membership (Standard/Premium/VIP)
2. System redirects to payment method selection
3. User chooses Chapa or Telebirr
4. System creates pending registration record
5. User is redirected to payment gateway

### 2. Payment Processing
1. User completes payment on gateway
2. Gateway sends webhook to `payment_callback.php`
3. System verifies payment with gateway API
4. If successful, completes user registration
5. Sends confirmation email to user

### 3. Payment Verification
- **Chapa**: Uses transaction verification API
- **Telebirr**: Uses payment query API
- Both methods verify payment status before completing registration

## 🗄️ Database Requirements

Ensure these tables exist (run `fix_fans_table.php` if needed):

### Fans Table Updates
```sql
ALTER TABLE `fans` ADD COLUMN `payment_status` enum('free','paid','pending','failed') DEFAULT 'free';
ALTER TABLE `fans` ADD COLUMN `payment_date` timestamp NULL;
ALTER TABLE `fans` ADD COLUMN `tx_ref` varchar(100) NULL;
```

### New Tables
- `pending_registrations` - Stores registration data before payment
- `payment_transactions` - Tracks all payment attempts
- `membership_benefits` - Stores membership benefit details

## 🧪 Testing

### Test Mode
1. Set `PAYMENT_TEST_MODE = true` in configuration
2. Use test API keys
3. Test payments won't charge real money

### Test Cards (Chapa)
- **Success**: 4000000000000002
- **Decline**: 4000000000000069
- **Insufficient Funds**: 4000000000000341

### Test Numbers (Telebirr)
Use test phone numbers provided by Ethio Telecom

## 🚀 Production Deployment

### 1. Update Configuration
```php
define('PAYMENT_TEST_MODE', false);
// Use live API keys
define('CHAPA_SECRET_KEY', 'CHASECK-live-key');
define('TELEBIRR_APP_KEY', 'live-app-key');
```

### 2. Update URLs
Change localhost URLs to your domain:
```php
define('PAYMENT_SUCCESS_URL', 'https://yourdomain.com/payment_success_real.php');
define('PAYMENT_CALLBACK_URL', 'https://yourdomain.com/payment_callback.php');
```

### 3. SSL Certificate
Ensure your domain has a valid SSL certificate for secure payments.

## 🔐 Security Considerations

1. **API Keys**: Never expose secret keys in client-side code
2. **Webhook Verification**: Always verify webhook signatures
3. **HTTPS**: Use HTTPS for all payment-related pages
4. **Input Validation**: Validate all payment data
5. **Logging**: Log all payment attempts for audit

## 📧 Email Notifications

The system automatically sends:
- Registration confirmation emails
- Payment success notifications
- Membership benefit details

## 🛠️ Troubleshooting

### Common Issues
1. **Invalid API Keys**: Check key format and validity
2. **Webhook Failures**: Verify URL accessibility
3. **SSL Errors**: Ensure proper SSL configuration
4. **Database Errors**: Run database update scripts

### Debug Tools
- `payment_debug_complete.php` - System status check
- `test_db_columns.php` - Database structure verification
- `fix_fans_table.php` - Database schema updates

## 📞 Support

### Chapa Support
- Email: support@chapa.co
- Documentation: https://developer.chapa.co

### Telebirr Support
- Contact: Ethio Telecom business services
- Phone: +251-11-515-5555

## 🔄 Next Steps

1. **Get API Keys**: Obtain real credentials from both gateways
2. **Update Config**: Replace placeholder keys with real ones
3. **Test Payments**: Use test mode to verify integration
4. **Go Live**: Switch to production mode when ready

The payment system is now ready for real payment processing with both Chapa and Telebirr gateways!