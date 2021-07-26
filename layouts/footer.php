     </div>
    </div>
  
  <!--
  <script src="https://ajax.googleapis.com/ajax/lib/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/lib/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>-->

  <!-- jquery/ajax -->
  <!-- === NOTE ===
    -- This was moved to the header.
    -- NOT working when placed into footer
    -- (don't know why ?)
  -->
  <!--<script type="text/javascript" src="lib/js/jquery-3.5.1.js"></script>-->

  <!-- cached version -->
  <script type="text/javascript" src="cache/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="cache/js/bootstrap-datepicker.min.js"></script>

  <!-- DataTables -->
  <script type="text/javascript" src="lib/DataTables/datatables.min.js"></script>
  
  <script type="text/javascript" src="lib/js/functions.js"></script>
  </body>
</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>
