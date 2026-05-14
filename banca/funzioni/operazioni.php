<?php
class Operazioni{
    private PDO $conn;
    private array $whitelist=["conticorrenti","correntisti"];

    function __construct(){
        $conf=require("conf.php");

        try{
            $this->conn= new PDO("mysql: host=".$conf["host"]."; dbname=".$conf["dbname"],$conf["user"],$conf["psw"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            throw new Exception($e->getMessage());
        }
    }

    function query($table,$where=[],$groupBy=[],$having=[],$orderBy=[],$select=['*']){
        if(!in_array($table, $this->whitelist)) throw new Exception("Tabella non trovata");
        
        $valori = [];
    
        // SELECT
        $sql = "SELECT ".implode(",", array_map(fn($c) => $c=='*' ? '*' : "`$c`", $select))." FROM `$table`";
    
        // WHERE
        if(!empty($where)) {
            $sql=$sql." WHERE ";
            $condizioni_where = [];
            foreach($where as $k=>$v) {
                $condizioni_where[]="`$k`=:w_$k";
                $valori[":w_$k"]=$v;
            }
            $sql .= implode(" AND ", $condizioni_where);
        }
    
        // GROUP BY
        if(!empty($groupBy)) $sql=$sql." GROUP BY ".implode(",", array_map(fn($c) => "`$c`", $groupBy));
    
        // HAVING
        if(!empty($having)) {
            $sql=$sql." HAVING ";
            $condizioni_having=[];
            foreach($having as $k=>$v) {
                $condizioni_having[] = "`$k`=:h_$k";
                $valori[":h_$k"] = $v;
            }
            $sql .= implode(" AND ", $condizioni_having);
        }
    
        // ORDER BY
        if(!empty($orderBy)) {
            $orders=[];
            foreach($orderBy as $k => $dir) {
                $dir=strtoupper($dir)=='DESC' ? 'DESC' : 'ASC';
                $orders[]="`$k` $dir";
            }
            $sql=$sql." ORDER BY " . implode(",", $orders);
        }
    
        $sql=$sql.";";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($valori);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function transaction(array $operations) {
        try {
            $this->conn->beginTransaction();
    
            foreach ($operations as $index => $op) {
                $table = $op['table'] ?? '';
                if (!in_array($table, $this->whitelist)) {
                    throw new Exception("Tabella non trovata: $table");
                }
    
                $type = strtoupper($op['type'] ?? '');
                $valori = [];
                $sql = "";
    
                switch ($type) {
                    case 'INSERT':
                        $campi = array_keys($op['data']);
                        $placeholders = array_map(fn($c) => ":i_{$index}_$c", $campi);
                        
                        $sql = "INSERT INTO `$table` (`" . implode("`,`", $campi) . "`) VALUES (" . implode(",", $placeholders) . ")";
                        
                        foreach ($op['data'] as $k => $v) {
                            $valori[":i_{$index}_$k"] = $v;
                        }
                        break;
    
                        case 'UPDATE':
                            $sql = "UPDATE `$table` SET ";
                            $set_part = [];
                            foreach ($op['data'] as $k => $v) {
                                if (is_string($v) && strpos($v, $k) !== false) {
                                    $set_part[] = "`$k`=$v";
                                } else {
                                    $set_part[] = "`$k`=:u_{$index}_$k";
                                    $valori[":u_{$index}_$k"] = $v;
                                }
                            }
                            $sql .= implode(", ", $set_part);
    
                        if (!empty($op['where'])) {
                            $sql .= " WHERE ";
                            $where_part = [];
                            foreach ($op['where'] as $k => $v) {
                                $where_part[] = "`$k`=:w_{$index}_$k";
                                $valori[":w_{$index}_$k"] = $v;
                            }
                            $sql .= implode(" AND ", $where_part);
                        }
                        break;
    
                    case 'DELETE':
                        $sql = "DELETE FROM `$table`";
                        if (!empty($op['where'])) {
                            $sql .= " WHERE ";
                            $where_part = [];
                            foreach ($op['where'] as $k => $v) {
                                $where_part[] = "`$k`=:w_{$index}_$k";
                                $valori[":w_{$index}_$k"] = $v;
                            }
                            $sql .= implode(" AND ", $where_part);
                        }
                        break;
    
                    default:
                        throw new Exception("Tipo operazione non valido: $type");
                }
    
                $sql .= ";";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($valori);
            }
    
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }
    

    function insert($table,$arr_att_val){
        if(!in_array($table,$this->whitelist)) throw new Exception("Tabella non trovata");
        if(!is_array($arr_att_val)) throw new Exception("Errore nei valori passati");

        $valori=[];
        foreach($arr_att_val as $chiave => $valore) $valori[":$chiave"]=$valore;

        $stmt=$this->conn->prepare("INSERT INTO `$table`(".implode(",", array_map(fn($k) => "`$k`", array_keys($arr_att_val))).") VALUES (".implode(",",array_keys($valori)).")");
        $stmt->execute($valori);
        return $this->conn->lastInsertId();
    }

    function update($table,$arr_att_val,$arr_id_val){
        if(!in_array($table,$this->whitelist)) throw new Exception("Tabella non trovata");
        if(!is_array($arr_att_val)) throw new Exception("Errore nei valori passati");
        if(!is_array($arr_id_val)) throw new Exception("Errore nei id passati");

        $valori = [];
        foreach($arr_att_val as $k => $v) $valori[":v_$k"] = $v;

        $condizioni=[];
        foreach($arr_id_val as $k => $v) {
            $condizioni[]="`$k`=:w_$k";
            $valori[":w_$k"]=$v;
        }

        $sql = "UPDATE `$table` SET " . implode(", ", array_map(fn($k) => "`$k` = :v_$k", array_keys($arr_att_val))) . " WHERE ".implode(" AND ",$condizioni);

        $stmt=$this->conn->prepare($sql);
        $stmt->execute($valori);
        return;
    }

    function delete($table,$arr_id_val){
        if(!in_array($table,$this->whitelist)) throw new Exception("Tabella non trovata");
        if(!is_array($arr_id_val)) throw new Exception("Errore nei id passati");

        $valori=[];

        $condizioni=[];
        foreach($arr_id_val as $k => $v) {
            $condizioni[]="`$k`=:w_$k";
            $valori[":w_$k"]=$v;
        }

        $sql="DELETE FROM `$table` WHERE ".implode(" AND ",$condizioni).";";

        $stmt=$this->conn->prepare($sql);
        $stmt->execute($valori);
        return;
    }
}