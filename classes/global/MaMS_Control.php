<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################


/**
 * 
 */
class MaMS_Control {
    /**
     * 
     */
    public function __construct() {
        
    }
    
    function page_activate($id) {
        global $output;
        global $MaMS_SQL;
        global $pages;

        if (isset($id) && is_numeric($id)) {
            if ($pages[$id]['ID'] == $id) {
                $sql = "UPDATE `pages` SET `active` = '1' WHERE `ID` = '$id'";
                $output->debug(__FUNCTION__, "[SQL] " . $sql, "4");
                $RC = $MaMS_SQL->sql_commit($sql);

                $output->debug(__FUNCTION__, "RC=" . $RC, "4");
                return $RC;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }
    
    function page_deactivate($id) {
        global $output;
        global $MaMS_SQL;
        global $pages;

        if (isset($id) && is_numeric($id)) {
            if ($pages[$id]['ID'] == $id) {
                $sql = "UPDATE `pages` SET `active` = '0' WHERE `ID` = '$id'";
                $output->debug(__FUNCTION__, "[SQL] " . $sql, "4");
                $RC = $MaMS_SQL->sql_commit($sql);

                $output->debug(__FUNCTION__, "RC=" . $RC, "4");
                return $RC;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }
    
    function page_add() {
        
    }
    
    function page_edit() {
        
    }
    
    function page_delete() {
        global $output;
        global $MaMS_SQL;
        global $pages;

        if (isset($id) && is_numeric($id)) {
            if ($pages[$id]['ID'] == $id) {
                $sql = "DELETE FROM `pages` WHERE `ID` = '$id'";
                $output->debug(__FUNCTION__, "[SQL] " . $sql, "4");
                $RC = $MaMS_SQL->sql_commit($sql);

                $output->debug(__FUNCTION__, "RC=" . $RC, "4");
                return $RC;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
        
        // alle mit dieser page verbundenen objekte auch löschen
    }
    
    function object_activate($id) {
        global $output;
        global $MaMS_SQL;
        global $page_objects;

        if (isset($id) && is_numeric($id)) {
            if ($page_objects[$id]['page_objects']['ID'] == $id) {
                $sql = "UPDATE `page_objects` SET `active` = '1' WHERE `ID` = '$id'";
                $output->debug(__FUNCTION__, "[SQL] " . $sql, "4");
                $RC = $MaMS_SQL->sql_commit($sql);

                $output->debug(__FUNCTION__, "RC=" . $RC, "4");
                return $RC;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }
    
    function object_deactivate($id) {
        global $output;
        global $MaMS_SQL;
        global $page_objects;

        if (isset($id) && is_numeric($id)) {
            if ($page_objects[$id]['page_objects']['ID'] == $id) {
                $sql = "UPDATE `page_objects` SET `active` = '0' WHERE `ID` = '$id'";
                $output->debug(__FUNCTION__, "[SQL] " . $sql, "4");
                $RC = $MaMS_SQL->sql_commit($sql);

                $output->debug(__FUNCTION__, "RC=" . $RC, "4");
                return $RC;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }
    
    function object_add() {
        
    }
    
    function object_edit() {
        
    }
    
    function object_delete() {
        //wird dann aus der page delete aufgerufen, wenn noch objekte übrig sind
    }
    
    function station_activate() {
        
    }
    
    function station_deactivate() {
        
    }

    function station_add() {
        
    }
    
    function station_edit() {
        
    }
    
    function station_delete() {
        
    }
    
    function station_discover() {
        //sollte nur eine subfunktion in der php classe des protokolls laden
    }


    
    //$possible_templates
    //$possible_controlpanels
    //
    //$possible_station_protocols
    //$possible_pages
    //
    //get templates
    //get control_panels
    //
    //job:
    //job_add
    //add short job
    //job_delete
    
}