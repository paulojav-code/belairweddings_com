<?php
    function query($con,$sql,$params = []){
        $res = [];
        try{
            $stmt = $con->prepare($sql);
            if($params != []){
                call_user_func_array([$stmt,'bind_param'],$params);
            }
            $stmt->execute();
            
            $result = $stmt->get_result();
            if(isset($result->num_rows) && $result->num_rows > 0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $res[] = $row;
                }
            }
            return $res;
        }catch(Throwable $th){
            return ['error'=>$con->error];
        }
    }
?>