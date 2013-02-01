<?php
/**
 * Property Default Template for Single Property View
 *
 * Overwrite by creating your own in the theme directory called either:
 * property.php
 * or add the property type to the end to customize further, example:
 * property-building.php or property-floorplan.php, etc.
 *
 * By default the system will look for file with property type suffix first,
 * if none found, will default to: property.php
 *
 * Copyright 2010 Andy Potanin <andy.potanin@twincitiestech.com>
 *
 * @version 1.3
 * @author Andy Potanin <andy.potnain@twincitiestech.com>
 * @package WP-Property
*/

// Uncomment to disable fancybox script being loaded on this page
//wp_deregister_script('jquery-fancybox');
//wp_deregister_script('jquery-fancybox-css');
?>

<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
   <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }
  ?>

<?php the_post(); ?>

    <script type="text/javascript">
    var map;
    var marker;
    var infowindow;

    jQuery(document).ready(function() {


      if(typeof google == 'object') {
        initialize_this_map();
      } else {
        jQuery("#property_map").hide();
      }

    });


  function initialize_this_map() {
    <?php if($coords = WPP_F::get_coordinates()): ?>
    var myLatlng = new google.maps.LatLng(<?php echo $coords['latitude']; ?>,<?php echo $coords['longitude']; ?>);
    var myOptions = {
      zoom: <?php echo (!empty($wp_properties['configuration']['gm_zoom_level']) ? $wp_properties['configuration']['gm_zoom_level'] : 13); ?>,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(document.getElementById("property_map"), myOptions);

    infowindow = new google.maps.InfoWindow({
      content: '<?php echo WPP_F::google_maps_infobox($post); ?>',
      maxWidth: 500
    });

     marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: '<?php echo addslashes($post->post_title); ?>',
      icon: '<?php echo apply_filters('wpp_supermap_marker', '', $post->ID); ?>'
    });

    google.maps.event.addListener(infowindow, 'domready', function() {
    document.getElementById('infowindow').parentNode.style.overflow='hidden';
    document.getElementById('infowindow').parentNode.parentNode.style.overflow='hidden';
   });

   setTimeout("infowindow.open(map,marker);",1000);

    <?php endif; ?>
  }

  </script>


  <div id="container" class="container">
    <div id="content" class="row-fluid" role="main">
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


<!-- Featured Image & Title -->
    <div class="row-fluid">
      <div class="span9">

      <div id="myCarousel" class="carousel slide">
            <!-- Carousel items -->
            <div class="carousel-inner">
              <div class="active item">
                <?php if (has_post_thumbnail()) {
                the_post_thumbnail();
                }?>
              </div>
              <?php
            $argsgallery = array(
            'numberposts' => 50,
            'order'=> 'ASC',
            'post_mime_type' => 'image',
            'post_parent' => $post->ID,
            'post_type' => 'attachment'
            );
            $gallery = get_children( $argsgallery );
            $attr = array(
                'class' => "attachment-$size wp-post-image",
            );
            foreach( $gallery as $image ) {
                echo '<div class="item">';
                 echo '<a href="' . wp_get_attachment_url($image->ID) . '" rel="gallery-' . get_the_ID() . '">';
                 echo wp_get_attachment_image($image->ID, 'full', false, $attr);
                 echo '</a>';
                echo '</div>';
            }
            ?>
            </div>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
          </div>
        </div>

      <div class="span3">
         <h1 class="page-header"><?php the_title(); ?></h1>
          <hp><?php the_tagline(); ?></hp>
          <?php if($property['price']): ?>
                <h2 class="property_price"><?php echo $property['price']; ?></h2>
          <?php endif; ?>
      </div>
    </div>

<!-- Belangrijkste eigenschappen -->
    <div class="row-fluid">
      <div class="span9">
        <div class="row-fluid">
          <?php if($property['kamers']): ?>
            <div class="span3">
              <p><i class="icon-glass"></i>Aantal kamers: <?php echo $property['kamers']; ?></p>
            </div>
          <?php endif; ?>
          <?php if($property['gbo']): ?>
            <div class="span3">
              <p><i class="icon-glass"></i> GBO: <?php echo $property['gbo']; ?> m<sup>2</sup></p>
            </div>
          <?php endif; ?>
          <?php if($property['inhoud']): ?>
            <div class="span3">
              <p><i class="icon-glass"></i>Inhoud: <?php echo $property['inhoud']; ?> m<sup>3</sup></p>
            </div> 
          <?php endif; ?>
          <?php if($property['perceel']): ?>
            <div class="span3">
              <p><i class="icon-glass"></i> Perceel: <?php echo $property['perceel']; ?> m<sup>2</sup></p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.plattegrond').fancybox({
              width: '95%',
              height: '95%',
              autoSize: true
              });
        });
    </script>


<!-- Introductietekst -->
    <div class="row-fluid">
      <div class="span9">
        <div class=""><p><?php echo $property['introductietext']; ?></p></div>
        <!-- Links floorplanner ed -->
        <div class="row-fluid">
          <div class="span4">
            <a href="<?php echo $property['floorplanner'] ?>" class="btn btn-large btn-primary btn-block plattegrond" rel="gallery1">Plattegrond</a>
          </div>
          <div class="span4">
            <a href="" class="btn btn-large btn-primary btn-block">Brochure downloaden</a>
          </div>
          <div class="span4">
            <a href="" class="btn btn-large btn-primary btn-block">Woonfilm bekijken</a>
          </div>
        </div>

<!-- Aanvullende teksten -->
        <div class="row-fluid">
          <div class="span12">
           <?php if($property['begane_grond_text']): ?>
              <h4>Begane grond</h4>
              <p><?php echo $property['begane_grond_text']; ?></p>
          <?php endif; ?>
          <?php if($property['eerste_verdieping_text']): ?>
              <h4>Eerste verdieping</h4>
              <p><?php echo $property['eerste_verdieping_text']; ?></p>
          <?php endif; ?>
          <?php if($property['tweede_verdieping_text']): ?>
              <h4>Tweede verdieping</h4>
              <p><?php echo $property['tweede_verdieping_text']; ?></p>
          <?php endif; ?>
           <?php if($property['tuin_text']): ?>
              <h4>Tuin</h4>
              <p><?php echo $property['tuin_text']; ?></p>
          <?php endif; ?>
           <?php if($property['balkon_text']): ?>
              <h4>Balkon</h4>
              <p><?php echo $property['balkon_text']; ?></p>
          <?php endif; ?>
           <?php if($property['detail_text']): ?>
              <p><?php echo $property['detail_text']; ?></p>
          <?php endif; ?>
           <?php if($property['overige_text']): ?>
              <p><?php echo $property['overige_text']; ?></p>
          <?php endif; ?>

          </div>
        </div>
      </div>
 
<!-- -->
        <div class="span3">
          <?php if ( empty($wp_properties['property_groups']) || $wp_properties['configuration']['property_overview']['sort_stats_by_groups'] != 'true' ) : ?>
            <ul id="property_stats" class="">
              <?php if(!empty($post->display_address)): ?>
              <li class="">
                <span class="attribute"><?php 
                
                echo $wp_properties['property_stats'][$wp_properties['configuration']['address_attribute']]; ?><span class="wpp_colon">:</span></span>
                <span class="value"><?php echo $post->display_address; ?>&nbsp;</span>
              </li>
              <?php endif; ?>
              <?php @draw_stats("display=list&make_link=true&exclude={$wp_properties['configuration']['address_attribute']}"); ?>
            </ul>
          <?php else: ?>
            <?php if(!empty($post->display_address)): ?>
            <ul id="property_stats" class="<?php wpp_css('property::property_stats', "property_stats overview_stats list"); ?>">
              <li class="wpp_stat_plain_list_location alt">
                <span class="attribute"><?php echo $wp_properties['property_stats'][$wp_properties['configuration']['address_attribute']]; ?><span class="wpp_colon">:</span></span>
                <span class="value"><?php echo $post->display_address; ?>&nbsp;</span>
              </li>
            </ul>
            <?php endif; ?>
            <?php @draw_stats("display=list&make_link=true&exclude={$wp_properties['configuration']['address_attribute']}"); ?>
          <?php endif; ?>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span12">
        <?php if(WPP_F::get_coordinates()): ?>
          <div id="property_map" class="<?php wpp_css('property::property_map'); ?>" style="width:100%; height:450px"></div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row-fluid">
        <?php if(class_exists('WPP_Inquiry')): ?>
          <h2><?php _e('Interested?','wpp') ?></h2>
          <?php WPP_Inquiry::contact_form(); ?>
        <?php endif; ?>


        <?php if($post->post_parent): ?>
          <a href="<?php echo $post->parent_link; ?>" class="<?php wpp_css('btn', "btn btn-return"); ?>"><?php _e('Return to building page.','wpp') ?></a>
        <?php endif; ?>
    </div>

</div><!-- .entry-content -->




<?php
  // Primary property-type sidebar.
  if ( is_active_sidebar( "wpp_sidebar_" . $post->property_type ) ) : ?>

    <div id="primary" class="<?php wpp_css('property::primary', "widget-area wpp_sidebar_{$post->property_type}"); ?>" role="complementary">
      <ul class="xoxo">
        <?php dynamic_sidebar( "wpp_sidebar_" . $post->property_type ); ?>
      </ul>
    </div><!-- #primary .widget-area -->

<?php endif; ?>


<?php get_template_part('templates/footer'); ?>