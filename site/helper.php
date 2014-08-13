<?php
/**
 * @package	   Joomla.Site
 * @subpackage mod_doyandexmetrika
 * @copyright  Copyright (C) 2011-2014 Open Source Matters. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ModDoyandexmetrikaHelper
{
	 /**
		* @param    array
		* @return   string
		*/
	 public static function getCode( $params )
	 {
			$inject = "";
			$do_counter_id = $params->get('do_counter_id');

			// Nothing to do without Yandex.Metrika counter ID
			if (!isset($do_counter_id)) {
				 return;
			}

			$do_counter_id = trim($do_counter_id);

			$do_counter_code = $params->get('do_counter_code');
			$do_informer = $params->get('do_informer');
			$do_clickmap = $params->get('do_clickmap');
			$do_tracklinks = $params->get('do_tracklinks');
			$do_trackbounce = $params->get('do_trackbounce');
			$do_visitsparams = $params->get('do_visitsparams');
			$do_noindex = $params->get('do_noindex');
			$do_webvisor = $params->get('do_webvisor');
			$do_trackhash = $params->get('do_trackhash');
			$do_userparams = $params->get('do_userparams');
			$do_forxml = $params->get('do_forxml');

			if ($do_informer==1) {

				 // Get only informers params
				 $do_informerstyle = $params->get('do_informerstyle');
				 $do_informerinfo = $params->get('do_informerinfo');
				 $do_informer_color1 = strtoupper(trim($params->get('do_informer_color1')));
				 $do_informer_color2 = strtoupper(trim($params->get('do_informer_color2')));
				 $do_gradient = $params->get('do_gradient');
				 $do_textcolor = $params->get('do_textcolor');
				 $do_arrowcolor = $params->get('do_arrowcolor');
				 $do_informertype = $params->get('do_informertype');

				 $inject  = "<!-- Yandex.Metrika informer -->\n";
				 $inject .= "<a href=\"https://metrika.yandex.ru/stat/?id=$do_counter_id&amp;from=informer\"\n";
				 $inject .= "target=\"_blank\" rel=\"nofollow\"><img src=\"//bs.yandex.ru/informer/$do_counter_id";

				 if ($do_gradient==0) {
						$do_informer_color1 = $do_informer_color2;
				 }

				 $inject .= "/".$do_informerstyle."_".$do_arrowcolor."_".$do_informer_color1."FF_".$do_informer_color2."FF_".$do_textcolor."_".$do_informerinfo."\"\n";
				 $inject .= "style=\"width:";
				 switch ($do_informerstyle) {
						case 3: // 88x31
							 $inject .= "88px; height:31";
							 $titlea = "(просмотры, визиты и уникальные посетители)";
							 break;
						case 2: //80x31
							 $inject .= "80px; height:31";
							 break;
						case 1: //80x15
							 $inject .= "80px; height:15";
							 break;
				 }

				 // Select data for 80x31 and 80x15 style
				 if ($do_informerstyle<3) {
						switch ($do_informerinfo) {
							 case "pageviews":
									$titlea = "(просмотры)";
									break;
							 case "visits":
									$titlea = "(визиты)";
									break;
							 case "uniques";
									$titlea = "(уникальные посетители)";
									break;
						}
				 }

				 $inject .= "px; border:0;\" alt=\"Яндекс.Метрика\" title=\"Яндекс.Метрика: данные за сегодня ".$titlea."\" ";

				 if ($do_informertype == 1) {
						$inject .= "onclick=\"try{Ya.Metrika.informer({i:this,id:$do_counter_id,type:0,lang:'ru'});return false}catch(e){}\"";
				 }

				 $inject .= "/></a>\n<!-- /Yandex.Metrika informer -->\n\n";
			}

			$inject .= "<!-- Yandex.Metrika counter -->\n";

			/**
			 * Вставка имени пользователя в параметры для отслеживания поведения пользователей
			 */
			$userparams = '';
			if ( $do_userparams == 1) {
				$user =& JFactory::getUser();
				$userparams = "'Пользователь':'";
				if (!$user->guest) {
						$userparams .= $user->username."'";
				} else $userparams .= "Гость'";
			}

			if (!empty($do_visitsparams) || !empty($userparams)) {
				 $inject .= "<script type=\"text/javascript\">\nvar yaParams = {";
				 $inject .= $userparams;
				 if (!empty($do_visitsparams)) $inject .= ', ';
				 $inject .= trim($do_visitsparams);
				 $inject .= "};</script>\n";
			}

			// Async
			if ($do_counter_code == 1) {
				 $inject .= "<script type=\"text/javascript\">\n";
				 $inject .= "(function (d, w, c) {\n";
				 $inject .= "(w[c] = w[c] || []).push(function() {\ntry {\n w.";
			} else {
				 $inject .= "<script src=\"//mc.yandex.ru/metrika/watch.js\" type=\"text/javascript\"></script>\n";
				 $inject .= "<script type=\"text/javascript\">\ntry { var ";
			}

			$inject .= "yaCounter$do_counter_id = new Ya.Metrika({id:$do_counter_id";

			if (($do_clickmap == 1) && ($do_tracklinks == 1) && ($do_trackbounce == 1)) {
				 $inject .= ",\nenableAll: true";
			} else {
				 if ($do_clickmap == 1) {
						$inject .= ",\nclickmap:true";
				 }
				 if ($do_tracklinks == 1) {
						$inject .= ",\ntrackLinks:true";
				 }
				 if ($do_trackbounce == 1) {
						$inject .= ",\naccurateTrackBounce:true";
				 }
			}

			if ($do_trackhash == 1) {
				 $inject .= ",\ntrackHash:true";
			}

			$noscriptind = ""; // var for noindex param in noscript part

			if ($do_noindex == 1) {
				 $u =& JFactory::getURI();
				 $path_site = $u->toString();

				 $do_noindexpages = trim($params->get('do_noindexpages'));

				 if (($do_noindexpages != "") && (preg_match($do_noindexpages, $path_site))) {
						$inject .= ",\nut: 'noindex'";
						$noscriptind = "?ut=noindex";
				 }
			}

			if ($do_webvisor == 1) { // v1.1.1 webvisor
				 $inject .= ",\nwebvisor:true";
			}

			if (!empty($do_visitsparams)  || !empty($userparams)) {
				 $inject .= ",params:window.yaParams||{ }";
			}

			$inject .= "});\n}\ncatch(e) { }\n";

			// Async
			if ($do_counter_code == 1) {
				 $inject .= "});";
				 $inject .= "var n = d.getElementsByTagName(\"script\")[0],\n";
				 $inject .= "s = d.createElement(\"script\"),\n";
				 $inject .= "f = function () { n.parentNode.insertBefore(s, n); };\n";
				 $inject .= "s.type = \"text/javascript\";\n";
				 $inject .= "s.async = true;\n";
				 $inject .= "s.src = (d.location.protocol == \"https:\" ? \"https:\" : \"http:\") + \"//mc.yandex.ru/metrika/watch.js\";\n";
				 $inject .= "if (w.opera == \"[object Opera]\") {\n";
				 $inject .= "  d.addEventListener(\"DOMContentLoaded\", f, false);\n";
				 $inject .= "} else { f(); }\n";
				 $inject .= "})(document, window, \"yandex_metrika_callbacks\");\n";
			};

			$inject .= "</script>\n";

			if ($do_forxml == 0) {
				$inject .= "<noscript><div><img src=\"//mc.yandex.ru/watch/$do_counter_id$noscriptind\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript>\n";
			}

			$inject .= "<!-- /Yandex.Metrika counter -->\n";

			return $inject;
	 } //end getCode
}
?>