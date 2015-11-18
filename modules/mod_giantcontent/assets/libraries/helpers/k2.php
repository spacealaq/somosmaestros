<?php
/**
 *------------------------------------------------------------------------------
 * @version		1.1.1
 * @package		Giant Content
 *------------------------------------------------------------------------------
 * @copyright	Copyright (C) 2014 GiantTheme. All Rights Reserved.
 * @license     GNU General Public License version 2 only, see LICENSE.txt
 * @author      GiantTheme <support@gianttheme.com> - http://www.gianttheme.com
 *------------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

if (JFile::exists(JPATH_SITE.'/components/com_k2/k2.php')) {
	require_once JPATH_SITE.'/components/com_k2/helpers/route.php';
	require_once JPATH_SITE.'/components/com_k2/helpers/utilities.php';
}

class ModGiantContentK2 {
	public static function getList($params) {

		$app	= JFactory::getApplication();
		$lang	= JFactory::getLanguage();
		$user	= JFactory::getUser();
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		// Source
		$source				= $params->get('source', 'categories');
		$exclude			= $params->get('exclude', array());
		$articles_k2		= $params->get('articles_k2', array());
		$categories_k2		= $params->get('categories_k2', array());
		// General
		$readmore			= $params->get('readmore', '');
		$ordering			= $params->get('ordering', 'random');
		$item_counts		= $params->get('item_counts', 5);
		$skip_counts		= $params->get('skip_counts', 0);
		$limit_intro		= $params->get('limit_intro', 200);
		// Display
		$show_date			= $params->get('show_date', 1);
		$show_hits			= $params->get('show_hits', 1);
		$show_tags			= $params->get('show_tags', 1);
		$show_image			= $params->get('show_image', 1);
		$show_intro			= $params->get('show_intro', 1);
		$show_title			= $params->get('show_title', 1);
		$show_author		= $params->get('show_author', 1);
		$show_avatar		= $params->get('show_avatar', 1);
		$show_rating		= $params->get('show_rating', 1);
		$show_profile		= $params->get('show_profile', 1);
		$show_category		= $params->get('show_category', 1);
		$show_comments		= $params->get('show_comments', 1);
		// Date
		$date_type			= $params->get('date_type', 'created');
		$date_format		= $params->get('date_format', 'd F Y');
		// Image
		$image_width		= $params->get('image_width', 200);
		$image_height		= $params->get('image_height', 100);
		$image_quality		= $params->get('image_quality', 100);
		$image_link			= $params->get('image_link', 'none');
		$image_title		= $params->get('image_title', 1);
		$image_resize		= $params->get('image_resize', 1);
		$image_source		= $params->get('image_source', 'auto');
		// 3rd-party
		$avatar_width		= $params->get('avatar_width', 60);
		$avatar_height		= $params->get('avatar_height', 60);
		$avatar_system		= $params->get('avatar_system', 'kunena');
		$profile_system		= $params->get('profile_system', 'kunena');
		$comments_system	= $params->get('comments_system', 'komento');
		// User access
		$authorised			= implode(',', $user->getAuthorisedViewLevels());
		// Clean HTML tags
		$clean_intro		= $params->get('clean_intro', 1);
		$allowed_tags		= str_replace(' ', '', $params->get('allowed_tags'));
		$allowed_tags		= "<".str_replace(',', '><', $allowed_tags).">";
		// Content filtering
		$tags_k2			= $params->get('tags_k2', array());
		$author				= $params->get('author', array());
		$featured			= $params->get('featured', 0);
		// Featured label/ribbon
		$featured_label			= $params->get('featured_label', 0);
		$featured_label_text	= $params->get('featured_label_text', 'Featured');
		$featured_label_color	= $params->get('featured_label_color', '#e52626');
		// Link
		$title_link			= $params->get('title_link', 1);
		$category_link		= $params->get('category_link', 1);

		if (JFile::exists(JPATH_SITE.'/components/com_k2/k2.php')) {
			if ($source == 'categories' && $categories_k2) {
				if ($categories_k2[0] != '') {
					$categories_k2 = (count($categories_k2) == 1) ? ' = '.$categories_k2[0].'' : 'IN ('.implode(',', $categories_k2).')';
					$query->where('a.catid '.$categories_k2);
				}
				$exclude ? $query->where('a.id NOT IN ('.$exclude.')') : '';
			} else if ($source == 'articles' && $articles_k2) {
				$query->where('a.id IN ('.implode(',', $articles_k2).')');
			} else {
				echo JText::_('MOD_GIANTCONTENT_ERROR_SOURCE');
				return;
			}
		} else {
			echo JText::_('MOD_GIANTCONTENT_ERROR_TYPE_K2');
			return;
		}

		// Ordering
		switch ($ordering) {
			case 'random':
				$orderBy = 'RAND()';
			break;
			case 'id_asc':
				$orderBy = 'a.id ASC';
			break;
			case 'id_desc':
				$orderBy = 'a.id DESC';
			break;
			case 'title_asc':
				$orderBy = 'a.title ASC';
			break;
			case 'title_desc':
				$orderBy = 'a.title DESC';
			break;
			case 'popular_last':
				$orderBy = 'a.hits ASC';
			break;
			case 'popular_first':
				$orderBy = 'a.hits DESC';
			break;
			case 'created_oldest':
				$orderBy = 'date ASC';
			break;
			case 'created_newest':
				$orderBy = 'date DESC';
			break;
			case 'most_rated':
				$orderBy = 'rating_total DESC, r.rating_count DESC';
			break;
			case 'least_rated':
				$orderBy = 'rating_total ASC, r.rating_count ASC';
			break;
			case 'most_commented':
				$orderBy = 'comments_count DESC, comments_date DESC';
			break;
			case 'latest_commented':
				$orderBy = 'comments_date DESC, date DESC';
			break;
		}

		// Content
		$query->select('a.id, a.title, a.alias, a.introtext, a.fulltext, a.hits');
		$query->from('#__k2_items AS a');

		// Category
		$query->select('a.catid AS category_id, c.name AS category_name, c.alias AS category_alias');
		$query->join('LEFT', '#__k2_categories AS c ON c.id = a.catid');

		// Join user
		$query->select('u.id AS user_id, u.email AS user_email, u.name AS user_name, a.created_by_alias AS user_alias');
		$query->join('LEFT', '#__users AS u ON u.id = a.created_by');

		// Join rating
		$query->select('ROUND(AVG(r.rating_sum / r.rating_count), 2) AS rating_average, r.rating_count');
		$query->join('LEFT', '#__k2_rating AS r ON r.itemID = a.id');

		// Select date
		if ($date_type !== 'created') {
			$query->select('CASE WHEN a.'.$date_type.' = "0000-00-00 00:00:00" THEN a.created ELSE a.'.$date_type.' END AS date');
		} else {
			$query->select('a.created AS date');
		}

		// Join avatar for author
		if ($show_avatar) {
			switch ($avatar_system) {
				// K2 avatar integration - http://getk2.org
				case 'k2':
					if (JFile::exists(JPATH_SITE.'/components/com_k2/k2.php')) {
						$query->select('ua.image AS avatar_user');
						$query->join('LEFT', '#__k2_users AS ua ON ua.userID = u.id');
						$avatar_path = 'media/k2/users/';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_AVATAR_SYSTEM_K2');
						return;
					}
				break;
				// Kunena avatar integration - http://kunena.org
				case 'kunena':
					if (JFile::exists(JPATH_SITE.'/components/com_kunena/kunena.php')) {
						$query->select('ua.avatar AS avatar_user');
						$query->join('LEFT', '#__kunena_users AS ua ON ua.userid = u.id');
						$avatar_path = 'media/kunena/avatars/';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_AVATAR_SYSTEM_KUNENA');
						return;
					}
				break;
				// JomSocial avatar integration - http://jomsocial.com
				case 'jomsocial':
					if (JFile::exists(JPATH_SITE.'/components/com_community/community.php')) {
						$query->select("ua.avatar AS avatar_user");
						$query->join('LEFT', '#__community_users AS ua ON ua.userid = u.id');
						$avatar_path	= '';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_AVATAR_SYSTEM_JOMSOCIAL');
						return;
					}
				break;
				// Comprofiler avatar integration - http://joomlapolis.com
				case 'comprofiler':
					if (JFile::exists(JPATH_SITE.'/components/com_comprofiler/comprofiler.php')) {
						$query->select('ua.avatar AS avatar_user');
						$query->join('LEFT', '#__comprofiler AS ua ON ua.user_id = u.id');
						$avatar_path = 'images/comprofiler/';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_AVATAR_SYSTEM_COMPROFILER');
						return;
					}
				break;
				// EasyBlog avatar integration - http://stackideas.com
				case 'easyblog':
					if (JFile::exists(JPATH_SITE.'/components/com_easyblog/easyblog.php')) {
						$query->select("ua.avatar AS avatar_user");
						$query->join('LEFT', '#__easyblog_users AS ua ON ua.id = u.id');
						$avatar_path = 'images/easyblog_avatar/';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_AVATAR_SYSTEM_EASYBLOG');
						return;
					}
				break;
				// EasySocial avatar integration - http://stackideas.com
				case 'easysocial':
					if (JFile::exists(JPATH_SITE.'/components/com_easysocial/easysocial.php')) {
						$query->select("ua.large AS avatar_user");
						$query->join('LEFT', '#__social_avatars AS ua ON ua.uid = u.id');
						$avatar_path = 'media/com_easysocial/avatars/users/';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_AVATAR_SYSTEM_EASYSOCIAL');
						return;
					}
				break;
				// EasyDiscuss avatar integration - http://stackideas.com
				case 'easydiscuss':
					if (JFile::exists(JPATH_SITE.'/components/com_easydiscuss/easydiscuss.php')) {
						$query->select("ua.avatar AS avatar_user");
						$query->join('LEFT', '#__discuss_users AS ua ON ua.id = u.id');
						$avatar_path = 'images/discuss_avatar/';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_AVATAR_SYSTEM_EASYDISCUSS');
						return;
					}
				break;
			}
		}

		// Join comments for content
		if ($show_comments || $ordering == 'most_commented' || $ordering == 'latest_commented') {
			switch ($comments_system) {
				// Default comment system
				case 'default';
					$query->select('COUNT(cm.id) AS comments_count, MAX(cm.commentDate) AS comments_date');
					$query->join('LEFT', '#__k2_comments AS cm ON cm.itemID = a.id AND cm.published = 1');
					$comments_link = '#itemCommentsAnchor';
				break;
				// Komento comment integration - http://stackideas.com
				case 'komento';
					if (JFile::exists(JPATH_SITE.'/components/com_komento/komento.php')) {
						$query->select('COUNT(cm.id) AS comments_count, MAX(cm.created) AS comments_date');
						$query->join('LEFT', '#__komento_comments AS cm ON cm.cid = a.id AND cm.component = "com_k2" AND cm.published = 1');
						$comments_link = '#section-kmt';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_COMMENTS_SYSTEM_KOMENTO');
						return;
					}
				break;
				// CComment comment integration - http://compojoom.com
				case 'ccomment';
					if (JFile::exists(JPATH_SITE.'/components/com_comment/comment.php')) {
						$query->select('COUNT(cm.id) AS comments_count, MAX(cm.date) AS comments_date');
						$query->join('LEFT', '#__comment AS cm ON cm.contentid = a.id AND cm.component = "com_k2" AND cm.published = 1');
						$comments_link = '#!/ccomment';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_COMMENTS_SYSTEM_CCOMMENT');
						return;
					}
				break;
				// JComments comment integration - http://joomlatune.com
				case 'jcomments';
					if (JFile::exists(JPATH_SITE.'/components/com_jcomments/jcomments.php')) {
						$query->select('COUNT(cm.id) AS comments_count, MAX(cm.date) AS comments_date');
						$query->join('LEFT', '#__jcomments AS cm ON cm.object_id = a.id AND cm.object_group = "com_k2" AND cm.published = 1');
						$comments_link = '#comments';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_COMMENTS_SYSTEM_JCOMMENTS');
						return;
					}
				break;
				// JA Comment comment integration - http://joomlart.com
				case 'jacomment';
					if (JFile::exists(JPATH_SITE.'/components/com_jacomment/jacomment.php')) {
						$query->select('COUNT(cm.id) AS comments_count, MAX(cm.date) AS comments_date');
						$query->join('LEFT', '#__jacomment_items AS cm ON cm.contentid = a.id AND cm.option = "com_k2" AND cm.published = 1');
						$comments_link = '#jac-wrapper';
					} else {
						echo JText::_('MOD_GIANTCONTENT_ERROR_COMMENTS_SYSTEM_JACOMMENT');
						return;
					}
				break;
			}
		}

		// Filter tags
		if ($tags_k2) {
			$query->join('INNER', '#__k2_tags_xref AS t ON t.itemID = a.id');
			$query->where('t.tagID IN ('.implode(',', $tags_k2).')');
		}

		// Filter author
		if ($author) {
			$query->where('a.created_by IN ('.implode(',', $author).')');
		}

		// Filter featured
		if ($featured) {
			$query->where('a.featured = 1');
		}

		// Access or published
		$query->where('a.trash = 0 AND c.trash = 0 AND a.published = 1 AND c.published = 1 AND a.access IN ('.$authorised.') AND c.access IN ('.$authorised.') AND a.publish_up <= "'.JFactory::getDate().'"');

		$query->group('a.id');
		$query->order($orderBy);

		$db->setQuery($query, $skip_counts, $item_counts);

		$items = $db->loadObjectList();

		$lists = array();
		foreach ($items as $i => &$item) {
			$lists[$i] = new stdClass;
			$lists[$i]->id				= $item->id;
			$lists[$i]->date			= '';
			$lists[$i]->hits			= '';
			$lists[$i]->link			= '';
			$lists[$i]->tags			= '';
			$lists[$i]->intro			= '';
			$lists[$i]->image			= '';
			$lists[$i]->title			= '';
			$lists[$i]->author			= '';
			$lists[$i]->avatar			= '';
			$lists[$i]->rating			= '';
			$lists[$i]->featured		= '';
			$lists[$i]->category		= '';
			$lists[$i]->comments		= '';
			$lists[$i]->readmore		= '';
			$lists[$i]->fulltext		= $item->fulltext;
			$lists[$i]->introtext		= $item->introtext;
			$lists[$i]->category_id		= $item->category_id;
			$lists[$i]->category_alias	= $item->category_alias;

			// Content link
			$lists[$i]->link = JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.$item->alias, $item->category_id));

			// Readmore link
			$lists[$i]->readmore = $readmore ? '<a href="'.$lists[$i]->link.'"><span>'.$readmore.'</span></a>' : '';

			// Show content date
			$lists[$i]->date = $show_date ? JHtml::_('date', $item->date, $date_format) : '';

			// Show content hits
			$lists[$i]->hits = $show_hits ? '<span>'.$item->hits.'</span>' : '';

			// Show content image
			if ($show_image) {
				$img		= array();
				$image		= md5("Image".$item->id);

				if (JFile::exists(JPATH_SITE.'/media/k2/items/src/'.$image.'.jpg')) {
					$image	= 'media/k2/items/src/'.$image.'.jpg';
				} else {
					$image	= '';
				}

				if ($image_source == 'auto') {
					if (@$image) {
						$img_source = 'media';
					} else {
						$img_source = 'content';
					}
				} else {
					$img_source = $image_source;
				}

				if ($img_source == 'media') {
					if (@$image) {
						$img['src'] = $image;
						$img['alt'] = $item->title;
						$img['ttl'] = $item->title;
					}
				} else {
					$pattern = '/<img[^>]+>/i';
					preg_match($pattern, $item->introtext, $img_tag);
					if (!count($img_tag)) {
						preg_match($pattern, $item->fulltext, $img_tag);
					}
					if (count($img_tag)) {
						preg_match_all('/(src|alt|title)\s*=\s*(["\'])(.*?)\2/i', $img_tag[0], $img_elem);
						$img_elem = array_combine($img_elem[1], $img_elem[3]);
						if (@$img_elem['src']) {
							$img['src'] = trim(@$img_elem['src']);
							$img['alt'] = trim(@$img_elem['alt']);
							$img['ttl'] = trim(@$img_elem['title']);
							$item->introtext = preg_replace($pattern, '', $item->introtext, 1);
						}
					}
				}

				if (!@$img['src']) {
					// Default image
					$img['src'] = 'modules/mod_giantcontent/assets/images/default.png';
					$img['alt'] = $item->title;
				}

				if ($img['src']) {
					$img_src = $img_attr = $img_title = '';

					// Use timthumb to resize image
					if ($image_resize) {
						$img_src		= JURI::base(true).'/modules/mod_giantcontent/assets/libraries/includes/timthumb.php?src=';
						$img_attr		= '&amp;w='.$image_width.'&amp;h='.$image_height.'&amp;q='.$image_quality;
					}

					$img_src			= $img_src && strncasecmp($img['src'], "http", 4) !== 0 ? $img_src.JURI::base(true).'/' : $img_src;
					$img['ttl']			= $image_title ? $item->title : @$img['ttl'];
					$img_title			= $img['ttl'] ? 'title="'.$img['ttl'].'"' : '';

					$lists[$i]->image	= '<img src="'.@$img_src.@$img['src'].@$img_attr.'" alt="'.@$img['alt'].'" '.@$img_title.' />';

					switch ($image_link) {
						case 'none':
							$lists[$i]->image	= $lists[$i]->image;
						break;
						case 'content':
							$lists[$i]->image	= '<a href="'.$lists[$i]->link.'">'.$lists[$i]->image.'</a>';
						break;
						case 'shadowbox':
							$lists[$i]->image	= '<a href="'.@$img['src'].'" rel="shadowbox" '.@$img_title.'>'.$lists[$i]->image.'</a>';
						break;
					}

					$lists[$i]->image_src		= @$img['src'];
					$lists[$i]->image_alt		= @$img['alt'];
					$lists[$i]->image_title		= @$img['ttl'];
				}
			}

			// Show author profile
			if ($show_profile) {
				switch ($profile_system) {
					// K2 profile integration - http://getk2.org
					case 'k2':
						if (JFile::exists(JPATH_SITE.'/components/com_k2/k2.php')) {
							require_once JPATH_SITE.'/components/com_k2/helpers/route.php';
							$profile_link = JRoute::_(K2HelperRoute::getUserRoute($item->user_id));
						} else {
							echo JText::_('MOD_GIANTCONTENT_ERROR_PROFILE_SYSTEM_K2');
							return;
						}
					break;
					// Kunena profile integration - http://kunena.org
					case 'kunena':
						if (JFile::exists(JPATH_SITE.'/components/com_kunena/kunena.php')) {
							$profile_link = KunenaRoute::_('index.php?option=com_kunena&view=profile&userid='.$item->user_id);
						} else {
							echo JText::_('MOD_GIANTCONTENT_ERROR_PROFILE_SYSTEM_KUNENA');
							return;
						}
					break;
					// JomSocial profile integration - http://jomsocial.com
					case 'jomsocial':
						if (JFile::exists(JPATH_SITE.'/components/com_community/community.php')) {
							require_once JPATH_SITE.'/components/com_community/libraries/core.php';
							$profile_link = CRoute::_('index.php?option=com_community&view=profile&userid='.$item->user_id);
						} else {
							echo JText::_('MOD_GIANTCONTENT_ERROR_PROFILE_SYSTEM_JOMSOCIAL');
							return;
						}
					break;
					// Comprofiler profile integration - http://joomlapolis.com
					case 'comprofiler':
						if (JFile::exists(JPATH_SITE.'/components/com_comprofiler/comprofiler.php')) {
							$profile_link = JRoute::_('index.php?option=com_comprofiler&task=userProfile&user='.$item->user_id);
						} else {
							echo JText::_('MOD_GIANTCONTENT_ERROR_PROFILE_SYSTEM_COMPROFILER');
							return;
						}
					break;
					// EasyBlog profile integration - http://stackideas.com
					case 'easyblog':
						if (JFile::exists(JPATH_SITE.'/components/com_easyblog/easyblog.php')) {
							require_once JPATH_SITE.'/components/com_easyblog/helpers/router.php';
							$profile_link = EasyBlogRouter::_('index.php?option=com_easyblog&view=blogger&layout=listings&id='.$item->user_id);
						} else {
							echo JText::_('MOD_GIANTCONTENT_ERROR_PROFILE_SYSTEM_EASYBLOG');
							return;
						}
					break;
					// EasySocial profile integration - http://stackideas.com
					case 'easysocial':
						if (JFile::exists(JPATH_SITE.'/components/com_easysocial/easysocial.php')) {
							$profile_link = Foundry::user($item->user_id)->getPermalink();
						} else {
							echo JText::_('MOD_GIANTCONTENT_ERROR_PROFILE_SYSTEM_EASYSOCIAL');
							return;
						}
					break;
					// EasyDiscuss profile integration - http://stackideas.com
					case 'easydiscuss':
						if (JFile::exists(JPATH_SITE.'/components/com_easydiscuss/easydiscuss.php')) {
							require_once JPATH_SITE.'/components/com_easydiscuss/helpers/router.php';
							$profile_link = DiscussHelper::getTable('Profile')->load($item->user_id)->getLink();
						} else {
							echo JText::_('MOD_GIANTCONTENT_ERROR_PROFILE_SYSTEM_EASYDISCUSS');
							return;
						}
					break;
				}
			}

			// Show content intro
			if ($show_intro) {
				// Clean HTML tags
				if ($clean_intro) {
					$item->introtext		= strip_tags($item->introtext, $allowed_tags);
					$item->introtext		= str_replace('&nbsp;', ' ', $item->introtext);
					$item->introtext		= preg_replace('/\s{2,}/u', ' ', trim($item->introtext));
				}
				$lists[$i]->intro			= $limit_intro ? self::truncateText($item->introtext, $limit_intro) : $item->introtext;
			}

			// Show content title
			if ($show_title) {
				$lists[$i]->title_name		= $item->title;
				$lists[$i]->title			= $title_link ? '<a href="'.$lists[$i]->link.'">'.$lists[$i]->title_name.'</a>' : $lists[$i]->title_name;
			}

			// Show content category
			if ($show_category) {
				$lists[$i]->category_name	= $item->category_name;
				$lists[$i]->category_link	= JRoute::_(K2HelperRoute::getCategoryRoute($item->category_id.':'.$item->category_alias));
				$lists[$i]->category		= $category_link ? '<a href="'.$lists[$i]->category_link.'">'.$lists[$i]->category_name.'</a>' : $lists[$i]->category_name;
			}

			// Show content comments
			if ($show_comments) {
				$lists[$i]->comments_count	= $item->comments_count;
				$lists[$i]->comments_link	= $lists[$i]->link.$comments_link;
				$lists[$i]->comments		= '<a href="'.$lists[$i]->comments_link.'">'.$item->comments_count.'</a>';
			}

			// Show content author
			if ($show_author) {
				$lists[$i]->author_name		= $item->user_alias ? $item->user_alias : $item->user_name;
				$lists[$i]->author			= $show_profile ? '<a href="'.$profile_link.'">'.$lists[$i]->author_name.'</a>' : $lists[$i]->author_name;
			}

			// Show profile avatar
			if ($show_avatar) {
				$avatar_src					= 'modules/mod_giantcontent/assets/libraries/includes/timthumb.php?src='.JURI::base(true).'/';
				$avatar_attr				= '&amp;w='.$avatar_width.'&amp;h='.$avatar_height;
				$avatar_default				= '<img src="'.$avatar_src.'/modules/mod_giantcontent/assets/images/avatar.png'.$avatar_attr.'"  alt="'.$item->user_name.'" />';

				$lists[$i]->avatar_user		= $item->avatar_user;
				if ($avatar_system == 'easysocial') {
					$avatar_img = $avatar_path.$item->user_id.'/'.$item->avatar_user;
				} else {
					$avatar_img = $avatar_path.$item->avatar_user;
				}
				if (JFile::exists($avatar_img)) {
					$lists[$i]->avatar		= '<img src="'.$avatar_src.$avatar_img.$avatar_attr.'" alt="'.$item->user_name.'" />';
					$lists[$i]->avatar		= $show_profile ? '<a href="'.$profile_link.'">'.$lists[$i]->avatar.'</a>' : $lists[$i]->avatar;
				} else {
					$lists[$i]->avatar		= $show_profile ? '<a href="'.$profile_link.'">'.$avatar_default.'</a>' : $avatar_default;
				}
			}

			// Show content rating
			if ($show_rating) {
				if ($item->rating_count > 0) {
					$lists[$i]->rating_count	= $item->rating_count;
					$lists[$i]->rating_average	= $item->rating_average;
				} else {
					$lists[$i]->rating_count	= 0;
					$lists[$i]->rating_average	= 0.00;
				}

				$rating_current = $item->rating_average * 20;
				$lists[$i]->rating = '<span class="gc-rating-list"><span style="width:'.$rating_current.'%;" class="gc-rating-current"></span></span>';
			}

			// Show content tags
			if ($show_tags) {
				$db		= JFactory::getDbo();
				$query	= $db->getQuery(true);

				$query->select('t.id, t.name AS title');
				$query->from('#__k2_tags AS t');
				$query->join('LEFT', '#__k2_tags_xref AS tm ON tm.tagID = t.id');
				$query->where('t.published = 1 AND tm.itemID = '.$item->id);

				$db->setQuery($query);
				$tags = $db->loadObjectList();

				$list_tags = '';
				if ($tags) {
					foreach ($tags as $tag) {
						$link_tags = JRoute::_(K2HelperRoute::getTagRoute($tag->title));
						$list_tags .= '<a class="gc-tag" href="'.$link_tags.'">'.$tag->title.'</a>';
					}
				}
				$lists[$i]->tags = $list_tags;
			}

			// Show featured label
			if ($featured_label) {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT * FROM #__k2_items WHERE id = '.$item->id.' AND featured = 1');
				$featured = $db->loadResult();

				if ($featured) {
					$lists[$i]->featured = '<span class="gc-featured" style="background: '.$featured_label_color.'">'.$featured_label_text.'</span>';
				}
			}
		}
		return $lists;
	}

	// Cut introtext
	public static function truncateText($text, $limit, $ellipsis = '...') {
		if(strlen($text) > $limit) 
			$text = trim(substr($text, 0, $limit)) . $ellipsis; 
		return $text;
	}
	/*public static function truncateText($text, $limit, $ellipsis = '...') {
		if (strlen($text) > $limit) {
			$endpos = strpos(str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $text), ' ', $limit);
			if ($endpos !== false)
				$text = trim(substr($text, 0, $endpos)) . $ellipsis;
			}
		return $text;
	}*/
}