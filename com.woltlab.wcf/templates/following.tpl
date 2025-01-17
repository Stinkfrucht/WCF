{include file='userMenuSidebar'}

{capture assign='contentTitleBadge'}<span class="badge">{#$items}</span>{/capture}

{capture assign='contentInteractionPagination'}
	{pages print=true assign=pagesLinks controller='Following' link="pageNo=%d"}
{/capture}

{include file='header' __sidebarLeftHasMenu=true}

{if $objects|count}
	<div class="section sectionContainerList">
		<ol class="containerList userList jsReloadPageWhenEmpty jsObjectActionContainer" data-object-action-class-name="wcf\data\user\follow\UserFollowAction">
			{foreach from=$objects item=user}
				<li class="jsFollowing jsObjectActionObject" data-object-id="{@$user->getObjectID()}">
					<div class="box48">
						{user object=$user type='avatar48' ariaHidden='true' tabindex='-1'}
						
						<div class="details userInformation">
							{include file='userInformationHeadline'}
							
							<nav class="jsMobileNavigation buttonGroupNavigation">
								<ul class="buttonList iconList jsOnly">
									<li><a class="pointer jsTooltip jsObjectAction" data-object-action="delete" title="{lang}wcf.user.button.unfollow{/lang}" data-object-id="{@$user->followID}">{icon name='xmark'} <span class="invisible">{lang}wcf.user.button.unfollow{/lang}</span></a></li>
									{event name='userButtons'}
								</ul>
							</nav>
							
							<dl class="plain inlineDataList small">
								{include file='userInformationStatistics'}
							</dl>
						</div>
					</div>
				</li>
			{/foreach}
		</ol>
	</div>
	
	<footer class="contentFooter">
		{hascontent}
			<div class="paginationBottom">
				{content}{@$pagesLinks}{/content}
			</div>
		{/hascontent}
		
		{hascontent}
			<nav class="contentFooterNavigation">
				<ul>
					{content}{event name='contentFooterNavigation'}{/content}
				</ul>
			</nav>
		{/hascontent}
	</footer>
{else}
	<p class="info" role="status">{lang}wcf.user.following.noUsers{/lang}</p>
{/if}

{include file='footer'}
