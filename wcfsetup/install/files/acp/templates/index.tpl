{include file='header'}

<header class="contentHeader">
	<h1 class="contentTitle">{lang}wcf.global.acp{/lang}</h1>
</header>

{if !(80100 <= PHP_VERSION_ID && PHP_VERSION_ID <= 80399)}
	<div class="error">{lang}wcf.global.incompatiblePhpVersion{/lang}</div>
{/if}
{foreach from=$evaluationExpired item=$expiredApp}
	<p class="error">{lang packageName=$expiredApp[packageName] isWoltLab=$expiredApp[isWoltLab] pluginStoreFileID=$expiredApp[pluginStoreFileID]}wcf.acp.package.evaluation.expired{/lang}</p>
{/foreach}
{foreach from=$evaluationPending key=$evaluationEndDate item=$pendingApps}
	<div class="warning">{lang evaluationEndDate=$evaluationEndDate}wcf.acp.package.evaluation.pending{/lang}</div>
{/foreach}

{foreach from=$taintedApplications item=$taintedApplication}
	<div class="error">{lang}wcf.acp.package.application.isTainted{/lang}</div>
{/foreach}

{if $systemIdMismatch}
	{if $__wcf->session->getPermission('admin.configuration.package.canInstallPackage') && (!ENABLE_ENTERPRISE_MODE || $__wcf->user->hasOwnerAccess())}
		<p class="info">{lang}wcf.acp.index.systemIdMismatch{/lang}</p>
	{/if}
{/if}

{if $recaptchaWithoutKey}
	<p class="error">{lang}wcf.acp.index.recaptchaWithoutKey{/lang}</p>
{/if}

{if !VISITOR_USE_TINY_BUILD}
	<p class="info">{lang}wcf.acp.index.tinyBuild{/lang}</p>
{/if}

{if $usersAwaitingApproval}
	<p class="info">{lang}wcf.acp.user.usersAwaitingApprovalInfo{/lang}</p>
{/if}

{if $missingLanguageItemsMTime}
	<p class="warning">{lang}wcf.acp.index.missingLanguageItems{/lang}</p>
{/if}

{event name='userNotice'}

<div class="acpDashboard">
	{foreach from=$dashboard->getVisibleBoxes() item='box'}
		<div class="acpDashboardBox">
			<h2 class="acpDashboardBox__title">{$box->getTitle()}</h2>
			<div class="acpDashboardBox__content">
				{@$box->getContent()}
			</div>
		</div>
	{/foreach}
</div>

<div class="section tabMenuContainer" data-active="credits" data-store="activeTabMenuItem">
	<nav class="tabMenu">
		<ul>
			<li><a href="#credits">{lang}wcf.acp.index.credits{/lang}</a></li>
			
			{event name='tabMenuTabs'}
		</ul>
	</nav>
	
	<div id="credits" class="hidden tabMenuContent">
		<section class="section">
			<dl>
				<dt>{lang}wcf.acp.index.credits.developedBy{/lang}</dt>
				<dd><a href="https://www.woltlab.com/{if $__wcf->getLanguage()->getFixedLanguageCode() === 'de'}de/{/if}" class="externalURL"{if EXTERNAL_LINK_TARGET_BLANK} target="_blank" rel="noopener"{/if}>WoltLab&reg; GmbH</a></dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.acp.index.credits.productManager{/lang}</dt>
				<dd>
					<ul class="inlineList commaSeparated">
						<li>Marcel Werk</li>
					</ul>
				</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.acp.index.credits.developer{/lang}</dt>
				<dd>
					<ul class="inlineList commaSeparated">
						<li>Tim D&uuml;sterhus</li>
						<li>Alexander Ebert</li>
						<li>Joshua R&uuml;sweg</li>
						<li>Matthias Schmidt</li>
						<li>Marcel Werk</li>
					</ul>
				</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.acp.index.credits.designer{/lang}</dt>
				<dd>
					<ul class="inlineList commaSeparated">
						<li>Alexander Ebert</li>
						<li>Marcel Werk</li>
					</ul>
				</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.acp.index.credits.contributor{/lang}</dt>
				<dd>
					<ul class="inlineList commaSeparated">
						<li>Andrea Berg</li>
						<li>Thorsten Buitkamp</li>
						<li>
							<a href="https://github.com/WoltLab/WCF/contributors" class="externalURL"{if EXTERNAL_LINK_TARGET_BLANK} target="_blank" rel="noopener"{/if}>{lang}wcf.acp.index.credits.contributor.more{/lang}</a>
						</li>
					</ul>
				</dd>
			</dl>
			
			<dl>
				<dt></dt>
				<dd>Copyright &copy; 2001-{TIME_NOW|date:'Y'} WoltLab&reg; GmbH. All rights reserved.</dd>
			</dl>
			
			<dl>
				<dt></dt>
				<dd>{lang}wcf.acp.index.credits.trademarks{/lang}</dd>
			</dl>
		</section>
	</div>
	
	{event name='tabMenuContents'}
</div>

{include file='footer'}
