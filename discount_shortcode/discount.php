<?php
// [discount price="100" percent="20"]

function discount_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'price' => 0,
            'percent' => 0,
        ),
        $atts,
        'discount'
    );

    $discount_amount = ($atts['price'] * $atts['percent']) / 100;
    $new_price = $atts['price'] - $discount_amount;

    $output = "Старая цена: {$atts['price']}<br>";
    $output .= "Новая цена: {$new_price}<br>";
    $output .= "Размер скидки: {$discount_amount}";

    return $output;
}
add_shortcode('discount', 'discount_shortcode');
?>