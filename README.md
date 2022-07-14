# Woo_Custom_slick_slider_gallery
A Custom override for woocommerce gallery.

Add the code from Functions.php in this repositry to the functions or PHP file in your own WP theme.

Replace the following code: (located in theme/woocommerce/content-single-product.php) 

```
do_action( 'woocommerce_before_single_product_summary' );
```

With 

```
do_action('nb_woocommerce_product_gallery');
```

Or directly into the code from functions.php

```

function replace_gallery() {
  do_action('em_woocommerce_product_gallery');
  return;
}

add_action('woocommerce_before_single_product_summary', 'replace_gallery');

````

Gallery requires
- Slick Slider
- Bootstrap 5 (if you want to use lightbox)
