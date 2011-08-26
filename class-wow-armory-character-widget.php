<?php
/*  
Copyright 2011  Adam Cooper  (email : adam@networkpie.co.uk)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Provides the wordpress widget.
 * 
 * @author Adam Cooper <adam@networkpie.co.uk>
 */
class WoW_Armory_Character_Widget extends WP_Widget
{
	protected $_default_options;
	
	public function __construct()
	{
		$this->_default_options = array(
			'name' => '', 
			'realm' => '',
			'region' => 'EU',
			'show_portrait' => 1,
			'show_title' => 1,
			'show_talents' => 1,
			'show_items' => 1,
			'show_profs' => 1,
			'show_achievs' => WoW_Armory_Character_Plugin::STYLE_ACHIEV_BAR | WoW_Armory_Character_Plugin::STYLE_ACHIEV_LIST,
			'locale' => 'en_GB',
			'title' => __('Armory for %NAME%', 'wow_armory_character'),
		);
		
		$widget_ops = array('classname' => 'WoW_Armory_Character_Widget', 'description' => __("Displays a World of Warcraft character's information", 'wow_armory_character'));
		parent::__construct('wow-armory-character-widget', __('WoW Armory Character', 'wow_armory_character'), $widget_ops);
	}
	
	public function form($instance)
	{
		$instance = wp_parse_args ((array)$instance, $this->_default_options);
	?>
		<div class="wow_armory_options">
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wow_armory_character'); ?></label><br />
				<input type="text" class="wa-title widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
				<small><?php _e('Use %NAME% for the character\'s name.', 'wow_armory_character'); ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Character name:', 'wow_armory_character'); ?></label><br />
				<input type="text" class="wa-name widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" value="<?php echo esc_attr($instance['name']); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('realm'); ?>"><?php echo __('Realm:', 'wow_armory_character'); ?></label><br />
				<select class="wa-region" id="<?php echo $this->get_field_id('region'); ?>" name="<?php echo $this->get_field_name('region'); ?>">
					<option value="US"<?php echo ($instance['region'] == 'US' ? ' selected="selected"' : ''); ?>>US</option>
					<option value="EU"<?php echo ($instance['region'] == 'EU' ? ' selected="selected"' : ''); ?>>EU</option>
					<option value="KR"<?php echo ($instance['region'] == 'KR' ? ' selected="selected"' : ''); ?>>KR</option>
					<option value="TW"<?php echo ($instance['region'] == 'TW' ? ' selected="selected"' : ''); ?>>TW</option>
				</select>
				<input type="text" class="wa-realm" style="width: 175px" id="<?php echo $this->get_field_id('realm'); ?>" name="<?php echo $this->get_field_name('realm'); ?>" value="<?php echo htmlspecialchars($instance['realm']); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('locale'); ?>"><?php echo __('Language:', 'wow_armory_character'); ?></label><br />
				<select class="wa-lang widefat" id="<?php echo $this->get_field_id('locale'); ?>" name="<?php echo $this->get_field_name('locale'); ?>">
					<option value="en_GB"<?php echo $instance['locale'] == 'en_GB' ? ' selected="selected"' : ''; ?>><?php _e('English', 'wow_armory_character'); ?></option>
					<option value="de_DE"<?php echo $instance['locale'] == 'de_DE' ? ' selected="selected"' : ''; ?>><?php _e('Deutsch', 'wow_armory_character'); ?></option>
					<option value="es_ES"<?php echo $instance['locale'] == 'es_ES' ? ' selected="selected"' : ''; ?>><?php _e('Espa√±ol', 'wow_armory_character'); ?></option>
					<option value="fr_FR"<?php echo $instance['locale'] == 'fr_FR' ? ' selected="selected"' : ''; ?>><?php _e('Fran√ßaise', 'wow_armory_character'); ?></option>
					<option value="ru_RU"<?php echo $instance['locale'] == 'ru_RU' ? ' selected="selected"' : ''; ?>><?php _e('P—É—Å—Å–∫–∏–π', 'wow_armory_character'); ?></option>
					<option value="ko_KR"<?php echo $instance['locale'] == 'ko_KR' ? ' selected="selected"' : ''; ?>><?php _e('ÌïúÍµ≠Ïñ¥', 'wow_armory_character'); ?></option>
					<option value="zh_TW"<?php echo $instance['locale'] == 'zh_TW' ? ' selected="selected"' : ''; ?>><?php _e('ÂÆòË©±', 'wow_armory_character'); ?></option>
				</select>
			</p>
			<h4><?php _e ('Display Options', 'wow_armory_character'); ?></h4>
			<p>
				<input id="<?php echo $this->get_field_id('show_portrait'); ?>" name="<?php echo $this->get_field_name('show_portrait'); ?>" value="1" type="checkbox" <?php echo $instance['show_portrait'] ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('show_portrait'); ?>"><?php _e('Show Portrait', 'wow_armory_character'); ?></label><br/>
				<input id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" value="1" type="checkbox" <?php echo $instance['show_title'] ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e('Show Title', 'wow_armory_character'); ?></label><br/>
				<input id="<?php echo $this->get_field_id('show_talents'); ?>" name="<?php echo $this->get_field_name('show_talents'); ?>" value="1" type="checkbox" <?php echo $instance['show_talents'] ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('show_talents'); ?>"><?php _e('Show Talents', 'wow_armory_character'); ?></label><br/>
				<input id="<?php echo $this->get_field_id('show_items'); ?>" name="<?php echo $this->get_field_name('show_items'); ?>" value="1" type="checkbox" <?php echo $instance['show_items'] ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('show_items'); ?>"><?php _e('Show Items', 'wow_armory_character'); ?></label><br/>
				<input id="<?php echo $this->get_field_id('show_profs'); ?>" name="<?php echo $this->get_field_name('show_profs'); ?>" value="1" type="checkbox" <?php echo $instance['show_profs'] ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('show_profs'); ?>"><?php _e('Show Profressions', 'wow_armory_character'); ?></label><br/>
				<input id="<?php echo $this->get_field_id('show_achievs'); ?>" name="<?php echo $this->get_field_name('show_achievs'); ?>" value="1" type="checkbox" <?php echo $instance['show_achievs'] ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('show_achievs'); ?>"><?php _e('Show Achievements', 'wow_armory_character'); ?></label><br/>
			</p>
			<div class="achiev_options">
				<h5><?php _e ('Achievement Display Options', 'wow_armory_character'); ?></h5>
				<p>
					<input id="<?php echo $this->get_field_id('show_achievs_bar'); ?>"
								 name="<?php echo $this->get_field_name('show_achievs_bar'); ?>"
								 value="<?php echo WoW_Armory_Character_Plugin::STYLE_ACHIEV_BAR; ?>"
								 type="checkbox"
								 <?php echo (($instance['show_achievs'] & WoW_Armory_Character_Plugin::STYLE_ACHIEV_BAR) === WoW_Armory_Character_Plugin::STYLE_ACHIEV_BAR) ? 'checked="checked"' : ''; ?>
					/>
					<label for="<?php echo $this->get_field_id('show_achievs_list'); ?>"><?php _e('Show Completion Bar', 'wow_armory_character'); ?></label><br/>
					<input id="<?php echo $this->get_field_id('show_achievs_list'); ?>"
								 name="<?php echo $this->get_field_name('show_achievs_list'); ?>"
								 value="<?php echo WoW_Armory_Character_Plugin::STYLE_ACHIEV_LIST; ?>"
								 type="checkbox"
								 <?php echo (($instance['show_achievs'] & WoW_Armory_Character_Plugin::STYLE_ACHIEV_LIST) === WoW_Armory_Character_Plugin::STYLE_ACHIEV_LIST) ? 'checked="checked"' : ''; ?>
					/>
					<label for="<?php echo $this->get_field_id('show_achievs_list'); ?>"><?php _e('Show Recent Achievements', 'wow_armory_character'); ?></label><br/>
				</p>
			</div>
		</div>
	<?php
	}
	
	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['name'] = strip_tags(stripslashes($new_instance['name']));
		$instance['realm'] = strip_tags(stripslashes($new_instance['realm']));
		$instance['region'] = strip_tags(stripslashes($new_instance['region']));
		$instance['show_portrait'] = strip_tags(stripslashes($new_instance['show_portrait']));
		$instance['show_title'] = strip_tags(stripslashes($new_instance['show_title']));
		$instance['show_talents'] = strip_tags(stripslashes($new_instance['show_talents']));
		$instance['show_items'] = strip_tags(stripslashes($new_instance['show_items']));
		$instance['show_profs'] = strip_tags(stripslashes($new_instance['show_profs']));
		$instance['locale'] = strip_tags(stripslashes($new_instance['locale']));
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		
		// We ignore the setting of 'show_achievs' and parse the bitwise setting instead. Having
		// bitwise settings checked implies you want the master setting configured.
		$ach_config = null;
		if ($new_instance['show_achievs_bar']) $ach_config = $ach_config | WoW_Armory_Character_Plugin::STYLE_ACHIEV_BAR;
		if ($new_instance['show_achievs_list']) $ach_config =  $ach_config | WoW_Armory_Character_Plugin::STYLE_ACHIEV_LIST;

		// If no settings are configured but the master is ticked then set the defaults. This shouldn't be 
		// needed since JS on the frontend will sort it but we need to cover ourselves.
		if ($new_instance['show_achievs'] && $ach_config == null) $ach_config = $this->_default_options['show_achievs'];
		$instance['show_achievs'] = $ach_config;		
		
		return $instance;
	}
	
	public function widget($args, $instance)
	{
		extract($args);
		
		echo $before_widget;
		
		$title = apply_filters('widget_title', str_replace('%NAME%', $instance['name'], $instance['title']));		
		if (!empty($title))
			echo $before_title . $title . $after_title;		
		
		$char = WoW_Armory_Character_DAL::fetch_character($instance['region'], $instance['locale'], $instance['realm'], $instance['name']);
		
		if (!is_wp_error($char))
		{
			$view = new WoW_Armory_Character_View($char);
			echo $view->display_character($instance);
		}
		else
		{
			// Show the error message.
			echo $char->get_error_message();
		}
		
		echo $after_widget;
	}
}