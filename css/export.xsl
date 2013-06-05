<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" doctype-system="about:legacy-compat" encoding="UTF-8" />
	<xsl:template match="/export">
		<html>
		<head> 
			<meta charset="UTF-8" />
			<meta name="robots" content="noindex" />		
		</head>
		<body>
			<div id="exportFeedHeader">
			</div>
			<div id="exportFeedBody">
				<div id="exportFeedTitle">
				<xsl:element name="h1">
					<xsl:element name="a">
						<xsl:attribute name="href">
							<xsl:value-of select="channel/link" />
						</xsl:attribute>
						<xsl:value-of select="channel/title" />
					</xsl:element>
				</xsl:element>
					<div class="titleWithLine">
						<xsl:value-of select="channel/description" />
					</div>
				</div>
				<div id="exportFeedContent">
					<xsl:for-each select="channel/item">
						<div class="entry">
							<xsl:element name="h3">
								<xsl:element name="a">
									<xsl:attribute name="href">
										<xsl:value-of select="link/@href"/>
									</xsl:attribute>
									#<xsl:value-of select="id"/>: 
									<xsl:value-of select="title"/>
								</xsl:element>
							</xsl:element>
							<div class="lastUpdated">
								<strong>On </strong><xsl:value-of select="published"/>
								<xsl:if test="string-length(person/firstname) != 0">
								<strong>By </strong><xsl:value-of select="person/firstname"/> <xsl:value-of select="person/firstname"/>
									<xsl:if test="string-length(person/email) != 0">
									 (<xsl:value-of select="person/email"/>)
									</xsl:if>
								</xsl:if>
							</div>
							<strong>Approved: </strong><xsl:value-of select="approved"/>
							<strong> Verified: </strong><xsl:value-of select="verified"/>
							<div class="location">
								<xsl:if test="string-length(location) != 0">
									<strong>Location: </strong>
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
									<xsl:if test="position() = 1"><strong>Category: </strong></xsl:if>
									<xsl:if test="position() != 1">, </xsl:if>
									<xsl:value-of select="."/>
								</xsl:for-each>
							</div>
							<xsl:for-each select="customfields/*">
								<xsl:if test="string-length() != 0">
									<xsl:variable name="customfieldLabel" select="local-name()">
									</xsl:variable>
									<div><strong><xsl:value-of select="$customfieldLabel" />: </strong>
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
						<div style="clear: both;"></div>
					</xsl:for-each>
				</div>
			</div>
			<div id="exportFeedFooter">
				<xsl:value-of select="channel/copyright"/>
			</div>
		</body>
		</html>
	</xsl:template>
</xsl:stylesheet>