/*
 * Plugin Name: WooCommerce New Recipient
 * Plugin URI: /
 * Description: Sending a notification of a new order if the product is real.
 * Author: Ivan Khrystenko
 * Author URI: /
 * Version: 1.0.1
 */
function change_admin_new_order_email_recipient($recipient, $order)
{
    global $woocommerce;
    if ($order) {
        // New recipient
        $new_email = 'info@test.info';

        // Check whether all the goods in the order are virtual
        $has_non_virtual = false;
        if ('checkout') {
            foreach ($order->get_items() as $item_id => $item) {
                $product = $item->get_product();
                if ($product && !$product->is_virtual()) {
                    $has_non_virtual = true;
                    break;
                }
            }
        }

        // If the order contains non-virtual goods, we replace the standard email with a new one
        if ($has_non_virtual) {
            $recipient = $new_email;
        }
    }

    return $recipient;
}


add_filter('woocommerce_email_recipient_new_order', 'change_admin_new_order_email_recipient', 10, 2);
