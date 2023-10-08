<?php
$taxonomy   = 'post_tag';
$tag_fields = pzfm_tags_fields();
unset( $tag_fields['description'] );
$number     = 12;
$paged 		= (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset 	= ( $paged > 0 ) ?  $number * ( $paged - 1 ) : 1;
$search     = '';
$args = array(
    'taxonomy'      => $taxonomy,
    'order'         => 'ASC',
    'hide_empty'    => false,
    'number'        => $number,
    'offset'        => $offset
);

if( isset($_GET['pzfm-stag']) && !empty($_GET['pzfm-stag']) ){
    $args['search'] = sanitize_text_field($_GET['pzfm-stag']);
    $search         = $args['search'];
}

$args           = apply_filters( 'pzfm_term_tags_args', $args );
$add_page       = $paged > 1 ? '/page/'.$paged.'/' : '';
$the_query      = new WP_Term_Query($args);

unset( $args['offset'] );
$totalterms     = wp_count_terms( $args );
$total_pages    = ceil( $totalterms / $number );

$dashboard_url 	= get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page();
?>
<div class="bg-white mb-5">
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <form id="pzfm-search-form" method="get" class="navbar-form d-md-flex col-xl-4 col-md-6 px-0">
                <input type="hidden" name="dashboard" value="pzfm_posts">
                <input type="hidden" name="action" value="tags">
                <div class="input-group mb-2">
                    <input type="text" class="form-control form-control-sm" name="pzfm-stag" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_html_e( 'Search for...', 'pz-frontend-manager' ); ?>" aria-label="<?php esc_html_e( 'Search for...', 'pz-frontend-manager' ); ?>" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-pzfm" type="submit"><?php esc_html_e( 'Search tags', 'pz-frontend-manager' ); ?></button>
                    </div>
                </div>
            </form>
        </div>
        <div id="pzfm-post_tag_form" class="col-lg-4">
            <div class="card shadow">
                <div class="card-header pzfm-header">
                    <?php esc_html_e( 'Add new '.pzfm_tags_label(), 'pz-frontend-manager'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        $term_data  = (array)get_term( pzfm_parameters('term_id'), $taxonomy );
                        foreach( pzfm_tags_fields() as $form_key => $form_fields ): ?>
                            <?php
                                $value = array_key_exists( $form_key, $term_data ) ? $term_data[$form_key] : '';          
                                echo pzfm_field_generator( $form_fields, $form_key, $value, 'form-control' );
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-block pzfm-save-tag my-3 btn-pzfm" date-type="post_tag"><?php esc_html_e( 'Save', 'pz-frontend-manager' ); ?></button>
            <input type="hidden" name="action" value="<?php echo pzfm_parameters('term_id'); ?>">
        </div>
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header pzfm-header">
                    <?php echo pzfm_tags_label(); ?>
                </div>
                <div class="card-body">
                    <div class="text-dark pzfm_table">
                            <table class="table pzfm_table pzfm_tags_table">
                                <thead>
                                    <tr>
                                        <th scope="col"><input id="bulk-select-all" type="checkbox" class="bulk-select-all"></th>
                                        <?php foreach( $tag_fields as $tag_key => $tag_value ): ?>
                                            <th scope="col"><?php echo esc_html( $tag_value['label'] ); ?></th>
                                        <?php endforeach; ?>
                                        <th scope="col"><?php esc_html_e( 'Count', 'pz-frontend-manager' ); ?></th>
                                    </tr>
                                </thead>
                            <tbody>
                            <?php if( !empty( $the_query->terms ) ): ?>
                                <?php foreach( $the_query->terms as $tag ): ?>
                                        <?php
                                            $colcounter 	= 0;
                                            $term_name      = $tag->name;
                                            $term_slug      = $tag->slug;
                                            $term_description = $tag->description;
                                            $term_count     = $tag->count;
                                        ?>
                                        <tr class="pz-row pzpost-row">
                                            <td class="align-middle">
                                                <input type="checkbox" value="<?php echo (int)$tag->term_id; ?>" name="cat_checkbox[]" class="bulk-select-checkbox">
                                            </td>
                                            <?php foreach( $tag_fields as $tag_key => $tag_value ): ?>
                                                <td data-label="<?php echo esc_attr( $tag_key ); ?>" class="pzfm-cat-<?php echo esc_attr( $tag_key ); ?>">
                                                    <?php echo !$colcounter ? sprintf( '<a href="%s">%s</a> ', esc_url_raw( $dashboard_url .'&action=update-tags&term_id='.$tag->term_id ), $tag->$tag_key ) : $tag->$tag_key; ?>
                                                    <?php if(!$colcounter): ?>
                                                        <section class="pzfm-row-actions">
                                                            <ul>
                                                            <?php foreach ( pzfm_table_actions() as $actn_key => $actn_label ): ?>
                                                                <?php 
                                                                    $class  = 'pzfm-post_'.$actn_key;
                                                                    $link   = '#';
                                                                    if( $actn_key == 'delete' ){
                                                                        $class .= ' text-danger tag-remove-btn';
                                                                    }elseif( $actn_key == 'edit' ){
                                                                        $class .= ' pzfm-tag-edit';
                                                                    }else{
                                                                        $link = get_term_link( $tag->term_id ); 
                                                                    }
                                                                ?>
                                                                <li>
                                                                    <a href="<?php echo esc_url( $link ); ?>" class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $actn_label ); ?>" data-id="<?php echo (int)$tag->term_id; ?>" data-type="posts_cat"><?php echo esc_html( $actn_label ); ?></a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                            </ul>
                                                        </section>
                                                    <?php endif; ?>
                                                </td>
                                            <?php $colcounter++; endforeach; ?>
                                            <td data-label="Count" class="pzfm-product-price">
                                                <?php printf( '<a href="%s">%d</a>', esc_url( $dashboard_url.'&tag='.$term_slug ), (int)$term_count ); ?>
                                            </td>
                                        </tr>
                                                
                                    <?php endforeach; ?>
                                <?php else:  ?>
                                    <tr>
                                        <td colspan="9"><i><?php esc_html_e( 'No results found', 'pz-frontend-manager' ); ?></i></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <section class="col-lg-6">
                                <div class="row align-items-center">
                                    <div class="col col-auto pr-0">
                                        <select name="pzfm-bulk-actions" class="pzfm-bulk-actions form-control form-control-sm d-inline" style="width:120px">
                                            <option value=""><?php esc_html_e('Bulk Actions', 'pz-frontend-manager'); ?></option>
                                            <?php foreach( pzfm_table_bulk_actions() as $bulk_key => $bulk_label ): ?>
                                                <option value="<?php echo esc_attr( $bulk_key ); ?>"><?php echo esc_html( $bulk_label ); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col pl-1">
                                        <button class="btn btn-sm btn-secondary pzfm-tax-bulk_action" data-type="post_tag" style="width: fit-content"><?php esc_html_e('Apply', 'pz-frontend-manager'); ?></button>
                                    </div>
                                </div>
                            </section>
                            <div class="col-lg-6 text-center mt-lg-0 mt-3 text-lg-right">
                                <?php if( $total_pages > 1 ): ?>
                                    <div class="page-buttons text-center text-lg-right d-inline ml-4">
                                        <?php
                                        echo paginate_links( array(
                                            'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                                            'format' => '?paged=%#%',
                                            'current' => max( 1, $paged ),
                                            'total' => $total_pages,
                                            'prev_text' => '&lsaquo;',
                                            'next_text' => '&rsaquo;'
                                        ) ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade pzfm-modal-form" id="pzfmTagFormModal" tabindex="-1" aria-labelledby="editTagModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="editTagModalLabel"></h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <?php
        $term_data  = (array)get_term( pzfm_parameters('term_id'), $taxonomy );
        foreach( pzfm_tags_fields() as $form_key => $form_fields ): 
            $value = array_key_exists( $form_key, $term_data ) ? $term_data[$form_key] : '';          
            echo pzfm_field_generator( $form_fields, $form_key, $value, 'form-control' );
        endforeach; 
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e( 'Close', 'pz-frontend-manager' ); ?></button>
        <button type="button" class="btn btn-pzfm pzfm-modal pzfm-save-tag" date-type="post_tag"><?php esc_html_e( 'Save changes', 'pz-frontend-manager' ); ?></button>
				<input type="hidden" id="current-term-id" name="action" value>
      </div>
    </div>
  </div>
</div>