<?php


use Elementor\Controls_Manager;

class FuturPortfolioLeft extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return "Futur portfolio left";
    }

    public function get_title()
    {
        return "Img_left";
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function _register_controls()
    {
        $this->start_controls_section(
            'section_label', [
                'label' => 'Affiche les 2 derniers articles',
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->end_controls_section();
    }

    public function render()
    {
        $args = array(
            'post_type' => 'post',
            'category_name' => 'feature_portfolio',
            'posts_per_page' => 2,
            'offset' => 3,
            'order' => 'DSC'
        );
        $query = new WP_Query($args);
        echo "<div class='feature__portfolio__left'>";
        global $post;
        $a = 4;
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $image_src = get_the_post_thumbnail_url(($post), 'miniature');

                $image_full = get_the_post_thumbnail_url(($post), 'portfolio');

                echo "<a class='fancybox lazy center-cropped'  href=" . $image_full . " data-title-id=\"title-{$a}\"  rel=\"gallery1\"  >";
                ?>
                <div id='title-<?php echo $a ?>' class='hidden'><h2><?php the_title() ?></h2>
                    <p class="fancybox__content"> <?php the_content(); ?></p>
                    <p class="fancybox__cat"><?php
                        foreach ((get_the_category()) as $cat) {
                            if ($cat->cat_name == "portfolio_haut") {
                                echo "";
                            } else {
                                echo "<span class='fancybox__box__span'>".$cat->cat_name."</span>";

                            }
                        } ?> </p></div>
                <?php
                echo "<img  src=" . $image_src . ">";

                echo "</a>";
                for ($i = 1; $i <= 5; $i++) {
                    $val_ = get_field("photo_" . $i);
                    $img = wp_get_attachment_image($val_['id'], 'portfolio');

                    echo "<a class='fancybox lazy top_img' data-title-id=\"title-{$a}\"  href=" . $val_['sizes']['portfolio'] . " rel=\"gallery1\"  >";
                    echo $img;
                    echo "</a>";
                }
                $a++;

            };
            wp_reset_postdata();
        };
        echo "</div>";


    }

}

