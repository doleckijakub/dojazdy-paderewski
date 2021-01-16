<style>
	@keyframes showModal {
		0% {
			transform: translate(-50%, -50%) scale(1);
		}
		1% {
			transform: translate(-50%, -50%) scale(.5);
		}
		45% {
			transform: translate(-50%, -50%) scale(1.05);
		}
		80% {
			transform: translate(-50%, -50%) scale(.95);
		}
		100% {
			transform: translate(-50%, -50%) scale(1);
		}
	}

	.fullscreen-overlay {
		position: fixed;
		width: 100vw;
		height: 100vh;
		top: 0;
		left: 0;
		background: #00000077;
		z-index: 8888;
	}

	.alert-modal {
		width: 478px;
		opacity: 1;
		background-color: #fff;
		text-align: center;
		border-radius: 5px;
		position: fixed;
		left: 50%;
		top: 50%;
		margin: 20px auto;
		display: inline-block;
		vertical-align: middle;
		z-index: 8898;
		transform: translate(-50%, -50%) scale(1);
		animation: showModal .5s;
	}

	.alert-icon {
		pointer-events: none;
		width: 80px;
		height: 80px;
		border-width: 4px;
		border-style: solid;
		border-radius: 50%;
		padding: 0;
		position: relative;
		box-sizing: content-box;
		margin: 20px auto;
	}

	.alert-icon-success-ring {
		border-color: #a5dc86;
	}

	.alert-icon-error-ring {
		border-color: #f27474;
	}

	.alert-title {
		pointer-events: none;
		font-size: 27px;
	}

	.alert-text {
		pointer-events: none;
		font-size: 16px;
	}

	.alert-button-container {
	}

	.alert-button {
		cursor: pointer;
		color: #fff;
		background-color: #428bca;
		border-color: #357edb;
		padding: 10px 24px;
		border: 1px solid transparent;
		border-radius: 4px;
		cursor: pointer !important;
		margin: 20px;
		z-index: 9999;
	}

	.alert-success-line {
		height: 5px;
		background-color: #a5dc86;
		display: block;
		border-radius: 2px;
		position: absolute;
		z-index: 2;
	}

	.alert-success-line-long {
		width: 47px;
		right: 8px;
		top: 38px;
		transform: rotate(-45deg);
	}

	.alert-success-line-short {
		width: 25px;
		left: 14px;
		top: 46px;
		transform: rotate(45deg);
	}

	.alert-error-line {
		position: absolute;
		height: 5px;
		width: 47px;
		background-color: #f27474;
		display: block;
		top: 37px;
		border-radius: 2px;
	}

	.alert-error-line-1 {
		transform: rotate(45deg);
		left: 17px;
	}

	.alert-error-line-2 {
		transform: rotate(-45deg);
		right: 16px;
	}
</style>

<script>
	function del(el) {
		el.parentElement.removeChild(el);
	}
</script>

<?php

function alert_modal($title, $text, $type) {

	if(!in_array($type, array('success', 'error'))) {

		return;

	}

	$key_class = 'o'.bin2hex(random_bytes(20));

	$icon = '';
	$icon_middle = '';
	switch($type) {
		case 'success':
			$icon = 'alert-icon-success-ring';
			$icon_middle = '<span class="alert-success-line-long alert-success-line"></span><span class="alert-success-line-short alert-success-line"></span>';
			break;
		case 'error':
			$icon = 'alert-icon-error-ring';
			$icon_middle = '<span class="alert-error-line alert-error-line-1"></span><span class="alert-error-line alert-error-line-2"></span>';
			break;
	}

	echo "<div class='fullscreen-overlay ".$key_class."'>".
		"<div class='alert-modal'>".
			"<div class='alert-icon ".$icon."''>".
				$icon_middle.
			"</div>".
			"<div class='alert-title'>".$title."</div>".
			"<div class='alert-text'>".$text."</div>".
			"<div class='alert-footer'>".
				"<div class='alert-button-container'>".
					"<button class='alert-button' onclick='del(document.querySelector(\".".$key_class."\"))'>OK</button>".
				"</div>".
			"</div>".
		"</div>".
	"</div>";

}