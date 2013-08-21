<script type="text/javascript">
   /**
    * Loads in a URL into a specified divName, and applies the function to
    * all the links inside the pagination div of that page (to preserve the ajax-request)
    * @param string href The URL of the page to load
    * @param string divName The name of the DOM-element to load the data into
    * @return boolean False To prevent the links from doing anything on their own.
    */
   function loadPiece(href,divName) {
      
      $(divName).load(href, {}, function(){
         
         //CallBack - Function active
         $("#light-ajax-loading").css("display", "none");

         var divPaginationLinks = divName+" #pagination a";
         $(divPaginationLinks).click(function() {
            var thisHref = $(this).attr("href");
            loadPiece(thisHref,divName);
            return false;
         });
      });
      //New Request...
      $("#light-ajax-loading").css("display", "inline");
   }

   $(document).ready(function() {
      loadPiece("<?php 
      				if(isset($query)) { echo $html->url(array('controller' => 'laboratories', 'action' => 'grid', $query));}
					else {echo $html->url(array('controller' => 'laboratories', 'action' => 'grid'));}
      			?>","#listObjs");
   });
</script>
<div id="listObjs">
</div>
