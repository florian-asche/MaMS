{foreach $pages as $page}
    <a class="table_menu_button" href="setup.php?page=Objects&action=page_edit&selected_id={$page.ID}"><h2>[{$page.ID}] {$page.name} ({if {$page.active} == "1"}active{elseif {$page.active} == "0"}inactive{else}error{/if})</h2></a>
    
    <table border = "0">
        <thead>
        <tr>
            <th align="left" colspan="5">
                <a class="table_menu_button" href="setup.php?page=Objects&action=object_add_start&selected_id={$page.ID}">Add a new Object...</a>
            </th>
        </tr>
            <tr>
                <th style="background-color: #d0d0d0"><font color="black">ID</font></th>
                <th style="background-color: #d0d0d0"><font color="black">X</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Y</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Name</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Object ID</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Link to Device</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Status</font></th>
                <th colspan="3" style="background-color: #d0d0d0"><font color="black">Options</font></th>
            </tr>
        </thead>
        <tbody>
        {foreach $page_objects as $tabledata_array}
            {if {$tabledata_array.page_objects.pageid} == {$page.ID}}
                <tr style="background-color: {cycle values="#eeeeee,#d0d0d0"}">
                    <td>{$tabledata_array.page_objects.ID}</td>
                    <td>{$tabledata_array.page_objects.x}</td>
                    <td>{$tabledata_array.page_objects.y}</td>
                    <td>{$tabledata_array.objects.name}</td>
                    <td>{$tabledata_array.page_objects.objectid}</td>
                    <td>
                    {if isset($tabledata_array.station_protocols.info)}
                        {if {$tabledata_array.station_protocols.info}}
                            {$tabledata_array.station_protocols.info}
                            ID={$tabledata_array.station_protocols.ID} CLASS={$tabledata_array.station_protocols.class}
                        {/if}
                    {/if}
                    </td>
                    <td>
                        {if {$tabledata_array.page_objects.active} == "0"}
                            inactive
                        {elseif {$tabledata_array.page_objects.active} == "1"}
                            active
                        {else}
                            error
                        {/if}
                    </td>
                        {if {$tabledata_array.page_objects.active} == "0"}
                            <td><a class="table_menu_button" href="setup.php?page=Objects&action=object_activate&selected_id={$tabledata_array.page_objects.ID}">activate</a></td>
                        {elseif {$tabledata_array.page_objects.active} == "1"}
                            <td><a class="table_menu_button" href="setup.php?page=Objects&action=object_deactivate&selected_id={$tabledata_array.page_objects.ID}">deactivate</a></td>
                        {/if}
                    <td><a class="table_menu_button" href="setup.php?page=Objects&action=object_edit&selected_id={$tabledata_array.page_objects.ID}">edit</a></td>
                    <td><a onclick='return confirmSubmit();' class="table_menu_button" href="setup.php?page=Objects&action=object_delete&selected_id={$tabledata_array.page_objects.ID}">delete</a></td>
                </tr>
            {/if}
        {/foreach}
        </tbody>
    </table>
{/foreach}