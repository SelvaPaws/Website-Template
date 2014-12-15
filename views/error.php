<div id="error-header">
Error - <?php echo $this->errorName; ?>
</div>
<?php if ($this->errorMessage) { ?>
<div id="error-explanation">
	<?php echo $this->errorMessage; ?>
</div>
<?php } ?>