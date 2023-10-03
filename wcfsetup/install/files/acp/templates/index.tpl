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

{include file='footer'}
