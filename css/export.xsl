<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" doctype-system="about:legacy-compat" encoding="UTF-8" />
	<xsl:template match="/export">
		<html>
		<head> 
			<meta charset="UTF-8" />
			<meta name="robots" content="noindex" />		
			<style>
				body {
					color: -moz-fieldtext;
					font: message-box;
					margin: 0;
					padding: 0 3em;
				}
				a {
					text-decoration: none;
				}
				.right {
					float: right;
				}
				#exportFeedBody {
					-moz-padding-start: 30px;
					background: none;
					border: 1px solid threedshadow;
					margin: 2em auto;
					padding: 3em;
				}
				#exportFeedTitle {
					margin-bottom: 1.5em;
				}
				h1.title {
					border-bottom: 2px solid #c2c2c2;
					margin-bottom: 0.2em;
				}
				.titleWithLine {
					color: #a2a2a2;
				}
				.feedEntryContent {
					font-size: 110%;
					padding-top: 1em;
				}
				div.entry {
					border: 1px solid #F1B47F;
					margin-bottom: 0.5em;
				}
				h3.entryTitle {
					background: #F1B47F;
					margin: 0;
					padding: 0.3em;
				}
				div.entryBody {
					margin: 0.5em;
				}
				span.label {
					font-weight: bolder;
					padding-right: 0.5em;
					padding-left: 1.5em;
					color: #94530D;
				}
				span.label:first-child {
					padding-left: 0;
				}
			</style>
		</head>
		<body>
			<div id="exportFeedHeader">
			</div>
			<div id="exportFeedBody">
				<div id="exportFeedTitle">
					<div class="right">
						<strong>Generated On </strong><xsl:value-of select="channel/updated" />
						<br/><strong>Using </strong> 
						<xsl:element name="a">
							<xsl:attribute name="href">
								<xsl:value-of select="channel/generator/@uri" />
							</xsl:attribute>
							<xsl:value-of select="channel/generator"/>
						</xsl:element>
					</div>
					<xsl:if test="string-length(channel/title) != 0">
						<xsl:element name="h1">
							<xsl:attribute name="class">
								title
							</xsl:attribute>
							<xsl:element name="a">
								<xsl:attribute name="href">
									<xsl:value-of select="channel/link" />
								</xsl:attribute>
								<xsl:value-of select="channel/title" />
							</xsl:element>
						</xsl:element>
						<div class="titleWithLine">
							<xsl:value-of select="channel/tagline" />
						</div>
					</xsl:if>
				</div>
				<div id="exportFeedContent">
					<xsl:for-each select="channel/item">
						<div class="entry">
							<h3 class="entryTitle">
								<xsl:element name="a">
									<xsl:attribute name="href">
										<xsl:value-of select="link/@href"/>
									</xsl:attribute>
									#<xsl:value-of select="id"/>: 
									<xsl:value-of select="title"/>
								</xsl:element>
							</h3>
							<div class="entryBody">
								<div>
									<span class="label">On </span><xsl:value-of select="published"/>
									<xsl:if test="string-length(person/firstname) != 0">
										<span class="label">By </span><xsl:value-of select="person/firstname"/> <xsl:value-of select="person/firstname"/>
										<xsl:if test="string-length(person/email) != 0">
										 (<xsl:value-of select="person/email"/>)
										</xsl:if>
									</xsl:if>
								</div>
								<div>
									<span class="label">Approved: </span><xsl:value-of select="approved"/>
									<span class="label"> Verified: </span><xsl:value-of select="verified"/>
								</div>
								<div class="location">
									<xsl:if test="string-length(location) != 0">
										<span class="label">Location: </span>
										<xsl:value-of select="location"/>
											 (
											<xsl:value-of select="longitude"/>
											, 
											<xsl:value-of select="latitude"/>
											)
									</xsl:if>
								</div>
								<div class="categories">
									<xsl:for-each select="category">
										<xsl:if test="position() = 1"><span class="label">Category: </span></xsl:if>
										<xsl:if test="position() != 1">, </xsl:if>
										<xsl:value-of select="."/>
									</xsl:for-each>
								</div>
								<xsl:for-each select="customfields/*">
									<xsl:if test="string-length() != 0">
										<xsl:variable name="customfieldLabel" select="local-name()">
										</xsl:variable>
										<div><span class="label"><xsl:value-of select="$customfieldLabel" />: </span>
											<xsl:value-of select="." />
										</div>
									</xsl:if>
								</xsl:for-each>
								<div class="feedEntryContent">
									<xsl:if test="string-length(content_parsed) != 0">
										<xsl:value-of select="content_parsed"/>
									</xsl:if>
								</div>
							</div>
						</div>
						<div style="clear: both;"></div>
					</xsl:for-each>
				</div>
				<div class="right">
					&#169; 
					<xsl:element name="a">
						<xsl:attribute name="href">
							<xsl:value-of select="channel/copyright/@uri" />
						</xsl:attribute>
						<xsl:value-of select="channel/copyright"/>
					</xsl:element>
				</div>
			</div>
			<div id="exportFeedFooter">		
			</div>
		</body>
		</html>
	</xsl:template>
</xsl:stylesheet>