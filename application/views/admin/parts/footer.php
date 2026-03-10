

 	</div>
   <div id="footer">
        <div class="left_message" id="left_system_message"></div>
        <div id="logo_footer"></div>
        <div class="right_message" id="right_system_message"><? if( logged_in() ) : ?>Logged In as <?=cookiedata('alias')?><? else : ?><strong>Chi</strong> | Content Handler/Interface &copy; 2009-2011<? endif; ?></div>
   </div>
<script type="text/javascript">
   $("#main_menu li a.has_sub").click(function() { 
		$(this).parent().find("ul.submenu").show(); 
      $(this).parent().find("a.mm_item").addClass("subselected");
		$(this).parent().hover(
			function() { }, 
			function() { $(this).parent().find("ul.submenu").hide(); $(this).parent().find("a.mm_item").removeClass("subselected"); }
		);
	}).hover(
		function() {   $(this).addClass("subhover"); }, 
		function() {	$(this).removeClass("subhover"); }
	);
   
</script>
</body>
</html>
