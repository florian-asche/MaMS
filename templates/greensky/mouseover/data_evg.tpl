<table border = "0">
    <thead>
        <tr>
            <th style="background-color: #d0d0d0"><font color="black">{#time_discription#}</font></th>
            
            {foreach $objekt['objects']['configuration']['show_table'] as $key => $value}
                    <th style="background-color: #d0d0d0"><font color="black">{$default_configuration.datatypes.$value.description}</font></th>
            {/foreach}
        </tr>
    </thead>
    <tbody>
        {foreach $evgdata as $tabledata_array}
            <tr style="background-color: {cycle values="#eeeeee,#d0d0d0"}">
                <td>{$tabledata_array.time}{#time_unit#}</td>

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