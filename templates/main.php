<?php
// Ensures the JS entry is enqueued if not already
script($_['appId'], 'main');
?>
<div class="section">
  <h1 class="page-heading">Help</h1> <!-- <- the text under the nav bar -->
  <div id="zammad-help"></div>       <!-- <- Vue mounts here -->
</div>
