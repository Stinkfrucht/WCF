<select id="{$option->optionName}" name="values[{$option->optionName}]">
	<option value=""></option>
	{foreach from=$selectOptions key=key item=selectOption}
		<option value="{$key}"{if $value == $key} selected="selected"{/if}>{lang}{@$selectOption}{/lang}</option>
	{/foreach}
</select>