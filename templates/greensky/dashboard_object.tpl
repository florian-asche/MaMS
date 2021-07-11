{if file_exists("templates/{$selected_template}/dashboard_objects/{$objekt.objects.template}.tpl")}
    {if isset($objektdata.timestampdiff)}
        {include file="templates/{$selected_template}/dashboard_objects/{$objekt.objects.template}.tpl"}
    {elseif preg_match("/special-(.*)/", {$objekt.objects.template})}
        {include file="templates/{$selected_template}/dashboard_objects/{$objekt.objects.template}.tpl"}
    {else}
        {include file="templates/{$selected_template}/dashboard_objects/no_data.tpl"}
    {/if}
{else}
    {include file="templates/{$selected_template}/dashboard_objects/no_tpl.tpl"}
{/if}
