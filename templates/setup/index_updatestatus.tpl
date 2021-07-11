<h1>Updatestatus:</h1>
You are using Version: <b>{$current_version}</b>.
Up to Date Version is: <b>{$newest_version}</b>.

{if {$current_version} == "ERROR"}
Gethering Updatestatus failed
{elseif {$newest_version} == "ERROR"}
Gethering Updatestatus failed
{elseif {$current_version} == {newest_version}}
Your System is up to date!
{elseif {$current_version} < {$newest_version}}
There is a new Version of MaMS! You can Update your SYstem! Please Update your SYstem!
{/fi}
