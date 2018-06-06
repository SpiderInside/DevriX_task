<?php
/*
 * Archive page
 * 
 */
get_header();
?>
<section class="archive-container">
    <?php
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'meta_key' => 'event_date',
        'orderby' => 'meta_value',
        'post_status' => 'publish',
        'order' => 'desc',
    );
    $query = new WP_Query($args);
    while ($query->have_posts()) : $query->the_post();
        $eventTitle = get_the_title();
        $metaArr = get_post_meta(get_the_ID());
        ?>
        <div class="row-container">
            <div class="table-cell date-container">
                <span><?php echo $metaArr['event_date'][0]; ?></span>
            </div>
            <div class="table-cell text-container">
                <h2>
                    <a href="<?php echo get_permalink(); ?>" title="<?php echo $eventTitle; ?>">
                        <?php echo $eventTitle; ?>
                    </a>
                </h2>
                <span class="map-coordinates hidden" data-info-latitude="<?php echo $metaArr['event_location_latitude'][0]; ?>" data-info-longitude="<?php echo $metaArr['event_location_longitude'][0]; ?>"  data-description="<?php echo $eventTitle; ?>"></span>
                <a target="_blank" href="<?php echo $metaArr['event_url'][0]; ?>">
                    <img border="0" src="https://www.google.com/calendar/images/ext/gc_button1_en.gif">
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();
    ?>
    <div id="map-canvas" class="g-map" style="height:500px"></div>
</section>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBR3yNAbq8JHD3YufxCgTUsm7V8BcVKE1E"></script>
<div class="hidden" id="base-url" data-base-url="<?php bloginfo('template_url'); ?>"></div>
<?php
get_footer();
?>