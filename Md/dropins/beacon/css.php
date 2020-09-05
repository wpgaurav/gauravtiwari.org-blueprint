<style type="text/css">

/*------------------------------*\
	$BEACON
\*------------------------------*/

.beacon {
	color: #fff;
	font-size: 14px;
	line-height: 22px;
	position: relative;
	text-align: center;
	vertical-align: top;
	z-index: 10;
}

/* STATUS */

.beacon-status {
	border-radius: 50%;
	height: 21px;
	position: relative;
	width: 21px;
	z-index: 10;
}

.beacon.on .beacon-status { background-color: #30a146; }

.beacon.off .beacon-status { background-color: #777; }

.beacon-pulse {
	animation: pulse 2.5s ease-out;
	animation-iteration-count: infinite;
	background-color: #2b803c;
	border-radius: 50%;
	height: 29px;
	opacity: 0;
	position: absolute;
	width: 29px;
}

/* MENU CONTENT */

.beacon-menu {
	display: none;
	margin-top: <?php echo $single; ?>px;
}

.beacon-menu .beacon-status, .beacon-menu .beacon-pulse, .beacon-menu.on:hover .beacon-pulse { display: none; }

.beacon-menu .beacon-pulse {
	left: 6px;
	top: 6px;
}

.beacon-content {
	background-color: rgba(0, 0, 0, 0.85);
	border-radius: 3px;
}

.beacon-text { margin-bottom: <?php echo $half; ?>px; }

.beacon .button {
	display: block;
	text-align: center;
}

/* TRIGGER */

.beacon-trigger {
	display: inline-block;
	padding: 3px 3px 0 10px;
}

.beacon-trigger .beacon-status { display: block; }

.beacon-trigger .beacon-pulse {
	left: 6px;
	top: -1px;
}

/* QUERIES */

@media all and (min-width: <?php echo $site_width + $single; ?>px) {
	.beacon-menu { margin-right: -10px; }
}

@media all and (min-width: 900px) {
	.beacon-menu {
		display: inline-block;
		margin-left: <?php echo $half; ?>px;
		margin-top: 9px;
		padding: 10px;
	}
	.beacon-menu:hover {
		background-color: rgba(0, 0, 0, 0.85);
		border-radius: 3px 3px 0 0;
	}
	.beacon-menu:hover .beacon-content {
		border-radius: 3px 0 3px 3px;
		display: block;
	}
	.beacon-menu .beacon-status, .beacon-menu .beacon-pulse { display: block; }
	.beacon-trigger {
		display: none;
		padding: 0;
	}
	.beacon-content {
		display: none;
		position: absolute;
			top: 41px;
			right: 0;
		width: 300px;
	}
}

@media all and (max-width: 900px) {
	.beacon-toggle { display: block; }
}

/* PULSE ANIMATION */

@keyframes pulse {
	0% {
		opacity: 0;
		transform: scale(.1, .1);
	}
	50% { opacity: 1; }
	100% {
		opacity: 0;
		transform: scale(1.2, 1.2);
	}
}