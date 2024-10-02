<?php 
// No direct access
// When updating the leaflet library, make sure that the CLM main has the same library version
defined('_JEXEC') or die; ?>
<div class="clm_map" id="map<?php echo $module->id; ?>"></div>
<script type="text/javascript">

<?php echo $js; ?>
</script>