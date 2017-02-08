<?php


use Elementor\Controls_Manager;



class ProjetVitrines extends \Elementor\Widget_Base {




	public function get_name() {
		return "Projet vitrines";
	}

	public function get_title() {
		return "Projet vitrines";
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function _register_controls() {
		$this->start_controls_section(
			'section_label', [
				'label' => 'Affiche les 3 derniers projets vitrines',
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
		$this->end_controls_section();
	}

	public function getUrl( $url ) {
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		curl_setopt( $ch, CURLOPT_HEADER, false );

		$exe = curl_exec( $ch );

		$httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

		curl_close( $ch );

		return ( $httpcode >= 200 && $httpcode < 300 ) ? $exe : false;
	}

	public function render()
	{

			$url = "http://localhost:8888/EVEMA_vitrines/wp-json/wp/v2/posts/?per_page=3";
			$data = $this->getUrl($url);
			$data = json_decode($data);
			$nbArray = count($data);

			$a = 0;




			if ($nbArray > 0) {
				while ($nbArray > $a) {
					$img_portfolio = $data[$a]->better_featured_image->media_details->sizes->portfolio->source_url;
					$img_mini = $data[$a]->better_featured_image->media_details->sizes->miniature->source_url;
					$the_title = $data[$a]->title->rendered;
					$the_content = $data[$a]->content->rendered;

					echo "<a class='fancybox vitrines center-cropped' href='$img_portfolio' data-title-id='title-{$a}' rel='gallery1'  >";

					?>

					<div id='title-<?php echo $a ?>' class='hidden'><h2><?php echo $the_title; ?></h2>
						<p class="fancybox__box__content"> <?php echo $the_content; ?></p>
						<p class="fancybox__box__cat"></p></div>

					<?php

					echo "<img class='lazy' src='$img_mini'>";
					echo "</a>";

					for ($i = 1; $i <= 5; $i++) {

						$pic = "photo_" . $i;
						$acf = $data[$a]->acf->$pic->sizes->portfolio;

						echo "<a class='fancybox  hidden' data-title-id='title-{$a}' rel='gallery1' href='$acf'>";
						if($acf){
						echo "<img class='lazy' src='$acf'>";
						}
						echo "</a>";

					}
					$a++;
				}


			}

		}

}
