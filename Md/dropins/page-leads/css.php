<style type="text/css">

/*------------------------------*\
	$PAGE_LEADS
\*------------------------------*/

.email-lead .email-form-inner:after {
	clear: both;
	content: '';
	display: table;
}

.video-lead:not(.text-white) .play-button { border-color: #1e1e1e; }
.video-lead:not(.text-white) .play-button:after { border-left-color: #1e1e1e; }

.funnel-lead .box-style {
	background-color: #fff;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
.funnel-lead .col { vertical-align: bottom; }
.funnel-lead .col .button { display: block; }
.funnel-lead .has-col-button .button {
	border: 3px solid #fff;
	position: relative;
	z-index: 1;
}
.funnel-lead .has-col-button + .col-image { margin-top: -<?php echo $triple; ?>px; }
.funnel-lead .col-image img { width: 100%; }

.table-lead ul { margin-left: 0; }
.table-lead .content-item:not(:last-child) { border-bottom: 1px solid #ddd; }
.table-lead-pro .table-lead-content { background-color: #fff; }
.table-lead-featured {
	background-color: #32a4e6;
	color: #fff;
}
.table-lead .col-featured { border-top: 8px solid #F2A846; border-radius: 4px 4px 0 0; }
.table-lead-control { cursor: pointer; }

.action-lead { background-color: <?php echo $colors['site']['secondary']; ?>; }
.action-lead .col-featured {
	border-bottom: none;
	border-color: rgba(0, 0, 0, 0.15);
}
.content .action-lead .content {
	float: none;
	width: 100%;
}
.content .action-lead .sidebar { float: none; }
.content .action-lead .sidebar {
	padding-left: 0;
	padding-top: 0;
}

@media all and (min-width: 1150px) {
	.video-lead-embed iframe, .video-lead-embed video, .video-lead-embed object { max-width: inherit; }
}
@media all and (max-width: 1118px) {
	.columns-video-lead { margin-left: 0; }
	.columns-video-lead .video-lead-text {
		padding-left: <?php echo $single; ?>px;
		padding-right: <?php echo $single; ?>px;
	}
}
@media all and (min-width: 950px) {
	.email-lead-left-right .email-form-intro {
		float: left;
		margin-bottom: 0;
		padding-right: <?php echo $double; ?>px;
		width: 54%;
	}
	.email-lead-left-right .email-form {
		float: left;
		width: 46%;
	}
}
@media all and (min-width: 900px) {
	.content-sidebar .content .action-lead .sidebar { width: 60%; }
	.content .action-lead .sidebar {
		margin-left: auto;
		margin-right: auto;
		width: 40%;
	}
	.columns-video-lead .col1 {
		float: left;
		width: 42.754919499%;
	}
	.columns-video-lead .col2 {
		float: left;
		width: 57.245080501%;
	}
	.columns-video-lead .col-right { float: right; }
	.has-play-button .col1 { width: 65% !important; }
	.has-play-button .col2 { width: 35% !important; }
}
@media all and (min-width: 700px) {
	.table-lead-control { display: none; }
}
@media all and (max-width: <?php echo $site_width; ?>px) {
	.page-leads-columns {
		padding-left: <?php echo $half; ?>px;
		padding-right: <?php echo $half; ?>px;
	}
}
@media all and (max-width: 900px) {
	.action-lead { text-align: center; }
	.action-lead .content {
		padding-left: <?php echo $half; ?>px;
		padding-right: <?php echo $half; ?>px;
	}
	.action-lead .content-sidebar .content { margin-bottom: <?php echo $single; ?>px; }
	.action-lead .content-sidebar .sidebar { padding-top: 0; }
	.action-lead .alignvertical .button {
		text-align: center;
		width: 100%;
	}
	.content .action-lead .content {
		padding-left: 0;
		padding-right: 0;
	}
	.columns-video-lead > .col2 { padding-left: 0; }
	.columns-video-lead.block-double-tb { padding-bottom: 0; }
	.video-lead-text:not(:last-child) { margin-bottom: <?php echo $mid; ?>px; }
}