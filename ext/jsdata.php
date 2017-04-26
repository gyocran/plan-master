<?php
    //include_once("ext/programarea.php");
    echo "<script type='text/javascript'>";
            include_once("ext/programarea.php");
            $p=new programareas();
            if($p->get_districts()){

                echo "districts=eval('[";
                $row=$p->fetch();
                while($row){
                    echo "{\"districtID\":" . $row['DistrictID'];
                    echo ",\"district\":\"" . $row['District'] ."\"";
                    echo ",\"programarea_id\":" . $row['programarea_programarea_id'] ."}";
                    $row=$p->fetch();
                    if($row){
                        echo ",";
                    }
                }
            }
            echo "]');";
            echo "\n";
            echo "// communities";
            echo "\n";
            echo "communities=eval('[";
            $programearea_id=  get_programarea();
            
            if($p->get_communities_programarea($programearea_id)){
                $row=$p->fetch();
                while($row){
                    echo "{\"communityID\":" . $row['community_id'];
                    echo ",\"community\":\"" . $row['community'] ."\"";
                    echo ",\"districtID\":" . $row['community_districts_DistrictID']; 
                    echo ",\"programareaID\":".$row['programarea_programarea_id'] ."}";
                    $row=$p->fetch();
                    if($row){
                        echo ",";
                    }
                
                }
            }
            echo "]');";
    echo "</script>";
?>
