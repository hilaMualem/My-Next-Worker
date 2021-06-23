<?php
/*
Template Name: Buy package
*/
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>
  <?php get_header(); ?>
<body <?php body_class(); ?> style="font-family: Rubik, sans-serif" >
<?php wp_body_open(); ?>

<div class="package-price" id="tabs">
        <div class="package-price__body">
            <h1 class="qa__title"><?=get_the_title()?></h1>
            <p class="qa__subtitle"><?= get_field('subtitle'); ?></p>
            
            <div class="plan-switcher-block">
              <div class="plan-switcher">            
                <div>חודשי</div>              
                <label class="switch" for="packCheckbox">
                  <input type="checkbox" id="packCheckbox" onchange="calc()" checked />
                  <div class="slider round"></div>
                </label>
                <div>שנתי</div>
              </div>
            </div>
            
            <?php
               $taxonomy     = 'product_cat';
                $orderby      = 'name';  
                $show_count   = 0;      // 1 for yes, 0 for no
                $pad_counts   = 0;      // 1 for yes, 0 for no
                $hierarchical = 1;      // 1 for yes, 0 for no  
                $title        = '';  
                $empty        = 0;
              
                $args = array(
                       'taxonomy'     => $taxonomy,
                       'orderby'      => $orderby,
                       'show_count'   => $show_count,
                       'pad_counts'   => $pad_counts,
                       'hierarchical' => $hierarchical,
                       'title_li'     => $title,
                       'hide_empty'   => $empty
                );
               $all_categories = get_categories( $args );
               
               $cat = $all_categories[0];
               $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 10,
                    'product_cat'    => $cat->name,
                    'order_by' => 'ID',
                );
               $products = new WP_Query($args); 
               $products = $products->posts;
                // var_export($products);
            ?>

            <div class="why-us">
            	<div class="why-us__body" id="monthly">
               
               <?php 
               $i=1;
               foreach($products as $key => $val): 
               ?>
                 <?php $cur_prod = wc_get_product($val->ID); ?>
                  <div class="why-us__card why-us-card package-price-box package-price--active">
                  <?php if($i++<4): ?>
                    <div class="why-us-card__title package-price-box__header"><?=$cur_prod->get_title()?></div>
    
                    <div class="package-price-box__subtitle">
                      <?=$val->post_excerpt?>
                    </div>
                        
                    <div class="package-price-box__price">  <?=$cur_prod->get_price()?> <?=get_woocommerce_currency_symbol()?> </div>
                    <div class="package-price-box__price-exp"> בתשלום חודשי מתחדש </div>
                    
                    <!--<div class="price"> <?=$cur_prod->get_regular_price()?> </div>
                    
                    <div class="price"> <?=$cur_prod->get_sale_price()?> </div>-->
                      
                      <a href='<?=wc_get_checkout_url() . "?add-to-cart=" . $cur_prod->get_id() . "&quantity=1"?>' class="package-price-box__button package-price-box__button--black">בחר/י</a>
                      
                      <?php
                      
                        if( have_rows('product_view_attr',$val->ID ) ):
                            $top = [];
                            $bottom = [];
                            while( have_rows('product_view_attr',$val->ID) ) : the_row();
                                $top_val = get_sub_field('product_top_attr_val');
                                $bottom_val = get_sub_field('product_bottom_attr_val');
                                array_push( $top, $top_val );
                                array_push( $bottom, $bottom_val );
                          // End loop.
                            endwhile;
                        endif;
                      ?>
                      
                      <ul class="package-price-box-desc package-price-box-desc--standart">
                         <!-- <?php/* foreach($top as $key => $val):  */?>
                          <li><div style="width: 100%; text-align: start;"><?php/* echo $val */?></div></li>
                        <?php/* endforeach; */?>  -->
                          <li><div style="width: 100%; text-align: start;"><?php echo $top[0]?></div></li>
                      </ul>
                      
                      <div class="package-price-box__devider"></div>
                      
                      <ul class="package-price-box-desc package-price-box-desc--rounded">
                        <?php foreach($bottom as $key => $val):  ?>
                          <li><div style="width: 100%; text-align: start;"><?=$val?></div></li>
                        <?php endforeach; ?>
                      </ul>
                      <?php else: ?>
                        <div class="bank-content-table">
                          <div class="titel-descriptions">
                            <div class="why-us-card__title package-price-box__header"><?=$cur_prod->get_title()?></div>
                            <div class="package-price-box__subtitle"><?=$val->post_excerpt?></div>
                            <div class="package-price-box__price">  <?=$cur_prod->get_price()?> <?=get_woocommerce_currency_symbol()?> </div>
                          </div>
                          <?php if( have_rows('product_view_attr',$val->ID ) ):
                            $top = [];
                            $bottom = [];
                            while( have_rows('product_view_attr',$val->ID) ) : the_row();
                              $top_val = get_sub_field('product_top_attr_val');
                              $bottom_val = get_sub_field('product_bottom_attr_val');
                              array_push( $top, $top_val );
                              array_push( $bottom, $bottom_val );
                            endwhile;
                          endif;?>                   
                          <ul class="package-price-box-desc package-price-box-desc--standart">
                            <!-- <?php/* foreach($top as $key => $val):  */?>
                            <li><div style="width: 100%; text-align: start;"><?php/* echo $val */?></div></li>
                            <?php/* endforeach; */?> -->
                            <li><div style="width: 100%; text-align: start;"><?php echo $top[0]?></div></li>
                          </ul>                    
                          <ul class="package-price-box-desc package-price-box-desc--rounded">
                            <?php foreach($bottom as $key => $val):  ?>
                            <li><div style="width: 100%; text-align: start;"><?=$val?></div></li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                        <a href='<?=wc_get_checkout_url() . "?add-to-cart=" . $cur_prod->get_id() . "&quantity=1"?>' class="package-price-box__button package-price-box__button--black">בחר/י</a>
                      <?php endif; ?>  
                  </div>
               <?php endforeach; ?>      
		        </div>
                    
          <?php
               $taxonomy     = 'product_cat';
                $orderby      = 'name';  
                $show_count   = 0;      // 1 for yes, 0 for no
                $pad_counts   = 0;      // 1 for yes, 0 for no
                $hierarchical = 1;      // 1 for yes, 0 for no  
                $title        = '';  
                $empty        = 0;
              
                $args = array(
                       'taxonomy'     => $taxonomy,
                       'orderby'      => $orderby,
                       'show_count'   => $show_count,
                       'pad_counts'   => $pad_counts,
                       'hierarchical' => $hierarchical,
                       'title_li'     => $title,
                       'hide_empty'   => $empty
                );
               $all_categories = get_categories( $args );
               
               $cat = $all_categories[1];
               $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 10,
                    'product_cat'    => $cat->name,
                    'orderby' => 'meta_value_num',
                    'meta_key' => '_price',
                    'order' => 'desc'
                    // 'order_by' => 'ID',
                );
               $products = new WP_Query($args); 
               $products = $products->posts;
            ?>

            <div class="why-us">
            	<div class="why-us__body" id="yearly" style="display: none">
               <?php
               $i=1;
                foreach($products as $key => $val): 
                ?>
                 <?php
                     $cur_prod = wc_get_product($val->ID);
                     // var_export($cur_prod);
                 ?>
                 <div class="why-us__card why-us-card package-price-box package-price--active">
                 <?php if($i++<4): ?>
        					<div class="why-us-card__title package-price-box__header"><?=$cur_prod->get_title()?></div>
  
        					<div class="package-price-box__subtitle">
        						<?=$val->post_excerpt?>
        					</div>
                      
                   <div class="package-price-box__price">  <?php echo $cur_prod->get_price()/12 ?> <?=get_woocommerce_currency_symbol()?> </div>
                   <!-- <div class="package-price-box__price-exp"> בתשלום שנתי מתחדש </div> -->
                   <div class="package-price-box__price-exp"> *12 </div>
                   
                   <!--<div class="price"> <?=$cur_prod->get_regular_price()?> </div>
                   
                   <div class="price"> <?=$cur_prod->get_sale_price()?> </div>-->
                    
                    <a href='<?=wc_get_checkout_url() . "?add-to-cart=" . $cur_prod->get_id() . "&quantity=1"?>' class="package-price-box__button package-price-box__button--black">בחר/י</a>
                    
                    <?php
                    
                      if( have_rows('product_view_attr',$val->ID ) ):
                 			    $top = [];
                          $bottom = [];
                			    while( have_rows('product_view_attr',$val->ID) ) : the_row();
                               $top_val = get_sub_field('product_top_attr_val');
                               $bottom_val = get_sub_field('product_bottom_attr_val');
                			        array_push( $top, $top_val );
                			        array_push( $bottom, $bottom_val );
                				// End loop.
                			    endwhile;
                			endif;
                    ?>
                    
                    <ul class="package-price-box-desc package-price-box-desc--standart">
                      <!-- <?php/* foreach($top as $key => $val):  */?>
                        <li><div style="width: 100%; text-align: start;"><?php/* echo $val */?></div></li>
                      <?php/* endforeach; */?> -->
                      <li><div style="width: 100%; text-align: start;"><?php echo $top[0] ?></div></li>
                    </ul>
                    
                    <div class="package-price-box__devider"></div>
                    
                    <ul class="package-price-box-desc package-price-box-desc--rounded">
                      <?php foreach($bottom as $key => $val):  ?>
                        <li><div style="width: 100%; text-align: start;"><?=$val?></div></li>
                      <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                        <div class="bank-content-table">
                          <div class="titel-descriptions">
                            <div class="why-us-card__title package-price-box__header"><?=$cur_prod->get_title()?></div>
                            <div class="package-price-box__subtitle"><?=$val->post_excerpt?></div>
                            <div class="package-price-box__price">  <?=$cur_prod->get_price()?> <?=get_woocommerce_currency_symbol()?> </div>
                          </div>
                          <?php if( have_rows('product_view_attr',$val->ID ) ):
                            $top = [];
                            $bottom = [];
                            while( have_rows('product_view_attr',$val->ID) ) : the_row();
                              $top_val = get_sub_field('product_top_attr_val');
                              $bottom_val = get_sub_field('product_bottom_attr_val');
                              array_push( $top, $top_val );
                              array_push( $bottom, $bottom_val );
                            endwhile;
                          endif;?>                   
                          <ul class="package-price-box-desc package-price-box-desc--standart">
                            <!-- <?php/* foreach($top as $key => $val):  */?>
                            <li><div style="width: 100%; text-align: start;"><?php/* echo $val */?></div></li>
                            <?php/* endforeach; */?> -->
                            <li><div style="width: 100%; text-align: start;"><?php echo $top[0] ?></div></li>
                          </ul>                    
                          <ul class="package-price-box-desc package-price-box-desc--rounded">
                            <?php foreach($bottom as $key => $val):  ?>
                            <li><div style="width: 100%; text-align: start;"><?=$val?></div></li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                        <a href='<?=wc_get_checkout_url() . "?add-to-cart=" . $cur_prod->get_id() . "&quantity=1"?>' class="package-price-box__button package-price-box__button--black">בחר/י</a>
                      <?php endif; ?> 
        				</div>
               <?php endforeach; ?>      
		        </div>
                    
            <!-- <div class="package-price-banner">
                <div class="package-price-banner__wrapper">
                  <h1 class="package-price-banner__h1">לרכישת חבילות לארגונים גדולים</h1>
                  <a href="#" class="package-price-banner__button">לחץ כאן</a>
                </div>
            </div> -->
        </div>
        
        
    </div>    
<?php get_footer(); ?>

<script>
    
var monthly;
var yearly;
var packCheckbox;
var swetcherVal = true;

window.onload = function () {
    monthly = document.getElementById('monthly');
    yearly = document.getElementById('yearly');
    packCheckbox = document.getElementById('packCheckbox');
}

function calc() {
  console.log(packCheckbox.checked);
  if(packCheckbox.checked) {
    showMonthlyPackBlock();
    hideYearlyPackBlock();
  } else {
    hideMonthlyPackBlock();
    showYearlyPackBlock();
  }
}

function hideYearlyPackBlock() {
    yearly.style.display = 'none';
}

function showYearlyPackBlock() {
    yearly.style.display = 'flex';
}

function hideMonthlyPackBlock() {
    monthly.style.display = 'none';
}

function showMonthlyPackBlock() {
    monthly.style.display = 'flex';
}

</script>

</body>
</html>