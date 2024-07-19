<div class="walkscore">
	<script type="text/javascript">
	jQuery(function($) {
		"use strict"; 
        var ws_lat = "45.839280";
        var ws_lon = "-64.193250";
        var ws_width = "630";
        $(function(){
            $.getScript("http://www.walkscore.com/tile/show-tile.php?wsid=g9e8ab0f84b9441bfb18b53b651034066", function(){            
             $('<iframe src="http://www.walkscore.com/serve-tile.php?' + ws_params 
                                         + '" marginwidth="0" marginheight="0" vspace="0" hspace="0"'
                                         + ' allowtransparency="true" frameborder="0" scrolling="no" width="' 
                                         + ws_width + 'px" height="' + ws_height + 'px"></iframe>')
                                         .appendTo("#contentArea");
           });
        });
	 });	
    </script>
</div>