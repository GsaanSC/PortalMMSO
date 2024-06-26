<?php
/**
 * Generate the XML for export for posts and form actions.
 *
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect
 *
 * @package Formidable
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

if ( ! $item_ids ) {
	return;
}

global $wp_query;
// Fake being in the loop.
$wp_query->in_the_loop = true;

// fetch 20 posts at a time rather than loading the entire table into memory
while ( $next_posts = array_splice( $item_ids, 0, 20 ) ) {
	$posts = FrmDb::get_results( $wpdb->posts, array( 'ID' => $next_posts ) );

	// Begin Loop
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$is_sticky = is_sticky( $post->ID ) ? 1 : 0;
		?>
	<view>
		<title><?php echo esc_html( apply_filters( 'the_title_rss', $post->post_title ) ); ?></title>
		<link><?php the_permalink_rss(); ?></link>
		<post_author><?php echo FrmXMLHelper::cdata( get_the_author_meta( 'login' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></post_author>
		<description></description>
		<content><?php echo FrmXMLHelper::cdata( apply_filters( 'the_content_export', $post->post_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></content>
		<excerpt><?php echo FrmXMLHelper::cdata( apply_filters( 'the_excerpt_export', $post->post_excerpt ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></excerpt>
		<post_id><?php echo esc_html( $post->ID ); ?></post_id>
		<post_date><?php echo esc_html( $post->post_date ); ?></post_date>
		<post_date_gmt><?php echo esc_html( $post->post_date_gmt ); ?></post_date_gmt>
		<comment_status><?php echo esc_html( $post->comment_status ); ?></comment_status>
		<ping_status><?php echo esc_html( $post->ping_status ); ?></ping_status>
		<post_name><?php echo esc_html( $post->post_name ); ?></post_name>
		<status><?php echo esc_html( $post->post_status ); ?></status>
		<post_parent><?php echo esc_html( $post->post_parent ); ?></post_parent>
		<menu_order><?php echo esc_html( $post->menu_order ); ?></menu_order>
		<post_type><?php echo esc_html( $post->post_type ); ?></post_type>
		<post_password><?php echo FrmXMLHelper::cdata( $post->post_password ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></post_password>
		<is_sticky><?php echo esc_html( $is_sticky ); ?></is_sticky>
<?php	if ( 'attachment' === $post->post_type ) : ?>
		<attachment_url><?php echo esc_url( wp_get_attachment_url( $post->ID ) ); ?></attachment_url>
		<?php
		endif;

		$postmeta = FrmDb::get_results( $wpdb->postmeta, array( 'post_id' => $post->ID ) );
		foreach ( $postmeta as $meta ) :
			if ( apply_filters( 'wxr_export_skip_postmeta', false, $meta->meta_key, $meta ) ) {
				continue;
			}
			?>
		<postmeta>
			<meta_key><?php echo esc_html( $meta->meta_key ); ?></meta_key>
			<meta_value><?php echo FrmXMLHelper::cdata( $meta->meta_value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></meta_value>
		</postmeta>
<?php
		endforeach;

		$taxonomies = get_object_taxonomies( $post->post_type );
		if ( ! empty( $taxonomies ) ) {
			$terms = wp_get_object_terms( $post->ID, $taxonomies );

			foreach ( (array) $terms as $term ) {
				?>
		<category domain="<?php echo esc_attr( $term->taxonomy ); ?>" nicename="<?php echo esc_attr( $term->slug ); ?>"><?php echo FrmXMLHelper::cdata( $term->name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></category>
<?php
			}
		}

		if ( 'frm_display' === $post->post_type && is_callable( 'FrmViewsLayout::get_layouts_for_view' ) ) {
			$layouts = FrmViewsLayout::get_layouts_for_view( $post->ID );
			foreach ( $layouts as $layout ) {
				?>
		<layout>
			<type><?php echo esc_html( $layout->type ); ?></type>
			<data><?php echo FrmXMLHelper::cdata( $layout->data ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></data>
		</layout>
<?php
			}
		}
		?>
	</view>
<?php
	}//end foreach
}//end while

if ( empty( $taxonomies ) ) {
	return;
}

global $frm_inc_tax;
if ( empty( $frm_inc_tax ) ) {
	$frm_inc_tax = array();
}

$parent_slugs = FrmXMLController::get_parent_terms_slugs( $terms );

foreach ( (array) $terms as $term ) {
	if ( in_array( $term->term_id, $frm_inc_tax, true ) ) {
		continue;
	}

	$frm_inc_tax[] = $term->term_id;
	$label         = ( 'category' === $term->taxonomy || 'tag' === $term->taxonomy ) ? $term->taxonomy : 'term';
	?>
	<term><term_id><?php echo esc_html( $term->term_id ); ?></term_id><term_taxonomy><?php echo esc_html( $term->taxonomy ); ?></term_taxonomy><?php
	if ( ! empty( $parent_slugs[ $term->parent ] ) ) {
		echo '<term_parent>' . esc_html( $parent_slugs[ $term->parent ] ) . '</term_parent>';
	}
	if ( ! empty( $term->name ) ) {
		echo '<term_name>' . FrmXMLHelper::cdata( $term->name ) . '</term_name>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	if ( ! empty( $term->description ) ) {
		echo '<term_description>' . FrmXMLHelper::cdata( $term->description ) . '</term_description>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '<term_slug>' . esc_html( $term->slug ) . '</term_slug>';
	echo '</term>';
}//end foreach
