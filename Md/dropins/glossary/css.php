<style type="text/css">

/*------------------------------*\
	$GLOSSARY
\*------------------------------*/

.post-type-archive-glossary .content-inner {
	background-color: transparent;
	box-shadow: none;
}

/* LETTERS NAV */

.glossary-letters {
	background-color: #fff;
	border-top: 1px solid rgba(0, 0, 0, 0.1);
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	padding: <?php echo $half; ?>px;
}

.glossary-letter {
	border-bottom: 0;
	border-radius: 50%;
	display: inline-block;
	height: 32px;
	transition: 0.3s;
	width: 32px;
}

.glossary-letter:hover, .glossary-letter.active {
	background-color: <?php echo $colors['site']['secondary']; ?>;
	color: #fff;
}

/* LOOP */

.glossary-term {
	border-left: 8px solid <?php echo $colors['site']['primary']; ?>;
	border-radius: 5px;
}

.glossary-term-letter {
	font-size: <?php echo $colors['site']['headline']; ?>px;
	line-height: 1;
}

.glossary-link.active { font-weight: bold; }

/* CALL TO ACTION */

.glossary-cta {
	border-left-color: <?php echo $colors['site']['secondary']; ?>;
	text-align: center;
}

/* QUERIES */

@media all and (min-width: 900px) {
	.glossary-content { padding: <?php echo $double; ?>px <?php echo $double; ?>px <?php echo $single; ?>px; }
	.glossary-after { padding-top: <?php echo $double; ?>px; }
}

@media all and (max-width: 900px) {
	.glossary-content, .glossary-after, .post-type-archive-glossary .content { padding: <?php echo $single; ?>px <?php echo $half; ?>px; }
}