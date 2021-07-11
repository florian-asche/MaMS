<table border = "0">
    <thead>
        <tr>
            <th style="background-color: #d0d0d0"><font color="black">{$default_configuration.datatypes.date.description}</font></th>
            <th style="background-color: #d0d0d0"><font color="black">{$default_configuration.datatypes.time.description}</font></th>

            {foreach $objekt['objects']['configuration']['show_table'] as $key => $value}
                    <th style="background-color: #d0d0d0"><font color="black">{$default_configuration.datatypes.$value.description}</font></th>
            {/foreach}
        </tr>
    </thead>
    <tbody>
        {foreach $tabledata as $tabledata_array}
            <tr style="background-color: {cycle values="#eeeeee,#d0d0d0"}">
                <td>{$tabledata_array.timestamp|date_format:"%d.%m.%Y"}</td>
                <td>{$tabledata_array.timestamp|date_format:"%H:%M:%S"}</td> 
                
                {foreach $objekt['objects']['configuration']['show_table'] as $key => $value}
                    <td>
                        {if isset($tabledata_array.resolved_data.$value)}
                            {$tabledata_array.resolved_data.$value}{$default_configuration.datatypes.$value.unit}
                        {/if}
                    </td>
                {/foreach}
            </tr>
        {/foreach}
    </tbody>
</table>