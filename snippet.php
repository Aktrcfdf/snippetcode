<?php
// Подключение стилей родительской темы
add_action('wp_enqueue_scripts', 'enqueue_parent_styles');
function enqueue_parent_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

//------------------------НАВИГАЦИЯ--------------------------------
//--Отключить панель администратора--
//--Разрешить смайлики--
//--Рубль р.--
//--Убрать зум на товарах и лайтбокс--
//--Меняет местами старую и новую цену--
//--Вывести кол-во новых постов за сутки--
//--В магазине сверху товары, которые в наличии--
//--Поменять текст добавить в корзину--
//--Изображение товаров и скидка на стр оформ заказа--
//--Исчезающие предупреждения при оформлении заказа, 10 секунд--
//--На стран оформл заказа выводит итоговую цену до применения бонусов и купонов--
//--Убрать доставку в корзине--
//--Скрыть способы доставки при заказе товаров с классом доставки delivery-nsk--
//--Выводить сообщение на стр оформл заказа "Ввведите город" для отображения ПВЗ--
//--Скрыть самовывоз, если в заказе нет товаров с классом доставки delivery-nsk--
//--Города России на странице оформления заказа--
//--Условия бесплатной доставки--
//--Редирект на страницу авторизации, если пользователь не авторизирован на станице оформления заказа--
//--Аватары--
//--Форма загрузки аватара--
//--WYSIWYG--
//НЕАКТИВ--Ограничить доступ к медиатеке автору--
//--Редирект на стр авторизации, чтобы оставить комментарий--
//-- Вывести кол-во заказов у клиента в статусе обработка--
//--Шорткод вывести стр платежи в приют-- 
//--Кастомизация лк донор--
//--Изменить поля оформ заказа--
//--Скрытие полей доставки при вирт товарах, самовывозе, такси и  класс доставки delivery-nsk--
//--Добавлен новый статус заказа "доставка"--
//--Добавить поля Кличка, Отчество у пользователя--
//--На стр оформления заказа поле кличка+отчество в лк--
//--Отчество на стр офор заказа--
//--Кнопка выйти--
//--Редирект со страницы мои заказы, если клиент не авторизован--
//--Вывод третьей цены в каталоге товаров через шорткод--
//--Цена по подписке для клиентов с подпиской--
//--Цена по подписке для вариативных товаров--
//--На страницах корзины и оформления выводит третью цену, распродажи и базовую цену--
//--В письмах менять адрес--
//--Описание доставки в письмах для СДЭК, самовывоз--
//--Кнопка удалить товары на стр оформл заказа--
//--Плюс и минус на стр корзины--
//--В корзине выводит Осталось меньше 10шт--
//--Процент скидки каждого товара в корзине--
//--Убрать автоскролл в корзине и оформл заказа--
//--Кнопка оставить отзыв на стр вакансии--
//--Список товаров мой аккаунт заказы--
//--Общая сумма скидки в корзине--
//--Подписка активна до "дата"--
//--Изменить надпись после покупки memberships--
//--Сервисный сбор--
//--Процент скидки в каталоге--
//--Текущая страница в форме оценки заказа--
//--Скрыть вкладки и медиа для shop manager--
//--Скрыть списать бонусы в оформл заказа, если бонусов нет--
//--Бонусы у кого подписка не сгорают-- 
//--Догибонусы начисляются только при наличной оплате--
//--SMTP для почты--
//--Только имя в отзывах товаров--
//--Все покупки клиента--//
//--Удалить медиа при удаления поста--
//--Сделать первое фото в галерее миниатюрой поста--
//--Slug архив автора--
//--Добавить в корзину на стр товара ajax--
//--Убрать диапазон цен на стр товара--
//--Кнопки вариации товаров на стр товара--
//--Изменить логотип входа в админку--
//--Убрать Подытог в личном кабинете в информации о заказе--
//--Уведомление выключить VPN на стр оформления заказа--

//----------------------------------------------//
//--Отключить панель администратора--
add_action( 'wp', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        show_admin_bar( false );
    }
} );


//----------------------------------------------//
//--Разрешить смайлики--
add_filter( 'widget_text', 'convert_smilies' );
add_filter( 'the_title', 'convert_smilies' );
add_filter( 'wp_title', 'convert_smilies' );
add_filter( 'get_bloginfo', 'convert_smilies' );


//----------------------------------------------//
//--Рубль р.--
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'RUB': $currency_symbol = 'р.'; break;
     }
     return $currency_symbol;}


//----------------------------------------------//
//--Убрать зум на товарах и лайтбокс--
function remove_image_zoom_support() {
remove_theme_support( 'wc-product-gallery-zoom' );}
add_action( 'wp', 'remove_image_zoom_support', 100 );


//----------------------------------------------//
//--Меняет местами старую и новую цену--
add_filter('woocommerce_format_sale_price', 'ss_format_sale_price', 100, 3);
function ss_format_sale_price( $price, $regular_price, $sale_price ) {
    $output_ss_price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>' ;
    return $output_ss_price;
}


//----------------------------------------------//
//--Изменить "Нет в наличии"--
//add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
//function wcs_custom_get_availability( $availability, $_product ) {
//if ( $_product->is_in_stock() ) {
//$availability['availability'] = __('В наличии 😺', 'woocommerce');}
//if ( ! $_product->is_in_stock() ) {
//$availability['availability'] = __('Распродано 🏃', 'woocommerce');}
//return $availability;}


//----------------------------------------------//
//--Вывести кол-во новых постов за сутки--
function todays_posts_shortcode() {
    $today = getdate();
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'category_name' => 'blog',
        'date_query' => array(
            array(
                'year' => $today['year'],
                'month' => $today['mon'],
                'day' => $today['mday'],
            ),
        ),
    );
    $query = new WP_Query($args);
    return $query->found_posts;
}
add_shortcode('todays_posts', 'todays_posts_shortcode');

function todays_posts_shortcode2() {
    $today = getdate();
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'category_name' => 'news',
        'date_query' => array(
            array(
                'year' => $today['year'],
                'month' => $today['mon'],
                'day' => $today['mday'],
            ),
        ),
    );
    $query = new WP_Query($args);
    return $query->found_posts;
}
add_shortcode('todays_posts2', 'todays_posts_shortcode2');


//----------------------------------------------//
//--В магазине сверху товары, которые в наличии--
add_filter( 'woocommerce_get_catalog_ordering_args', 'truemisha_sort_by_stock', 25 );
 function truemisha_sort_by_stock( $args ) { 
    $args[ 'meta_key' ] = '_stock_status';
    $args[ 'orderby' ] = 'meta_value';
    return $args;}
    

//----------------------------------------------//  
//--Поменять текст добавить в корзину--
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_add_to_cart_button_text_single' ); 
function woocommerce_add_to_cart_button_text_single() {
    return __( 'Добавить в корзину', 'woocommerce' ); }
function change_loop_add_to_cart_button( $button, $product, $args = array() ) {
    if( !$product->is_in_stock() ){
        $button = '<a class="button disabled" style="color:#000;opacity: 0.2;">'.__('', 'woocommerce').'</a>';
    }
   return $button;}
add_filter( 'woocommerce_loop_add_to_cart_link', 'change_loop_add_to_cart_button', 20, 3 );
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_add_to_cart_button_text_archives' );  
function woocommerce_add_to_cart_button_text_archives() {
    return __( '', 'woocommerce' );}

    
//----------------------------------------------//
//--Изображение товаров и скидка на стр оформ заказа--
add_filter( 'woocommerce_cart_item_name', 'true_checkout_product_images', 25, 2 );
function true_checkout_product_images( $name, $cart_item ) {
    if ( ! is_checkout() ) {
        return $name;}
    $product = $cart_item[ 'data' ];
    $image = $product->get_image( array( 300, 300 ), array( 'class' => 'alignleft' ) );
    return $image . $name;}

    
//----------------------------------------------//  
//--Исчезающие предупреждения при оформлении заказа, 10 секунд--
add_action( 'wp_enqueue_scripts', 'true_checkout_error_fade_out', 25 );
function true_checkout_error_fade_out() {
    if( ! is_checkout() ) {
        return;}
    wc_enqueue_js( "
        $( document.body ).on( 'checkout_error', function(){
            setTimeout( function(){
                $('.woocommerce-error').fadeOut( 300 );
            }, 10000);
        })
    " );}
    
    
//----------------------------------------------//  
//--На стран оформл заказа выводит итоговую цену до применения бонусов и купонов--
add_filter('woocommerce_cart_totals_order_total_html', 'truemisha_total_with_coupons', 25);
function truemisha_total_with_coupons($value)
{
    if (is_checkout() && WC()->cart->get_cart_discount_total() <> 0) {
        $new_total = wc_price(WC()->cart->get_total('edit'));
        $old_total = wc_price(WC()->cart->get_subtotal() + WC()->cart->get_shipping_total() + WC()->cart->get_fee_total());
        $value = sprintf('<del>%s</del> <b>%s</b>', $old_total, $new_total);
    }
    return $value;}


//----------------------------------------------//  
//--Убрать доставку в корзине--
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;}
    return $show_shipping;}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );


//----------------------------------------------//
//--Скрыть способы доставки при заказе товаров с классом доставки delivery-nsk--
// Скрыть способ доставки Woocommerce для класса доставки delivery-nsk
function hide_flat_rate_shipping( $rates, $package ) {
    $shipping_classes = array('delivery-nsk');
    $if_exists = false;
    foreach( $package['contents'] as $key => $values ) {
        if( in_array( $values[ 'data' ]->get_shipping_class(), $shipping_classes ) )
            $if_exists = true;}
    if( $if_exists ) unset( $rates['boxberry_self:43']); 
    if( $if_exists ) unset( $rates['official_cdek:136']);
     if( $if_exists ) unset( $rates['flat_rate:35']); 
    return $rates;}
add_filter( 'woocommerce_package_rates', 'hide_flat_rate_shipping', 10, 2 );

// Функция для отображения класса доставки на странице корзины
add_filter('woocommerce_cart_item_name', 'display_shipping_class_in_cart', 20, 3);
function display_shipping_class_in_cart($item_name, $cart_item, $cart_item_key) {
    if (!is_cart()) {
        return $item_name;}
    $product = $cart_item['data'];
    $shipping_class_id = $product->get_shipping_class_id();
    if (empty($shipping_class_id)) {
        return $item_name;}
    $shipping_class_term = get_term($shipping_class_id, 'product_shipping_class');
    if (is_wp_error($shipping_class_term) || !$shipping_class_term) {
        return $item_name;}
    $label = __('📦 Доставка', 'woocommerce');
    return $item_name . '<br>
        <p class="item-shipping-class" style="margin:4px 0 0;">
            <strong>' . $label . ': </strong>' . $shipping_class_term->name . '</p>';}

// Отображать пользовательское сообщение на основе класса доставки на страницах корзины Woocommerce и оформления заказа
add_action( 'woocommerce_review_order_before_order_total', 'display_shipping_class_message_checkout' );
add_action( 'woocommerce_cart_totals_after_order_total', 'display_shipping_class_message_cart' );
function display_shipping_class_message_checkout(){
    display_shipping_class_message(true);}
function display_shipping_class_message_cart(){
    display_shipping_class_message(false);}
function display_shipping_class_message($is_checkout) {
    $shipping_classes = array('delivery-nsk');
    if ($is_checkout) {
        $message = __('<p class="custom-shipping-message">Замороженные продукты доставляются курьерской службой LDOG Фреш (г.Новосибирск) в вечернее время.<br>Укажите в комментарии дату доставки.</p>', "woocommerce");
    } else {
        $message = __('<p class="custom-shipping-message">Замороженные продукты доставляются только в г. Новосибирск</p>', "woocommerce");}
    // Loop through cart items
    foreach( WC()->cart->get_cart() as $cart_item ){
        $shipping_class = $cart_item['data']->get_shipping_class();
        if( in_array($shipping_class, $shipping_classes ) ){
            echo '<tr class="shipping-note">
                <td colspan="2"><strong>'.__("", "woocommerce").'</strong> '.$message.'</td> 
            </tr>';
            break;}}}
            
            
//----------------------------------------------// 
//--Выводить сообщение на стр оформл заказа "Ввведите город" для отображения ПВЗ--
add_action( 'woocommerce_review_order_before_payment', 'display_no_delivery_class_message_checkout' );
function display_no_delivery_class_message_checkout() {
    // Проверяем, находимся ли мы на странице оформления заказа
    if ( ! is_checkout() ) {
        return; // Если не на странице оформления заказа, ничего не делаем
    }

    $has_delivery_class = false;
    $has_virtual_product = false;
    $all_virtual_products = true;
    $shipping_classes = array('delivery-nsk');
    $message = __('<p>👉🏼 Введите город для отображения пунктов выдачи на карте СДЭК, Boxberry</p>', "woocommerce");

    // Перебираем товары в корзине
    foreach( WC()->cart->get_cart() as $cart_item ) {
        $shipping_class = $cart_item['data']->get_shipping_class();
        $is_virtual = $cart_item['data']->is_virtual();
        
        // Проверяем, есть ли в корзине товар с определенным классом доставки
        if( in_array($shipping_class, $shipping_classes) ) {
            $has_delivery_class = true;
            break;
        }

        // Проверяем, есть ли в корзине виртуальный товар
        if ( $is_virtual ) {
            $has_virtual_product = true;
        } else {
            // Если есть хотя бы один не виртуальный товар
            $all_virtual_products = false;
        }
    }

    // Если товаров с классом доставки delivery-nsk нет и нет виртуальных товаров, выводим сообщение
    if( !$has_delivery_class && !$all_virtual_products ) {
        echo '<div id="no-delivery-message" class="woocommerce-error">' . $message . '</div>';
    }
}


//----------------------------------------------// 
//--Скрыть самовывоз, если в заказе нет товаров с классом доставки delivery-nsk--
function hide_local_pickup_shipping( $rates, $package ) {
    $shipping_classes = array('delivery-nsk');
    $class_exists = false;
    foreach( $package['contents'] as $key => $values ) {
        if( in_array( $values['data']->get_shipping_class(), $shipping_classes ) ) {
            $class_exists = true;
            break;
        }
    }
    if( !$class_exists ) {
        unset( $rates['local_pickup:45'] ); 
    }

    return $rates;
}
add_filter( 'woocommerce_package_rates', 'hide_local_pickup_shipping', 10, 2 );


//----------------------------------------------// 
//--Города России на странице оформления заказа--
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields) {
    // Чтение списка городов из JSON файла
    $file_path = get_template_directory() . '/cities.json';
    if (!file_exists($file_path)) {
        return $fields; // Если файл не найден, возвращаем оригинальные поля
    }
    
    $cities_json = file_get_contents($file_path);
    $cities_array = json_decode($cities_json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return $fields;
    }
    $cities = array('' => __('Введите город', 'woocommerce'));
    foreach ($cities_array['Россия'] as $city) {
        $cities[$city] = __($city, 'woocommerce');
    }

    // Добавление поля выбора города с автозаполнением на страницу оформления заказа
    // Добавляем проверку на наличие класса 'delivery-nsk-hidden'
    $city_field_class = array('form-row-wide');
    if (isset($fields['billing']['billing_city']['class']) && in_array('delivery-nsk-hidden', $fields['billing']['billing_city']['class'])) {
        $city_field_class[] = 'delivery-nsk-hidden';
    }

    $fields['billing']['billing_city'] = array(
        'type' => 'text',
        'label' => __('Город', 'woocommerce'),
        'required' => false,
        'class' => $city_field_class,
        'clear' => true,
        'autocomplete' => 'off',
        'custom_attributes' => array(
            'list' => 'cities'
        )
    );

    // Добавление datalist с городами для автозаполнения
    add_action('wp_footer', function() use ($cities_array) {
        echo '<datalist id="cities">';
        foreach ($cities_array['Россия'] as $city) {
            echo '<option value="' . esc_attr($city) . '">';
        }
        echo '</datalist>';
    });
    return $fields;}
 
 
//----------------------------------------------//  
//--Условия бесплатной доставки--
add_action('woocommerce_checkout_update_order_review', 'recalculate_checkout_totals');
function recalculate_checkout_totals($post_data) {
    WC()->cart->calculate_totals();}

add_action('woocommerce_cart_calculate_fees', 'apply_boxberry_free_shipping_discount', 20, 1);
function apply_boxberry_free_shipping_discount($cart) {
    if (is_checkout()) {
        $user = wp_get_current_user();
        $user_roles = $user->roles;
        $min_amount = 2990; // Default minimum amount for customers without a subscription
        $max_discount = 90; // Default maximum discount for customers without a subscription

        if (in_array('member', $user_roles)) {
            $min_amount = 990; // Minimum amount for members
            $max_discount = 90; // Maximum discount for members
        }

        // Check if the cart contains products with the 'delivery-nsk' shipping class
        $has_delivery_nsk = false;
        foreach ($cart->get_cart() as $cart_item) {
            $product = $cart_item['data'];
            if ($product->get_shipping_class() === 'delivery-nsk') {
                $has_delivery_nsk = true;
                break;
            }
        }

        if ($has_delivery_nsk) {
            if (in_array('member', $user_roles)) {
                $min_amount = 1500; // Minimum amount for members with local delivery
            } else {
                $min_amount = 2500; // Minimum amount for customers without a subscription with local delivery
            }
        }

        $current = $cart->get_subtotal();

        // Adjust maximum discount based on the order amount
        if (in_array('member', $user_roles)) {
            if ($current >= 6990) {
                $max_discount = 690;
            } elseif ($current >= 5990) {
                $max_discount = 590;
            } elseif ($current >= 4990) {
                $max_discount = 490;
            } elseif ($current >= 3990) {
                $max_discount = 390;
            } elseif ($current >= 2990) {
                $max_discount = 290;
            } elseif ($current >= 1990) {
                $max_discount = 190;
            } elseif ($current >= 990) {
                $max_discount = 90;
            }
        } else {
            if ($current >= 8990) {
                $max_discount = 690;
            } elseif ($current >= 7990) {
                $max_discount = 590;
            } elseif ($current >= 6990) {
                $max_discount = 490;
            } elseif ($current >= 5990) {
                $max_discount = 390;
            } elseif ($current >= 4990) {
                $max_discount = 290;
            } elseif ($current >= 3990) {
                $max_discount = 190;
            } elseif ($current >= 2990) {
                $max_discount = 90;
            }
        }

        if ($current >= $min_amount) {
            $shipping_total = 0;
            $chosen_methods = WC()->session->get('chosen_shipping_methods');
            $chosen_shipping = $chosen_methods[0];
            foreach (WC()->shipping->get_packages() as $package) {
                if (isset($package['rates'][$chosen_shipping])) {
                    $shipping_total = $package['rates'][$chosen_shipping]->cost;
                    break;
                }
            }

            // Применяем скидку на доставку, но не более максимального значения
            if ($shipping_total > 0) {
                $discount = min($shipping_total, $max_discount);
                $cart->add_fee(__('Скидка на доставку', 'woocommerce'), -$discount);
            }
        }
    }
}

add_action('woocommerce_before_cart_totals', 'show_free_shipping_message');
function show_free_shipping_message() {
    $user = wp_get_current_user();
    $user_roles = $user->roles;
    $min_amount = 2990; // Default minimum amount for customers

    if (in_array('member', $user_roles)) {
        $min_amount = 990;
    }

    // Check if the cart contains products with the 'delivery-nsk' shipping class
    $has_delivery_nsk = false;
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        if ($product->get_shipping_class() === 'delivery-nsk') {
            $has_delivery_nsk = true;
            break;
        }
    }

    if ($has_delivery_nsk) {
        if (in_array('member', $user_roles)) {
            $min_amount = 1500;
        } else {
            $min_amount = 2500;
        }
    }

    $current = WC()->cart->subtotal;

    if ($current < $min_amount) {
        $remaining = $min_amount - $current;
        echo '<div class="woocommerce-info">';
        echo sprintf(__('Добавьте товаров на %s руб для бесплатной доставки! (<a href="%s" style="text-decoration: underline; color: #CB6C30;">подробнее</a>)', 'woocommerce'), wc_price($remaining), esc_url('/delivery/'));
        echo '</div>';
    } else {
        echo '<div class="woocommerce-message">';
        echo sprintf(__('Вы получили бесплатную доставку! (<a href="%s" style="text-decoration: underline; ">подробнее</a>)', 'woocommerce'), esc_url('/delivery/'));
        echo '</div>';
    }
}


//----------------------------------------------//           
//--Редирект на страницу авторизации, если пользователь не авторизирован на станице оформления заказа--
add_action('template_redirect','check_if_logged_in');
function check_if_logged_in()
{
    $pageid = get_option( 'woocommerce_checkout_page_id' );
   if(!is_user_logged_in() && is_page($pageid))
    {
        $url = add_query_arg(
            'redirect_to',
            get_permalink($pagid),
            site_url('/login/')
        );
        wp_redirect($url);
        exit;}}
 
        
//----------------------------------------------//       
//--Аватары--
add_filter( 'get_avatar_url', 'my_custom_avatar_author', 10, 3 );
function my_custom_avatar_author( $avatar, $id_or_email, $size ) { 
  $meta_key = "user_avatar";
  $user = false;
  if ( is_numeric( $id_or_email ) ) {
    $user = get_user_by( 'id' , (int)$id_or_email );
  } 
  
  elseif ( is_object( $id_or_email ) ) {
    if ( ! empty( $id_or_email->user_id ) ) {
      $id = (int)$id_or_email->user_id;
      $user = get_user_by( 'id' , $id );
    }
  } else {
    $user = get_user_by( 'email', $id_or_email );    
  }

  if ( $user && is_object( $user ) ) {
    $post_id = get_user_meta( $user->ID, $meta_key, true );
    if ( $post_id ) {
      $attachment_url = wp_get_attachment_url( $post_id );
      $avatar = wp_get_attachment_image_url($post_id, $size = array('400', '400')); 
    }
  }
 return $avatar;
}

add_filter( 'avatar_defaults', 'wpb_new_gravatar' );
function wpb_new_gravatar ($avatar_defaults) {
$myavatar = 'https://l-dog.ru/wp-content/uploads/2023/08/Frame-183-1.png';
$avatar_defaults[$myavatar] = "Default Gravatar";
return $avatar_defaults;}




//----------------------------------------------// 
//--Форма загрузки аватара--
$error_message = '';
function update_user_avatar($user_id) {
    global $error_message;

    // Получаем ID старого аватара
    $old_avatar_id = get_user_meta($user_id, 'user_avatar', true);
    
    // Удаляем старый аватар, если есть
    if ($old_avatar_id) {
        // Удаляем изображение из медиатеки
        wp_delete_attachment($old_avatar_id, true);
        
        // Удаляем мета-данные старого аватара
        delete_user_meta($user_id, 'user_avatar');
    }
    
    // Получаем новый аватар из $_FILES
    if (!empty($_FILES['user_avatar']['name'])) {
        // Загружаем новое изображение и получаем его ID
        $attachment_id = media_handle_upload('user_avatar', 0);
        
        if (is_wp_error($attachment_id)) {
            // Обработка ошибок загрузки
            return;
        }
        
        // Сохраняем ID нового аватара в метаполе
        update_user_meta($user_id, 'user_avatar', $attachment_id);
    }
}

function user_avatar_upload_form() {
    global $error_message; // Получаем глобальную переменную
    $user_id = get_current_user_id();
    $old_avatar_id = get_user_meta($user_id, 'user_avatar', true);
    ob_start();
    ?>
    <div class="avatar-upload-form">
        <form method="post" enctype="multipart/form-data" class="jet-form-builder-file-upload">
            <input type="file" name="user_avatar" accept=".png, .jpeg, .jpg, .heic" class="jet-form-builder-file-upload__input">
            <input type="hidden" name="action" value="upload_user_avatar">
            <input type="button" class="addfile" value="Загрузить аватар"/>
            <div class="labeladdfile">Выберите файл, не более 4мб</div>
            <input type="submit" value="Сохранить" class="save-button">
        </form>

        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="color: red;"><?php echo esc_html($error_message); ?></div>
        <?php endif; ?>

        <?php if ($old_avatar_id): ?>
            <form method="post">
                <input type="hidden" name="action" value="delete_user_avatar">
                <input type="submit" value="По умолчанию" onclick="return confirm('Вы уверены, что хотите удалить изображение?');" class="default-button">
            </form>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('user_avatar_form', 'user_avatar_upload_form');

function handle_user_avatar_upload() {
    global $error_message; // Получаем глобальную переменную

    if (isset($_POST['action'])) {
        $user_id = get_current_user_id();

        if ($user_id) {
            if ($_POST['action'] === 'upload_user_avatar' && !empty($_FILES['user_avatar'])) {
                
                // Проверяем размер файла
                $file_size = $_FILES['user_avatar']['size'];
                $max_file_size = 4 * 1024 * 1024; 

                if ($file_size > $max_file_size) {
                    $error_message = 'Файл больше 4мб'; // Устанавливаем сообщение об ошибке
                    return;
                }

                update_user_avatar($user_id);
            } elseif ($_POST['action'] === 'delete_user_avatar') {
                // Удаляем аватар
                $old_avatar_id = get_user_meta($user_id, 'user_avatar', true);
                
                if ($old_avatar_id) {
                    wp_delete_attachment($old_avatar_id, true);
                    delete_user_meta($user_id, 'user_avatar');
                }
            }
        }
    }
}
add_action('init', 'handle_user_avatar_upload');



//----------------------------------------------//
//--WYSIWYG--
$wysiwygConfig = function ( $wysiwyg_config ) {
    $plugins         = array(
        'colorpicker',
        'textcolor',
    );
    $toolbar_buttons = array(
        '|',
        'forecolor',
        'backcolor',
        'underline'
    );
    $wysiwyg_config['tinymce']['plugins']  .= ',' . implode( ',', $plugins );
    $wysiwyg_config['tinymce']['toolbar1'] .= ',' . implode( ',', $toolbar_buttons );
    return $wysiwyg_config;
};
add_filter( 'jet-form-builder/fields/wysiwyg-field/config', $wysiwygConfig );
function custom_mce_buttons() {
    add_filter("mce_buttons_2", "add_underline_button");
}
function add_underline_button($buttons) {
    array_push($buttons, "underline");
    return $buttons;
}add_action("admin_init", "custom_mce_buttons");


//----------------------------------------------//
//--Ограничить доступ к медиатеке автору--
//add_filter( 'posts_where', 'devplus_attachments_wpquery_where' );
//function devplus_attachments_wpquery_where( $where ){
//  global $current_user;
//  if( is_user_logged_in() ){
//      if( isset( $_POST['action'] ) ){
//          if( $_POST['action'] == 'query-attachments' ){
//              $where .= ' AND post_author='.$current_user->data->ID;}}}
//return $where;}


//----------------------------------------------//


//--Редирект на стр авторизации, чтобы оставить комментарий--
add_filter( 'login_url', 'wpse_290288_custom_login_url', 10, 3 );
function wpse_290288_custom_login_url( $login_url, $redirect, $force_reauth ) {
    $login_page_id = 10914;
    return get_permalink( $login_page_id );}
    

//----------------------------------------------//
//-- Вывести кол-во заказов у клиента в статусе обработка--
add_shortcode( 'orders_count', 'display_orders_count');
function display_orders_count() {
    $customer_id = get_current_user_id();
    $order_count = wc_get_orders( array(
        'limit'      => -1,
        'customer'   => $customer_id,
        'status' => array( 'processing', 'on-hold', 'pending', 'wc-delivery' ),
    ) );
    if (count($order_count) > 0) {
        echo count($order_count);
    }
}

function check_customer_orders(){
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $customer_orders = wc_get_orders( array(
            'customer_id' => $user_id,
            'status' => 'processing'
        ) );
        if ( !empty( $customer_orders ) ) {
            echo '<div style="display: flex; align-items: center;">'; echo '<img src="https://l-dog.ru/wp-content/uploads/2024/05/box.svg" style="width: 30px; height: 30px; margin-right: 8px;" />'; echo '<p style="margin: 0;">Ваш заказ на сборке</p>'; echo '</div>';
        }
    }
}
add_shortcode( 'check_customer_orders', 'check_customer_orders' );

function check_delivery_orders(){
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $customer_orders = wc_get_orders( array(
            'customer_id' => $user_id,
            'status' => 'wc-delivery'
        ) );
        // Если у пользователя есть заказы в статусе 'wc-delivery', выводим сообщение
        if ( !empty( $customer_orders ) ) {
            echo '<div style="display: flex; align-items: center;">'; echo '<img src="https://l-dog.ru/wp-content/uploads/2024/05/box1.svg" style="width: 30px; height: 30px; margin-right: 8px;" />'; echo '<p style="margin: 0;">Заказ передан в доставку  </p>'; echo '</div>';
        }
    }
}
add_shortcode( 'check_delivery_orders', 'check_delivery_orders' );
 
 
//----------------------------------------------//
//--Шорткод вывести стр платежи в приют-- 
function custom_shortcode_function() {
    ob_start();
    ?>
    <iframe src="https://l-dog.ru/donor-account/" width="100%" height="900px" frameborder="0"></iframe>
    <?php
    return ob_get_clean();}
add_shortcode('donor_account', 'custom_shortcode_function');


//----------------------------------------------//
//--Кастомизация лк донор--
add_action( 'init', 'leika_apply_css_if_url_contains_string' ); 
function leika_apply_css_if_url_contains_string() {
   $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   if ( false !== strpos( $url, 'donor-account' ) ) {
      echo '<style> 
       .header-tint {display:none!important;}
       .leyka-persistant-campaign .leyka-campaign-content .content-area .entry-content .leyka-pf-star{margin-top:50px!important; border-radius:30px!important;}
       .site-content {background-color:#F6F3EF!important;}
       .list-title {font-family:"Comic Sans MS"!important;}
       .leyka-screen-form h2{font-family:"Comic Sans MS"!important;}
       .entry-content p{font-family:"Comic Sans MS"!important;}
       .leyka-screen-form a{font-family:"Comic Sans MS"!important;}
       </style>';
   } 
}


//----------------------------------------------//
//--Изменить поля оформ заказа--
add_filter( 'woocommerce_order_button_text', 'wc_custom_order_button_text' ); 
function wc_custom_order_button_text() {
    return __( 'Оформить заказ', 'woocommerce' ); 
}

add_filter( 'woocommerce_checkout_fields', 'custom_override_checkout_fieldss' );
function custom_override_checkout_fieldss( $fields ) {
    $fields['billing']['billing_postcode']['required'] = false;
    $fields['billing']['billing_state']['required'] = false;
    $fields['billing']['billing_country']['required'] = false;
    
return $fields;
}

add_filter( 'woocommerce_default_address_fields', 'custom_override_default_address_fields' );
function custom_override_default_address_fields( $address_fields ) {
    $address_fields['city']['label'] = 'Город';
    return $address_fields;
}

add_filter( 'woocommerce_default_address_fields', 'custom_override_default_address_fields1' );
function custom_override_default_address_fields1( $address_fields ) {
    $address_fields['country']['label'] = 'Страна';
    return $address_fields;
}

add_filter( 'woocommerce_default_address_fields', 'change_checkout_fields_order' );
function change_checkout_fields_order( $fields ) {
    $fields['city']['priority'] = 70;
    $fields['address_1']['priority'] = 80;
    $fields['address_2']['priority'] = 90;
    return $fields;
}

add_filter( 'default_checkout_country', 'change_default_checkout_country' );
function change_default_checkout_country() {
    return 'RU';
}

add_filter( 'woocommerce_form_field', 'bbloomer_remove_optional_checkout_fields', 9999 );
function bbloomer_remove_optional_checkout_fields( $field ) {
   $field = preg_replace('/&nbsp;<span class="optional">(.*?)<\/span>/', '', $field );
   return $field;
}



//----------------------------------------------//
//--Скрытие полей доставки при вирт товарах, самовывозе, такси и  класс доставки delivery-nsk--
// Скрыть поля страна, город, штат при заказе с классом доставки delivery_nsk
add_filter('woocommerce_checkout_fields', 'hide_shipping_fields_if_delivery_nsk');
function hide_shipping_fields_if_delivery_nsk($fields) {
    // Проверить соответствует ли какой-либо товар в корзине классу delivery-nsk
    $delivery_nsk_cart_item = false;
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        if (has_term('delivery-nsk', 'product_shipping_class', $product->get_id())) {
            $delivery_nsk_cart_item = true;
            break;
        }
    }

    // Если есть продукт с классом delivery-nsk, добавьте пользовательский класс в поля
    if ($delivery_nsk_cart_item) {
        $fields['billing']['billing_country']['class'][] = 'delivery-nsk-hidden';
        $fields['billing']['billing_city']['class'][] = 'delivery-nsk-hidden';
        $fields['billing']['billing_city']['required'] = false;
    }

    return $fields;
}

add_filter('woocommerce_checkout_fields', 'customize_checkout_fields', 20); // Установим приоритет выше
function customize_checkout_fields($fields) {
    $cart = WC()->cart;
    $virtual_only = true;

    // Проверка на виртуальные товары
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (!$cart_item['data']->is_virtual()) {
            $virtual_only = false;
            break;
        }
    }

    // Скрытие полей для виртуальных товаров
    if ($virtual_only) {
        unset($fields['billing']['billing_city']);
        unset($fields['order']['order_comments']);
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_address_2']);
    } else {
        // Скрытие полей в зависимости от способа доставки
        $shipping_method_ids = array('flat_rate:38', 'local_pickup:45', 'official_cdek:136', 'boxberry_self:43');
        $hide_fields = array('billing_address_1', 'billing_address_2', 'billing_city');

        $chosen_methods = WC()->session->get('chosen_shipping_methods');
        $chosen_shipping = $chosen_methods[0];

        foreach ($hide_fields as $field) {
            if (in_array($chosen_shipping, $shipping_method_ids)) {
                $fields['billing'][$field]['required'] = false;
                $fields['billing'][$field]['class'][] = 'hide_field';
            }
            $fields['billing'][$field]['class'][] = 'billing-dynamic';
        }
    }

    return $fields;
}

// При перезагрузке странице восстанавливает логику скрытия полей
add_action('wp_ajax_get_selected_shipping_method', 'get_selected_shipping_method');
add_action('wp_ajax_nopriv_get_selected_shipping_method', 'get_selected_shipping_method');
function get_selected_shipping_method() {
    $chosen_methods = WC()->session->get('chosen_shipping_methods');
    if ($chosen_methods && isset($chosen_methods[0])) {
        wp_send_json_success(array('selectedShippingMethod' => $chosen_methods[0]));
    } else {
        wp_send_json_error();
    }
}


//----------------------------------------------//
//--Добавлен новый статус заказа "доставка"--
add_action('init', 'register_delivery_order_status');
function register_delivery_order_status(){
    register_post_status('wc-delivery', array(
        'label' => 'Доставка',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Доставка <span class="count">(%s)</span>', 'Доставка <span class="count">(%s)</span>')
    ));
    add_filter('wc_order_statuses', 'add_delivery_to_order_statuses');
    function add_delivery_to_order_statuses($order_statuses){
        $order_statuses['wc-delivery'] = _x('Доставка', 'Order status', 'woocommerce');
        return $order_statuses;
    }
}


//----------------------------------------------//
//--Добавить поля Кличка, Отчество у пользователя--
add_filter( 'woocommerce_customer_meta_fields', 'misha_admin_address_field' );
function misha_admin_address_field( $admin_fields ) {
    $admin_fields[ 'billing' ][ 'fields' ][ 'pet_name' ] = array(
        'label' => 'Кличка питомца',
        'description' => '',
    );
    return $admin_fields;}

add_filter('woocommerce_customer_meta_fields', 'misha_admin_address_field2');
function misha_admin_address_field2($admin_fields) {
    $original_billing_fields = $admin_fields['billing']['fields'];
    $new_billing_fields = array();
    foreach ($original_billing_fields as $key => $field) {
        $new_billing_fields[$key] = $field;
        if ($key === 'billing_first_name') {
            $new_billing_fields['billing_patronymic'] = array(
                'label' => 'Отчество',
                'description' => '',
            );
        }
    }
    $admin_fields['billing']['fields'] = $new_billing_fields;
    return $admin_fields;
}


//----------------------------------------------//
//--На стр оформления заказа поле кличка+отчество в лк--
// Добавляем поле "Кличка питомца" на страницу оформления заказа
add_action('woocommerce_before_order_notes', 'custom_checkout_fields');
function custom_checkout_fields($checkout) {
    woocommerce_form_field('pet_name', array(
        'type' => 'text',
        'label' => __('Кличка питомца'),
        'placeholder' => __('Если несколько, напишите через запятую'),
        'required' => true,
    ), $checkout->get_value('pet_name'));
}

add_action('woocommerce_checkout_update_order_meta', 'save_custom_checkout_fields');
function save_custom_checkout_fields($order_id) {
    if (!empty($_POST['pet_name'])) {
        $order = wc_get_order($order_id);
        $customer_id = $order->get_user_id();
        $order->update_meta_data('pet_name', sanitize_text_field($_POST['pet_name']));
        $order->save();
        if ($customer_id) {
            update_user_meta($customer_id, 'pet_name', sanitize_text_field($_POST['pet_name']));
        }
    }
}

// Показываем введенное значение поля "Кличка питомца" на странице заказа в админке
add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_checkout_fields_in_admin', 10, 1);
function display_custom_checkout_fields_in_admin($order) {
    echo '<p><strong>' . __('Кличка питомца') . ':</strong> ' . $order->get_meta('pet_name') . '</p>';
}

// Добавляем поле "Кличка питомца" в письма
add_filter('woocommerce_email_order_meta_fields', 'add_pet_name_to_order_email', 10, 3);
function add_pet_name_to_order_email($fields, $sent_to_admin, $order) {
    $pet_name = $order->get_meta('pet_name');
    if ($pet_name) {
        $fields['pet_name'] = array(
            'label' => __('Кличка питомца'),
            'value' => $pet_name,
        );
    }
    return $fields;
}

// Добавляем поле "Кличка питомца" в блок деталей о клиенте на странице информации о заказе в личном кабинете
add_action('woocommerce_order_details_after_customer_details', 'display_pet_name_and_full_name_in_customer_details', 10, 1);
function display_pet_name_and_full_name_in_customer_details($order) {
    $pet_name = $order->get_meta('pet_name');
    if ($pet_name) {
        echo '<p class="pet-name-field"><span class="paw-icon"></span> ' . $pet_name . '</p>';
    }
    
    // Добавляем ФИО в блок деталей о клиенте на странице информации о заказе в личном кабинете
    $first_name = $order->get_billing_first_name();
    $last_name = $order->get_billing_last_name();
    $patronymic = $order->get_meta('billing_patronymic');
    $full_name = trim($last_name . ' ' . $first_name . ' ' . $patronymic);
    if ($full_name) {
        echo '<p class="full-name-field"><span class="user-icon"></span> ' . $full_name . '</p>';
    }
}


//----------------------------------------------//
//--Отчество на стр офор заказа--
// Добавляем поле "Отчество" на страницу оформления заказа
add_action('woocommerce_before_order_notes', 'custom_checkout_fieldsss');
function custom_checkout_fieldsss($checkout) {
    woocommerce_form_field('billing_patronymic', array(
        'type' => 'text',
        'label' => __('Отчество'),
        'placeholder' => __('Введите ваше отчество'),
        'required' => true,
    ), $checkout->get_value('billing_patronymic'));
}

// Сохраняем значение поля "Отчество" в мета-данные заказа
add_action('woocommerce_checkout_update_order_meta', 'save_custom_checkout_fieldsss');
function save_custom_checkout_fieldsss($order_id) {
    if (!empty($_POST['billing_patronymic'])) {
        $order = wc_get_order($order_id);
        $order->update_meta_data('billing_patronymic', sanitize_text_field($_POST['billing_patronymic']));
        $order->save();
    }
}

// Показываем введенное значение поля "Отчество" на странице заказа в админке
add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_checkout_fieldsss_in_admin', 10, 1);
function display_custom_checkout_fieldsss_in_admin($order){
    echo '<p><strong>' . __('Отчество') . ':</strong> ' . $order->get_meta('billing_patronymic') . '</p>';
}


// Добавляем поле "ФИО" в письма
add_filter('woocommerce_email_order_meta_fields', 'add_full_name_to_order_email', 10, 3);
function add_full_name_to_order_email($fields, $sent_to_admin, $order) {
    $first_name = $order->get_billing_first_name();
    $last_name = $order->get_billing_last_name();
    $patronymic = $order->get_meta('billing_patronymic');
    $full_name = trim($last_name . ' ' . $first_name . ' ' . $patronymic);

    if ($full_name) {
        $fields['full_name'] = array(
            'label' => __('ФИО'),
            'value' => $full_name,
        );
    }
    return $fields;
}
//Удалить из письма фамилию и имя
add_filter('woocommerce_order_formatted_billing_address', 'remove_name_from_billing_address_in_emails', 10, 2);
function remove_name_from_billing_address_in_emails($address, $order) {
    unset($address['first_name']);
    unset($address['last_name']);
    return $address;
}


//----------------------------------------------//
//--Кнопка выйти--
function logout_button_shortcode() {
    return '<form id="logout_form" action="' . wp_logout_url() . '" method="post">
                <input type="submit" value="Выйти?">
            </form>';
}
add_shortcode('logout_button', 'logout_button_shortcode');

//----------------------------------------------//
//--Редирект со страницы мои заказы, если клиент не авторизован--
add_action('template_redirect', 'redirect_non_logged_user');
function redirect_non_logged_user(){
    if ( is_page('my-account') && !is_user_logged_in() ) {
        wp_redirect( home_url('/login') );
        exit;
    }
}


//----------------------------------------------//
//--Вывод третьей цены в каталоге товаров через шорткод--
function avs_get_third_price($atts) {
    global $product;
    if (!$product) {
        return '';
    }
    $product_id = $product->get_id();
    // Проверяем, является ли товар вариативным
    if ($product->is_type('variable')) {
        // Получаем все вариации товара
        $variations = $product->get_available_variations();
        $min_third_price = null;
        // Перебираем все вариации, чтобы найти минимальную "третью цену"
        foreach ($variations as $variation) {
            $third_price = get_post_meta($variation['variation_id'], 'third_price', true);
            if ($third_price !== '') {
                $third_price = floatval(str_replace(',', '.', $third_price)); // Преобразуем цену в число
                if (is_null($min_third_price) || $third_price < $min_third_price) {
                    $min_third_price = $third_price;
                }
            }
        }
        // Возвращаем минимальную "третью цену" в формате цены WooCommerce с префиксом "от"
        if (!is_null($min_third_price)) {
            return 'от ' . wc_price($min_third_price);
        }
    } else {
        // Получаем значение метаполя третьей цены для обычного товара
        $third_price = get_post_meta($product_id, 'third_price', true);

        // Проверяем наличие значения и возвращаем отформатированную цену
        if (!empty($third_price)) {
            $third_price = floatval(str_replace(',', '.', $third_price)); // Преобразуем цену в число
            return wc_price($third_price);
        }
    }
    return '';
}
add_shortcode('third_price', 'avs_get_third_price');


//----------------------------------------------//
//--Цена по подписке для клиентов с подпиской--
//изменяет цену товаров в корзине для пользователей с ролью member, устанавливая цену из мета-поля third_price для каждого товара, если это мета-поле существует и не пустое
add_action('woocommerce_before_calculate_totals', 'apply_third_price_in_cart', 10, 1);
function apply_third_price_in_cart($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        if (in_array('member', $user->roles)) {
            foreach ($cart->get_cart() as $cart_item) {
                $product = $cart_item['data'];
                $third_price = get_post_meta($product->get_id(), 'third_price', true);
                if (!empty($third_price)) {
                    $cart_item['data']->set_price($third_price);
                }
            }
        }
    }
}

//----------------------------------------------//
//--Цена по подписке для вариативных товаров--
// Добавляем новую цену для обычных товаров
add_action('woocommerce_product_options_pricing', 'add_third_price_field_simple');
function add_third_price_field_simple() {
    global $post;
    echo '<div class="options_group">';
    woocommerce_wp_text_input( array(
        'id'            => 'third_price',
        'name'          => 'third_price',
        'label'         => __( 'Цена по подписке', 'woocommerce' ),
        'desc_tip'      => true,
        'type'          => 'text',
        'description'   => __( 'Формат цены 90,5', 'woocommerce' ),
        'value'         => get_post_meta( $post->ID, 'third_price', true ),
    ));
    echo '</div>';
}

// Сохраняем значение метаполя для третьей цены при сохранении товара
add_action('woocommerce_process_product_meta', 'save_third_price_field_simple');
function save_third_price_field_simple($post_id) {
    $third_price = isset($_POST['third_price']) ? sanitize_text_field($_POST['third_price']) : '';
    update_post_meta($post_id, 'third_price', $third_price);
}

// Добавляем новую цену в админке для вариативных товаров
add_action( 'woocommerce_variation_options_pricing', 'add_third_price_field', 10, 3 );
function add_third_price_field( $loop, $variation_data, $variation ) {
    woocommerce_wp_text_input( array(
        'id'            => 'third_price['.$loop.']',
        'name'          => 'third_price['.$loop.']',
        'type'          => 'text',
        'label'         => __( 'Формат цены 90,5' ),
        'value'         => get_post_meta( $variation->ID, 'third_price', true ),
        'desc_tip'      => true,
    ));
}

// Сохраняем значение метаполя для третьей цены в вариации
add_action( 'woocommerce_save_product_variation', 'save_third_price_field', 10, 2 );
function save_third_price_field( $variation_id, $i ) {
    $third_price = $_POST['third_price'][$i];
    if( isset( $third_price ) ) {
        update_post_meta( $variation_id, 'third_price', esc_attr( $third_price ) );
    }
}

//Менялась цена по подписке на стр товара
add_action('wp_ajax_update_third_price', 'update_third_price_callback');
add_action('wp_ajax_nopriv_update_third_price', 'update_third_price_callback');
function update_third_price_callback() {
    $product_id = $_POST['product_id'];
    $third_price = get_post_meta($product_id, 'third_price', true);
    echo $third_price;
    wp_die();
}


//----------------------------------------------//
//--На страницах корзины и оформления выводит третью цену, распродажи и базовую цену--
add_filter('woocommerce_cart_item_subtotal', 'bbloomer_change_cart_item_subtotal_display', 30, 3);
function bbloomer_change_cart_item_subtotal_display($subtotal, $cart_item, $cart_item_key) {
    $product = $cart_item['data'];
    $quantity = $cart_item['quantity'];
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
    $third_price = get_post_meta($product->get_id(), 'third_price', true);
    $regular_total = $regular_price * $quantity;
    $sale_total = !empty($sale_price) ? $sale_price * $quantity : null;
    $third_total = !empty($third_price) ? $third_price * $quantity : null;

    if (!empty($third_price)) {
        if (!empty($sale_price)) {
            $subtotal = '<ins class="third-price">' . wc_price($third_total) . '</ins> <ins class="sale-price">' . wc_price($sale_total) . '</ins> <del class="regular-price">' . wc_price($regular_total) . '</del>';
        } else {
            $subtotal = '<ins class="third-price">' . wc_price($third_total) . '</ins> <span class="regular-price">' . wc_price($regular_total) . '</span>';
        }
    } else if (!empty($sale_price)) {
        $subtotal = '<ins class="sale-price">' . wc_price($sale_total) . '</ins> <del class="regular-price">' . wc_price($regular_total) . '</del>';
    } else {
        $subtotal = '<span class="regular-price">' . wc_price($regular_total) . '</span>';
    }
    return $subtotal;}


//----------------------------------------------//
//--В письмах менять адрес--
//В письмах поменять город на Новосибирск, если в заказе класс доставки
function update_city_on_delivery_nsk( $order_id ) {
    $order = wc_get_order( $order_id );
    $delivery_nsk_cart_item = false;
    foreach ( $order->get_items() as $item_id => $item ) {
        $product = $item->get_product();
        if ( has_term( 'delivery-nsk', 'product_shipping_class', $product->get_id() ) ) {
            $delivery_nsk_cart_item = true;
            break;
        }
    }
    if ( $delivery_nsk_cart_item ) {
        // Обновите поля для выставления счетов и отправки
        $order->set_shipping_city( 'Новосибирск' );
        $order->set_billing_city( 'Новосибирск' );
        $order->save();
    }
}

//Поменять город на Новосибирск в данных у клиента, если в заказе класс доставки
add_action( 'woocommerce_checkout_update_order_meta', 'update_city_on_delivery_nsk' );
function update_user_city_on_delivery_nsk( $user_id ) {
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $product = $cart_item['data'];
        if ( has_term( 'delivery-nsk', 'product_shipping_class', $product->get_id() ) ) {
            $delivery_nsk_cart_item = true;
            break;
        }
    }
    if ( $delivery_nsk_cart_item ) {
        update_user_meta( $user_id, 'billing_city', 'Новосибирск' );
        update_user_meta( $user_id, 'shipping_city', 'Новосибирск' );
    }
}
add_action( 'woocommerce_checkout_update_user_meta', 'update_user_city_on_delivery_nsk' );


//В письме очистить поля Адрес 1, Адрес 2 при самовывозе, такси, СДЭК, а при боксберри только Адрес 2
add_action( 'woocommerce_checkout_update_order_meta', 'clear_billing_address_fields_on_shipping_methods' );
function clear_billing_address_fields_on_shipping_methods( $order_id ) {
    $order = wc_get_order( $order_id );
    $shipping_methods = $order->get_shipping_methods();
    foreach ( $shipping_methods as $shipping_method ) {
        if ( ($shipping_method->get_method_id() === 'flat_rate' && $shipping_method->get_instance_id() == 38) || 
             ($shipping_method->get_method_id() === 'local_pickup' && $shipping_method->get_instance_id() == 45) ||
             (strpos($shipping_method->get_method_id(), 'official_cdek') !== false) ) {
            // Очистить поля адреса
            update_post_meta( $order_id, '_billing_address_1', '' );
            update_post_meta( $order_id, '_billing_address_2', '' );
            // Обновить объект заказа
            $order->set_billing_address_1( '' );
            $order->set_billing_address_2( '' );
            $order->save();
            break;
        }
        if ( $shipping_method->get_method_id() === 'boxberry_self' && $shipping_method->get_instance_id() == 43) {
            // Очистить поле адреса 2
            update_post_meta( $order_id, '_billing_address_2', '' );
            $order->set_billing_address_2( '' );
            $order->save();
            break;
        }
    }
}

//Очистить Адрес 1, Адрес 2 в данных у клиента при доставке СДЭК, а при боксберри Адрес 2
add_action( 'woocommerce_checkout_update_order_meta', 'clear_customer_address_fields_on_shipping_methods' );
function clear_customer_address_fields_on_shipping_methods( $order_id ) {
    $order = wc_get_order( $order_id );
    $shipping_methods = $order->get_shipping_methods();
    foreach ( $shipping_methods as $shipping_method ) {
        if ( strpos($shipping_method->get_method_id(), 'official_cdek') !== false ) {
            $customer_id = $order->get_user_id();
            if ( $customer_id ) {
                update_user_meta( $customer_id, 'billing_address_1', '' );
                update_user_meta( $customer_id, 'billing_address_2', '' );
                update_user_meta( $customer_id, 'shipping_address_1', '' );
                update_user_meta( $customer_id, 'shipping_address_2', '' );
            }
            update_post_meta( $order_id, '_billing_address_1', '' );
            update_post_meta( $order_id, '_billing_address_2', '' );
            update_post_meta( $order_id, '_shipping_address_1', '' );
            update_post_meta( $order_id, '_shipping_address_2', '' );
            $order->set_billing_address_1( '' );
            $order->set_billing_address_2( '' );
            $order->set_shipping_address_1( '' );
            $order->set_shipping_address_2( '' );
            $order->save();
            break;
        }
        
        if ( $shipping_method->get_method_id() === 'boxberry_self' && $shipping_method->get_instance_id() == 43 ) {
            $customer_id = $order->get_user_id();
            if ( $customer_id ) {
                update_user_meta( $customer_id, 'billing_address_2', '' );
                update_user_meta( $customer_id, 'shipping_address_2', '' );
            }
            update_post_meta( $order_id, '_billing_address_2', '' );
            update_post_meta( $order_id, '_shipping_address_2', '' );
            $order->set_billing_address_2( '' );
            $order->set_shipping_address_2( '' );
            $order->save();
            break;
        }
    }
}


//----------------------------------------------//
//--Описание доставки в письмах для СДЭК, самовывоз--
function save_shipping_method_description($order_id) {
    $order = wc_get_order($order_id);
    $chosen_shipping_methods = WC()->session->get('chosen_shipping_methods');
    $chosen_shipping_method = explode(':', $chosen_shipping_methods[0]);
    
    if ($chosen_shipping_method[0] === 'official_cdek') {
        $description = '
<p><span style="color: #04832f;"><img src="https://l-dog.ru/wp-content/uploads/2025/04/cdek.png" alt="CDEK" width="100" height="28" /></span></p>
<p><span style="color: #04832f;">Для удобства отслеживания посылки скачайте приложение СДЭК или смотрите на <a style="color: #04832f; text-decoration: underline;" href="https://www.cdek.ru/ru/tracking/">сайте</a>.<br>Когда посылка будет отправлена, Вам на почту от компании СДЭК придёт <strong>трек-номер</strong>, а также <strong>адрес ПВЗ</strong><br><span style="color: #636363;">Если возникли вопросы, напишите нам в <a style="color: #636363; text-decoration: underline;" href="https://t.me/ldog_support">службу заботы</a></span> ❤️</span></p>';
        $order->update_meta_data('_shipping_method_description', $description);
    } elseif ($chosen_shipping_method[0] === 'local_pickup' && $chosen_shipping_method[1] == 45) {
        $description = '<p><span style="color: #4872BA;"><strong>Адрес самовывоза: Троллейная 63</strong></span></p>';
        $order->update_meta_data('_shipping_method_description', $description);
    }
    $order->save();
}

add_action('woocommerce_checkout_update_order_meta', 'save_shipping_method_description');
// Функция для отображения мета-данных в письме о заказе
function display_shipping_method_description_in_email($order, $sent_to_admin, $plain_text, $email) {
    $description = $order->get_meta('_shipping_method_description');
    if ($description) {
        echo '<div>' . wp_kses_post($description) . '</div>';
    }
}
add_action('woocommerce_email_order_meta', 'display_shipping_method_description_in_email', 10, 4);


//----------------------------------------------//
//--Кнопка удалить товары на стр оформл заказа--
function lionplugins_woocommerce_checkout_remove_item( $product_name, $cart_item, $cart_item_key ) {
    if ( is_checkout() ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        $remove_link = apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
            '<a href="%s" class="remove-item-link" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
            esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
            __( 'Remove this item', 'woocommerce' ),
            esc_attr( $product_id ),
            esc_attr( $_product->get_sku() ),
            __( 'Удалить товар', 'woocommerce' )
        ), $cart_item_key );

        return '<span>' . $product_name . '</span><br><span>' . $remove_link . '</span>';
    }
    return $product_name;
}
add_filter( 'woocommerce_cart_item_name', 'lionplugins_woocommerce_checkout_remove_item', 10, 3 );


//----------------------------------------------//
//--Плюс и минус на стр корзины--
add_action( 'woocommerce_after_quantity_input_field', 'truemisha_quantity_plus', 25 );
add_action( 'woocommerce_before_quantity_input_field', 'truemisha_quantity_minus', 25 );
function truemisha_quantity_plus() {
    if ( ! is_cart() ) return;
    echo '<button type="button" class="plus">+</button>';
}
function truemisha_quantity_minus() {
    if ( ! is_cart() ) return;
    echo '<button type="button" class="minus">-</button>';}
    
    
//----------------------------------------------//
//--В корзине выводит Осталось меньше 10шт--
add_action('woocommerce_after_cart_item_name', 'bbloomer_low_stock_cart_item_title', 9999, 2);
function bbloomer_low_stock_cart_item_title($cart_item, $cart_item_key) {
    $product = $cart_item['data'];
    if ($product->backorders_require_notification() && $product->is_on_backorder($cart_item['quantity'])) {
        return;}
    $stock_quantity = $product->get_stock_quantity();
    if ($stock_quantity !== null && $stock_quantity < 10) {
        echo '<p class="low-stock-notice">Осталось только ' . $stock_quantity . ' шт.!</p>';
    }
}


//----------------------------------------------//
//--Процент скидки каждого товара в корзине--
add_filter('woocommerce_cart_item_name', 'display_discount_percentage_under_item_name', 20, 3);
function display_discount_percentage_under_item_name($product_name, $cart_item, $cart_item_key) {
    $product = $cart_item['data'];
    $regular_price = (float)$product->get_regular_price();
    $third_price = (float)get_post_meta($product->get_id(), 'third_price', true);
    if ($regular_price > 0 && $third_price > 0 && $regular_price > $third_price) {
        $discount_percentage = round((($regular_price - $third_price) / $regular_price) * 100);
        $product_name .= sprintf('<br><span class="discount-percentage">Скидка: -%d%%</span>', $discount_percentage);
    }
    return $product_name;}
    
    
//----------------------------------------------//
//--Убрать автоскролл в корзине и оформл заказа--
//в корзите java скрирт ещё добавлен
add_action('wp_footer','custom_js_function');
function custom_js_function(){
?>
<script>
 jQuery( document ).ajaxComplete( function(event, xhr, settings) {
            if ( jQuery( 'body' ).hasClass( 'woocommerce-checkout' ) || jQuery( 'body' ).hasClass( 'woocommerce-cart' ) ) {
                jQuery( 'html, body' ).stop();
            }
        } );
</script>
<?php
}

//----------------------------------------------//
//--Кнопка оставить отзыв на стр вакансии--
function change_comment_button_text( $args ) {
    global $post;
    // Проверяем, является ли текущий пост типом "job"
    if ( $post->post_type === 'job' ) {
        $args['label_submit'] = 'Оставить отзыв'; // Новый текст кнопки
    }
    return $args;
}
add_filter( 'comment_form_defaults', 'change_comment_button_text' );


//----------------------------------------------//
//--Список товаров мой аккаунт заказы--
// Отображение миниатюры продукта на страницах просмотра заказов Woocommerce
add_filter( 'woocommerce_order_item_name', 'wpsh_display_product_image_in_order_item', 20, 3 );
function wpsh_display_product_image_in_order_item( $item_name, $item, $is_visible ) {
    // Targeting view order pages only
    if( is_wc_endpoint_url( 'view-order' ) ) {
        $product   = $item->get_product(); 
        $thumbnail = $product->get_image(array( 50, 50)); 
        if( $product->get_image_id() > 0 )
            $item_name = '<div class="item-thumbnail">' . $thumbnail . '</div>' . $item_name;
    }
    return $item_name;
}

// Показать, как отображать название и количество товаров в новой колонке
add_filter( 'woocommerce_my_account_my_orders_columns', 'wpsh_product_column', 10, 1 );
function wpsh_product_column( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $name ) {
        $new_columns[ $key ] = $name;

        if ( 'order-status' === $key ) {
            $new_columns['order-items'] = __( 'Товар', 'woocommerce' );
        }
    }
    return $new_columns;
}

add_action( 'woocommerce_my_account_my_orders_column_order-items', 'wpsh_product_column_content', 10, 1 );
function wpsh_product_column_content( $order ) {
    $details = array();
    foreach( $order->get_items() as $item ) {
        $product_id = $item->get_product_id();
        $thumbnail = wp_get_attachment_image( get_post_thumbnail_id( $product_id ), array( 50, 50 ) );
        $details[] = $thumbnail . ' ' . $item->get_name() . ' × ' . $item->get_quantity();
    }

    echo count( $details ) > 0 ? implode( '<br>', $details ) : '–';
}

// Фильтр
add_filter( 'woocommerce_my_account_my_orders_query', 'bbloomer_my_account_orders_filter_by_status' );
function bbloomer_my_account_orders_filter_by_status( $args ) {
   if ( isset( $_GET['status'] ) && ! empty( $_GET['status'] ) ) {
      $args['status'] = array( $_GET['status'] );
   }
   return $args;
}
add_action( 'woocommerce_before_account_orders', 'bbloomer_my_account_orders_filters' );
function bbloomer_my_account_orders_filters() {
   echo '<p>Фильтр: ';
   $customer_orders = 0;
   foreach ( wc_get_order_statuses() as $slug => $name ) {
      $status_orders = count( wc_get_orders( [ 'status' => $slug, 'customer' => get_current_user_id(), 'limit' => -1 ] ) );
      if ( $status_orders > 0 ) {
         if ( isset( $_GET['status'] ) && ! empty( $_GET['status'] ) && $_GET['status'] == $slug ) { 
            echo '<b>' . $name . '</b><span class="delimit"> - </span>';
         } else echo '<a href="' . add_query_arg( 'status', $slug, wc_get_endpoint_url( 'orders' ) ) . '">' . $name . '</a><span class="delimit"> - </span>';
      }
      $customer_orders += $status_orders;
   }
   if ( isset( $_GET['status'] ) && ! empty( $_GET['status'] ) ) {
      echo '<a href="' . remove_query_arg( 'status' ) . '">Все заказы</a>';
   } else echo '<b>Все заказы</b>';
   echo '</p>';
}


//----------------------------------------------//
//--Общая сумма скидки в корзине--
add_action( 'woocommerce_cart_totals_after_order_total', 'bbloomer_show_total_discount_cart_checkout', 9999 ); 
function bbloomer_show_total_discount_cart_checkout() {
    $discount_total = 0;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
        $product = $values['data']; 
        if ( $product->is_on_sale() ) { 
            $regular_price = $product->get_regular_price(); 
            $third_price = get_post_meta($product->get_id(), 'third_price', true); 
            $discount = ( (float)$regular_price - (float)$third_price ) * (int)$values['quantity']; 
            $discount_total += $discount; 
        } 
    }
    if ( $discount_total > 0 ) { 
        echo '<div class="custom-discount-message"><img src="https://l-dog.ru/wp-content/uploads/2025/03/pets-3-1.png" alt="Icon" class="icon"> Экономия с подпиской: ' . wc_price( -$discount_total + WC()->cart->get_discount_total() ) . '</div>'; 
    } 
}
 
add_action( 'woocommerce_cart_totals_after_order_total', 'bbloomer_show_total_discount_cart_checkout1', 9999 );  
function bbloomer_show_total_discount_cart_checkout1() {   
   $discount_total = 0;  
   foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {         
      $product = $values['data'];
      if ( $product->is_on_sale() ) {
         $regular_price = $product->get_regular_price();
         $sale_price = $product->get_sale_price();
         $discount = ( (float)$regular_price - (float)$sale_price ) * (int)$values['quantity'];
         $discount_total += $discount;
      }
   }          
   if ( $discount_total > 0 ) {
      echo '<div class="custom-discount-message2">Без подписки: ' . wc_price( -$discount_total + WC()->cart->get_discount_total() ) . '</div>';
   }
}


//----------------------------------------------//
//--Подписка активна до "дата"--
function wc_membership_expiration_date_shortcode() {
    if ( ! function_exists( 'wc_memberships_get_user_memberships' ) ) {
        return '';
    }
    $user_id = get_current_user_id();
    if ( $user_id > 0 ) {
        $memberships = wc_memberships_get_user_memberships( $user_id );
        foreach ( $memberships as $membership ) {
            if ( $membership->is_active() ) {
                $end_date = $membership->get_end_date();
                if ( $end_date ) {
                    return 'Подписка активна до ' . date_i18n( get_option( 'date_format' ), strtotime( $end_date ) );
                }
            }
        }
    }
    return '';
}
add_shortcode( 'membership_expiration_date', 'wc_membership_expiration_date_shortcode' );


//----------------------------------------------//
//--Изменить надпись после покупки memberships--
function custom_memberships_thank_you(){
    $thank_you_message = "<span style='font-family: \"Comic Sans MS\", cursive, sans-serif;'>Ура! Вы оформили подписку, теперь покупки станут выгоднее, а скидка на доставку станет больше! 🌺 </span>";
    return $thank_you_message;
}
add_filter( 'woocommerce_memberships_thank_you_message', 'custom_memberships_thank_you' );


//----------------------------------------------//
//--Сервисный сбор--
add_action('woocommerce_cart_calculate_fees', 'add_service_fee');
function add_service_fee() {
    if (is_checkout()) { 
        $has_membership_products = false;
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product_id = $cart_item['product_id'];
            if (has_term('membership', 'product_cat', $product_id)) {
                $has_membership_products = true;
                break; 
            }
        }
        if (!$has_membership_products) {
            $fee = 20; // фиксированный сервисный сбор
            WC()->cart->add_fee(__('Сервисный сбор', 'your-text-domain'), $fee);
        }
    }
}


//----------------------------------------------//
//--Процент скидки в каталоге--
// Добавление шорткода [discount_percentage]
function discount_percentage_shortcode($atts) {
    global $product;
    if (!$product) {
        return '';
    }
    // Получаем базовую цену и цену third_price
    $regular_price = (float)$product->get_regular_price();
    $third_price = (float)$product->get_meta('third_price'); 
    if ($product->is_type('variable')) {
        $max_discount_percentage = 0;
        $variations = $product->get_available_variations();

        foreach ($variations as $variation) {
            $variation_product = wc_get_product($variation['variation_id']);
            $variation_regular_price = (float)$variation_product->get_regular_price();
            $variation_third_price = (float)$variation_product->get_meta('third_price');
            if ($variation_regular_price > 0 && $variation_third_price > 0) {
                $discount_percentage = (($variation_regular_price - $variation_third_price) / $variation_regular_price) * 100;
                $discount_percentage = round($discount_percentage);
                if ($discount_percentage > $max_discount_percentage) {
                    $max_discount_percentage = $discount_percentage;
                }
            }
        }

        if ($max_discount_percentage > 0) {
            return sprintf('%d%%', $max_discount_percentage);
        } else {
            return ''; 
        }
    } else {
        // Обычный продукт, просто проверяем
        if ($regular_price > 0 && $third_price > 0) {
            $discount_percentage = (($regular_price - $third_price) / $regular_price) * 100;
            $discount_percentage = round($discount_percentage);
            if ($discount_percentage > 0) {
                return sprintf('%d%%', $discount_percentage);
            }
        }
    }
    return ''; // Если скидки нет, ничего не выводим
}
add_shortcode('discount_percentage', 'discount_percentage_shortcode');


//----------------------------------------------//
//--Текущая страница в форме оценки заказа--
function current_page_url_shortcode() {
global $wp;
return home_url( $wp->request );}
add_shortcode('current_page_url', 'current_page_url_shortcode');


//----------------------------------------------//
//--Скрыть вкладки и медиа для shop manager--
function custom_remove_menu_items() {
    if (current_user_can('shop_manager')) {
        remove_menu_page('edit.php'); // Убираем "Записи"
        remove_menu_page('edit.php?post_type=page'); // Убираем "Страницы"
        remove_menu_page('elementor');
        remove_menu_page('edit.php?post_type=jet-form-builder');
        remove_menu_page('edit.php?post_type=job'); 
        remove_menu_page('edit.php?post_type=reviewsvet'); // отзывы ветеринаров
        remove_menu_page('edit.php?post_type=commercial'); //реклама
        remove_menu_page('edit.php?post_type=shelter'); 
        remove_menu_page('themes.php'); 
        remove_menu_page('edit.php?post_type=vetdietologi');
        remove_menu_page('tools.php');
        remove_menu_page('options-general.php');
        remove_menu_page('getwooplugins'); 
        remove_menu_page('options-general.php?page=updraftplus'); 
        remove_menu_page('jet-dashboard'); 
        remove_menu_page('jet-engine');
        remove_menu_page('jet-smart-filters');
        remove_menu_page('edit.php?post_type=elementor_library');
        remove_menu_page('WP-Optimize');    
        remove_menu_page('wt_geotargeting');
        remove_menu_page('hmwp_settings');
        remove_menu_page('asl_settings');
        remove_menu_page('snippets');   
        remove_menu_page('rank-math');
        remove_menu_page('wpxtension', 'variation-price-display');
        remove_menu_page('index.php');
        remove_menu_page('wcusage');
    }
}
add_action('admin_menu', 'custom_remove_menu_items', 99); 

function remove_add_menu_item_from_admin_bar() {
    if (current_user_can('shop_manager')) {
        global $wp_admin_bar;
        $wp_admin_bar->remove_node('new-content');
        $wp_admin_bar->remove_node('woocommerce-site-visibility-badge');
    }
}
add_action('admin_bar_menu', 'remove_add_menu_item_from_admin_bar', 100);

function shapeSpace_remove_toolbar_menu() {
    global $wp_admin_bar;
        $wp_admin_bar->remove_menu('updraft_admin_node');
}
add_action('wp_before_admin_bar_render', 'shapeSpace_remove_toolbar_menu', 999);
function restrict_media_library( $query ) {
    if ( ! current_user_can( 'administrator' ) ) {
        $current_user_id = get_current_user_id();
        if ( isset( $query->query['post_type'] ) && $query->query['post_type'] === 'attachment' ) {
            $query->set( 'author', $current_user_id );
        }
    }
}
add_action( 'pre_get_posts', 'restrict_media_library' );

function custom_upload_size_limit( $file ) {
    $current_user = wp_get_current_user();
        if ( in_array( 'shop_manager', (array) $current_user->roles ) ) {
        $max_size = 10 * 1024 * 1024; // 10 МБ в байтах
        if ( $file['size'] > $max_size ) {
            $file['error'] = 'Размер файла не должен превышать 10 МБ.';
        }
    }
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'custom_upload_size_limit' );


//----------------------------------------------//
//--Скрыть списать бонусы в оформл заказа, если бонусов нет--
add_filter('bfw_not_use_points_text','my_bfw_not_use_points_text', 10, 1);
function my_bfw_not_use_points_text($text) {
    if (is_checkout()) {
        return '';
    }
    return $text; }
  
    
//----------------------------------------------//
//--Бонусы у кого подписка не сгорают--    
add_filter( 'bfw-exclude-role-for-cron', 'bfw_exlude_role_in_cron',10,2 );
function bfw_exlude_role_in_cron($exclude_role){
$exclude_role = array_merge($exclude_role, array('member')); 
return $exclude_role;} 


//----------------------------------------------//
//--Догибонусы начисляются только при наличной оплате--
add_filter('bfw-completed-points', function($points, $order_id, $order) {
    // Проверяем способ оплаты
    if ($order->get_payment_method() !== 'cod') {
        return 0; // Устанавливаем бонусы в 0 для всех способов оплаты, кроме наличных
    }
    return $points; 
}, 10, 3);

//На странце оформления заказа отображать кешбек только при выборе наличного способа оплаты
add_filter('bfw-cart-cashback-display-amount', 'adjust_cashback_based_on_payment_method', 10, 1);
function adjust_cashback_based_on_payment_method($cashback_this_order) {
    $woocommerce = WC();
    $chosen_payment_method = $woocommerce->session->get('chosen_payment_method');
    // Если метод оплаты не "наличными" (код метода 'cod'), то не отображать
    if ($chosen_payment_method !== 'cod') {
        return 0; // Обнуляем кэшбэк
    }
    return $cashback_this_order;
}
    

//----------------------------------------------//
//--SMTP для почты--
function custom_smtp_mail( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.beget.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Username = 'info@l-dog.ru'; 
    $phpmailer->Password = '12Qwerfdsa!!63'; 
    $phpmailer->SMTPSecure = 'ssl'; 
    $phpmailer->Port = 465;
    $phpmailer->setFrom( 'info@l-dog.ru', 'LDOG' ); // Адрес и имя отправителя
    $phpmailer->addReplyTo( 'shop@l-dog.ru', 'LDOG' ); // Ответ на тот же адрес
}
add_action( 'phpmailer_init', 'custom_smtp_mail' );


//----------------------------------------------//
//--Только имя в отзывах товаров--
add_filter( 'get_comment_author', 'wpse_use_user_first_name_only', 10, 3 );
function wpse_use_user_first_name_only( $author, $comment_id, $comment ) {
    $firstname = '';
    $user_id = $comment->user_id;
    if ( $user_id ) {
        $user_object = get_userdata( $user_id );
        $firstname = $user_object->user_firstname; 
    }
    if ( $firstname ) {
        $author = $firstname;
    }
    return $author;}
    
    
//----------------------------------------------//
//--Все покупки клиента--//
add_action( 'jet-engine/register-macros', function() { 
    class Purchased_Products_Macro extends \Jet_Engine_Base_Macros {
        public function macros_tag() {
            return 'purchased_products';}

        public function macros_name() {
            return esc_html__( 'Purchased products', 'jet-engine' );}

        public function macros_args() {
            return array();}

        public function macros_callback( $args = array() ) {
            $user_id = get_current_user_id();
            if ( ! $user_id || ! function_exists( 'WC' ) ) {
                return;
            }

            $args = array(
                'customer_id' => $user_id,
                'limit'     => -1,
                'orderby'   => 'date', // Сортировка по дате
                'order'     => 'DESC', // Последние заказы первыми
                'status'    => array(
                    'completed',
                ),
            );

            $orders = wc_get_orders( $args );
            if ( empty( $orders ) ) {
                return esc_html__( ' ', 'jet-engine' );}
            $products = array();
            foreach ( $orders as $order ) {
                $items = $order->get_items();

                foreach ( $items as $item ) {
                    $products[] = $item->get_data()['product_id'];
                }
            }
            return implode( ',', $products );
        }
    }
    new Purchased_Products_Macro();  
} );


//----------------------------------------------//
//--Удалить медиа при удаления поста--
add_action( 'before_delete_post', function( $id ) {
$attachments = get_attached_media( '', $id );
foreach ($attachments as $attachment) {
wp_delete_attachment( $attachment->ID, 'true' );
}
} );


//----------------------------------------------//
//--Сделать первое фото в галерее миниатюрой поста--
add_action( 'save_post', function ( $post_id, $post, $update ) {
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;}
if ( wp_is_post_revision( $post_id ) ) {
    return;}
if ( get_post_type( $post_id ) !== 'history' ) {
    return;}
add_action('shutdown', function() use ($post_id) {
    $gallery_key = 'history_gallery';  
    $gallery = get_post_meta( $post_id, $gallery_key, true );
   if ( empty( $gallery ) ) {
        return; }
   if ( is_string( $gallery ) ) {
        $gallery = explode( ',', $gallery );}
$image_id = is_array( $gallery ) ? $gallery[0] : $gallery;
set_post_thumbnail( $post_id, $image_id );
});
}, 99, 3 );


add_action( 'save_post', function ( $post_id, $post, $update ) {
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;}
if ( wp_is_post_revision( $post_id ) ) {
    return;}
if ( get_post_type( $post_id ) !== 'shelter' ) {
    return;}
add_action('shutdown', function() use ($post_id) {
    $gallery_key = 'galereia_shelter';  
    $gallery = get_post_meta( $post_id, $gallery_key, true );
   if ( empty( $gallery ) ) {
        return; }
   if ( is_string( $gallery ) ) {
        $gallery = explode( ',', $gallery );}
$image_id = is_array( $gallery ) ? $gallery[0] : $gallery;
set_post_thumbnail( $post_id, $image_id );
});
}, 99, 3 );


//----------------------------------------------//
//--Slug архив автора--
// 1. Обработка запроса - заменяет author_name на ID автора по nickname
add_filter('request', 'wpse5742_request');
function wpse5742_request($query_vars) {
    if (array_key_exists('author_name', $query_vars)) {
        global $wpdb;
        $author_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT user_id FROM {$wpdb->usermeta} 
                WHERE meta_key='nickname' AND meta_value = %s",
                $query_vars['author_name']
            )
        );
        if ($author_id) {
            $query_vars['author'] = $author_id;
            unset($query_vars['author_name']);
        }
    }
    return $query_vars;
}

// 2. Изменение URL автора - заменяет nicename на nickname
add_filter('author_link', 'wpse5742_author_link', 10, 3);
function wpse5742_author_link($link, $author_id, $author_nicename) {
    $author_nickname = get_user_meta($author_id, 'nickname', true);
    if ($author_nickname) {
        $link = str_replace($author_nicename, $author_nickname, $link);
    }
    return $link;
}

// 3. Автоматическое обновление user_nicename при обновлении профиля
add_action('user_profile_update_errors', 'wpse5742_set_user_nicename_to_nickname', 10, 3);
function wpse5742_set_user_nicename_to_nickname(&$errors, $update, &$user) {
    if (!empty($user->nickname)) {
        $user->user_nicename = sanitize_title($user->nickname, $user->display_name);
    }
}


//----------------------------------------------//
//--Добавить в корзину на стр товара ajax--
function ace_ajax_add_to_cart_handler() {
    WC_Form_Handler::add_to_cart_action();
    WC_AJAX::get_refreshed_fragments();}
add_action( 'wc_ajax_ace_add_to_cart', 'ace_ajax_add_to_cart_handler' );
add_action( 'wc_ajax_nopriv_ace_add_to_cart', 'ace_ajax_add_to_cart_handler' );
remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );
add_filter( 'wc_add_to_cart_message_html', '__return_null' );


//----------------------------------------------//
//--Убрать диапазон цен на стр товара--
add_action( 'wp_enqueue_scripts', 'enqueue_variation_price_script' );
function enqueue_variation_price_script() {
    if ( is_product() ) {
        global $product;

        if ( $product && is_a( $product, 'WC_Product_Variable' ) ) {
            $prices = $product->get_variation_prices()['price'];
            if ( count( array_unique( $prices ) ) > 1 ) {
                wp_enqueue_script( 'variation-price', get_template_directory_uri() . '/js/variation-price.js', array( 'jquery' ), null, true );
                wp_localize_script( 'variation-price', 'product_data', array(
                    'product_id' => get_the_ID(),
                ));
            }
        }
    }
}

add_filter( 'woocommerce_variable_sale_price_html', 'ts_replace_variable_price_range', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'ts_replace_variable_price_range', 10, 2 );
function ts_replace_variable_price_range( $price, $product ) {
    if ( is_product() && is_a( $product, 'WC_Product_Variable' ) ) {
        $prices = $product->get_variation_prices()['price'];
        if ( count( array_unique( $prices ) ) > 1 ) {
            return '<span class="woocommerce-Price-amount amount" id="variable-product-price">' . wc_price( min( $prices ) ) . '</span>';
        }
    }
    return $price;
}


//----------------------------------------------//
//--Кнопки вариации товаров на стр товара--
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'rudr_radio_variations', 20, 2);
function rudr_radio_variations($html, $args) {
    $options = $args['options'];
    $product = $args['product'];
    $attribute = $args['attribute'];
    $name = $args['name'] ?: 'attribute_' . sanitize_title($attribute);
    $id = $args['id'] ?: sanitize_title($attribute);
    $class = $args['class'];

    if (empty($options) || !$product) {
        return $html;
    }

    $available_variations = $product->get_available_variations();
    $radios = '<div class="rudr-variation-radios">';

    if (taxonomy_exists($attribute)) {
        $terms = wc_get_product_terms($product->get_id(), $attribute, ['fields' => 'all']);

        foreach ($terms as $term) {
            if (in_array($term->slug, $options, true)) {
                $is_in_stock = false;
                foreach ($available_variations as $variation) {
                    if (in_array($term->slug, $variation['attributes'], true)) {
                        $is_in_stock = $variation['is_in_stock'];
                        break;
                    }
                }
                $disabled_class = !$is_in_stock ? 'disabled' : '';
                $radios .= sprintf(
                    '<input type="radio" id="%1$s-%2$s" name="%1$s" value="%2$s"%3$s %5$s><label for="%1$s-%2$s" class="%4$s">%6$s</label><br />',
                    esc_attr($name),
                    esc_attr($term->slug),
                    checked($args['selected'], $term->slug, false),
                    esc_attr($disabled_class),
                    $disabled_class ? 'disabled' : '',
                    esc_html($term->name)
                );
            }
        }
    } else {
        foreach ($options as $option) {
            $is_in_stock = false;
            foreach ($available_variations as $variation) {
                if (in_array($option, $variation['attributes'], true)) {
                    $is_in_stock = $variation['is_in_stock'];
                    break;
                }
            }
            $disabled_class = !$is_in_stock ? 'disabled' : '';
            $checked = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
            $radios .= sprintf(
                '<input type="radio" id="%1$s-%2$s" name="%1$s" value="%2$s"%3$s %5$s><label for="%1$s-%2$s" class="%4$s">%6$s</label>',
                esc_attr($name),
                esc_attr($option),
                $checked,
                esc_attr($disabled_class),
                $disabled_class ? 'disabled' : '',
                esc_html($option)
            );
        }
    }
    $radios .= '</div>';
    return $html . $radios;
}


//----------------------------------------------//
//--Изменить логотип входа в админку--
function my_custom_login_logo() { 
    echo '<style type="text/css"> 
    h1 a { background-image:url(https://l-dog.ru/wp-content/uploads/2025/04/logo-ldog.svg) !important; } 
    </style>'; 
    } 
add_action('login_head', 'my_custom_login_logo');

add_filter( 'login_display_language_dropdown', '__return_false' );

add_filter( 'login_headerurl', 'custom_loginlogo_url' );

function custom_loginlogo_url($url) {
     return 'https://l-dog.ru';
}


//----------------------------------------------//
//--Убрать Подытог в личном кабинете в информации о заказе--
add_filter( 'woocommerce_get_order_item_totals', function( $totals, $order, $tax_display ) {
    if ( isset( $totals['cart_subtotal'] ) ) {
        unset( $totals['cart_subtotal'] );
    }
    return $totals;
}, 10, 3 );


//----------------------------------------------//
//--Уведомление выключить VPN на стр оформления заказа--
add_action( 'woocommerce_before_checkout_form', 'add_vpn_warning_message' );
function add_vpn_warning_message() {
    wc_print_notice( 'Выключите VPN, если включён, во избежание ошибок. Спасибо! ☺️', 'success' );
}
