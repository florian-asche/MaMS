<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################
// AFTER CONFIGURATION CHANGE, YOU HAVE TO RESTART THE DAEMON

#COMMON CONFIGURATION
$default_configuration = array(
    'default_settings' => array(
        'system'            => "unix",
          #unix
          #windows
        'log_to_syslog'     => "0",
          #0 = AUS
          #1 = AN
        'log_to_file'       => "0",
          #0 = AUS
          #1 = AN
        'logfile'           => "mams.log",
        'log_to_terminal'   => "1",
          #0 = AUS
          #1 = AN
        'debug_level'       => array( 
        // Debug Level for Terminal and Logfile, NOT Syslog
            'tcp_connect' => "1",
            'default' => "1",
            'run' => "3",
            'childSignalHandler' => "3",
            'run_mams_job' => "3",
            'check_mamsdb_for_new_jobs' => "3",
            '__construct' => "3",
            'load_data' => "1",
            'mams_add_lock' => "1",
        ),
          #0 - No Logging
          #1 - Error
          #2 - Info
          #3 - Debug
          #4 - More Debug
        'design'            => "greensky",
        'timezone'          => "+1",
        'sommertime_offset' => "1",             // 0 = keine automatische umrechnung auf sommerzeit // 1 = automatische umrechnung auf sommezeit ist eingeschaltet
        'crypt_salt'        => "34t340fl3q4",   // Unique salt used for generating the password and crypt session data
        'session_timeout'   => "86400"          // 86400 Seconds = 1 Day
    ),
    'daemon_settings' => array(
        'job_timeout'       => "240000000",     // in microseconds (2000000 = 2s)
        'maxProcesses'      => "10",
        'sleeptime'         => "500000",   //500000      //50000   // Sleep Time between check for new database jobs, but only if maxProcesses is ok
        'retrigger_on_fail' => "1",             // 0 = OFF // 1 = ON // 2 = INSTANT RETRIGGER
        'fail_multiplikator'=> "1",             // Multiplikator * Time Interval that got added to Timestamp when job is failed
    ),
    'datatypes' => array(
        'date' => array(
            'description'   => "Date",
            'unit'          => "",
            'datatype'      => "number",
        ),
        'time' => array(
            'description'   => "Time",
            'unit'          => "",
            'datatype'      => "number",
        ),
        'timestamp' => array(
            'description'   => "Timestamp",
            'unit'          => "",
            'datatype'      => "number",
        ),
        'percentage' => array(
            'description'   => "Percentage",
            'unit'          => "%",
            'datatype'      => "number",
				#Number
				#Binaer
                                #Mapping
        ),
        'adc_raw' => array(
            'description'   => "ADC Raw",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'temperature_c' => array(
            'description'   => "Temperature C",
            'unit'          => "&#176;C",
            'datatype'      => "number",
	),
	'target_temperature_c' => array(
            'description'   => "Temperature C",
            'unit'          => "&#176;C",
            'datatype'      => "number",
	),
	'temperature_f' => array(
            'description'   => "Temperature F",
            'unit'          => "F",
            'datatype'      => "number",
	),
	'wind_speed' => array(
            'description'   => "Wind Speed",
            'unit'          => "km/h",
            'datatype'      => "number",
	),
	'wind_direction' => array(
            'description'   => "Wind Direction",
            'unit'          => "",
            'datatype'      => "text",
	),
	'humidity' => array(
            'description'   => "Humidity",
            'unit'          => "%",
            'datatype'      => "number",
	),
	'absolute_pressure' => array(
            'description'   => "Absolute Pressure",
            'unit'          => "Pa",
            'datatype'      => "number",
	),
	'door_state' => array(
            'description'   => "Door State",
            'unit'          => "",
            'datatype'      => "number",
            'mapping' => array(
                '0' => 'OPEN',
                '1' => 'CLOSED',
            ),
	),
	'device_state' => array(
            'description'   => "Device State",
            'unit'          => "",
            'datatype'      => "number",
            'mapping' => array(
                '0' => 'OFF',
                '1' => 'ON',
            ),
        ),
	'impulses' => array(
            'description'   => "Impulses",
            'unit'          => "Imp.",
            'datatype'      => "number",
        ),
	'count' => array(
            'description'   => "Number of Count",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'active_power_extrapolated' => array(
            'description'   => "Power Consumption Hochgerechnet",
            'unit'          => "W",
            'datatype'      => "number",
        ),
	'wattstunde' => array(
            'description'   => "Wattstunde",
            'unit'          => "Wh",
            'datatype'      => "number",
        ),
	'kilowattstunde' => array(
            'description'   => "Kilowattstunde",
            'unit'          => "kWh",
            'datatype'      => "number",
        ),
	'kilowattstunde_extrapolated' => array(
            'description'   => "kilowattstunde Hochgerechnet",
            'unit'          => "kWh",
            'datatype'      => "number",
        ),
	'voltage' => array(
            'description'   => "Voltage",
            'unit'          => "V",
            'datatype'      => "number",
        ),
	'power' => array(
            'description'   => "power",
            'unit'          => "A",
            'datatype'      => "number",
        ),
	'frequency' => array(
            'description'   => "Frequency",
            'unit'          => "Hz",
            'datatype'      => "number",
        ),
	'active_power' => array(
            'description'   => "Active Power",
            'unit'          => "W",
            'datatype'      => "number",
        ),
	'reactive_power' => array(
            'description'   => "Reactive Power",
            'unit'          => "VAr",
            'datatype'      => "number",
        ),
	'apparent_power' => array(
            'description'   => "Apparent power",
            'unit'          => "VA",
            'datatype'      => "number",
        ),
	'power_factor' => array(
            'description'   => "Power factor",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'total_power_meter_reading' => array(
            'description'   => "Total power meter reading",
            'unit'          => "kWh",
            'datatype'      => "number",
        ),
	'total_power_meter_reading_copy' => array(
            'description'   => "Total power meter reading copy",
            'unit'          => "kWh",
            'datatype'      => "number",
        ),
	'energy_in_reverse_direction' => array(
            'description'   => "Energy in reverse direction",
            'unit'          => "kWh",
            'datatype'      => "number",
        ),
	'energy_in_reverse_direction_copy' => array(
            'description'   => "Energy in reverse direction copy",
            'unit'          => "kWh",
            'datatype'      => "number",
        ),
        #openHR20F
	'openHR20F_auto_mode' => array(
            'description'   => "HR20 Mode Status",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'ventil_position' => array(
            'description'   => "ventil_position",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'target_temperature_c' => array(
            'description'   => "target_temperature_c",
            'unit'          => "&#176;C",
            'datatype'      => "number",
        ),
	'window_status' => array(
            'description'   => "window_status",
            'unit'          => "",
            'datatype'      => "number",
        ),
        #MQ135
	'mq135_ppm' => array(
            'description'   => "ppm concentration",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'mq135_ro' => array(
            'description'   => "mq135_ro",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'mq135_res' => array(
            'description'   => "mq135_res",
            'unit'          => "",
            'datatype'      => "number",
        ),
	'mq135_defaultro' => array(
            'description'   => "mq135_defaultro",
            'unit'          => "",
            'datatype'      => "number",
        ),
	#'hektopascal'
	#'strom?' #kwH?...
    ),
    'holidays' => array(
        'date' => array(
            '01.01' => "Neujahr",
            '01.05' => "Tag der Arbeit",
            '03.10' => "Tag der deutschen Einheit",
            '25.12' => "1. Weihnachtstag",
            '26.12' => "2. Weihnachtstag",
        ),
        'easter-dependent' => array(
            '-2' => "Karfreitag",
             '1' => "Ostermontag",
            '39' => "Christi Himmelfahrt",
            '50' => "Pfingsten",
            '60' => "Fronleichnam",
        ),
    ),
    'weekend' => array(
        'day' => array(
            '6' => "Samstag",
            '7' => "Sonntag",
        ),
    ),
    'object_templates' => array(
        'default' => array(
            'used_template'     => "default",
            'sizex'             => "1",
            'sizey'             => "1",
            'backgroundcolor'   => "#006600",
            'calc'              => "any",
//            'templates' => array (
//                'object_config'    => array(
//                    'y',
//                    'x',
//                    'active',
//                ),
//            ),
        ),
        'special-clock' => array(
            'used_template'     => "sidebar-clock",
            'object_type_name'  => "Sidebar Clock",
            'sizex'             => "2",
            'sizey'             => "1",
            'description'       => "",
            'backgroundcolor'   => "#FF9933",
            'show_graph' => array(
                //'adc',
                //'percentage',
            ),
            'show_table' => array(
                //'adc',
                //'percentage',
                //'wind_direction',
            ),
            'load_control_panels_dashboard' => array(
                //Used Templates on Mouseover
                //'Test eins' => "eins.php",
                //'Test zwei' => "zwei.php",
            ),
            'default_control_panels_values' => array(
                //Default Value for Send Formular (Control Panel)
                //'temperature_c' => "20",
            ),
            'load_templates_mouseover' => array(
                //Used Templates on Mouseover
                //'Data' => "data_table.tpl",
                //'Average' => "data_evg.tpl",
                //'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
                //'temperature_c' => '5' # Temperatur in Celsius * 5
                //Hiermit koennen Werte manuell angepasst werden.
            ),
            'additional_data' => array(
                //'wind_direction' => 'windDir(\'120\',$result[$row[\'ID\']][\'resolved_data\'][\'percentage\'])',
            ),
         ),
        'wind_direction' => array(
            'used_template'     => "wind_direction",
            'object_type_name'  => "Wind Direction",
            'description'       => "Sensor that Shows the Wind Direction. Percentage shows the Direction. 0% is N, 50% is SSE and 100% is NNW",
            'backgroundcolor'   => "#006600",
            'show_graph' => array(
                //'adc',
                'percentage',
            ),
            'show_table' => array(
                //'adc',
                'percentage',
                'wind_direction',
            ),
            'load_control_panels_dashboard' => array(
                #Used Templates on Mouseover
                #'Test eins' => "eins.php",
                #'Test zwei' => "zwei.php",
            ),
            'default_control_panels_values' => array(
                #Default Value for Send Formular (Control Panel)
                #'temperature_c' => "20",
            ),
            'load_templates_mouseover' => array(
                #Used Templates on Mouseover
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
                #'temperature_c' => '5' # Temperatur in Celsius * 5
                #Hiermit koennen Werte manuell angepasst werden.
            ),
            'additional_data' => array(
                'wind_direction' => 'windDir(\'120\',$result[$row[\'ID\']][\'resolved_data\'][\'percentage\'])',
            ),
            'calc' => array(
                'percentage',
            ),
         ),
        'temperature' => array(
            'used_template'     => "temperature",
            'object_type_name'  => "Temperature Sensor (in Celsius)",
            'description'       => "Thermosensor?",
            'backgroundcolor'   => "#FFFF00",
            'show_graph' => array(
                'temperature_c',
            ),
            'show_table' => array(
                'temperature_c',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
                'temperature_c',
            ),
         ),
        'wind_speed' => array(
            'used_template'     => "wind_speed",
            'object_type_name'  => "Wind Speed",
            'description'       => "",
            'backgroundcolor'   => "#006600",
            'show_graph' => array(
                //'count',
                'wind_speed',
            ),
            'show_table' => array(
                'count',
                'wind_speed',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
                'wind_speed' => '$result[$row[\'ID\']][\'resolved_data\'][\'count\'] * 10',
                // 10 Multiplikator in objects DB als VAR verschieben
            ),
            'calc' => array(
            ),
         ),
        'air_pressure' => array(
            'used_template'     => "air_pressure",
            'object_type_name'  => "Pressure Sensor",
            'description'       => "Pressure?",
            'backgroundcolor'   => "#33CCFF",
            'show_graph' => array(
                'temperature_c',
                'absolute_pressure',
            ),
            'show_table' => array(
                'temperature_c',
                'absolute_pressure',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'humidity' => array(
            'used_template'     => "humidity",
            'object_type_name'  => "Humidity Sensor",
            'description'       => "Humidity?",
            'backgroundcolor'   => "#FF6600",
            'show_graph' => array(
                'temperature_c',
                'humidity',
            ),
            'show_table' => array(
                'temperature_c',
                'humidity',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'device_MQ135' => array(
            'used_template'     => "device_MQ135",
            'object_type_name'  => "MQ135 Air Quality Sensor",
            'description'       => "some text?",
            'backgroundcolor'   => "#FF6600",
            'show_graph' => array(
                //'mq135_ppm',
                'mq135_ro',
                //'mq135_res',
                //'mq135_defaultro',
            ),
            'show_table' => array(
                'mq135_ppm',
                'mq135_ro',
                'mq135_res',
                'mq135_defaultro',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'device_rgbww_esp' => array(
            'used_template'     => "device_rgbww_esp",
            'object_type_name'  => "Device RGBWW ESP",
            'description'       => "PIN?",
            'backgroundcolor'   => "#006550",
            'show_graph' => array(
                'device_state_original',
            ),
            'show_table' => array(
                'device_state',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'ethersex_adc' => array(
            'used_template'     => "ethersex_adc",
            'object_type_name'  => "Ethersex ADC Sensor",
            'description'       => "ADC?",
            'backgroundcolor'   => "#33CCFF",
            'show_graph' => array(
                'percentage',
            ),
            'show_table' => array(
                'percentage',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'ethersex_pwm' => array(
            'used_template'     => "ethersex_pwm",
            'object_type_name'  => "Ethersex PWM Controller",
            'description'       => "PWM?",
            'backgroundcolor'   => "#33CCFF",
            'show_graph' => array(
                'percentage',
            ),
            'show_table' => array(
                'percentage',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'ethersex_pin' => array(
            'used_template'     => "ethersex_pin",
            'object_type_name'  => "Ethersex PIN Switch",
            'description'       => "PIN?",
            'backgroundcolor'   => "#006550",
            'show_graph' => array(
                'device_state_original',
            ),
            'show_table' => array(
                'device_state',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'ethersex_pin_stateonly' => array(
            'used_template'     => "ethersex_pin_stateonly",
            'object_type_name'  => "Ethersex PIN State Only",
            'description'       => "PIN State?",
            'backgroundcolor'   => "#006550",
            'show_graph' => array(
                'device_state_original',
            ),
            'show_table' => array(
                'device_state',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'ethersex_door' => array(
            'used_template'     => "ethersex_door",
            'object_type_name'  => "Ethersex PIN State Only",
            'description'       => "PIN State?",
            'backgroundcolor'   => "#006550",
            'show_graph' => array(
                'device_state_original',
            ),
            'show_table' => array(
                'door_state',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
                'door_state' => '$result[$row[\'ID\']][\'resolved_data\'][\'device_state_original\']',
            ),
            'calc' => array(
            ),
         ),
        'ethersex_door_stateonly' => array(
            'used_template'     => "ethersex_door_stateonly",
            'object_type_name'  => "Ethersex PIN State Only",
            'description'       => "PIN State?",
            'backgroundcolor'   => "#006550",
            'show_graph' => array(
                'device_state_original',
            ),
            'show_table' => array(
                'door_state',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
                'door_state' => '$result[$row[\'ID\']][\'resolved_data\'][\'device_state_original\']',
            ),
            'calc' => array(
            ),
         ),
        'special-ethersex_pin_nostate' => array(
            'used_template'     => "special-ethersex_pin_nostate",
            'object_type_name'  => "Ethersex PIN Switch without data",
            'description'       => "PIN?",
            'backgroundcolor'   => "#006550",
            'show_graph' => array(
            ),
            'show_table' => array(
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'power_consumption_count' => array(
            'used_template'     => "power_consumption_count",
            'object_type_name'  => "Power Consumption measured with Impulse Counter",
            'description'       => "",
            'backgroundcolor'   => "#7fff00",
            'show_graph' => array(
                //'count',
                'kilowattstunde',
            ),
            'show_table' => array(
                'count',
                'kilowattstunde',
                'kilowattstunde_extrapolated',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
                'kilowattstunde' => '$result[$row[\'ID\']][\'resolved_data\'][\'count\'] * 0.001',
                'kilowattstunde_extrapolated' => '$result[$row[\'ID\']][\'resolved_data\'][\'count\'] * 60 * 0.001',
                'active_power_extrapolated' => '$result[$row[\'ID\']][\'resolved_data\'][\'count\'] * 60 * 0.001 * 1000',
                // 0.001 Multiplikator in objects DB als VAR verschieben
            ),
            'calc' => array(
            ),
         ),
        //001613300207 phase 2      290W (Server?)		250W
	//001613300204 phase 1      040W temp kaputt	000W
	//001613300206 wohnzimmer   130W				-
	//001613300205 phase 3      150W (Wohnzimmer)
	//001613300208 none
        'device_DRS110M' => array(
            'used_template'     => "device_DRS110M",
            'object_type_name'  => "DRS110M Power Measurement Device",
            'description'       => "Some Text here",
            'backgroundcolor'   => "#7fff00",
            'show_graph' => array(
                //'voltage',
                //'power',
                //'frequency',
                'active_power',
                //'reactive_power',
                //'apparent_power',
                //'power_factor',
                //'total_power_meter_reading',
                //'total_power_meter_reading_copy',
                //'energy_in_reverse_direction',
                //'energy_in_reverse_direction_copy',
                //'temperature_c',
            ),
            'show_table' => array(
                'voltage',
                'power',
                'frequency',
                'active_power',
                'reactive_power',
                'apparent_power',
                'power_factor',
                'total_power_meter_reading',
                //'total_power_meter_reading_copy',
                'energy_in_reverse_direction',
                //'energy_in_reverse_direction_copy',
                'temperature_c',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
        'device_openHR20F' => array(
            'used_template'     => "device_openHR20F",
            'object_type_name'  => "openHR20 (F=MaMS Modded Version) Thermostate",
            'description'       => "Some Text here",
            'backgroundcolor'   => "#7fff00",
            'show_graph' => array(
                'openHR20F_auto_mode',
                'ventil_position',
                'temperature_c',
                'target_temperature_c',
                'voltage',
                'window_status',
            ),
            'show_table' => array(
                'openHR20F_auto_mode',
                'ventil_position',
                'temperature_c',
                'target_temperature_c',
                'voltage',
                'window_status',
            ),
            'load_control_panels_dashboard' => array(
            ),
            'default_control_panels_values' => array(
            ),
            'load_templates_mouseover' => array(
                'Data' => "data_table.tpl",
                'Average' => "data_evg.tpl",
                'Min./Max.' => "data_minmax.tpl",
            ),
            'data_adaptation' => array(
            ),
            'additional_data' => array(
            ),
            'calc' => array(
            ),
         ),
    ),
);
?>
