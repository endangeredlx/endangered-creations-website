<div id="main_content" class="clearfix">
    
    <? if( $success ) : ?>
    
    <? elseif( $error ) : ?>
    
    <?=validation_errors()?>
    
    <? elseif( $warning ) : ?>
    
    <div class="warning notice clearfix"></div>
    
    <? endif; ?>
    
   	<? if( !$success ) : ?>
    
         <h2>Add <?=ucwords( $singular )?></h2>
        
         <? $attributes = array('name' => 'write', 'id' => 'write'); ?>

         <?=form_open( base_url(). $class . '/create', $attributes )?>

         <?
            $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => '' );
            $venue_data = array( 'name' => 'venue', 'id' => 'venue', 'value' => '' );
            $address_data = array( 'name' => 'address', 'id' => 'address', 'value' => '' );
            $time_dropdown = array();
            for( $i = 0; $i < 1420; $i = $i + 30)
            {
               $time_dropdown[ $i ] = date( 'g:i a', ( ( $i * 60 ) + 25200 ) );
            }

            $js = ''; 

            $submit_js = 'onClick="submit_form(this); return false;"';
        ?>
        
        <label>Title</label>
        <?=form_input( $ttl_data, '', $js );?>

        <label>Venue</label>
        <?=form_input( $venue_data, '', $js )?>

        <label>Address</label>
        <?=form_input( $address_data, '', $js )?>

        <label>Date</label>
      
        <input type="text" class="small_input" name="date" value="MM/DD/YYYY" />

        <?=form_dropdown( 'time', $time_dropdown, '1260' )?>

        <?=form_submit( 'submit', 'Continue', $submit_js )?>
        
        <?=form_close()?>
    
    <? endif; ?>

</div>
