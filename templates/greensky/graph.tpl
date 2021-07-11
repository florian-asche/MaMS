<link href="lib/flot-0.8.3/examples.css" rel="stylesheet" type="text/css">

<script language="javascript" type="text/javascript" src="lib/flot-0.8.3/jquery.js"></script>
<script language="javascript" type="text/javascript" src="lib/flot-0.8.3/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="lib/flot-0.8.3/jquery.flot.time.js"></script>

<script type="text/javascript">
    $(function() {
        var options = {
            xaxis: {
                mode: "time"
            }
        };

        {foreach $graphdata as $dataheader => $dataarray}
            var rawData_{$dataheader} = [
            {foreach $dataarray as $timestamp => $data}
                [{$timestamp * 1000}, {$data}], 
            {/foreach}
            ];
        {/foreach}

        var dataset = [
            {foreach $graphdata as $dataheader => $dataarray}
            {
                label: "{$dataheader}",
                data: rawData_{$dataheader}
            },
            {/foreach}
        ];

        $.plot($("#placeholder"), dataset, options);
    });
</script>

<body>   
    <div id="content">
        <div class="demo-container">
            <div id="placeholder" class="demo-placeholder"></div>
        </div>
    </div>
</body>