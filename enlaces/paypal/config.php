<?php
define('ProPayPal', 0);
if (ProPayPal) {
    define("PayPalClientId", "ASEUnAFBxjyMdNrpPjSgvTu67wR5CPdKYNDb1EUo8DBZbkiqQbaQCebptSC-Tf5786BkxSXiC67UGQJ9");
    define("PayPalSecret", "EBHCg85_T-eC0uFmjLBZYHkoixxdwCvLVDYmwTuRUjlDFWaAtEa5s6At_p_h7RcUalGols_tLqhWNpE7");
    define("PayPalBaseUrl", "https://api.paypal.com/v1/");
    define("PayPalENV", "production");
} else {
    define("PayPalClientId", "ASEUnAFBxjyMdNrpPjSgvTu67wR5CPdKYNDb1EUo8DBZbkiqQbaQCebptSC-Tf5786BkxSXiC67UGQJ9");
    define("PayPalSecret", "EBHCg85_T-eC0uFmjLBZYHkoixxdwCvLVDYmwTuRUjlDFWaAtEa5s6At_p_h7RcUalGols_tLqhWNpE7");
    define("PayPalBaseUrl", "https://api.sandbox.paypal.com/v1/");
    define("PayPalENV", "sandbox");
}
