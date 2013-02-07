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



  <div id="container" class="container fullwidth-mobile">
    <div id="content" class="row-fluid" role="main">
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

      <div class="row-fluid">
        <div class="span8">
          <?php the_breadcrumb(); ?>
        </div>
      </div>
<!-- Featured Image & Title -->
    <div class="row-fluid">
      <div class="span8">

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
                'class' => "attachment-$size wp-post-image gallery",
            );
            foreach( $gallery as $image ) {
                echo '<div class="item">';
               
                 echo wp_get_attachment_image($image->ID, 'full', false, $attr);
              
                echo '</div>';
            }
            ?>
            </div>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
          </div>
        </div>

      <div class="span3 woningnaam">
        <span class="label">
                   <?php $beschikbaarheidstring = strip_tags($property["status"]);

          if ($beschikbaarheidstring == "Available"){
          echo "Beschikbaar";
          }
          elseif ($beschikbaarheidstring == "Sold_under_conditions"){
          echo "Verkocht onder voorbehoud";
          } 
          elseif ($beschikbaarheidstring == "Rented_under_conditions"){
          echo "Verhuurd onder voorbehoud";
          } 
          elseif ($beschikbaarheidstring == "Sold"){
          echo "Verkocht";
          } 
          elseif ($beschikbaarheidstring == "Rented"){
          echo "Verhuurd";
          }   
          else{
          echo "Niet beschikbaar";
          }?>
        </span>
        <div class="content">
           <h1 class="page-header prop-title"><?php the_title(); ?></h1>
            <hp><?php the_tagline(); ?></hp>
            <?php if($property['price']): ?>
                  <h2 class="property_price">
                  <?php 
                    $huurstring = strip_tags($property["huren"]);
                    if($huurstring == true){
                      echo $property['huurprijs'];
                      echo ",-";
                      echo "<small>p mnd</small>";
                    }
                      else{
                        echo $property['price'];
                        echo ",-";
                      }
                    ?>

                    <small> <?php 
                    $pricetypestring = strip_tags($property["kosten_koper"]);
                      if ($pricetypestring == "Costs_buyer"){
                        echo "K.K.";
                      }
                        elseif ($pricetypestring == 'Free_on_name'){
                          echo 'V.O.N.';
                      } 
            
                    ?>
                  </small></h2>


          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
<!-- Belangrijkste eigenschappen -->
    <div class="row-fluid">
      <div class="span8 yellow imp-elements">
        <div class="row-fluid">
          <?php if($property['kamers']): ?>
            <div class="span3">
              <p><i class="icon-group"></i> Aantal kamers: <?php echo $property['kamers']; ?></p>
            </div>
          <?php endif; ?>
          <?php if($property['gbo']): ?>
            <div class="span3">
              <p><i class="icon-exchange"></i> GBO: <?php echo $property['gbo']; ?> m<sup>2</sup></p>
            </div>
          <?php endif; ?>
          <?php if($property['inhoud']): ?>
            <div class="span3">
              <p><i class="icon-home"></i> Inhoud: <?php echo $property['inhoud']; ?> m<sup>3</sup></p>
            </div> 
          <?php endif; ?>
          <?php if($property['perceel']): ?>
            <div class="span3">
              <p><i class="icon-leaf"></i> Perceel: <?php echo $property['perceel']; ?> m<sup>2</sup></p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>



<!-- Introductietekst -->
    <div class="row-fluid">
      <div class="span8">
        <div class=""><p class="intro"><?php echo $property['introductietext']; ?></p></div>

        <!-- Links floorplanner ed -->
        <div class="row-fluid links">
          <?php if($property['floorplanner']): ?>
          <div class="span4">
            <a href="<?php echo $property['floorplanner'] ?>" class="btn btn-large btn-primary btn-block plattegrond" rel="gallery1">Plattegrond</a>
          </div>
          <?php endif; ?>
          <?php if($property['brochure']): ?>
          <div class="span4">
            <a href="<?php echo $property['brochure'] ?>?mode=window" target="_blank" class="btn btn-large btn-primary btn-block plattegrond">Brochure</a>
          </div>
          <?php endif; ?>
          <?php if($property['woonfilm']): ?>
          <div class="span4">
            <a href="" class="btn btn-large btn-primary btn-block">Woonfilm bekijken</a>
          </div>


          <?php endif; ?>

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

        <hr>

<!-- Aanvullende teksten -->
        <div class="row-fluid">
          <div class="span12">
            <a href="#overige-teksten" id="overige-teksten-link">Lees de volledige omschrijving</a>
            <hr>
          </div>
        </div>

        <div class="row-fluid">
          <div class="span12" id="overige-teksten">
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
 
<!-- Strings met vertaling..-->

        <div class="span4 woningzijbalk">

          <div class="makelaar">
            <p><strong>Makelaar:</strong> <?php echo $property['makelaar']; ?></p>
          </div>

          <?php if($property['datum_open_huis']): ?>
            <div class="openhuis">
              <h5>open Huis:</h5>
             
              <p><?php echo $property['informatie_open_huis']; ?></p>
            </div>
          <?php endif; ?>

          <div class="dewoning">
            <h5>De woning</h5>
            <ul class="unstyled">
            <li><?php $typewoningstring = strip_tags($property["type"]);

            if ($typewoningstring == "Detached_house"){
            echo "Vrijstaande woning";
            }
            elseif ($typewoningstring == "Linked_house"){
            echo "Geschakelde woning";
            } 
            elseif ($typewoningstring == "Semi_detached_house_one_roof"){
            echo "Twee-onder-een kapwoning";
            } 
            elseif ($typewoningstring == "Row_house_middle"){
            echo "Tussenwoning";
            } 
            elseif ($typewoningstring == "Row_house_corner"){
            echo "Hoekwoning";
            } 
            elseif ($typewoningstring == "Row_house_end"){
            echo "Eindwoning";
            } 
            elseif ($typewoningstring == "Semi_detached_house"){
            echo "Half vrijstaande woning";
            } 
            elseif ($typewoningstring == "Semi_detached_linked_house_one_roof"){
            echo "Geschakelde twee-onder-een kapwoning";
            } 
            elseif ($typewoningstring == "Serviceflat"){
            echo "Serviceflat";
            } 
            elseif ($typewoningstring == "Common_apartment"){
            echo "Appartement";
            } 
            elseif ($typewoningstring == "Corridor_flat"){
            echo "Corridorflat";
            } 
            elseif ($typewoningstring == "Beletage"){
            echo "Beletage";
            } 
            elseif ($typewoningstring == "Basement"){
            echo "Souterrain";
            } 
            elseif ($typewoningstring == "Double_upper_house"){
            echo "Dubbelbovenhuis";
            } 
            elseif ($typewoningstring == "Nursery_flat"){
            echo "Verzorgingsflat";
            } 
            else{
            echo "";
            }?>
           
            | <?php $soortwoningstring = strip_tags($property["soort"]);

            if ($soortwoningstring == "Single_family_house"){
            echo "Eengezinswoning";
            }
            elseif ($soortwoningstring == "Mansion"){
            echo "Herenhuis";
            } 
            elseif ($soortwoningstring == "Villa"){
            echo "Villa";
            } 
            elseif ($soortwoningstring == "Country_house"){
            echo "Landhuis";
            } 
            elseif ($soortwoningstring == "Bungalow"){
            echo "Bungalow";
            } 
            elseif ($soortwoningstring == "Residental_farm"){
            echo "Woonboerderij";
            } 
            elseif ($soortwoningstring == "Canal_house"){
            echo "Grachtenpand";
            } 
            elseif ($soortwoningstring == "Houseboat"){
            echo "Woonboot";
            } 
            elseif ($soortwoningstring == "Mobile_home"){
            echo "Stacaravan";
            }  
            elseif ($soortwoningstring == "Upstairs_apartment"){
            echo "Bovenwoning";
            } 
            elseif ($soortwoningstring == "Ground_floor_apartment"){
            echo "Benedenwoning";
            } 
            elseif ($soortwoningstring == "Maisonette"){
            echo "Maisonette";
            } 
            elseif ($soortwoningstring == "Gallery_flat"){
            echo "Gallerijflat";
            } 
            elseif ($soortwoningstring == "Portico_flat"){
            echo "Portiekflat";
            } 
            elseif ($soortwoningstring == "Upstairs_ground_floor_apartment"){
            echo "Benedenbovenwoning";
            } 
            elseif ($soortwoningstring == "Penthouse"){
            echo "Penthouse";
            } 
            elseif ($soortwoningstring == "Porch_apartment"){
            echo "Portiekwoning";
            } 
            elseif ($soortwoningstring == "Garage"){
            echo "Garagebox";
            } 
            elseif ($soortwoningstring == "Indoor_garage"){
            echo "Inpandige garage";
            } 
            elseif ($soortwoningstring == "Parking_cellar"){
            echo "Parkeerkelder";
            } 
            elseif ($soortwoningstring == "Parking_place"){
            echo "Parkeerplaats";
            } 
            else{
            echo "";
            }?></li>

          <?php if($property['bouwjaar']): ?>
            <li>Bouwjaar: <?php echo $property['bouwjaar']; ?></li>
          <?php endif; ?>
          <?php if($property['verdiepingen']): ?>
          <li>Woonlagen: <?php echo $property['verdiepingen']; ?></li>
          <?php endif; ?>
          <?php if($property['Bedrooms']): ?>
          <li>Slaapkamers: <?php echo $property['Bedrooms']; ?></li>
          <?php endif; ?>
          <?php if($property['Bathrooms']): ?>
            <li>Badkamers: <?php echo $property['Bathrooms']; ?></li>
          <?php endif; ?>
          <?php if($property['tuin']): ?>
            <li>Tuinligging: <?php $tuinliggingstring = strip_tags($property["tuin"]);
          if ($tuinliggingstring == "North"){
          echo "Noord";
          }
          elseif ($tuinliggingstring == "North_east"){
          echo "Noord Oost";
          } 
          elseif ($tuinliggingstring == "East"){
          echo "Oost";
          } 
          elseif ($tuinliggingstring == "South_west"){
          echo "Zuid West";
          } 
          elseif ($tuinliggingstring == "North_west"){
          echo "Noord West";
          } 
          elseif ($tuinliggingstring == "West"){
          echo "West";
          } 
          elseif ($tuinliggingstring == "South"){
          echo "Zuid";
          } 
          elseif ($tuinliggingstring == "South_east"){
          echo "Zuid Oost";
          }   
          else{
          echo "";
          }?></li>
          <?php endif; ?>
        </ul>
      </div>

          <h5>Energie</h5>
          <p>Verwarming: <?php $verwarmingstring = strip_tags($property["verwarming"]);

            if ($verwarmingstring == "Central_heating"){
            echo "CV Ketel";
            }
            elseif ($verwarmingstring == "Coal"){
            echo "Kolenkachel";
            } 
            elseif ($verwarmingstring == "Heating_block"){
            echo "Blokverwarming";
            } 
            elseif ($verwarmingstring == "District_heating"){
            echo "Stadverwarming";
            } 
            elseif ($verwarmingstring == "Central_fireplace"){
            echo "Moederhaard";
            } 
            elseif ($verwarmingstring == "Hot_air"){
            echo "Heteluchtverwarming";
            } 
            elseif ($verwarmingstring == "Airco"){
            echo "Airconditioning";
            } 
            elseif ($verwarmingstring == "Gas_stove"){
            echo "Gaskachels";
            } 
            elseif ($verwarmingstring == "Fireplace"){
            echo "Openhaard";
            } 
            elseif ($verwarmingstring == "Option_for_fireplace"){
            echo "Mogelijkheid tot openhaard";
            } 
            elseif ($verwarmingstring == "Floor_heating"){
            echo "Vloerverwarming";
            } 
            elseif ($verwarmingstring == "Floor_heating_partly"){
            echo "Vloerverwarming gedeeltelijk";
            } 
            elseif ($verwarmingstring == "Solar_collectors"){
            echo "Zonnecollectoren";
            } 
            elseif ($verwarmingstring == "Electric_heating"){
            echo "Elektrische verwarming";
            } 
            elseif ($verwarmingstring == "Wall_heating"){
            echo "Muurverwarming";
            }  
            else{
            echo "Geen verwarmingsgegevens beschikbaar";
            }?></p>
           <p><?php echo $property['energielabel']; ?></p>

           <h5>NEN 2580</h5>
           <ul class="unstyled nen"</ul>
           <?php if($property['gbo']): ?>
            <li>Woonoppervlakte: <?php echo $property['gbo']; ?> m<sup>2</sup></li>
           <?php endif; ?>
           <?php if($property['opp_overige_inpandige_ruimten']): ?>
           <li>Ovg. inpandige ruimte :<?php echo $property['opp_overige_inpandige_ruimten']; ?> m<sup>2</sup></li>
            <?php endif; ?>
            <?php if($property['opp_externe_bergruimten']): ?>
           <li>Externe bergruimte: <?php echo $property['opp_externe_bergruimten']; ?> m<sup>2</sup></li>
            <?php endif; ?>
            <?php if($property['opp_gebouwgebonden_buitenruimten']): ?>
           <li>Gebouwgebonden buitenruimte: <?php echo $property['opp_gebouwgebonden_buitenruimten']; ?> m<sup>2</sup></li>
            <?php endif; ?>
            </ul
          </div>
      </div>
    </div>
  </div><!-- End container for full width map -->
</div>
</div>

        <?php if(WPP_F::get_coordinates()): ?>
          <div id="property_map" class="<?php wpp_css('property::property_map'); ?>" style="width:100%; height:500px"></div>
        <?php endif; ?>

  <div class="container">
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