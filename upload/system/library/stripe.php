<?php

// Stripe singleton
require_once(dirname(__FILE__) . '/stripe-php/Stripe.php');

// Utilities
require_once(dirname(__FILE__) . '/stripe-php/Util/AutoPagingIterator.php');
require_once(dirname(__FILE__) . '/stripe-php/Util/RequestOptions.php');
require_once(dirname(__FILE__) . '/stripe-php/Util/Set.php');
require_once(dirname(__FILE__) . '/stripe-php/Util/Util.php');

// HttpClient
require_once(dirname(__FILE__) . '/stripe-php/HttpClient/ClientInterface.php');
require_once(dirname(__FILE__) . '/stripe-php/HttpClient/CurlClient.php');

// Errors
require_once(dirname(__FILE__) . '/stripe-php/Error/Base.php');
require_once(dirname(__FILE__) . '/stripe-php/Error/Api.php');
require_once(dirname(__FILE__) . '/stripe-php/Error/ApiConnection.php');
require_once(dirname(__FILE__) . '/stripe-php/Error/Authentication.php');
require_once(dirname(__FILE__) . '/stripe-php/Error/Card.php');
require_once(dirname(__FILE__) . '/stripe-php/Error/InvalidRequest.php');
require_once(dirname(__FILE__) . '/stripe-php/Error/RateLimit.php');

// Plumbing
require_once(dirname(__FILE__) . '/stripe-php/ApiResponse.php');
require_once(dirname(__FILE__) . '/stripe-php/JsonSerializable.php');
require_once(dirname(__FILE__) . '/stripe-php/StripeObject.php');
require_once(dirname(__FILE__) . '/stripe-php/ApiRequestor.php');
require_once(dirname(__FILE__) . '/stripe-php/ApiResource.php');
require_once(dirname(__FILE__) . '/stripe-php/SingletonApiResource.php');
require_once(dirname(__FILE__) . '/stripe-php/AttachedObject.php');
require_once(dirname(__FILE__) . '/stripe-php/ExternalAccount.php');

// Stripe API Resources
require_once(dirname(__FILE__) . '/stripe-php/Account.php');
require_once(dirname(__FILE__) . '/stripe-php/AlipayAccount.php');
require_once(dirname(__FILE__) . '/stripe-php/ApplicationFee.php');
require_once(dirname(__FILE__) . '/stripe-php/ApplicationFeeRefund.php');
require_once(dirname(__FILE__) . '/stripe-php/Balance.php');
require_once(dirname(__FILE__) . '/stripe-php/BalanceTransaction.php');
require_once(dirname(__FILE__) . '/stripe-php/BankAccount.php');
require_once(dirname(__FILE__) . '/stripe-php/BitcoinReceiver.php');
require_once(dirname(__FILE__) . '/stripe-php/BitcoinTransaction.php');
require_once(dirname(__FILE__) . '/stripe-php/Card.php');
require_once(dirname(__FILE__) . '/stripe-php/Charge.php');
require_once(dirname(__FILE__) . '/stripe-php/Collection.php');
require_once(dirname(__FILE__) . '/stripe-php/CountrySpec.php');
require_once(dirname(__FILE__) . '/stripe-php/Coupon.php');
require_once(dirname(__FILE__) . '/stripe-php/Customer.php');
require_once(dirname(__FILE__) . '/stripe-php/Dispute.php');
require_once(dirname(__FILE__) . '/stripe-php/Event.php');
require_once(dirname(__FILE__) . '/stripe-php/FileUpload.php');
require_once(dirname(__FILE__) . '/stripe-php/Invoice.php');
require_once(dirname(__FILE__) . '/stripe-php/InvoiceItem.php');
require_once(dirname(__FILE__) . '/stripe-php/Order.php');
require_once(dirname(__FILE__) . '/stripe-php/OrderReturn.php');
require_once(dirname(__FILE__) . '/stripe-php/Plan.php');
require_once(dirname(__FILE__) . '/stripe-php/Product.php');
require_once(dirname(__FILE__) . '/stripe-php/Recipient.php');
require_once(dirname(__FILE__) . '/stripe-php/Refund.php');
require_once(dirname(__FILE__) . '/stripe-php/SKU.php');
require_once(dirname(__FILE__) . '/stripe-php/Source.php');
require_once(dirname(__FILE__) . '/stripe-php/Subscription.php');
require_once(dirname(__FILE__) . '/stripe-php/ThreeDSecure.php');
require_once(dirname(__FILE__) . '/stripe-php/Token.php');
require_once(dirname(__FILE__) . '/stripe-php/Transfer.php');
require_once(dirname(__FILE__) . '/stripe-php/TransferReversal.php');

class Stripe {
    
}
