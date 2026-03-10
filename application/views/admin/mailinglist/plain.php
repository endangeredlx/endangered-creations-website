<div style="margin:10px auto; width:960px;"><? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?> <?=row_value( 'email' )?>, <? endwhile; endif; ?></div>
