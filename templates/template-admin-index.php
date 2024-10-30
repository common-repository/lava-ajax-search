<h1><?php esc_html_e( "Lava ajax search settings", 'lvbp-ajax-search' ); ?></h1>
<form method="post" action="options.php">
<?php
	settings_fields( lava_ajaxSearch()->admin->optionGroup ); ?>

	<table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e( "Search Setting", 'lvbp-ajax-search' ); ?></th>
			<td>
				<table class="widefat">
					<tbody>
						<?php /*
						<tr valign="top">
							<td width="1%"></td>
							<th><?php _e( "Placeholder Dropdown", 'lvbp-ajax-search' ); ?></th>
							<td>
								<input type="checkbox" name="<?php echo lava_ajaxSearch()->admin->getOptionFieldName( 'placeholder_dropdown' ); ?>" value="yes" <?php checked('yes' == lava_ajaxSearch()->admin->get_settings( 'placeholder_dropdown' )); ?>>
							</td>
						</tr> */ ?>
						<tr valign="top">
							<td width="1%"></td>
							<th><?php _e( "Show category list first", 'lvbp-ajax-search' ); ?></th>
							<td>
								<input type="checkbox" name="<?php echo lava_ajaxSearch()->admin->getOptionFieldName( 'show_categories' ); ?>" value="yes" <?php checked('yes' == lava_ajaxSearch()->admin->get_settings( 'show_categories' )); ?>>
								<p><small><?php esc_html_e( "Show all category list on the top first on the dropdown items. It's not recommended when you have many ( too long ). recommended less than 5 ~ 7 categories.", 'lvbp-ajax-search' ); ?></small></p>
							</td>
						</tr>
						<tr><td colspan="3" style="padding:0;"><hr style='margin:0;'></td></tr>
						<tr valign="top">
							<td width="1%"></td>
							<th><?php _e( "Search result count", 'lvbp-ajax-search' ); ?></th>
							<td>
								<input type="number" name="<?php echo lava_ajaxSearch()->admin->getOptionFieldName( 'search_limit' ); ?>" value="<?php echo intVal( lava_ajaxSearch()->admin->get_settings( 'search_limit', 0 ) ); ?>">
								<p><small><?php esc_html_e( "Unlimited = 0", 'lvbp-ajax-search' ); ?></small></p>
							</td>
						</tr>
						<tr><td colspan="3" style="padding:0;"><hr style='margin:0;'></td></tr>
						<tr valign="top">
							<td width="1%"></td>
							<th><?php _e( "Minimum number of search letters to run a search", 'lvbp-ajax-search' ); ?></th>
							<td>
								<input type="number" name="<?php echo lava_ajaxSearch()->admin->getOptionFieldName( 'min_search_length' ); ?>" min="0" value="<?php echo intVal( lava_ajaxSearch()->admin->get_settings( 'min_search_length', 1 ) ); ?>">
							</td>
						</tr>
						<tr><td colspan="3" style="padding:0;"><hr style='margin:0;'></td></tr>
						<tr valign="top">
							<td width="1%"></td>
							<th><?php _e( "Search Filter", 'lvbp-ajax-search' ); ?></th>
							<td>
								<?php
								foreach(
									Array(
										Array(
											'type' => 'separator',
											'label' => esc_html__( "Post Types", 'lvbp-ajax-search' ),
										),
										'posts' => Array(
											'label' => esc_html__( "Posts", 'lvbp-ajax-search' ),
										),
										'pages' => Array(
											'label' => esc_html__( "Pages", 'lvbp-ajax-search' ),
										),
										'listings' => Array(
											'label' => esc_html__( "Listings", 'lvbp-ajax-search' ),
										),
										/*
										Array(
											'type' => 'separator',
											'label' => esc_html__( "Taxonomy", 'lvbp-ajax-search' ),
										),
										'listing_category' => Array(
											'label' => esc_html__( "Listing Category", 'lvbp-ajax-search' ),
										), */
										Array(
											'type' => 'separator',
											'label' => esc_html__( "Buddy Press", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'BuddyPress' ),
										),
										'members' => Array(
											'label' => esc_html__( "Members", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'BuddyPress' ),
										),
										'groups' => Array(
											'label' => esc_html__( "Groups", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'BuddyPress' ),
										),
										Array(
											'type' => 'separator',
											'label' => esc_html__( "BBPress", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'bbPress' ),
										),
										'forum' => Array(
											'label' => esc_html__( "Forum", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'bbPress' ),
										),
										'topic' => Array(
											'label' => esc_html__( "Topics", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'bbPress' ),
										),
										'reply' => Array(
											'label' => esc_html__( "Replies", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'bbPress' ),
										),
										Array(
											'type' => 'separator',
											'label' => esc_html__( "Woocommerce", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'WC' ),
										),
										'products' => Array(
											'label' => esc_html__( "Products", 'lvbp-ajax-search' ),
											'allow' => function_exists( 'WC' ),
										),
									) as $strFilter => $arrFilterMeta
								) {

									if( isset( $arrFilterMeta[ 'allow' ] ) && true !== $arrFilterMeta[ 'allow' ] ) {
										continue;
									}

									if( isset( $arrFilterMeta[ 'type' ] ) && 'separator' == $arrFilterMeta[ 'type' ] ) {
										printf( '<h4>%s</h4>', $arrFilterMeta[ 'label' ] );
										continue;
									}

									printf(
										'<div style="margin-left:10px;"><label><input type="checkbox" name="%1$s[]" value="%2$s"%4$s>%3$s</label></div>',
										lava_ajaxSearch()->admin->getOptionFieldName( 'search_filter' ),
										$strFilter, $arrFilterMeta[ 'label' ],
										checked( in_array( $strFilter, (array) lava_ajaxSearch()->admin->get_settings( 'search_filter' ) ), true, false )
									);
								} ?>
							</td>
						</tr>
						<tr><td colspan="3" style="padding:0;"><hr style='margin:0;'></td></tr>
						<tr valign="top">
							<td width="1%"></td>
							<th><?php esc_html_e( "Search Page", 'lvbp-ajax-search' ); ?></th>
							<td>
								<h4><?php esc_html_e( "Seach Form Placeholder", 'lvbp-ajax-search' ); ?></h4>
								<lable>
									<input type="text" name="<?php echo lava_ajaxSearch()->admin->getOptionFieldName('search_page_placeholder'); ?>" value="<?php echo lava_ajaxSearch()->admin->get_settings('search_page_placeholder'); ?>">
								</label>
							</td>
						</tr>
						<tr><td colspan="3" style="padding:0;"><hr style='margin:0;'></td></tr>
						<tr valign="top">
							<td width="1%"></td>
							<th><?php esc_html_e( "Top Searched", 'lvbp-ajax-search' ); ?></th>
							<td class="suggestion-field-setting">
								<?php
								$keyword = new Lava_Ajax_Search_Keyword();
								$keywords = $keyword->get_keywords(Array(
									'field' => 'keyword',
								));
								$manualkeywords =  $keyword->get_keywords(Array(
									'type' => 'manual',
								));
								$suggestionOrderBy = lava_ajaxSearch()->admin->get_settings('suggestion_orderby');?>
								<div class="suggestion-orderby-field">
									<select name="<?php echo lava_ajaxSearch()->admin->getOptionFieldName('suggestion_orderby'); ?>">
										<option value="auto"><?php esc_html_e( "Automatic", 'lvbp-ajax-search' ); ?></option>
										<option value="manual" <?php selected('manual' == $suggestionOrderBy);?>><?php esc_html_e( "Manual", 'lvbp-ajax-search' ); ?></option>
									</select>
								</div>
								<div class="suggestion-load-top-10-field" style="display:none;">
									<button type="button" class="button" data-keywords='<?php echo wp_json_encode($keywords); ?>'>
										<?php esc_html_e( "Reset( Load top 10 keywords )", 'lvbp-ajax-search' ); ?>
									</button>
								</div>
								<div class="suggestion-top-10-field" style="display:none;">
									<ul class="suggestion-lists">
									<?php
									for($fieldLoop=0;$fieldLoop<10;$fieldLoop++) {
										$thisValue = isset($manualkeywords[$fieldLoop]) ? $manualkeywords[$fieldLoop] : '';
										?>
										<li class="list-item">
											<input type="text" name="<?php echo lava_ajaxSearch()->admin->getOptionFieldName('suggestion_keywords'); ?>[]" value="<?php echo esc_attr($thisValue); ?>">
											<button type="button" class="button button-danger" data-remove>
												<?php esc_html_e( "Remove", 'lvbp-ajax-search' ); ?>
											</button>
										</li>
									<?php } ?>
									</ul>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
	</table>
	<?php submit_button(); ?>
</form>