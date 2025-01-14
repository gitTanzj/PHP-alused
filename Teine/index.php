<?php 
    include 'db.php';

    $requestPayload = file_get_contents("php://input");
    $request = json_decode($requestPayload, true);

    if(!$request){
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON"]);
        exit;
    }

    $filters = $request['filters'] ?? [];
    $brandFilters = $filters['brand'] ?? [];
    $fuelFilters = $filters['fuel'] ?? [];
    $query = "SELECT COUNT(*) as autoCount FROM autod WHERE 1=1";
    $params = [];

    if(count($brandFilters) > 0){
        $query .= " AND";
        for($i = 0; $i < count($brandFilters); $i++){
            if($i > 0){
                $query .= " OR brand LIKE '$brandFilters[$i]'";
            } else {
                $query .= " brand LIKE '$brandFilters[$i]'";
            }
        };
    };

    if(count($fuelFilters) > 0){
        $query .= " AND";
        for($i = 0; $i < count($fuelFilters); $i++){
            if($i > 0){
                $query .= " OR fuel LIKE '$fuelFilters[$i]'";
            } else {
                $query .= " fuel LIKE '$fuelFilters[$i]'";
            }
        };
    };


    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(["autoCount" => $result['autoCount']]);
    } catch(PDOException $e) {
        die('Error occured' . $e->getMessage());
    }

?>